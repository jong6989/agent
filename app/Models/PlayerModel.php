<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table            = 'players';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name','email','phone','player_id','note','agency','operator','super_agent','agent'];
    protected $beforeInsert = ['beforeInsert'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected function beforeInsert(array $data){
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }
    
    public function getAllPlayersWithTransactions()
  {

    $query =  $this->db->query("
        SELECT players.id, players.operator, players.agent, 
        players.super_agent, players.name, players.email, players.phone, players.player_id,
          (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator)
           as 'operator-name', (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent)
            as 'super-agent-name', (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent) as
             'agent-name' FROM players
        ");

    return $query->getResultArray();
  }

  public function getPlayersWithSearch($search = null, $page = 1, $perPage = 10)
  {

    if ($page == 1) {
      $offSetValue = 0;
    } else {
      $offSetValue = ($page * $perPage) - $perPage;
    }

    if ($search) {
      $search = $this->db->escapeString($search);
      $query =   "SELECT players.id, players.operator, players.agent, players.super_agent, players.name, players.email, 
      players.phone, players.player_id, players.created_at, (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator) as 
      'operator-name', (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent) as 'super-agent-name',
       (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent) as 'agent-name' FROM players WHERE
        (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator ) LIKE '%$search%' OR 
        (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent ) LIKE '%$search%' OR
         (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent ) LIKE '%$search%' OR 
         players.name LIKE '%$search%' OR players.email LIKE '%$search%' OR players.phone LIKE
          '%$search%' OR players.player_id LIKE '%$search%' LIMIT $perPage OFFSET $offSetValue";
    } else {
      $query = "SELECT players.id, players.operator, players.agent, players.super_agent, players.name, players.email,
       players.phone, players.player_id, players.created_at, (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator) as 
       'operator-name', (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent) as 'super-agent-name', 
       (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent) as 'agent-name' FROM players LIMIT $perPage OFFSET $offSetValue";
    }

    return $this->db->query($query)->getResultArray();
    // return $this->db->cou;
  }

  public function getPlayersNumRows($search = null)
  {


    if ($search) {
      $search = $this->db->escapeString($search);
      $query =   "SELECT players.id, players.operator, players.agent, players.super_agent, players.name, players.email, 
      players.phone, players.player_id, (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator) as 
      'operator-name', (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent) as 'super-agent-name',
       (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent) as 'agent-name' FROM players WHERE
        (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator ) LIKE '%$search%' OR 
        (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent ) LIKE '%$search%' OR
         (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent ) LIKE '%$search%' OR 
         players.name LIKE '%$search%' OR players.email LIKE '%$search%' OR players.phone LIKE
          '%$search%' OR players.player_id LIKE '%$search%'";
    } else {
      $query = "SELECT players.id, players.operator, players.agent, players.super_agent, players.name, players.email, 
      players.phone, players.player_id, (SELECT accounts.name FROM accounts WHERE accounts.id = players.operator) as 
      'operator-name', (SELECT accounts.name FROM accounts WHERE accounts.id = players.super_agent) as 'super-agent-name',
      (SELECT accounts.name FROM accounts WHERE accounts.id = players.agent) as 'agent-name' FROM players";
    }

    return $this->db->query($query)->getNumRows();
  }

}
