<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\WalletModel;
use App\Models\PlayerModel;
use App\Models\GamePlayerModel;
use App\Models\TransactionModel;

class SuperAgent extends BaseController
{

    public function __construct(){
        helper('form');
        $this->account = new AccountModel();
        $this->player = new PlayerModel();
        $this->wallet = new WalletModel();
        $this->logs = new LogsModel();
        $this->gameplayer = new GamePlayerModel();
        $this->transaction = new TransactionModel();
        $this->logged = session()->get('isLoggedIn') ?? false;
        $this->id = session()->get('id');
        $this->operator = session()->get('operator');
        $this->access = session()->get('access');
        $this->commission = session()->get('commission');
        $this->balance = $this->wallet->where('account_id', $this->id)->select('sum(amount) as total')->first()['total'] ?? 0;
    }

    public function index($var)
    {
        if(!$this->logged){
            return redirect()->to('login');
        }

        $myData = $this->account->find($this->id);
        if($myData['phone'] == '') return redirect()->to('super_agent_profile');

        $myOperator = $this->account->find($myData['operator']);

        //update account wallet
        if($this->balance > $myData['wallet'] ){
            $this->account->save([
                "id" => $this->id,
                "wallet" => $this->balance
            ]);
        }

        $menu = $var ?? 'dashboard';
        $sub_menu = '';
        $view = $this->access . '/' . $menu;

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => $menu,
            "action" => $sub_menu,
            "operator" => $myOperator,
        ];

        if($var == 'agents'){
            $list = [];
            foreach ( $this->account->where('access', 'agent')->where('super_agent', $this->id)->find() as $k => $v) {
                $v['balance'] = $this->wallet->where('account_id', $v['id'])->select('sum(amount) as total')->first()['total'] ?? 0;
                $list[] = $v;
            }
            $data['list'] = $list;
        }
        if($var == 'players'){
            $list = [];
            foreach ( $this->player->where('super_agent', $this->id)->find() as $k => $v) {
                // $v['commission'] = $this->wallet->where('account_id', $this->id)->where('player_id', $v['player_id'])->select('sum(amount) as total')->first()['total'] ?? 0;
                // $v['transactions'] = $this->transaction->where('PLAYER_ID', $v['player_id'])->countAllResults();
                $list[] = $v;
            }
            $data['list'] = $list;
        }

        if($var == 'commissions'){
            $account_id = $this->request->getVar('id') ?? $this->id;

            $data['selected_account'] = $this->account->find($account_id);
            $data['list'] = $this->wallet->where('account_id', $account_id)->limit(2000)->orderBy('id','DESC')->find() ?? [];
            $data['payouts'] = $this->wallet->where('account_id', $account_id)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            foreach ($data['list'] as $key => $value) {
                $data['list'][$key]['player'] = $this->player->where('player_id',$value['player_id'])->first();
            }
            $data['commissions'] = $this->wallet->where('account_id', $account_id)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            
            foreach ( $data['list'] as $k => $v) {
                $data['list'][$k]['player'] = $this->player->where('player_id', $v['player_id'])->first();
            }
        }
        
        if($var == 'dashboard'){
            $day = date('j');
            $month = date('m');
            $last_month = date('m', strtotime("-1 month"));
            $year = date('Y');
            
            //payout
            $data['payout_month'] = $this->wallet->where('account_id', $this->id)->where('month', $month)->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_last_month'] = $this->wallet->where('account_id', $this->id)->where('month', $last_month )->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_year'] = $this->wallet->where('account_id', $this->id)->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_last_year'] = $this->wallet->where('account_id', $this->id)->where('year', intval($year) - 1)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            
            //income
            $data['commission_month'] = $this->wallet->where('account_id', $this->id)->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_last_month'] = $this->wallet->where('account_id', $this->id)->where('month', $last_month )->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_year'] = $this->wallet->where('account_id', $this->id)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_last_year'] = $this->wallet->where('account_id', $this->id)->where('year', intval($year) - 1)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            
            //GGR
            $data['ggr_month'] = $this->wallet->where('account_id', $this->id)->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['ggr_last_month'] = $this->wallet->where('account_id', $this->id)->where('month', $last_month )->where('year', $year)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['ggr_year'] = $this->wallet->where('account_id', $this->id)->where('year', $year)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['ggr_last_year'] = $this->wallet->where('account_id', $this->id)->where('year', intval($year) - 1)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['total_ggr'] = $this->wallet->where('account_id', $this->id)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;


            $data['all_players'] = $this->player->where('super_agent', $this->id)->countAllResults();
            $data['paired_players'] = $this->player->where('super_agent', $this->id)->where('player_id !=', 'none')->countAllResults();
            $data['agents'] = $this->account->where('access', 'agent')->where('super_agent', $this->id)->countAllResults();
            $data['payouts'] = $this->wallet->where('account_id', $this->id)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
        }

        return  view('header/dashboard')
                .view($view ,$data)
                .view('footer/dashboard');
    }

    public function register_agent(){
        if(!$this->logged){
            return redirect()->to('login');
        }
        
        $myData = $this->account->find($this->id);
        
        $id = $this->request->getVar('id') ?? false;
        if($id){
            $currentItem = $this->account->find($id);
        }

        
        $myOperator = $this->account->find($myData['operator']);

        $default = [
            'email' => ($id) ? $currentItem['email'] : '',
            'name' => ($id) ? $currentItem['name'] : '',
            'commission' => ($id) ? $currentItem['commission'] : '',
            'address' => ($id) ? $currentItem['address'] : '',
        ];

        $formURL = ($id) ? 'register_agent?id=' . $id : 'register_agent';

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => '',
            "action" => '',
            "validation" => $this->validator,
            "item_id" => $id ?? '',
            "default" => $default,
            "formUrl" => $formURL,
            "operator" => $myOperator,
        ];
        
        

        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'email' => 'trim|required|valid_email',
                'name' => 'trim|required',
                'commission' => [
                    'rules' => 'required|limitCommission',
                    'errors' => [
                        'limitCommission' => 'Commision share limit is ' . $myData['commission'] . '%'
                    ] 
                ],
            ];

            if(!$id){
                $rules['password'] = [
                    'rules' => 'trim|required|matches[re_password]|min_length[6]|max_length[255]',
                    'errors' => [
                        'matches' => 'Password did not match!'
                    ] 
                ];
            }

            if( $this->validate($rules) ){
                $data = [
                    'email' => $this->request->getVar('email'),
                    'name' => $this->request->getVar('name'),
                    'commission' => $this->request->getVar('commission'),
                    'address' => $this->request->getVar('address'),
                ];

                if($id){
                    $data['id'] = $id;
                    $this->account->save($data);
                }else {
                    $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                    $data['access'] = 'agent';
                    $data['status'] = 'new';
                    $data['operator'] = $myData['operator'];
                    $data['super_agent'] = $this->id;

                    $this->account->save($data);
                    $this->logs->save([
                        'name' => 'new agent',
                        'info' => json_encode($data),
                        'account_id' => $this->id,
                    ]);
                }
                return redirect()->to($this->access . '/agents');
            }else {
                $data["validation"] = $this->validator;
            }
        }

        return  view('header/dashboard')
                .view( $this->access . '/register_agent',$data)
                .view('footer/dashboard');
    }

    
    public function super_agent_profile(){
        if(!$this->logged && $this->id){
            return redirect()->to('login');
        }

        $currentItem = $this->account->find($this->id);
        $default = [
            'email' => $currentItem['email'] ?? '',
            'name' => $currentItem['name'] ?? '',
            'address' => $currentItem['address'] ?? '',
            'bank_name' => $currentItem['bank_name'] ?? '',
            'account_number' => $currentItem['account_number'] ?? '',
            'account_name' => $currentItem['account_name'] ?? '',
            'phone' => $currentItem['phone'] ?? '',
            'fb' => $currentItem['fb'] ?? '',
        ];
        
        $myOperator = $this->account->find($currentItem['operator']);

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'super_agent_profile',
            "action" => '',
            "validation" => $this->validator,
            "default" => $default,
            "operator" => $myOperator,
        ];
        

        if($this->request->getMethod() == 'post'){
            $rules = [
                'email' => 'trim|required|valid_email',
                'name' => 'trim|required',
                'bank_name' => 'required',
                'account_number' => 'required',
                'account_name' => 'required',
            ];

            if( $this->validate($rules) ){
                $updatedata = [
                    'email' => $this->request->getVar('email'),
                    'name' => $this->request->getVar('name'),
                    'address' => $this->request->getVar('address'),
                    'bank_name' => $this->request->getVar('bank_name'),
                    'account_number' => $this->request->getVar('account_number'),
                    'account_name' => $this->request->getVar('account_name'),
                    'phone' => $this->request->getVar('phone'),
                    'fb' => $this->request->getVar('fb'),
                ];
                $data['default'] = $updatedata;
                $updatedata['id'] = $this->id;
                $this->account->save($updatedata);
            }else {
              $data["validation"] = $this->validator;
            }
        }

        
        return  view('header/dashboard')
                .view($this->access . '/profile',$data)
                .view('footer/dashboard');
    }


}
