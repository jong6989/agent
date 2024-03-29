<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\LogsModel;
use App\Models\WalletModel;
use App\Models\MetaModel;
use App\Models\PlayerModel;
use App\Models\GamePlayerModel;
use App\Models\NewsModel;
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
        $this->news = new NewsModel();
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
                $v['hall'] = $this->account->find($v['operator'])['name'] ?? '';
                if($var == 'agents' && ($v['super_agent'] != '') ){
                    $v['upline'] = $this->account->find($v['super_agent'])['name'];
                }
                $list[] = $v;
            }
            $data['list'] = $list;
        }
        

        if($var == 'players'){
            $pager = service('pager');

            $page    = (int) ($this->request->getGet('page') ?? 1);
            $perPage = (int) ($this->request->getGet('per-page') ?? 25);;

            $total   = $this->player->getPlayersNumRows();
            $allPlayers = $this->player->getPlayersWithSearch(null,$page,$perPage);

            if($this->request->getGet('search')){
                $search = $this->request->getGet('search', FILTER_SANITIZE_SPECIAL_CHARS);
                $total   = $this->player->getPlayersNumRows($search);
                $allPlayers = $this->player->getPlayersWithSearch($search,$page,$perPage);
                $data['search'] = $search;
            }

    
            // Call makeLinks() to make pagination links.
            $pager_links = $pager->makeLinks($page, $perPage, $total, 'default_full');

            $data['list'] = $allPlayers;
            $data['pager_links'] = $pager_links;
            $data['perPage'] = $perPage;
            // $list = [];
            // $limit = $this->request->getVar('limit') ?? 5000;
            // $like = $this->request->getVar('like') ?? '';
            // $like_key = $this->request->getVar('like_key') ?? '';
            // $q = $this->player;
            // if($like != '' && $like_key != ''){
            //     $q = $q->like($like_key,$like);
            // }
            // $q = $q->limit($limit)->find();
            // foreach ( $q as $k => $v) {
            //     // $v['transactions'] = $this->transaction->where('PLAYER_ID', $v['player_id'])->countAllResults();
            //     $v['operator'] = $this->account->find($v['operator']);
            //     $v['super_agent'] = $this->account->find($v['super_agent']);
            //     $v['agent'] = $this->account->find($v['agent']);
            //     $v['agency'] = $this->account->find($v['agency'] ?? ['name'=>'']);
            //     $list[] = $v;
            // }
            // $data['list'] = $list;
        }
        
        //NEWS
        if ($var == 'news') {

            $allNews = $this->news->allNewsWithRelation()->find();
                

            $data['allNews'] = $allNews;
                
        }

        if($var == 'dashboard'){
            $day = date('j');
            $month = date('n');
            $year = date('Y');

            //trans
            $data['trans_day'] = $this->transaction->where('day', $day)->where('month', $month)->where('year', $year)->countAllResults();
            $data['trans_month'] = $this->transaction->where('month', $month)->where('year', $year)->countAllResults();
            $data['trans_year'] = $this->transaction->where('year', $year)->countAllResults();
            $data['trans_last_year'] = $this->transaction->where('year', intval($year) - 1)->countAllResults();


            //bets
            $data['bets_day'] = $this->transaction->where('day', $day)->where('month', $month)->where('year', $year)->select('sum(BET_AMOUNT) as total')->first()['total'] ?? 0;
            $data['bets_month'] = $this->transaction->where('month', $month)->where('year', $year)->select('sum(BET_AMOUNT) as total')->first()['total'] ?? 0;
            $data['bets_year'] = $this->transaction->where('year', $year)->select('sum(BET_AMOUNT) as total')->first()['total'] ?? 0;
            $data['bets_last_year'] = $this->transaction->where('year', intval($year) - 1)->select('sum(BET_AMOUNT) as total')->first()['total'] ?? 0;

            //income
            $data['commission_day'] = $this->wallet->where('day', $day)->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_month'] = $this->wallet->where('month', $month)->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_year'] = $this->wallet->where('year', $year)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
            $data['commission_last_year'] = $this->wallet->where('year', intval($year) - 1)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;


            $data['all_players'] = $this->player->countAllResults();
            $data['paired_players'] = $this->player->where('player_id !=', 'none')->countAllResults();
            $data['operators'] = $this->account->where('access', 'operator')->countAllResults();
            $data['super_agents'] = $this->account->where('access', 'super_agent')->countAllResults();
            $data['agents'] = $this->account->where('access', 'agent')->countAllResults();
        }
        
        if($var == 'commissions'){
            
            $account_id = $this->request->getVar('id') ?? '';

            if($account_id == ''){
                $view = $this->access . '/dashboard';
            }else{
                $data['selected_account'] = $this->account->find($account_id);
                $data['list'] = $this->wallet->where('account_id', $account_id)->limit(2000)->orderBy('id','DESC')->find() ?? [];
                $data['payouts'] = $this->wallet->where('account_id', $account_id)->where('type', 'payout')->select('sum(amount) as total')->first()['total'] ?? 0;
                foreach ($data['list'] as $key => $value) {
                    $data['list'][$key]['player'] = $this->player->where('player_id',$value['player_id'])->first() ?? ['agent'=>'','super_agent'=>'','operator'=>''];
                }
                $data['commissions'] = $this->wallet->where('account_id', $account_id)->where('type', 'income')->select('sum(amount) as total')->first()['total'] ?? 0;
                
                // foreach ( $data['list'] as $k => $v) {
                //     $data['list'][$k]['player'] = $this->player->where('player_id', $v['player_id'])->first();
                // }
            }
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
        
        $import_logs = $this->logs->where("name","import_reports")->limit(100)->orderBy('id','DESC')->find();
        
        $data = [
            "balance" => $this->balance,
            "id" => $this->id,
            "menu" => 'reports',
            "action" => '',
            "reports" => [],
            "saved" => 0,
            "inserts" => [],
            "targetPath" => '',
            "import_logs" => $import_logs,
        ];
        
        if (isset($_POST["clear_reports"])) {
            $this->transaction->truncate();
        }


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
                
                $this->logs->save(["name"=>"import_reports","account_id"=> $this->id, "info" => $_FILES['file']['name'] ]);
                $data['targetPath'] = $targetPath;
            }
        }

        $data['current_trans_pending'] = $this->transaction->where("completed",0)->countAllResults();
        $data['current_trans_processed'] = $this->transaction->where("completed",1)->countAllResults();
        $data['game_players_pending'] = $this->gameplayer->where("linked",0)->countAllResults();
        $data['game_players_linked'] = $this->gameplayer->where("linked",1)->countAllResults();

        $all_linked_players = $this->gameplayer->where("linked",1)->find();
        $available_for_processing = 0;
        // foreach ($all_linked_players as $k => $v) {
        //     $available = $this->transaction->where("completed",0)->where("PLAYER_ID", $v['game_player_id'])->countAllResults();
        //     $available_for_processing += $available;
        // }
        $data['available_for_processing'] = $available_for_processing;

        return  view('header/dashboard')
                .view($this->access . '/reports',$data)
                .view('footer/dashboard');
    }
    
    public function news()
    {
        // NEWS
        if (!$this->logged) {
            return redirect()->to('login');
        }


        $data = [
            "action" => '',
            'menu' => '',
        ];

        // ADD NEWS
        if ($this->request->getMethod() == 'post' && $this->request->getVar('addNews')) {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'image' => 'is_image[image]|uploaded[image]|max_size[image, 2048]',
            ];

            if ($this->validate($rules)) {

                $title = $this->request->getPost('title', FILTER_SANITIZE_SPECIAL_CHARS);
                $content = $this->request->getPost('content', FILTER_SANITIZE_SPECIAL_CHARS);

                //HANDLING IMAGE
                $image = $this->request->getFile('image');

                $imageName = date('Y-m-d') . "_" . time() . "_" . $image->getName();

                // die($imageName);

                $newsData = [
                    'account_id' => $this->id,
                    'title' => $title,
                    'content' => $content,
                    'img_path' => $imageName,
                ];

                if ($this->news->insert($newsData) && $image->move('images', $imageName)) {
                    return redirect()->to($this->access . '/news');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        //EDIT NEWS
        if ($this->request->getGet('edit') != null) {
            $id = $this->request->getGet('edit');
            $newsToEdit = $this->news->where('id', $id)->first();

            //IF NEWS TO EDIT FOUND
            if ($newsToEdit) {
                $data['formUrl'] = 'news?edit=' . $newsToEdit['id'];
                $data['newsToEdit'] = $newsToEdit;

                // NEWS EDIT SUBMIT
                if ($this->request->getVar('editNews') && $this->request->getMethod() == 'post') {


                    //CHECK IF EDIT NEWS SUBMIT A FILE
                    if ($this->request->getFile('image')->getName() != null) {

                        $rules = [
                            'title' => 'required',
                            'content' => 'required',
                            'image' => 'is_image[image]|uploaded[image]|max_size[image, 2048]',
                        ];

                        //PASS VALIDATION
                        if ($this->validate($rules)) {

                            $title = $this->request->getPost('title', FILTER_SANITIZE_SPECIAL_CHARS);
                            $content = $this->request->getPost('content', FILTER_SANITIZE_SPECIAL_CHARS);

                            //DELETING PREVIOUS IMAGE
                            unlink('images/' . $newsToEdit['img_path']);

                            //HANDLING IMAGE
                            $image = $this->request->getFile('image');
                            $imageName = date('Y-m-d') . "_" . time() . "_" . $image->getName();

                            $dataToUpdate = [
                                'title' => $title,
                                'content' => $content,
                                'img_path' => $imageName,
                            ];


                            if ($this->news->update($newsToEdit['id'], $dataToUpdate) && $image->move('images', $imageName)) {
                                return redirect()->to($this->access . '/news');
                            }

                            // ERROR VALIDATION
                        } else {
                            $data['validation'] = $this->validator;
                        }

                        //NEWS EDIT DOES NOT SUBMIT A FILE
                    } else {

                        $rules = [
                            'title' => 'required',
                            'content' => 'required',
                        ];

                        //PASS VALIDATION
                        if ($this->validate($rules)) {

                            $title = $this->request->getPost('title', FILTER_SANITIZE_SPECIAL_CHARS);
                            $content = $this->request->getPost('content', FILTER_SANITIZE_SPECIAL_CHARS);

                            $dataToUpdate = [
                                'title' => $title,
                                'content' => $content,
                            ];


                            if ($this->news->update($newsToEdit['id'], $dataToUpdate)) {
                                return redirect()->to($this->access . '/news');
                            }

                            // ERROR VALIDATION
                        } else {
                            $data['validation'] = $this->validator;
                        }
                    }
                }

                return  view('header/dashboard')
                    . view($this->access . '/edit_news', $data)
                    . view('footer/dashboard');
            } else {
                return redirect()->to($this->access . '/news');
            }
        }

        //DELETE A POST
        if ($this->request->getMethod() == 'post' && $this->request->getVar('d-news')) {
            $id = $this->request->getVar('d-id', FILTER_SANITIZE_SPECIAL_CHARS);
            $newsToDelete = $this->news->where('id', $id)->first();

            //IF NEWS TO DELETE FOUND
            if ($newsToDelete) {
                unlink('images/' . $newsToDelete['img_path']);
                $this->news->delete($newsToDelete['id']);
                return redirect()->back();
            } else {
                return redirect()->to($this->access . '/news');
            }
        }

        return  view('header/dashboard')
            . view($this->access . '/add_news', $data)
            . view('footer/dashboard');
    }


}
