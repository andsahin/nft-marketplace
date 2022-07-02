<?php 
namespace App\Modules\User\Controllers\Admin;

class User extends BaseController {
    
    
 
    public function index()
    {   
        
        $data['title']  = display('Customer_List');
        $uri = service('uri','<?php echo base_url(); ?>'); 

        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
       
        $total           = $this->common_model->countRow('user');
        $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        $data['content'] = $this->BASE_VIEW . '\user\list';
        return $this->template->admin_layout($data);
    }

    /*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    public function ajax_list()
    {
        $table = 'user';
        $column_order = array(null, 'username','f_name','l_name','email','phone','status','created'); //set column field database for datatable orderable
        $column_search = array('username','f_name','l_name','email','phone','status','created'); //set column field database for datatable searchable 

        $networkdata = $this->common_model->where_row('blockchain_network');
        $order = array('uid' => 'DESC'); // default order 
        $secondtable = 'user_wallet';  
        $join = 'user_wallet.user_id=user.user_id';  
        $list = $this->user_model->get_datatables($table,$column_order,$column_search,$order,$where=array(),$join,$secondtable);
        
        $data = array();
        $no = $this->request->getvar('start');
        foreach ($list as $users) {
            $no++;
            $row = array();
            $row[] = $no;  
            $row[] = '<a href="'.base_url("backend/customer/details/$users->uid").'">'.$users->f_name." ".$users->l_name.'</a>';
            $row[] = '<a href="'.base_url("backend/customer/details/$users->uid").'">'.$users->username.'</a>';
            $row[] = $users->email; 
             $row[] = '<a target="_blank" href="'.$networkdata->explore_url.'/address/0x'.$users->wallet_address.'">0x'.$users->wallet_address.'</a>';
            $row[] = '<a href="'.base_url("backend/customers/customer_info/$users->uid").'"'.' class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit">';


            $data[] = $row;
        }

        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->user_model->count_all($table),
                "recordsFiltered" => $this->user_model->count_filtered($table,$column_order,$column_search,$order),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }


 
    public function form($uid = null)
    { 
            
            $data['title']  = display('add_user');
            if (!empty($uid)){

                $this->validation->setRules(['username' => "required|max_length[100]|username_check[$uid]",'email' => "required|valid_email|max_length[100]|email_check[$uid]"],['username' => [ 'username_check' => 'This Username is already registered.'],'email' => [ 'email_check' => 'This Email is already registered.']]);      

            }else{
                $this->validation->setRule('username', display('username'),'required|is_unique[user.username]|max_length[20]');
                $this->validation->setRule('email', display('email'),'required|valid_email|is_unique[user.email]|max_length[100]'); 
            }  
            
            $this->validation->setRule('status', display('status'),'required|max_length[1]');

            if(isset($_POST['add'])){ 
                 
                $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5'); 
                $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');

            } else if(isset($_POST['edit'])){

                

                if($this->request->getVar('password',FILTER_SANITIZE_STRING)){
                    

                    $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');
    
                    $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');
    
                }

            }

           
            

            if (empty($uid)){ 
                $uId = $this->randomID();
                $data['user'] = (object)$userdata = array(
                    'user_id'     => $uId,
                    'username'    => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                    'f_name'      => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
                    'l_name'      => $this->request->getVar('l_name',FILTER_SANITIZE_STRING),
                    'email'       => $this->request->getVar('email',FILTER_SANITIZE_STRING),
                    'password'    => md5($this->request->getVar('password',FILTER_SANITIZE_STRING)), 
                    'reg_ip'      => $this->request->getIPAddress(),
                    'status'      => $this->request->getVar('status',FILTER_SANITIZE_STRING)    
                );

            }else{
                

                    $data['user']  = (object)$userdata = array(
                    'uid'                 => $this->request->getVar('uid',FILTER_SANITIZE_STRING),
                    'user_id'             => $this->request->getVar('user_id',FILTER_SANITIZE_STRING), 
                    'username'            => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                    'f_name'              => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
                    'l_name'              => $this->request->getVar('l_name',FILTER_SANITIZE_STRING),
                    'email'               => $this->request->getVar('email',FILTER_SANITIZE_STRING), 
                    'phone'               => $this->request->getVar('phone',FILTER_SANITIZE_STRING),
                    'reg_ip'              => $this->request->getIPAddress(),
                    'status'              => $this->request->getVar('status',FILTER_SANITIZE_STRING)
                    );

                    if($this->request->getVar('password',FILTER_SANITIZE_STRING)){
                        $userdata['password'] = md5($this->request->getVar('password',FILTER_SANITIZE_STRING));
                    }
            }

             

        if ($this->validation->withRequest($this->request)->run()){
 
            $db=db_connect(); 

            if (empty($uid)){

                $builder = $this->db->table('user'); 
                $builder->insert($userdata);
                $userID = $this->db->insertID();

                if ($userID) {

                    $obj_value = (object) ["user_id"=> $uId, "password"=> $this->request->getVar('password',FILTER_SANITIZE_STRING)]; 
                    $res = $this->blockchain->createWallet($obj_value);  
                    $this->common_model->insert('user_account', ['user_id'=>$uId, 'currency_id'=>'3', 'symbol'=>'BNB', 'balance'=>'0']);

                    $this->session->setFlashdata('message', display('save_successfully'));
                }else{
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/customers/customer_info/'));
            }else{
                $where = array( 
                        'uid'            => $uid
                 );
                if ($this->common_model->update('user',$where,$userdata)) {
                    $this->session->setFlashdata('message', display('update_successfully'));
                } else {
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/customers/customer_info/'.$uid));
            }
        }


        if(!empty($uid)){
            
                $data['editform'] = 1;
                $data['title'] = display('edit_user');
                $data['user']   = $this->user_model->single($uid);
        }
     
        $data['content'] = $this->BASE_VIEW . '\user\form';
        return $this->template->admin_layout($data);
    }

    public function details($uid = null)
    { 

     
        $data['title']  = display('details');

        if(!empty($uid)) {
            $where = array( 
                 'uid'            => $uid
            );  
            $data['user']       = $this->common_model->read('user',$where); 
            $where2 = ['user_id'=> $data['user']->user_id];
            $data['wallet_info'] = $this->common_model->read('user_wallet',$where2);  

            $pagewhere = array( 
                'user_id'            => $data['user']->user_id
            ); 

        }

        $data['content'] = $this->BASE_VIEW . '\user\user_details';
        return $this->template->admin_layout($data);
    }


    public function wallet_balance($uid=null)
    {
        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
            return redirect()->to('admin');
        }

        if(empty($uid)){
            return redirect()->to(base_url('backend/customers/customer_list'));
        } 


        $where = ['uid'=> $uid];  
        $user       = $this->common_model->read('user',$where); 
        $where2 = ['user_id'=> $user->user_id];
        $info = $this->common_model->read('user_wallet',$where2);
 
        $res = $this->blockchain->baseCoinBalance($info->wallet_address, 'ETH'); 
          
        if($res->status === 'success'){ 

            $builder = $this->db->table('user_wallet');
            $builder->where(['user_id'=> $info->user_id, 'wallet_address'=>$info->wallet_address])->update(['balance'=> $res->data->balance]); 

 
            echo json_encode(['status' =>'success', 'balance'=> $res->data->balance,'msg'=>'update successfully']); 
            exit;
        }else{ 

            echo json_encode(['status' =>'error', 'msg'=>'error']); 
            exit;
        }  

    }
  

    public function delete($user_id = null)
    {  
        if ($this->user_model->delete($user_id)) {
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("backend/user/user");
    }

    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */
}

