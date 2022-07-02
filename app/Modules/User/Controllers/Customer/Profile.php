<?php 
namespace App\Modules\User\Controllers\Customer;

class Profile extends BaseController {
 	 
    function __construct()
    {
        $this->network = BNETWORK;
        $this->currency = SYMBOL;
    }


 
    /*
    |----------------------------------
    |   view profile
    |----------------------------------
    */ 
	public function index()
	{  
        $user_id = $this->session->userdata('user_id');
        $where = array(
            'user_id' => $user_id
        );

        $this->validation->setRule('first_name', display('firstname'), 'required|alpha_space');
        $this->validation->setRule('last_name', display('lastname'), 'required|alpha_space');  
         
        if ($this->validation->withRequest($this->request)->run()) {

            $proImg = $this->request->getFile('profile_image',FILTER_SANITIZE_STRING);
            $bannerImg = $this->request->getFile('banner_image',FILTER_SANITIZE_STRING);
             
                $savepath="public/uploads/dashboard/new/";
                $old_image = $this->request->getVar('old_profile_image', FILTER_SANITIZE_STRING);

                $savepath1 ="public/uploads/dashboard/banner/";
                $old_image1 = $this->request->getVar('old_banner_img', FILTER_SANITIZE_STRING);

                if($this->request->getMethod() == "post"){
                    if (!empty($proImg)) {
                        $proImage = $this->imagelibrary->Image($proImg,$savepath,$old_image,300,300);
                    }
                    
                    if (!empty($bannerImg)) {
                        $bannerImage = $this->imagelibrary->Image($bannerImg,$savepath1,$old_image1,1400,400);
                    }    
                } 
 
            $userdata = array( 
                'f_name'      => $this->request->getVar('first_name',FILTER_SANITIZE_STRING),
                'l_name'      => $this->request->getVar('last_name',FILTER_SANITIZE_STRING), 
                'bio'      => $this->request->getVar('bio',FILTER_SANITIZE_STRING), 
                'portfolio_url'      => $this->request->getVar('portfolio_url',FILTER_SANITIZE_STRING), 
            );
             
            
             
            if(isset($bannerImage)){
                $userdata['banner_image'] = $bannerImage;
            }
             
            if($proImage){
                $userdata['image'] = explode("/", $proImage)[5];
            }
 
            $update = $this->common_model->update('user', $where, $userdata);
            if($update){
                $this->session->setFlashdata('message',display('update_successfully'));
                return redirect()->to(base_url('user/settings'));
            }else{
                $this->session->setFlashdata('exception',display('please_try_again'));
                return redirect()->to(base_url('user/settings'));
            }
            

        }

        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){

            $this->session->setFlashdata('exception', $error);

            return  redirect()->to(base_url('user/settings'));
        }
        if ($this->session->getFlashdata('exception') != null) {  
            $data['exception'] = $this->session->getFlashdata('exception');
        }else if($this->session->getFlashdata('message') != null){
            $data['message'] = $this->session->getFlashdata('message');
        }

        
        $data['title']  = display('profile');
        $data['languageList'] = $this->languageList(); 
        
        $data['profile'] = $this->common_model->read('user',$where);

        $data['walletInfo'] = $this->common_model->read('user_wallet',$where);

        $data['acInfo'] = $this->common_model->read('user_account',$where);

        $data['trxInfo'] = $this->common_model->where_rows('user_transaction', $where, 'ac_id', 'DESC');
        $data['network'] = $this->common_model->where_row('blockchain_network');


        
        $data['frontendAssets'] = base_url('public/assets/website');
        $data['content']        = view($this->BASE_VIEW . '\profile',$data);
        return $this->template->website_layout($data);
	}

    /*
    |----------------------------------
    |   Update save profile 
    |----------------------------------
    */
	public function update()
	{
	    $this->validation->setRule('f_name', display('firstname'), 'required|alpha_space');
	    $this->validation->setRule('l_name', display('lastname'), 'required|alpha_space');  
	    $this->validation->setRule('image', display('image'), 'ext_in[image,png,jpg,gif,ico]|is_image[image]');
	    if ($this->validation->withRequest($this->request)->run()) {
	        
            $img = $this->request->getFile('image',FILTER_SANITIZE_STRING);
                $savepath="public/uploads/dashboard/new/";
                $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING);
                if($this->request->getMethod() == "post"){
                    $image=$this->imagelibrary->image($img,$savepath,$old_image,51,80);
                }
                
    		$userdata = array(
                
    			'language'    => $this->request->getVar('language',FILTER_SANITIZE_STRING),
    			'f_name' 	  => $this->request->getVar('f_name',FILTER_SANITIZE_STRING),
    			'l_name' 	  => $this->request->getVar('l_name',FILTER_SANITIZE_STRING),
    			'email' 	  => $this->request->getVar('email',FILTER_SANITIZE_STRING),
    			'phone' 	  => $this->request->getVar('mobile',FILTER_SANITIZE_STRING),
    			'image'   	  => (!empty($image)?$image:$this->request->getVar('old_image',FILTER_SANITIZE_STRING)),
    		
            );
            
            
           
            $email = $this->db->table('user')->select('email')->where('user_id', $this->session->userdata('user_id'))->get()->getRow();
            $appSetting = $this->common_model->get_setting();
            $varify_code = $this->randomID();
    
            $template = array( 
                'fullname'      => $this->session->userdata('fullname'),
                'amount'        => @$amount,
                'balance'       => @$blance['balance'],
                'pre_balance'   => @$blance['balance'],
                'new_balance'   => @$blance['balance'],
                'user_id'       => $this->session->userdata('user_id'),
                'receiver_id'   => $this->session->userdata('user_id'),
                'varify_code'   => $varify_code,
                'date'          => date('d F Y')
            );
            $config_var = array( 
                'template_name' => 'profile_update',
                'template_lang' => 'english',
            );
            $message    = $this->common_model->email_msg_generate($config_var, $template);
            $send_email = array(
                'title'         => $appSetting->title,
                'to'            => $email->email,
                'subject'       => $message['subject'],
                'message'       => $message['message'],
            );
            $send = $this->common_model->send_email($send_email);
            
            #-----------------------------
            if(isset($send)){
    
                $varify_data = array(
    
                    'ip_address'    => $this->request->getIpAddress(),
                    'user_id'       => $this->session->userdata('user_id'),
                    'session_id'    => $this->session->userdata('isLogIn'),
                    'verify_code'   => $varify_code,
                    'data'          => json_encode($userdata)
    
                );
                
                $this->common_model->insert('verify_tbl',$varify_data);
                $id = $this->db->insertId();
    
                return redirect()->to(base_url('customer/profile/profile_verify/'.$id));
                    
            } 
	    }
	    $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
        }
	    return redirect()->to(base_url('customer/profile/edit_profile'));

	}


    public function withdraw()
    {
 
        $userId             = $this->session->userdata('user_id');
        $network            = $this->common_model->where_row('blockchain_network');
        $getUserWallet      = $this->common_model->where_row('user_wallet', ['user_id'=>$userId]);
        $userPrivateData    = $this->blockchain->privateCredential($getUserWallet); 

        
            // amount transfer blockchain 
             
        $this->validation->setRule('wallet_address', 'Wallet address', 'required');
        $this->validation->setRule('amount', 'Send amount', 'required');

        if ($this->validation->withRequest($this->request)->run()) {

            $toWallet = $this->request->getVar('wallet_address',FILTER_SANITIZE_STRING);
            $amount = $this->request->getVar('amount',FILTER_SANITIZE_STRING);

            $arr = array( 
   
                'formAddress'       => '0x'.$userPrivateData->data->address,
                'toAddress'         => $toWallet, 
                'sendAmount'        => number_format($amount, 4), 
                'privateKey'        => $userPrivateData->data->privatekey,
                "netWork"           => $this->network,

            );


            $trxArr = array( 
   
                'user_id'               => $userId,
                'currency_id'           => 2, 
                'symbol'                => 'ETH', 
                'transaction_type_id'   => 2,
                "transaction_type"      => 'Withdraw',
                "transaction_method"    => 'Self',
                "amount"                => number_format($amount, 4), 
                "created_at"            => date('Y-m-d H:i:s'), 

            );
 
            $res        = $this->blockchain->withdraw('api/transaction/sendBaseCoin', $arr);
            
            $resDecode  = json_decode($res);

            if(isset($resDecode->status)){

                if($resDecode->status == 'error'){

                    $trxArr["trx_info"] =  $res;
                    $trxArr["status"]   =  $resDecode->status;

                    $this->common_model->insert('user_transaction', $trxArr);

                    $this->session->setFlashdata('exception', $resDecode->msg);
                    return  redirect()->to(base_url('user/settings'));

                } else {

                    $trxArr["trx_info"] =  $res;
                    $trxArr["status"]   =  $resDecode->status;

                    $this->common_model->insert('user_transaction', $trxArr);

 
                    $this->session->setFlashdata('message', 'Withdraw Successfully (<a target="_blank" href="'.$network->explore_url.'/tx/'.$resDecode->data->txHash.'">Check your transaction)</a>');
                    return  redirect()->to(base_url('user/settings'));

                }
            }

            $this->session->setFlashdata('exception', display('please_try_again'));
            return  redirect()->to(base_url('user/settings'));   

        }

        $error  = $this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
        }
        return  redirect()->to(base_url('user/settings'));
         
    }


    public function profile_verify($id=NULL)
    {
        $data['title']   = display('change_verify');
        $data['content'] = $this->BASE_VIEW . '\profile_verify';
        return $this->template->customer_layout($data);
        
    }


    public function profile_update()
    {
        $code = $this->request->getVar('code',FILTER_SANITIZE_STRING);
        $id   = $this->request->getVar('id',FILTER_SANITIZE_STRING);

        $data = $this->db->table('verify_tbl')->select('*')
        ->where('verify_code',$code)
        ->where('id',$id)
        ->where('session_id',$this->session->userdata('isLogIn'))
        ->get()
        ->getRow();

        if($data!=NULL) {
            $p_data = ((array) json_decode($data->data));

            $user_id = $this->session->userdata('user_id');
            $userWhere = array(
                'user_id' => $user_id
            );
            $this->common_model->update('user',$userWhere,$p_data);
            $this->session->set(['image'=>$p_data['image']]);
            $this->session->setFlashdata('message',display('update_successfully'));
            
            echo 1;

        }else{

            echo 2;
        }
    }

    public function change_password()
    {
        $data['title']   = display('change_password'); 
        $data['content'] = $this->BASE_VIEW . '\change_password';
        return $this->template->customer_layout($data);
    }


    public function change_save(){
        
        $this->validation->setRule('old_pass', display('enter_old_password'), 'required');
        $this->validation->setRule('new_pass', display('enter_new_password'), 'required|max_length[32]|matches[confirm_pass]');
        $this->validation->setRule('confirm_pass', display('enter_confirm_password'), 'required|max_length[32]');
      
        if ($this->validation->withRequest($this->request)->run()) {
            
            $oldpass = MD5($this->request->getVar('old_pass',FILTER_SANITIZE_STRING));
            $new_pass['password'] = MD5($this->request->getVar('new_pass',FILTER_SANITIZE_STRING));

            $query = $this->db->table('user')->select('password')
            ->where('user_id',$this->session->userdata('user_id'))
            ->where('password',$oldpass)
            ->countALl();

            if($query > 0) {
                $where = array(
                  'user_id' => $this->session->userdata('user_id')  
                );
                $this->common_model->update('user',$where,$new_pass);
                
                $this->session->setFlashdata('message', display('password_change_successfull'));
                return redirect()->to(base_url('customer/profile/change_password'));

            } else {
                $this->session->setFlashdata('exception',display('old_password_is_wrong'));
                return redirect()->to(base_url('customer/profile/change_password'));
            }

        } else {
            
            $data['set_old'] = (object)$_POST;
            
            $data['title']   = display('change_password'); 
            
            $data['content'] = $this->BASE_VIEW . '\change_password';
            return $this->template->customer_layout($data);
     
        
        }

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



    public function languageList()
    { 
        if ($this->db->tableExists("language")) { 

                $fields = $this->db->getFieldData("language");
                $i = 1;
                foreach ($fields as $field)
                {  
                    if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
                }

                if (!empty($result)) return $result;
 

        } else {
            return false; 
        }
    }


}
