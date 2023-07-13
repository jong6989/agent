<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\WalletModel;
use App\Models\PlayerModel;
use App\Models\GamePlayerModel;
use App\Models\NewsModel;
use App\Models\TransactionModel;
use CodeIgniter\I18n\Time;

class Agent extends BaseController
{

    public function __construct(){
        helper('form');
        $this->account = new AccountModel();
        $this->player = new PlayerModel();
        $this->wallet = new WalletModel();
        $this->logs = new LogsModel();
        $this->gameplayer = new GamePlayerModel();
        $this->transaction = new TransactionModel();
        $this->news = new NewsModel();
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
        if($myData['phone'] == '') return redirect()->to('agent_profile');

        $myOperator = $this->account->find($myData['operator']);
        
        //update account wallet
        if($this->balance > $myData['wallet'] ){
            $this->account->save([
                "id" => $this->id,
                "wallet" => $this->balance
            ]);
        }

        $sub_menu = '';
        $view = $this->access . '/' . $var;


        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => $var,
            "action" => $sub_menu,
            "operator" => $myOperator,
        ];

        if($var == 'players'){
            $list = [];
            foreach ( $this->player->where('agent', $this->id)->find() as $k => $v) {
                // $v['commission'] = $this->wallet->where('account_id', $this->id)->where('player_id', $v['player_id'])->select('sum(amount) as total')->first()['total'] ?? 0;
                // $v['transactions'] = $this->transaction->where('PLAYER_ID', $v['player_id'])->countAllResults();
                $list[] = $v;
            }
            $data['list'] = $list;
        }

        if($var == 'commissions'){
            $data['list'] = $this->wallet->where('account_id', $this->id)->limit(2000)->orderBy('id','DESC')->find() ?? [];
            $data['payouts'] = $this->wallet->where('account_id', $this->id)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
        }

        if($var == 'dashboard'){
            $day = date('j');
            $month = date('m');
            $last_month = date('m', strtotime("-1 month"));
            $year = date('Y');

            //payout
            // $data['payout_day'] = $this->wallet->where('account_id', $this->id)->where('day', $day)->where('month', $month)->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_month'] = $this->wallet->where('account_id', $this->id)->where('month', $month)->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_last_month'] = $this->wallet->where('account_id', $this->id)->where('month', $last_month )->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_year'] = $this->wallet->where('account_id', $this->id)->where('year', $year)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['payout_last_year'] = $this->wallet->where('account_id', $this->id)->where('year', intval($year) - 1)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;

            //NEWS

           $time =     Time::now('asia/singapore');

           $end = $time->subDays(2);

            $data['adminNews'] = $this->news->select('news.id, news.title, news.content, news.img_path, news.created_at, accounts.name')
                                                        ->join('accounts', 'accounts.id = news.account_id')
                                                        ->where('accounts.access', 'admin')
                                                        ->where("DATE_FORMAT(news.created_at,'%Y-%m-%d') >= '$end' ")
                                                        ->orderBy('news.id', 'desc')
                                                        ->findAll(5);

            $data['operatorNews'] = $this->news->select('news.id, news.title, news.content, news.img_path, news.created_at, accounts.name')
                                                        ->join('accounts', 'accounts.id = news.account_id')
                                                        ->where('accounts.access', 'operator')
                                                        ->where("DATE_FORMAT(news.created_at,'%Y-%m-%d') >= '$end' ")
                                                        ->orderBy('news.id', 'desc')
                                                        ->findAll(5);

            $data['superAgentNews'] = $this->news->select('news.id, news.title, news.content, news.img_path, news.created_at, accounts.name')
                                                        ->join('accounts', 'accounts.id = news.account_id')
                                                        ->where('accounts.access', 'super_agent')
                                                        ->where("DATE_FORMAT(news.created_at,'%Y-%m-%d') >= '$end' ")
                                                        ->orderBy('news.id', 'desc')
                                                        ->findAll(5);
            
            //income
            // $data['commission_day'] = $this->wallet->where('account_id', $this->id)->where('day', $day)->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_month'] = $this->wallet->where('account_id', $this->id)->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_last_month'] = $this->wallet->where('account_id', $this->id)->where('month', $last_month )->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_year'] = $this->wallet->where('account_id', $this->id)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_last_year'] = $this->wallet->where('account_id', $this->id)->where('year', intval($year) - 1)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            
            //GGR
            $data['ggr_month'] = $this->wallet->where('account_id', $this->id)->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['ggr_last_month'] = $this->wallet->where('account_id', $this->id)->where('month', $last_month )->where('year', $year)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['ggr_year'] = $this->wallet->where('account_id', $this->id)->where('year', $year)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
            $data['ggr_last_year'] = $this->wallet->where('account_id', $this->id)->where('year', intval($year) - 1)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;



            $data['all_players'] = $this->player->where('agent', $this->id)->countAllResults();
            $data['paired_players'] = $this->player->where('agent', $this->id)->where('player_id !=', 'none')->countAllResults();
            $data['payouts'] = $this->wallet->where('account_id', $this->id)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['total_ggr'] = $this->wallet->where('account_id', $this->id)->where('type', 'income')->select('sum(ggr) as total')->first()['total'] ?? 0;
        }
        
        return  view('header/dashboard')
                .view($view ,$data)
                .view('footer/dashboard');
    }

    public function agent_profile(){
        if(!$this->logged){
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
            "menu" => 'agent_profile',
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
