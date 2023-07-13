<?php

namespace App\Controllers;
use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\WalletModel;

class Dashboard extends BaseController
{
    public function __construct(){
        helper('form');
        $this->account = new AccountModel();
        $this->logs = new LogsModel();
        $this->wallet = new WalletModel();
        $this->id = session()->get('id');
        $this->access = session()->get('access');
        $this->logged = session()->get('isLoggedIn') ?? false;
        $this->balance = $this->wallet->where('account_id', $this->id)->select('sum(amount) as total')->first()['total'] ?? 0;
    }

    public function index()
    {
        if($this->logged){
            return redirect()->to($this->access);
        }else {
            return redirect()->to('login');
        }
    }

    public function logout()
    {
        $this->account->save([
            'id' => $this->id,
            'online' => 0,
        ]);
        $this->logs->save([
            'name' => 'logout',
            'info' => $this->access,
            'account_id' => $this->id,
        ]);

        session()->destroy();
		return redirect()->to('/');
    }

    public function change_password($id){
        if(!$this->logged){
            return redirect()->to('login');
        }

        $myData = $this->account->find($this->id);
        $myOperator = $this->account->find($myData['operator']);

        $currentItem = $this->account->find($id);
        
        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => '',
            "action" => 'password',
            "validation" => $this->validator,
            "currentItem" => $currentItem,
            'updated' => false,
            "operator" => $myOperator,
        ];
        

        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'password' => [
                    'rules' => 'trim|required|matches[re_password]|min_length[6]|max_length[255]',
                    'errors' => [
                        'matches' => 'Password did not match!'
                    ] 
                ]
            ];

            if( $this->validate($rules) ){
                $newData = [
                    'id' => $id,
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                ];

                $this->account->save($newData);
                $data["updated"] = true;
            }else {
              $data["validation"] = $this->validator;
            }
        }

        
        return  view('header/dashboard')
                .view( 'password',$data)
                .view('footer/dashboard');
    }
    
    public function change_upline($id){
        if(!$this->logged){
            return redirect()->to('login');
        }
        if($this->access != 'super_admin'){
            return redirect()->to('Dashboard');
        }

        $currentItem = $this->account->find($id);
        $operator = $this->account->find($currentItem['operator']) ?? ['name'=>''];
        $SuperAGent = $this->account->find($currentItem['super_agent']) ?? ['name'=>''];
        
        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => '',
            "action" => 'upline',
            "currentItem" => $currentItem,
            "operator" => $operator,
            "super_agent" => $SuperAGent,
        ];
        

        
        return  view('header/dashboard')
                .view( 'upline',$data)
                .view('footer/dashboard');
    }
    

}
