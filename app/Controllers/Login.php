<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\PlayerModel;

class Login extends BaseController
{
    public function __construct(){
        helper('form');
        $this->account = new AccountModel();
        $this->logs = new LogsModel();
        $this->player = new PlayerModel();
        $this->logged = session()->get('isLoggedIn') ?? false;
        $this->id = session()->get('id');
    }

	private function setUserSession($x){
        
        $data = [
            'status' => $x['status'],
            'super_agent' => $x['super_agent'],
            'operator' => $x['operator'],
            'commission' => $x['commission'],
            'email' => $x['email'],
            'name' => $x['name'],
            'access' => $x['access'],
            'id' => $x['id'],
            'isLoggedIn' => true
        ];

		session()->set($data);
		return true;
	}

    public function index(){
        if($this->logged){
            return redirect()->to('dashboard');
        }

        $data = ["validation" => $this->validator];

        $accountData = session()->get();

        $data['account'] = $accountData;
        
        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'email' => 'required|valid_email',
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[255]|validateAccount[email,password]',
                    'errors' => [
                        'validateAccount' => 'Email or Password don\'t match'
                    ]
                ]
            ];

            if( $this->validate($rules) ){
                
                $account = $this->account->where('email', $this->request->getVar('email'))->first();
                $this->setUserSession($account);
                $savethis = [
                    'id' => $account['id'],
                    'online' => 1,
                ];

                if($account['status'] == 'new'){
                    $savethis['status'] = 'active';
                }

                $this->account->save($savethis);
                $this->logs->save([
                    'name' => 'login',
                    'info' => $account['access'],
                    'account_id' => $account['id'],
                ]);

                return redirect()->to('dashboard');
            }else {
                $data["validation"] = $this->validator;
            }
        }

        
        return  view('header/login')
                .view('login',$data)
                .view('footer/login');
    }

    public function player($agentId){
        $data = ["validation" => $this->validator];
        $view = 'player';

        $rules = [
            'email' => [
                'rules' => 'required|valid_email|checkPlayerEmailDuplicate',
                'errors' => [
                    'checkPlayerEmailDuplicate' => 'This email is already registered.'
                ]
            ],
            'phone' => [
                'rules' => 'required|checkPlayerPhoneDuplicate',
                'errors' => [
                    'checkPlayerPhoneDuplicate' => 'Phone Number is already registered.'
                ]
            ],
        ];

        
        $agent = $this->account->find($agentId);

        if($agent){
            $data['agent'] = $agent;
            $operator = $this->account->find($agent['operator']);
            if($operator){
                $data['operator'] = $operator;
            }else {
                $data['operator'] = $agent;
            }
        }else {
            $view = 'invalid';
        }

        $toSave = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
        ];

        if($agent['access'] == 'agent'){
            $toSave['operator'] = $agent['operator'];
            $toSave['super_agent'] = $agent['super_agent'];
            $toSave['agent'] = $agentId;
        }

        if($agent['access'] == 'super_agent'){
            $toSave['operator'] = $agent['operator'];
            $toSave['super_agent'] = $agentId;
            $toSave['agent'] = $agentId;
        }

        if($agent['access'] == 'operator'){
            $toSave['operator'] = $agentId;
            $toSave['super_agent'] = $agentId;
            $toSave['agent'] = $agentId;
        }


        if( $this->validate($rules) ){
            $this->player->save($toSave);
                echo  '<script language="javascript">
                            window.location="https://buenas.ph/sign-up";
                        </script>';
        }else {
            $data["validation"] = $this->validator;
        }
        

        return  view('header/login')
        .view($view,$data)
        .view('footer/login');
    }
}
