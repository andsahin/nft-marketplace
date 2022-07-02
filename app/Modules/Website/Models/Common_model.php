<?php namespace App\Modules\Website\Models;
class common_model {
    public function __construct(){
        $this->db = db_connect();
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
        $query      =$builder->get();
        return $data=$query->getResult();
    }
    #-----------------
    #Insert ANY TABLE
    #----------------
    public function insert($table,$data=array()){
            $builder=$this->db->table($table);
            return $builder->insert($data);
    }
    #-----------------
    #UPDATE ANY TABLE
    #----------------
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
        return $data=$query->getResult();
    }
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
        $builder    =    $this->db->table($table);
        return $builder->where($where)
			->delete();
    }
    
    
   
    public function send_email($post=array()){

        $email = \Config\Services::email();
        $where = array(
            'es_id' => 2
        );
        $emailquery = $this->read('email_sms_gateway',$where);
        
        if(!isset($emailquery)){ 
            return 0;
        }      

        //SMTP & mail configuration
        $config['protocol'] =   $emailquery->protocol;
        $config['SMTPHost'] =    $emailquery->host;
        $config['SMTPPort'] =    $emailquery->port;
        $config['SMTPUser']= $emailquery->user;
        $config['SMTPPass']= $emailquery->password;
        $config['mailType']= $emailquery->mailtype;
        $config['charset']  = $emailquery->charset;
        $config['wordWrap'] = true;
                
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
     
       $templateemail = $this->db->table('sms_email_template')->select('*')->where('template_name', @$config['template_name'])->where('sms_or_email', 'email')->get()->getRow();
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


    public function item_activity($nftStoreId, $tokenId)
    { 

        $nftInfo = $this->db->table('nfts_store')->select('nfts_store.*, user.f_name, user.l_name')->where(['id'=>$nftStoreId, 'token_id'=>$tokenId])->join('user', 'user.user_id=nfts_store.user_id')->get()->getRow();
         
        $arr[] = [
            'type'              => 'Mint',
            'nftId'             => $nftInfo->id,
            'from'              => $nftInfo->f_name.' '.$nftInfo->l_name, 
            'contract_address'  => $nftInfo->contract_address,
            'token_id'          => $nftInfo->token_id,
            'token_standard'    => $nftInfo->token_standard,
            'is_minted'         => $nftInfo->is_minted,
            'created_at'        => $nftInfo->created_at,
        ];

        /* Listing info */
        $listingInfo = $this->db->table('nft_listing_log')->select('nft_listing_log.*, user.f_name, user.l_name')->where(['nft_store_id'=>$nftStoreId, 'nft_token_id'=>$tokenId])->join('user', 'user.user_id=nft_listing_log.list_from')->get()->getresult();


        foreach ($listingInfo as $listingValue) {
           $arr[] = [
                'type'          => 'List',
                'nftId'         => $listingValue->nft_store_id,
                'from'          => $listingValue->f_name.' '.$listingValue->l_name,
                'token_id'      => $listingValue->nft_token_id,   
                'min_price'     => $listingValue->min_price,
                'list_status'   => $listingValue->status,
                'created_at'    => $listingValue->created_at,  
           ];
        }


        /* bidding info */
        $bidingInfo = $this->db->table('nft_biding')->select('nft_biding.*, user.f_name, user.l_name')->where(['nft_id'=>$nftStoreId])->orderBy('created_at', 'DESC')->join('user', 'user.user_id=nft_biding.bid_from_id')->get()->getresult();
         

        foreach ($bidingInfo as $bidingValue) {
            $arr[] = [
                'type'          => 'Bid',
                'nftId'         => $bidingValue->nft_id,
                'from'          => $bidingValue->f_name.' '.$bidingValue->l_name, 
                'token_id'      => $nftInfo->token_id,   
                'bid_amount'    => $bidingValue->bid_amount, 
                'created_at'    => $bidingValue->bid_start_at, 
           ];
        } 

        if(count($arr) > 0){
            return $this->desndingOrderArsort($arr, "created_at");
        }else{
            return array();
        }
        
  
    }
 
    function desndingOrderArsort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        arsort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;

       return $array;
    }


    public function getListingWithNftstoreInfo()
    {
 
        $result = $this->db->query("SELECT `dbt_nft_listing`.*, `dbt_nfts_store`.`id` as `nftId`, `dbt_nfts_store`.`contract_address`, `dbt_nfts_store`.`status` as `nftStatus` FROM `dbt_nft_listing` JOIN `dbt_nfts_store` ON `dbt_nfts_store`.`id`=`dbt_nft_listing`.`nft_store_id` WHERE DATE_FORMAT(end_date,'%d') = DATE_FORMAT(CURRENT_DATE, '%d') AND `dbt_nft_listing`.`status` = 0;")->getResult();
          
        if(!empty($result)){
            return $result;
        }else{
            return array();
        }

     
    }


    public function getUserWalletAccountInfo($userId)
    {
       $info = $this->db->table('user_wallet')
       ->select('user_wallet.*, user_account.balance as account_balance, user_account.hold_balance')
       ->where('user_wallet.user_id', $userId)
       ->join('user_account', 'user_account.user_id=user_wallet.user_id')
       ->get()
       ->getRow();

       if(!empty($info)){
            return $info;
       }else{
            return array();
       }
    }


    public function getAcceptableBidInfo($listingId, $nft_id)
    {
        $bidInfo = $this->db->table('nft_biding')
        ->select('*')
        ->where(['nft_listing_id'=>$listingId, 'nft_id'=> $nft_id, 'cancel_status'=> 0, 'accept_status'=> 0])
        ->orderBy('bid_amount', 'DESC')->get()->getRow();

        if(!empty($bidInfo)){
            return $bidInfo;
        }else{
            return array();
        }
    }

    public function getSearchingValues($table, $field, $where=array(), $key)
    {
        $res = $this->db->table($table)->select('*')->where($where)->like($field, $key)->limit(10)->get()->getResult();
        if($res){
            return $res;
        }else{
            return false;
        }
    }

    public function nftStoreLogSave($id, $status)
    { 
        $nftInfo = $this->db->table('nfts_store')->where(['id'=>$id])->get()->getrow(); 

        $nftInfo->store_id = $nftInfo->id;
        $nftInfo->ownership = $status; 
         
        unset($nftInfo->id); 
        $this->db->table('nfts_store_log')->insert((array) $nftInfo);
        return $this->db->insertID();  
    }

    public function saveListingLog2(int $id, int $status)
    {
        $data = $this->db->table('nft_listing')->where(['id'=>$id])->get()->getrow(); 

        $data->listing_id = $data->id;
        $data->status = $status; 
        unset($data->id);  
        $this->db->table('nft_listing_log')->insert((array) $data);
        return $this->db->insertID(); 
    }


}