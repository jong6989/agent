<?php

namespace App\Controllers;
use App\Models\AccountModel;
use App\Models\LogsModel;

class Dashboard extends BaseController
{
    public function __construct(){
        helper('form');
        $this->account = new AccountModel();
        $this->logs = new LogsModel();
        $this->id = session()->get('id');
        $this->access = session()->get('access');
        $this->logged = session()->get('isLoggedIn') ?? false;
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

}
