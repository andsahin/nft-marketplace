<?php namespace App\Modules\Nfts\Models\Users;

class User_nfts_model  {
    
    public function __construct(){
        $this->db = db_connect();
        $this->request = \Config\Services::request();

    }


    public function nfts_with_listing_info($tokenid, $nftTableId)
    {
    	$builder = $this->db->table('nfts_store');
        $builder->select('nfts_store.*, nfts_store.id as nftId, user.f_name, user.l_name, nft_category.cat_name, nft_collection.title as collection_title, nft_listing.*, nft_listing.id as listing_id');
        $builder->where('nfts_store.token_id', $tokenid);
        $builder->where('nfts_store.id', $nftTableId);  
        $builder->where('nfts_store.status', 3);  
        $builder->where('nft_listing.status', 0);  
        $builder->orderBy('nfts_store.id', 'DESC');
        $builder->join('user', 'user.user_id=nfts_store.user_id', 'left');
        $builder->join('nft_category', 'nft_category.id=nfts_store.category_id', 'left');
        $builder->join('nft_collection', 'nft_collection.id=nfts_store.collection_id', 'left'); 
        $builder->join('nft_listing', 'nft_listing.nft_store_id=nfts_store.id', 'left'); 
        $query = $builder->get();  
        if($query->getRow()){
        	return $query->getRow(); 
        }else{
        	return array();
        }

        
        
    }


    public function get_all($table, $where = array(), $field = null, $orderBy = null)
    {
    	$builder = $this->db->table($table)->select("{$table}.*, user.f_name, user.l_name")
        ->where($where)
        ->join("user", "user.user_id={$table}.bid_from_id", "left")
        ->orderBy($field, $orderBy)
        ->limit(10)
        ->get(); 
    	if(count($builder->getResult())){
    		return $builder->getResult();
    	}else{
    		return array();
    	} 
    }


    public function saveListingLog(Object $data, int $status)
    { 
        $data->listing_id = $data->id;
        $data->status = $status; 
        unset($data->id); 
        $this->db->table('nft_listing_log')->insert((array) $data);
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

    public function nftStoreLogSave($id, $status)
    { 
        $nftInfo = $this->db->table('nfts_store')->where(['id'=>$id])->get()->getrow(); 

        $nftInfo->store_id = $nftInfo->id;
        $nftInfo->ownership = $status; 
         
        unset($nftInfo->id); 
        $this->db->table('nfts_store_log')->insert((array) $nftInfo);
        return $this->db->insertID();  
    }


    public function get_all_collection($table, $where = array(), $limit = 0, $offset = 0,$title,$name){

        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($where);
        $builder->limit($limit,$offset);
        $builder->orderBy($title,$name);
        $query=$builder->get();
        $data=$query->getResult();
        if($data){
            foreach ($data as $key => $collection) {
               $collection->totalNfts = $this->countRow('nfts_store', ['collection_id'=>$collection->id]);
            }
        }
        return $data;
    }


    #------------------------
    #Count All Data from TABLE
    #-------------------------
    public function countRow($table, $where = array()){
        
        return $resutl = $this->db->table($table)
                       ->where($where)
                       ->countAllResults(); 
    }
    


}