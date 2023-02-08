<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['BET_TIME','TRANSACTION_ID','PLAYER_ID','CHANNEL_TYPE','BET_AMOUNT','PAYOUT','REFUND','GROSS_GAMING_REVENUE','completed','operator','agency','super_agent','agent','day','month','year'];
    protected $beforeInsert = ['beforeInsert'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected function beforeInsert(array $data){
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

}
