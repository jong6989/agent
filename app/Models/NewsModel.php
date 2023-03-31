<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['account_id', 'title', 'content', 'img_path', 'created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function allNewsWithRelation()
    {
        $this->builder()->select(['news.id','news.title', 'news.content', 'news.img_path', 'news.created_at', 'accounts.name']);
        $this->builder()->join('accounts', 'accounts.id = news.account_id');
        $this->builder()->orderBy('news.id','DESC');

        return $this;
    }

    public function allSearchNewsWithRelation($search)
    {
        $this->builder()->select(['news.id','news.title', 'news.content', 'news.img_path', 'news.created_at', 'accounts.name']);
        $this->builder()->join('accounts', 'accounts.id = news.account_id');
        $this->builder()->like('news.content', $search, 'both');
        $this->builder()->orLike('news.title', $search, 'both');
        $this->builder()->orLike('accounts.name', $search, 'both');
        $this->builder()->orderBy('news.id','DESC');
        return $this;
    }
}
