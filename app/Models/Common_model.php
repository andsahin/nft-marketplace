<?php 
namespace App\Models;

class Common_model {
    
    public function __construct(){
        $this->db = db_connect();
        $this->session = \Config\Services::session();
    }
    
    #------------------------
    #Read All Data from TABLE
    #-------------------------
    
    public function get_all($table, $where = array(), $limit = 0, $offset = 0,$title,$name){

        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($where);
        $builder->limit($limit,$offset);
        $builder->orderBy($title,$name);
        $query=$builder->get();
        return $data=$query->getResult();
    }
    
    #----------------------
    #Insert Into ANY TABLE 
    #----------------------
    public function insert($table,$data=array()){
    		
            $builder=$this->db->table($table);
            return $builder->insert($data);
    }
    
    #-----------------
    #UPDATE ANY TABLE
    #-----------------
     public function update($table,$where = array(),$data=array()){
        $builder=$this->db->table($table);
        return $builder->where($where)
                       ->update($data);
    }
    
    #-----------------
    #Read ANY TABLE
    #----------------
    public function read($table,$where = array(),$limit=null, $offset=null)
    {
            $builder=$this->db->table($table);
            return $builder->select("*")
                    ->where($where)
                    ->limit($limit, $offset)
                    ->get()
                    ->getRow();
    }

    public function where_row($table,$where=array())
    {
            $builder=$this->db->table($table);
            return $builder->select("*")
                    ->where($where)
                    ->get()
                    ->getRow();
    }

    public function where_rows($table,$where=array(), $field=null, $str=null)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($where); 
        $builder->orderBy($field,$str);
        $query=$builder->get();
        $data = $query->getResult();
        if(count($data) > 0){
            return $data;
        }else{
            return array();
        }
    }

    #------------------------
    #Get item activity
    #-------------------------
 
    
    
    #------------------------
    #Count All Data from TABLE
    #-------------------------
    public function countRow($table, $where = array()){
        
        return $resutl = $this->db->table($table)
                       ->where($where)
                       ->countAllResults(); 
    }
    
    #------------------------
    #Delete a row from TABLE
    #-------------------------
    public function deleteRow($table,$where){
        $builder=$this->db->table($table);
        return $builder->where($where)
			->delete();
    }
    
    
   
	public function send_email($post=array()){

        $email = \Config\Services::email();
		$where = array(
                    'es_id' => 2
                );
        $emailquery = $this->read('email_sms_gateway',$where);
                       

		//SMTP & mail configuration
        $config['protocol'] =   $emailquery->protocol;
        $config['SMTPHost'] =    $emailquery->host;
        $config['SMTPPort'] =    $emailquery->port;
        $config['SMTPUser']= $emailquery->user;
        $config['SMTPPass']= $emailquery->password;
        $config['mailType']= $emailquery->mailtype;
        $config['charset']  = $emailquery->charset;
        $config['wordWrap'] = true;
        
        //Intial the email config
        $email->initialize($config);


		//Email content
		$htmlContent = $post['message'];

        $email->setFrom($emailquery->user, $post['title']);
        $email->setTo($post['to']);
        

        $email->setSubject($post['subject']);
        $email->setMessage($htmlContent);
       
        
		//Send email
		if($ne=$email->send()){
		  
			return 1;

		} else{
		   
			return 0;

		}
	}

	public function email_msg_generate($config = array(), $message_data = array()){
     
		$templateemail = $this->db->table('dbt_sms_email_template')->select('*')->where('template_name', @$config['template_name'])->where('sms_or_email', 'email')->get()->getRow();
        $message  	   = ($config['template_lang']=='en')?$templateemail->template_en:$templateemail->template_fr;
        
        if (is_array($message_data) && sizeof($message_data) > 0){
            $message = $this->_template($message, $message_data);
        }

		//Email content
		$htmlContent = $message;
		$subject 	 = ($config['template_lang']=='en')?$templateemail->subject_en:$templateemail->subject_fr;
		$data = array(
					'subject'	=> $subject,
					'message'	=> $message
				);
		return $data;

	}

    private function _template($template = null, $data = array())
    {
        $newStr = $template;
        foreach ($data as $key => $value) {
            $newStr = str_replace("%$key%", $value, $newStr);
        } 
        return $newStr; 
    }


	public function sms_msg_generate($config = array(), $message_data = array()){

	    $templatesms = $this->db->table('dbt_sms_email_template')->select('*')->where('template_name', @$config['template_name'])->where('sms_or_email', 'sms')->get()->getRow();
        $message  	 = ($config['template_lang']=='en')?$templatesms->template_en:$templatesms->template_fr;
        if (is_array($message_data) && sizeof($message_data) > 0){
            $message = $this->_template($message, $message_data);
        }
        
        $subject 	 = ($config['template_lang']=='en')?$templatesms->subject_en:$templatesms->subject_fr;
        $data = array(
					'subject'	=> $subject,
					'message'	=> $message
				);
		return $data;
    }

	public function email_sms($method)
	{
            $builder=$this->db->table("sms_email_send_setup");
            return $builder->select('*')
                            ->where('method',$method)
                            ->get()
                            ->getrow();

	}

       public function get_setting(){
            $builder =$this->db->table("setting");
		return $settings = $builder->select("email,phone,time_zone,title")
                                            ->get()
                                            ->getRow();
	}
        
        public function payment_gateway()
	{
                $builder =$this->db->table("payment_gateway");
		return $builder->select('*')
                                ->where('status', 1)
                                ->get()
                                ->getresult();
	}
     
	 
        public function getFees($table,$id)
	{       
        $builder = $this->db->table($table);
		return $builder->select('*')
		->where($table.'_id',$id)
		->get()
		->getrow();
	}
        
	public function retriveUserInfo()
	{
        $builder = $this->db->table('user_registration');
		return $builder->select('*')
			->where('user_id', $this->session->get('user_id'))
			->get()
			->getrow();
	}


    public function slug_clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function getUserWalletAccountInfo($userId)
    {
       $info = $this->db->table('user_wallet')
       ->select('user_wallet.*, user_account.balance as account_balance')
       ->where('user_wallet.user_id', $userId)
       ->join('user_account', 'user_account.user_id=user_wallet.user_id', 'left')
       ->get()
       ->getRow();

       if(!empty($info)){
            return $info;
       }else{
            return array();
       }
    }

    public function getListingWithNftstoreInfo($where)
    {

        $today = date('Y-m-d'); 
        $result = $this->db->table('nft_listing')->select('nft_listing.*, nfts_store.id as nftId, nfts_store.contract_address, nfts_store.status as nftStatus')
        ->where($where)
        ->join('nfts_store', 'nfts_store.id=nft_listing.nft_store_id', 'left')
        ->get()->getrow();

        if(!empty($result)){
            return $result;
        }else{
            return array();
        }
 
    }

}