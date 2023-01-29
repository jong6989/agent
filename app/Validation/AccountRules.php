<?php
namespace App\Validation;
use App\Models\AccountModel;
use App\Models\PlayerModel;
use App\Models\GamePlayerModel;

class AccountRules
{
  public function __construct(){
    $this->account = new AccountModel();
    $this->player = new PlayerModel();
    $this->gameplayer = new GamePlayerModel();
  }

  public function validateAccount(string $str, string $fields, array $data){
    $account = $this->account->where('email', $data['email'])
                  ->first();

    if(!$account)return false;
    if($account['status'] == 'banned') return false;
    if($account['status'] == 'deleted') return false;

    return password_verify($data['password'], $account['password']);
  }

  public function checkDuplicateEmail(string $email){
    $xx = $this->account->where('email', $email)
                  ->first();
    if(!$xx)return true;
    return false;
  }

  public function checkPlayerPhoneDuplicate(string $phone){
    $xx = $this->player->where('phone', $phone)
                  ->first();
    if(!$xx)return true;
    return false;
  }

  public function checkPlayerEmailDuplicate(string $email){
    $xx = $this->player->where('email', $email)
                  ->first();
    if(!$xx)return true;
    return false;
  }

  public function checkGamePlayerId(string $id){
    $exist = $this->gameplayer->where('game_player_id', $id)->countAllResults();
    return ($exist == 0)? false:true;
  }

  public function limitCommission(int $x){
    return ( $x <= session()->get('commission') );
  }

}