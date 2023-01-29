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

class Admin extends BaseController
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

        $menu = $var ?? 'dashboard';
        $sub_menu = '';
        $view = $this->access . '/' . $menu;

        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => $menu,
            "action" => $sub_menu,
            "operatorID" => false
        ];

        if($var == 'operators'){
            $list = [];
            foreach ( $this->account->where('access', 'operator')->find() as $k => $v) {
                $v['balance'] = $this->wallet->where('account_id', $v['id'])->select('sum(amount) as total')->first()['total'] ?? 0;
                $list[] = $v;
            }
            $data['list'] = $list;
        }

        if($var == 'super_agents' || $var == 'agents'){
            $operators = $this->account->where('access', 'operator')->find();
            $data['operators'] = $operators;
            $list = [];
            $query = [];
            $accessFilter = ($var == 'agents') ? 'agent' : 'super_agent';
            $operatorID = $this->request->getVar('operator') ?? false;
            if($operatorID){
                $data['operatorID'] = $operatorID;
                $query = $this->account->where('access', $accessFilter)->where('operator', $operatorID)->find();
            }else {
                $query = $this->account->where('access', $accessFilter)->find();
            }
            foreach ( $query as $k => $v) {
                $v['balance'] = $this->wallet->where('account_id', $v['id'])->select('sum(amount) as total')->first()['total'] ?? 0;
                if($var == 'agents' && ($v['super_agent'] != '') ){
                    $v['upline'] = $this->account->find($v['super_agent'])['name'];
                }
                $list[] = $v;
            }
            $data['list'] = $list;
        }
        

        if($var == 'players'){
            $list = [];
            foreach ( $this->player->find() as $k => $v) {
                $v['transactions'] = $this->transaction->where('PLAYER_ID', $v['player_id'])->countAllResults();
                $list[] = $v;
            }
            $data['list'] = $list;
        }

        if($var == 'dashboard'){
            $data['operators'] = $this->account->where('access', 'operator')->countAllResults();
            $data['super_agents'] = $this->account->where('access', 'super_agent')->countAllResults();
            $data['agents'] = $this->account->where('access', 'agent')->countAllResults();
        }

        return  view('header/dashboard')
                .view($view ,$data)
                .view('footer/dashboard');
    }

    public function register_operator(){
        if(!$this->logged){
            return redirect()->to('login');
        }

        $id = $this->request->getVar('id') ?? false;
        if($id){
            $currentItem = $this->account->find($id);
        }
        $default = [
            'email' => ($id) ? $currentItem['email'] : '',
            'name' => ($id) ? $currentItem['name'] : '',
            'commission' => ($id) ? $currentItem['commission'] : '',
            'address' => ($id) ? $currentItem['address'] : '',
        ];

        $formURL = ($id) ? 'register_operator?id=' . $id : 'register_operator';
        
        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => '',
            "action" => '',
            "validation" => $this->validator,
            "item_id" => $id ?? '',
            "default" => $default,
            "formUrl" => $formURL
        ];
        

        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'email' => 'trim|required|valid_email',
                'name' => 'trim|required',
                'commission' => 'required',
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
                    $data['access'] = 'operator';
                    $data['status'] = 'new';
                    $data['operator'] = $this->id;
                    $data['super_agent'] = $this->id;

                    $this->account->save($data);
                    $this->logs->save([
                        'name' => 'new operator',
                        'info' => json_encode($data),
                        'account_id' => $this->id,
                    ]);
                }

                return redirect()->to($this->access . '/operators');
            }else {
              $data["validation"] = $this->validator;
            }
        }

        
        return  view('header/dashboard')
                .view($this->access . '/register_operator',$data)
                .view('footer/dashboard');
    }

    

    public function settings(){
        if(!$this->logged){
            return redirect()->to('login');
        }
        
        $ggr_share = $this->meta->where('name', 'ggr_share')->first();
        $minimum_payout = $this->meta->where('name', 'minimum_payout')->first();
        
        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'settings',
            "action" => '',
            'ggr_share' => $ggr_share['value'],
            'minimum_payout' => $minimum_payout['value']
        ];

        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'ggr_share' => 'required',
                'minimum_payout' => 'required',
            ];

            if( $this->validate($rules) ){
                
                $this->meta->save([ 'id' => $ggr_share['id'], 'value' => $this->request->getVar('ggr_share')]);
                $this->meta->save([ 'id' => $minimum_payout['id'], 'value' => $this->request->getVar('minimum_payout')]);
                $data['ggr_share'] = $this->request->getVar('ggr_share');
                $data['minimum_payout'] = $this->request->getVar('minimum_payout');
            }
        }


        return  view('header/dashboard')
                .view($this->access . '/settings',$data)
                .view('footer/dashboard');
    }

    

    public function reports(){
        if(!$this->logged){
            return redirect()->to('login');
        }
        
        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'reports',
            "action" => '',
            "reports" => [],
            "saved" => 0,
            "inserts" => [],
            "targetPath" => ''
        ];


        if (isset($_POST["import"])) {

            $allowedFileType = [
                'application/vnd.ms-excel',
                'text/xls',
                'text/xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
        
            if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        
                $targetPath = 'uploads/' . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
                $data['targetPath'] = $targetPath;
            }
        }

        $data['current_trans_pending'] = $this->transaction->where("completed",0)->countAllResults();
        $data['current_trans_processed'] = $this->transaction->where("completed",1)->countAllResults();
        $data['game_players_pending'] = $this->gameplayer->where("linked",0)->countAllResults();
        $data['game_players_linked'] = $this->gameplayer->where("linked",1)->countAllResults();

        $all_linked_players = $this->gameplayer->where("linked",1)->find();
        $available_for_processing = 0;
        foreach ($all_linked_players as $k => $v) {
            $available = $this->transaction->where("completed",0)->where("PLAYER_ID", $v['game_player_id'])->countAllResults();
            $available_for_processing += $available;
        }
        $data['available_for_processing'] = $available_for_processing;

        return  view('header/dashboard')
                .view($this->access . '/reports',$data)
                .view('footer/dashboard');
    }


}
