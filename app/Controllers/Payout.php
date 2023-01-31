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

class Payout extends BaseController
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

    public function index($var)
    {
        if(!$this->logged){
            return redirect()->to('login');
        }

        $sub_menu = $var ?? 'pending';
        $view = $this->access . '/' . $sub_menu . '_payouts';

        $minimum_payout = $this->meta->where('name', 'minimum_payout')->first()['value'];

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'payouts',
            "action" => $sub_menu,
            "operatorID" => false,
            "minimum_payout" => $minimum_payout
        ];

        $data['operators'] = $this->account->where('access', 'operator')->find();

        if($var == 'pending'){
            $list = [];
            $operatorID = $this->request->getVar('operator') ?? false;
            if($operatorID){
                $data['operatorID'] = $operatorID;
                $list = $this->account->where('wallet >', $minimum_payout)->where('operator', $operatorID)->find();
                $data['total_pending'] = $this->account->where('wallet >', $minimum_payout)->where('operator', $operatorID)->select('sum(wallet) as total')->first()['total'] ?? 0;
            }else {
                $list = $this->account->where('wallet >', $minimum_payout)->find();
                $data['total_pending'] = $this->account->where('wallet >', $minimum_payout)->select('sum(wallet) as total')->first()['total'] ?? 0;
            }
            
            $data['list'] = $list;
        }

        if($var == 'released'){
            $list = [];
            $operatorID = $this->request->getVar('operator') ?? false;
            if($operatorID){
                $data['operatorID'] = $operatorID;
                $list = $this->wallet->where('type', 'payout')->where('player_id', $operatorID)->find();
                $data['total_released'] = -($this->wallet->where('type', 'payout')->where('player_id', $operatorID)->select('sum(amount) as total')->first()['total'] ?? -0);
            }else {
                $list = $this->wallet->where('type', 'payout')->find();
                $data['total_released'] = -($this->wallet->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? -0);
            }
            
            $data['list'] = $list;
        }

        return  view('header/dashboard')
                .view($view ,$data)
                .view('footer/dashboard');
    }

    public function process_payout($id){
        if(!$this->logged){
            return redirect()->to('login');
        }

        $currentItem = $this->account->find($id) ?? [];
        $minimum_payout = $this->meta->where('name', 'minimum_payout')->first()['value'];

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'payouts',
            "action" => 'process',
            "validation" => $this->validator,
            "currentItem" => $currentItem,
            "minimum_payout" => intval($minimum_payout),
        ];
        

        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'bank' => 'required',
                'account_number' => 'required',
                'account_name' => 'required',
                'ref_no' => 'required',
                'ref_date' => 'required',
                'amount' => 'required|less_than[' . $currentItem['wallet'] .']|greater_than[' . $minimum_payout . ']',
            ];

            if( $this->validate($rules) ){
                $payoutValue = $this->request->getVar('amount');
                $data = [
                    'bank' => $this->request->getVar('bank'),
                    'account_number' => $this->request->getVar('account_number'),
                    'account_name' => $this->request->getVar('account_name'),
                    'ref_no' => $this->request->getVar('ref_no'),
                    'ref_date' => $this->request->getVar('ref_date'),
                    'amount' => -$payoutValue,
                    'account_id' => $currentItem['id'],
                    'player_id' => $currentItem['operator'],
                    'type' => 'payout'
                ];

                $this->wallet->save($data);
                $this->account->save(['wallet' => ($currentItem['wallet'] - $payoutValue ), 'id' => $currentItem['id'] ]);

                return redirect()->to('payouts/pending');
            }else {
              $data["validation"] = $this->validator;
            }
        }

        
        return  view('header/dashboard')
                .view($this->access . '/process_payout',$data)
                .view('footer/dashboard');
    }

    
}
