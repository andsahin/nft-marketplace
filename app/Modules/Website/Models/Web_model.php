<?php 
namespace App\Modules\Website\Models;

class Web_model {

	function __construct() {
            $this->db =  db_connect();
            $this->tableName = 'user';
            $this->primaryKey = 'uid';
            $this->session = \Config\Services::session();
         }

	public function registerUser($data = [])
	{	 
                $builder=$this->db->table('user');
		$data['modified'] = date("Y-m-d H:i:s");  
		$data['created'] = date("Y-m-d H:i:s");
                return $builder->insert($data);
                

	}
	
	public function updateUser($data)
	{
            $data['modified'] = date("Y-m-d H:i:s");
            $builder=$this->db->table('user');
                return $builder->where(array('email'=>$data['email']))
                               ->update($data);

	}
	public function activeAccountSelect($activecode='')
  	{   
	    $builder = $this->db->table('user');
	    return $builder->select("user.user_id")
	      			   ->where('user_id', $activecode);
  	}
	public function activeAccount($activecode='')
  	{
      	$data = array('status' => '1');
  
    	$builder=$this->db->table('user');
        return $builder->where('user_id', $activecode)
                       ->update($data);
  	}
	public function checkUser($data = array())
	{
                $builder = $this->db->table('user');
		$where = "(email ='".$data['email']."' OR username = '".$data['email']."')";
		return $builder->select("*")
			->where($where)
			->get();
	}

	public function checkDuplictemail($data = [])
	{
                $builder = $this->db->table('user');
		return $builder->select("user.email")
			->where('email', $data['email'])
			->get();
	}


	public function checkDuplictuser($data = [])
	{	 
                $builder = $this->db->table('user');
		return $builder->select("user.username")
			->where('username', $data['username'])
                        ->get()
			->getRow();
	}
        

	public function active_slider()
	{
                $builder = $this->db->table('web_slider');
		return $builder->select('*')
			->where('status', 1)
			->orderBy('slider_id', 'asc')
			->get()
			->getResult();
	}

	public function social_link()
	{   
                $builder = $this->db->table('web_social_link');
		return $builder->select('*')
			->where('status', 1)
			->orderBy('id', 'asc')
			->get()
			->getResult();
	}
	
	public function categoryList()
	{	 
                $builder = $this->db->table('web_category');
		return $builder->select('*')
			->where('status', 1)
			->orderBy('position_serial', 'asc')
			->get()
			->getResult();
	}

	public function cat_info($slug=NULL){
                $builder = $this->db->table('web_category');
		return $builder->select("*")
			->where('slug', $slug)
			->where('status', 1)
			->get()
			->getRow();
	}

	public function newsCatListBySlug($slug=NULL)
	{	 
                $builder = $this->db->table('web_category');
                $cat_id = $builder->select('cat_id')->where('slug', $slug)->get()->getRow();

		return $builder->select('*')
			->where('status', 1)
			->orderBy('cat_id', 'desc')
			->where('parent_id', $cat_id->cat_id)
			->get()
			->getResult();
	}

	public function catidBySlug($slug=NULL){
                $builder = $this->db->table('web_category');
		return $builder->select("cat_id")
                                ->where('slug', $slug)
                                ->where('status', 1)
                                ->get()
                                ->getRow();
	}

	public function article($id=NULL, $limit=NULL){
                $builder = $this->db->table('web_article');
		return $builder->select("*")
                                ->where('cat_id', $id)
                                ->orderBy('position_serial', 'asc')
                                ->limit($limit)
                                ->get()
                                ->getResult();
	}

	public function package(){
                $builder = $this->db->table('package');
		return $builder->select("*")
                                ->get()
                                ->getResult();
	}

	public function contentDetails($slug = null)
	{       
                $builder = $this->db->table('web_article');
		return $builder->select('*')
                                ->where('slug', $slug)
                                ->get()
                                ->getRow();
	}

	public function newsDetails($slug = null)
	{
                $builder = $this->db->table('web_news');
		return $builder->select('*')
			->where('slug', $slug)
			->get()
			->getRow();
	}

	public function cryptoCoin($limit, $offset)
	{
                $builder = $this->db->table('cryptolist');
		return $builder->select("*")
			->orderBy('SortOrder', 'asc')
			->limit($limit, $offset)
			->get()
			->getResult();
	}

	public function advertisement($id=NULL){
                $builder = $this->db->table('advertisement');
		return $builder->select("*")
			->where('page', $id)
			->where('status', 1)
			->orderBy('serial_position', 'asc')
			->get()
			->getResult();
	}
	public function webLanguage(){
                $builder = $this->db->table('web_language');
		return $builder->select('*')
			->where('id', 1)
			->get()
			->getRow();
	}
	public function findById($table, $where){
                $builder = $this->db->table($table);
		return $builder->select('*')
			->where($where)
			->get()
			->getRow();
	}

	public function countRow($table, $where = array()){
        
        return $resutl = $this->db->table($table)
                       ->where($where)
                       ->countAllResults(); 
    }


    public function countNftOwnerInCollection($table, $where = array()){ 
        return $res = $this->db->table($table)->where($where)->groupBy('user_id')->countAllResults(); 
    }


    public function getMinPrice($table, $where = array(), String $field){ 
        return $res = $this->db->table($table)->selectMin($field)->where($where)->get()->getRow(); 
    }

    function desndingOrderArsort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va->$key;
        } 
        arsort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }	
        $array = $ret;

       return $array;
    }
 
	public function getAllNfts($limit, $page_number)
	{
	  

        $result = $this->db->query("SELECT `dbt_nfts_store`.*, `dbt_nfts_store`.`id` as `nftId`, `dbt_nfts_store`.`status` as `nft_status`, `dbt_nft_collection`.`title` as `collection_title`, `dbt_nft_listing`.*, `dbt_nft_listing`.`id` as `listing_id` FROM `dbt_nfts_store` LEFT JOIN `dbt_nft_collection` ON `dbt_nft_collection`.`id`=`dbt_nfts_store`.`collection_id` LEFT JOIN `dbt_nft_listing` ON `dbt_nft_listing`.`nft_store_id`=`dbt_nfts_store`.`id` WHERE `dbt_nfts_store`.`status` = 3 AND `dbt_nft_listing`.`status` = 0 ORDER BY `dbt_nft_listing`.`created_at` DESC LIMIT 15")->getResult();
 

       	foreach ($result as $key => $value) {

       		$value->favoriteVal = $this->countRow('favorite_items', ['nft_id'=>$value->nftId]);
       		$value->auctionDateTime = $this->calculateAuctionDateTime($value->start_date, $value->end_date);
       		$value->favorite3img = $this->getLastThreeFavouriteUser($value->nftId); 
       		$value->favoriteActive = $this->countRow('favorite_items', ['nft_id'=> $value->nftId, 'user_id'=>$this->session->get('user_id')]);

       	}
  
       	return $result;
	}


	 

	public function getNfts($arr = array(), int $limit)
	{
		$builder = $this->db->table('nfts_store');
        $builder->select('nfts_store.*, nfts_store.id as nftId, nfts_store.status as nft_status, nft_collection.title as collection_title, nft_listing.*, nft_listing.id as listing_id'); 
        $builder->where($arr); 
        $builder->limit($limit); 
        $builder->join('nft_collection', 'nft_collection.id=nfts_store.collection_id', 'left'); 
        $builder->join('nft_listing', 'nft_listing.nft_store_id=nfts_store.id', 'left'); 
        $query = $builder->get(); 
       	$result = $query->getResult();

       	foreach ($result as $key => $value) {
       		$value->favoriteVal = $this->countRow('favorite_items', ['nft_id'=>$value->nftId]);
       		$value->auctionDateTime = $this->calculateAuctionDateTime($value->start_date, $value->end_date);
       		$value->favorite3img = $this->getLastThreeFavouriteUser($value->nftId); 
       		$value->favoriteActive = $this->countRow('favorite_items', ['nft_id'=> $value->nftId, 'user_id'=>$this->session->get('user_id')]);
       	}

       	return $result;
	}


	public function getUserDashboardNfts($arr = array(), int $limit, $mytab)
	{
		 

			$builder = $this->db->table('nfts_store');
	        $builder->select('nfts_store.*, nfts_store.id as nftId, nfts_store.status as nft_status, nft_collection.title as collection_title'); 
	       
	        if($mytab == 'favorite'){
	        	 $builder->whereIn('nfts_store.id', $arr);
	       	}else{
	       		 $builder->where($arr);
	       	}
	        $builder->limit($limit); 
	        $builder->join('nft_collection', 'nft_collection.id=nfts_store.collection_id', 'left');  
	        $query = $builder->get(); 
	       	$result = $query->getResult();

	       	foreach ($result as $key => $value) {
	       		$value->favoriteVal = $this->countRow('favorite_items', ['nft_id'=>$value->nftId]); 
	       		$value->favorite3img = $this->getLastThreeFavouriteUser($value->nftId); 
	       		$value->favoriteActive = $this->countRow('favorite_items', ['nft_id'=> $value->nftId, 'user_id'=>$this->session->get('user_id')]);
	       	}
	     

       	return $result;
	}


	public function getFeaturedNfts()
	{
	 
       $result = $this->db->query("SELECT `dbt_nfts_store`.*, `dbt_nfts_store`.`id` as `nftId`, `dbt_nfts_store`.`status` as `nft_status`, `dbt_nft_collection`.`title` as `collection_title`, `dbt_nft_listing`.*, `dbt_nft_listing`.`id` as `listing_id` FROM `dbt_nfts_store` LEFT JOIN `dbt_nft_collection` ON `dbt_nft_collection`.`id`=`dbt_nfts_store`.`collection_id` LEFT JOIN `dbt_nft_listing` ON `dbt_nft_listing`.`nft_store_id`=`dbt_nfts_store`.`id` WHERE `dbt_nfts_store`.`is_featured` = 1 ORDER BY `dbt_nft_listing`.`created_at` DESC")->getRow();
       	  
       	$result->auctionDateTime = $this->calculateAuctionDateTime($result->start_date, $result->end_date); 
       	  
       	return $result;
	}

	public function getLastThreeFavouriteUser(int $nftId)
	{

		$favoriteValues = $this->db->query("SELECT `dbt_favorite_items`.*, `dbt_user`.`image` FROM `dbt_favorite_items` LEFT JOIN `dbt_user` ON `dbt_user`.`user_id`=`dbt_favorite_items`.`user_id` WHERE `dbt_favorite_items`.`nft_id` = $nftId ORDER BY `created_at` DESC LIMIT 3")->getResult();
  
		return $favoriteValues;
	}

	public function calculateAuctionDateTime($startDate, $endDate)
	{
		$start = $startDate;
		$end = $endDate; 
 
		
		$currentTime = date('Y-m-d H:i:s');
		$curretSec = strtotime($currentTime);
		$startSec = strtotime($start);
		$endSec = strtotime($end); 
 
        $sec = abs($endSec - $curretSec);
        $day = floor($sec/24/60/60);
        $houreLeft = floor($sec - $day*86400);
        $houre = floor($houreLeft/3600);
        $minutesLeft = floor(($houreLeft) - ($houre*3600));
        $minutes     = floor($minutesLeft/60);
        $remainingSeconds = $sec % 60;
        return $day.' : '.$houre.' : '.$minutes.' : '.$remainingSeconds;
        
	}

	public function topCollections()
	{ 

		$collections = $this->db->query("SELECT dbt_nft_collection.*, COUNT(dbt_nfts_store.id) AS totalNft FROM dbt_nft_collection LEFT JOIN dbt_nfts_store on dbt_nfts_store.collection_id = dbt_nft_collection.id GROUP BY dbt_nft_collection.id HAVING COUNT(dbt_nfts_store.id) > 0 ORDER BY `totalNft` DESC LIMIT 12")->getResult();

		foreach($collections as $value){ 
			$value->images = $this->getCollectionWise3NftsImage($value->id);
		}

		return $collections;
	}

	public function getCollectionWise3NftsImage($col_id)
	{
		$result = $this->db->table('nfts_store')->select('file, file_uri, file_token')->where(['collection_id'=>$col_id])->orderBy('created_at','DESC')->limit(2)->get()->getResult();

		return $result;
	}

	public function topSellers()
	{
		
		$results = $this->db->query("SELECT dbt_user.*, COUNT(dbt_nfts_store.id) AS totalNft FROM dbt_user LEFT JOIN dbt_nfts_store ON dbt_nfts_store.user_id = dbt_user.user_id WHERE dbt_user.status = 1 GROUP BY dbt_user.user_id HAVING COUNT(dbt_nfts_store.id)>0 ORDER BY `totalNft` DESC LIMIT 12;")->getResult();
		
		return $results;

	}



	public function getNftDetails($tokenid, $nftTableId)
	{
		

		$result = $this->db->query("SELECT `dbt_nfts_store`.*, `dbt_nfts_store`.`id` as `nftId`, `dbt_user`.`f_name`, `dbt_user`.`l_name`, `dbt_user`.`username`, `dbt_user`.`image` as `user_image`, `dbt_nft_category`.`cat_name`, `dbt_nft_category`.`slug` `cat_slug`, `dbt_nft_collection`.`title` as `collection_title`, `dbt_nft_collection`.`slug` as `collection_slug`, `dbt_nft_listing`.*, `dbt_nft_listing`.`id` as `listing_id` FROM `dbt_nfts_store` LEFT JOIN `dbt_user` ON `dbt_user`.`user_id`=`dbt_nfts_store`.`user_id` LEFT JOIN `dbt_nft_category` ON `dbt_nft_category`.`id`=`dbt_nfts_store`.`category_id` LEFT JOIN `dbt_nft_collection` ON `dbt_nft_collection`.`id`=`dbt_nfts_store`.`collection_id` LEFT JOIN `dbt_nft_listing` ON `dbt_nft_listing`.`nft_store_id`=`dbt_nfts_store`.`id` AND `dbt_nft_listing`.`status`=0 WHERE `dbt_nfts_store`.`id` = $nftTableId AND `dbt_nfts_store`.`token_id` = $tokenid")->getRow(); 
  
        return $result; 
	}


	public function getNftWiseBid($nftId, $listingId)
	{
		$result = $this->db->table('nft_biding')->select('nft_biding.*, user.f_name, user.l_name, user.image')
			->where(['nft_biding.nft_id'=>$nftId, 'nft_biding.nft_listing_id'=>$listingId, 'nft_biding.cancel_status'=>0, 'nft_biding.accept_status'=>0])
			->join('user', 'user.user_id=nft_biding.bid_from_id', 'left')
			->get()
			->getResult();
			
		return $result;
	}


	public function getListings($tokenid, $nftId)
	{
		$result = $this->db->table('nft_listing_log')->select('nft_listing_log.*, user.f_name, user.l_name')->where(['nft_listing_log.nft_store_id'=>$nftId, 'nft_listing_log.nft_token_id'=>$tokenid])->join('user', 'user.user_id=nft_listing_log.list_from')->get()->getResult();
		return $result;
	}


	public function slug_clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
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


}