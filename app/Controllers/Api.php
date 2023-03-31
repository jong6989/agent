<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\WalletModel;
use App\Models\MetaModel;
use App\Models\PlayerModel;
use App\Models\GamePlayerModel;
use App\Models\TransactionModel;

class Api extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->account = new AccountModel();
        $this->wallet = new WalletModel();
        $this->logs = new LogsModel();
        $this->meta = new MetaModel();
        $this->player = new PlayerModel();
        $this->gameplayer = new GamePlayerModel();
        $this->transaction = new TransactionModel();
        $this->request = service('request');
    }

    public function index()
    {
        $data = [
            'data' => 'Api endpoint',
            'code' => 200,
        ];

        return $this->respond($data,200);
    }

    public function get_list()
    {
        $r = $this->request->getVar();

        $data = [
            'data' => [
                'request' => $r,
            ],
            'code' => 200,
        ];

        return $this->respond($data,200);
    }

    
    public function import_report(){

        $targetPath = $this->request->getVar('targetPath');
        
        $target_keys = ['TRANSACTION ID','PLAYER ID','BET TIME','CHANNEL TYPE','BET AMOUNT','PAYOUT','REFUND','GROSS GAMING REVENUE'];
        $target_index = [];

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        
        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $excelData = $excelSheet->toArray();
        $dataCount = count($excelData);

        $data = [
            "items" => 0,
            "imported" => 0,
            "path" => $targetPath
        ];

        // $data['reports'] = $excelData;
        $data['items'] = count($excelData) ?? 0;

        if($dataCount > 1){
            $saved = 0;
            //get keys
            foreach ($target_keys as $key => $value) {
                if(in_array($value,$excelData[0])){
                    $target_index[] = array_search($value,$excelData[0]);
                }
            }
            $data['target_index'] = $target_index;
            //save to DB
            foreach ($excelData as $k => $v) {
                if($k > 0 ){
                    $iid = $v[$target_index[0]];//trans ID
                    if( $iid !== '' && $iid !== ' ' && $iid !== null && $iid !== '0' && $iid !== 0){
                        $exist = $this->transaction->where('TRANSACTION_ID', $iid)->countAllResults();
                        if($exist == 0){
                            $newTransData = [];
                            //build data set
                            foreach ($target_keys as $x => $y) {
                                $x_index = str_replace(" ","_",$y);
                                $x_value = $v[$target_index[$x]];
                                $newTransData[$x_index] = $x_value ?? 0;
                            }
                            //save to database count($target_keys)
                            if(count($newTransData) == count($target_keys) ){
                                //save game player data
                                $playerId = $v[$target_index[1]];
                                $player = $this->gameplayer->where('game_player_id', $playerId)->find();
                                if(count($player) == 0){
                                    $this->gameplayer->save([
                                        "game_player_id" => $playerId
                                    ]);
                                }else {
                                    $p = $player[0];
                                    $newTransData['operator'] = $p['operator'];
                                    $newTransData['agency'] = $p['agency'];
                                    $newTransData['super_agent'] = $p['super_agent'];
                                    $newTransData['agent'] = $p['agent'];
                                }
                                $dateRaw = explode(' ',$newTransData['BET_TIME']);
                                
                                if(count($dateRaw) > 1){
                                    $dateArray = explode('/',$dateRaw[0]);
                                    if(count($dateArray) == 3){
                                        $newTransData['month'] = $dateArray[0];
                                        $newTransData['day'] = $dateArray[1];
                                        $newTransData['year'] = $dateArray[2];
                                    }
                                }
                                $this->transaction->save($newTransData);

                                $saved++;
                            }
                                
                        }
                    }

                }
            }
            // $data['saved'] = $saved;
            $data['imported'] = $saved;

        }


        return $this->respond($data,200);
    }

    public function process_commission(){

        $data = [];

        $all_linked_players = $this->gameplayer->where("linked",1)->find();
        foreach ($all_linked_players as $k => $v) {

            $ggr = $this->transaction->where("completed",0)->where("PLAYER_ID", $v['game_player_id'])->select('sum(GROSS_GAMING_REVENUE) as total')->first()['total'] ?? 0;
            $bet = $this->transaction->where("completed",0)->where("PLAYER_ID", $v['game_player_id'])->select('sum(BET_AMOUNT) as total')->first()['total'] ?? 0;
            $win = $this->transaction->where("completed",0)->where("PLAYER_ID", $v['game_player_id'])->select('sum(PAYOUT) as total')->first()['total'] ?? 0;

            $agent_share = $this->account->find($v['agent'])['commission'];
            $super_agent_share = $this->account->find($v['super_agent'])['commission'];
            $agency_share = 0;
            $operator_share = $this->account->find($v['operator'])['commission'];

            if($v['agency'] !== ''){
                $agency_share = $this->account->find($v['agency'])['commission'];
            }

            $transID = date('Ymd');
            $playerID = $v['game_player_id'];

            $agent_commission = $ggr * ( $agent_share / 100 );
            $super_raw_share = $ggr * ( $super_agent_share / 100 );
            $super_agent_commission = $super_raw_share - $agent_commission;
            $agency_raw = ($agency_share == 0)? 0 : ( $ggr * ( $agency_share / 100 ) );
            $agency_commission = ($agency_share == 0)? 0 : ($agency_raw - $super_raw_share);
            $operator_raw = $ggr * ( $operator_share / 100 );
            $operator_commission = ($agency_share == 0)? ($operator_raw - $super_raw_share) : ($operator_raw - $agency_raw);

            //transaction list
            if($ggr > 0){
                
                //agent share
                if($agent_commission > 0){
                    $this->wallet->save([
                        "account_id" => $v['agent'],
                        "amount" => $agent_commission,
                        "bet" => $bet,
                        "win" => $win,
                        "ggr" => $ggr,
                        "type" => 'income',
                        "transaction" => $transID,
                        "player_id" => $playerID,
                        "day" => date('d'),
                        "month" => date('m'),
                        "year" => date('Y'),
                    ]);
                }
                
                //super agent share
                if($super_agent_commission > 0){
                    $this->wallet->save([
                        "account_id" => $v['super_agent'],
                        "amount" => $super_agent_commission,
                        "bet" => $bet,
                        "win" => $win,
                        "ggr" => $ggr,
                        "type" => 'income',
                        "transaction" => $transID,
                        "player_id" => $playerID,
                        "day" => date('d'),
                        "month" => date('m'),
                        "year" => date('Y'),
                    ]);
                }
                
                //operator share
                if($operator_commission > 0){
                    $this->wallet->save([
                        "account_id" => $v['operator'],
                        "amount" => $operator_commission,
                        "bet" => $bet,
                        "win" => $win,
                        "ggr" => $ggr,
                        "type" => 'income',
                        "transaction" => $transID,
                        "player_id" => $playerID,
                        "day" => date('d'),
                        "month" => date('m'),
                        "year" => date('Y'),
                    ]);
                }
                
                if($agency_commission > 0){
                    //agent share
                    $this->wallet->save([
                        "account_id" => $v['agency'],
                        "amount" => $agency_commission,
                        "bet" => $bet,
                        "win" => $win,
                        "ggr" => $ggr,
                        "type" => 'income',
                        "transaction" => $transID,
                        "player_id" => $playerID,
                        "day" => date('d'),
                        "month" => date('m'),
                        "year" => date('Y'),
                    ]);
                }

            }

            //update transactions
            $this->transaction->set('completed',1)->where("completed",0)->where("PLAYER_ID", $v['game_player_id'])->update();
            


        }

        return $this->respond($data,200);
    }

}
