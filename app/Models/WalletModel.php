<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table            = 'commission';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['amount','account_id','transaction','type','bank','account_number','account_name','ref_no','ref_date','player_id','day','month','year'];
    protected $beforeInsert = ['beforeInsert'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    protected function beforeInsert(array $data){
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

}
