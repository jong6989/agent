<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\WalletModel;
use App\Models\MetaModel;
use App\Models\PlayerModel;
use App\Models\GamePlayerModel;
use App\Models\TransactionModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Player extends BaseController
{

    public function __construct(){
        helper('form');
        $this->account = new AccountModel();
        $this->wallet = new WalletModel();
        $this->logs = new LogsModel();
        $this->meta = new MetaModel();
        $this->player = new PlayerModel();
        $this->gameplayer = new GamePlayerModel();
        $this->transaction = new TransactionModel();
        $this->logged = session()->get('isLoggedIn') ?? false;
        $this->id = session()->get('id');
        $this->access = session()->get('access');
        $this->balance = $this->wallet->where('account_id', $this->id)->select('sum(amount) as total')->first()['total'] ?? 0;
    }

    public function index($player_id)
    {
        if(!$this->logged){
            return redirect()->to('login');
        }

        $player = $this->player->find($player_id);
        $ggr_share = $this->meta->where('name', 'ggr_share')->first()['value'];

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'player',
            "action" => '',
            "player_id" => $player_id,
            "player" => $player,
            'ggr_share' => $ggr_share
        ];

        $data['transactions'] = $this->transaction->where('PLAYER_ID', $player['player_id'])->countAllResults();
        $data['total_bets'] = $this->transaction->where('PLAYER_ID', $player['player_id'])->select('sum(BET_AMOUNT) as total')->first()['total'] ?? 0;
        $data['total_payout'] = $this->transaction->where('PLAYER_ID', $player['player_id'])->select('sum(PAYOUT) as total')->first()['total'] ?? 0;
        $data['total_refund'] = $this->transaction->where('PLAYER_ID', $player['player_id'])->select('sum(REFUND) as total')->first()['total'] ?? 0;
        $data['total_ggr'] = $this->transaction->where('PLAYER_ID', $player['player_id'])->select('sum(GROSS_GAMING_REVENUE) as total')->first()['total'] ?? 0;

        
        $data['operator'] = $this->account->find($player['operator']);
        $data['agency'] = ($player['agency'] !== '')? $this->account->find($player['agency']): ['commission'=> 0];
        $data['super_agent'] = ($player['super_agent'] !== '')? $this->account->find($player['super_agent']): ['commission'=> 0];
        $data['agent'] = ($player['agent'] !== '')? $this->account->find($player['agent']): ['commission'=> 0];

        
        $data['operator_commission'] = $data['operator']['commission'];
        $data['agency_commission'] = $data['agency']['commission'] ?? 0;
        $data['super_agent_commission'] = $data['super_agent']['commission'];
        $data['agent_commission'] = $data['agent']['commission'];
        
        $data['operator_share'] = ($data['agency_commission'] == 0) ? $data['operator_commission'] - $data['super_agent_commission'] : $data['operator_commission'] - $data['agency_commission'];
        $data['agency_share'] = $data['agency_commission'] - $data['super_agent_commission'];
        $data['super_agent_share'] = $data['super_agent_commission'] - $data['agent_commission'];
        
        
        $data['operator_wallet'] = $this->wallet->where('type','income')->where('player_id',$player['player_id'])->where('account_id',$player['operator'])->select('sum(amount) as total')->first()['total'] ?? 0;
        //$data['agency_wallet'] = $this->wallet->where('type','income')->where('player_id',$player['player_id'])->where('account_id',$player['agency'])->select('sum(amount) as total')->first()['total'] ?? 0;
        $data['super_agent_wallet'] = $this->wallet->where('type','income')->where('player_id',$player['player_id'])->where('account_id',$player['super_agent'])->select('sum(amount) as total')->first()['total'] ?? 0;
        $data['agent_wallet'] = $this->wallet->where('type','income')->where('player_id',$player['player_id'])->where('account_id',$player['agent'])->select('sum(amount) as total')->first()['total'] ?? 0;

        return  view('header/dashboard')
                .view('game/player' ,$data)
                .view('footer/dashboard');
    }

    public function edit_player($player_id){
        if(!$this->logged){
            return redirect()->to('login');
        }

        $player = $this->player->find($player_id);
        
        $myData = $this->account->find($this->id);
        $myOperator = $this->account->find($myData['operator']);

        $default = [
            'email' => $player['email'],
            'name' => $player['name'],
            'phone' => $player['phone'],
            'player_id' => ($player['player_id'] == 'none')? '': $player['player_id'] ,
            'note' => $player['note'],
        ];

        $data = [
            "balance" => $this->balance ?? 0,
            "id" => $this->id,
            "menu" => 'edit_player',
            "action" => '',
            "validation" => $this->validator,
            "player_id" => $player_id,
            "default" => $default,
            "saved" => false,
            "valid_access" => (session()->get('access') =='admin'),
            "operator" => $myOperator,
        ];
        
        if(session()->get('access') =='operator'){
            $data['valid_access'] = ($player['operator'] == $this->id);
        }
        
        if(session()->get('access') =='agency'){
            $data['valid_access'] = ($player['agency'] == $this->id);
        }
        
        if(session()->get('access') =='super_agent'){
            $data['valid_access'] = ($player['super_agent'] == $this->id);
        }

        if(session()->get('access') =='agent'){
            $data['valid_access'] = ($player['agent'] == $this->id);
        }

        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'email' => 'trim|required|valid_email',
                'name' => 'trim|required',
                'phone' => 'required',
                'player_id' => [
                    'rules' => 'checkGamePlayerId',
                    'errors' => [
                        'checkGamePlayerId' => 'Player ID is Invalid or not existing yet.'
                    ]
                ],
            ];

            if( $this->validate($rules) ){
                $targetGamePlayerID = $this->request->getVar('player_id');
                $toSave = [
                    'email' => $this->request->getVar('email'),
                    'name' => $this->request->getVar('name'),
                    'phone' => $this->request->getVar('phone'),
                    'player_id' => ($targetGamePlayerID == '')? 'none': $targetGamePlayerID,
                    'note' => $this->request->getVar('note'),
                ];

                $toSave['id'] = $player['id'];
                $gameplayer = $this->gameplayer->where('game_player_id',$targetGamePlayerID)->first();
                if($gameplayer){
                    $this->gameplayer->save([
                        "id" => $gameplayer['id'],
                        "affiliate_player_id" => $player['id'],
                        "operator" => $player['operator'],
                        "agency" => $player['agency'],
                        "super_agent" => $player['super_agent'],
                        "agent" => $player['agent'],
                        "linked" => 1,
                    ]);
                    $this->transaction
                        ->set('operator',$player['operator'])
                        ->set('agency',$player['agency'])
                        ->set('super_agent',$player['super_agent'])
                        ->set('agent',$player['agent'])
                        ->where('PLAYER_ID', $targetGamePlayerID)
                        ->update();
                }
                
                $this->player->save($toSave);

                $data['saved'] = true;
            }else {
              $data["validation"] = $this->validator;
            }
        }

        
        return  view('header/dashboard')
                .view('game/edit_player',$data)
                .view('footer/dashboard');
    }

    

}
