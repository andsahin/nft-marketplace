<?php 
namespace App\Modules\Nfts\Controllers\Users;
class User_nfts extends BaseController 
{
 
  function __construct()
  {
      $this->network = BNETWORK;
      $this->currency = SYMBOL;
  }

   
	public function index()
  {

    if (!$this->session->get('isLogIn') && !$this->session->get('user_id')) {
        return redirect()->to(base_url());
    }
    if ($this->session->get('isLogIn') && $this->session->get('isAdmin')) {
        return redirect()->to('backend/home');
    }



    $data['title']  = "My NFTs";

    #-------------------------------#
     #pagination starts
    #-------------------------------#
    $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
    $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1); 
    $builder = $this->db->table('nfts_store');
    $builder->select('nfts_store.*, nfts_store.id as nftId, user.f_name, user.l_name, nft_category.cat_name, nft_collection.title as collection_title');
    $builder->where(['nfts_store.user_id' => $this->session->get('user_id'), 'nfts_store.is_minted' => 1]);
    $builder->limit(10,($page_number-1)*10);
    $builder->orderBy('nfts_store.id', 'DESC');
    $builder->join('user', 'user.user_id=nfts_store.user_id', 'left');
    $builder->join('nft_category', 'nft_category.id=nfts_store.category_id', 'left');
    $builder->join('nft_collection', 'nft_collection.id=nfts_store.collection_id', 'left');  
    $query = $builder->get(); 
    $data['nfts'] = $query->getResult();
  
     
    $total           = $this->common_model->countRow('nfts_store', ['nfts_store.user_id' => $this->session->get('user_id')]);
    $data['pager']   = $this->pager->makeLinks($page_number, 10, $total);  
     #------------------------
     #pagination ends
     #------------------------

    $data['networks'] = $this->common_model->get_all('nfts_store', $pagewhere=array(),20,($page_number-1)*20,'id','desc');

    $data['content'] = $this->BASE_VIEW . '\nfts\index';
    return $this->template->customer_layout($data);
  } 

  /*
  |----------------------------------------------
  |   Datatable Ajax data Pagination+Search
  |----------------------------------------------     
  */

  public function list_collection()
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
        return redirect()->to('admin');
    } 
    $uri = service('uri','<?php echo base_url(); ?>'); 
    #-------------------------------#
    #pagination starts
    #-------------------------------#
    $data['limit'] = $limit = 20;
    $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
    $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
    $data['collections']  = $this->nfts_model->get_all_collection('nft_collection',$where=array('user_id'=>$this->session->get('user_id')),$limit,($page_number-1)*$limit,'id','desc');

    $data['total'] = $total           = $this->common_model->countRow('nft_collection', $where);
    $data['pager']   = $this->pager->makeLinks($page_number, $limit, $total);  
    #------------------------
    #pagination ends
    #------------------------

    $data['title']  = 'My Collections'; 
    $data['frontendAssets'] = base_url('public/assets/website');
    $data['content']        = view($this->BASE_VIEW . '\nfts\list_collection',$data);
    return $this->template->website_layout($data); 
  }

  public function add_collection()
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 
    if(!$this->session->get('user_id')){
      return redirect()->to();
    }

    $this->validation->setRule('col_name', 'Collection Name','required|is_unique[nft_collection.title]');  
 
    $this->validation->setRule('category', 'Category','required'); 
    $this->validation->setRule('banner_img', 'Banner image', 'ext_in[banner_img,png,jpg,gif,ico,jpeg]|is_image[banner_img]');
    $this->validation->setRule('profile_img', 'Profile image', 'ext_in[profile_img,png,jpg,gif,ico,jpeg]|is_image[profile_img]');

    if($this->validation->withRequest($this->request)->run()){

      $banner_img = $this->request->getFile('banner_img',FILTER_SANITIZE_STRING);
      $profile_img = $this->request->getFile('profile_img',FILTER_SANITIZE_STRING);

      if($profile_img->getSize() == 0){
        $this->session->setFlashdata('exception',  'profile image is required'); 
        return  redirect()->to(base_url('user/add-collection'));
      }else if(($profile_img->getSize() / 1024) > 2049){
        $this->session->setFlashdata('exception',  'NTFs file size must be less than 2 MB'); 
        return  redirect()->to(base_url('user/add-collection'));
      }

      if($banner_img->getSize() == 0){
        $this->session->setFlashdata('exception',  'Banner image is required'); 
        return  redirect()->to(base_url('user/add-collection'));
      }else if(($banner_img->getSize() / 1024) > 4096){
        $this->session->setFlashdata('exception',  'NTFs file size must be less than 4 MB'); 
        return  redirect()->to(base_url('user/add-collection'));
      } 

      if($banner_img){
        $savepath="public/uploads/collection/banner/";
        $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING); 
        $image=$this->imagelibrary->image($banner_img,$savepath,$old_image,1400,400);
      }else{
        $image = null;
      }

      if($profile_img){
        $savepath="public/uploads/collection/profile/";
        $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING); 
        $froImage=$this->imagelibrary->image($profile_img,$savepath,$old_image,350,350);
      }else{
        $froImage = null;
      } 
    } 


    if ($this->validation->withRequest($this->request)->run()){ 
          $slug = $this->request->getVar('slug', FILTER_SANITIZE_STRING);
          if(empty($slug)){
            $slug = $this->_clean($this->request->getVar('col_name', FILTER_SANITIZE_STRING));
          }
           
          $data = [
              'user_id' => $this->user_id,
              'title' => $this->request->getVar('col_name', FILTER_SANITIZE_STRING),
              'slug' => strtolower($slug),
              'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING), 
              'category_id' => $this->request->getVar('category', FILTER_SANITIZE_STRING),   
              'banner_image' => $image, 
              'logo_image' => $froImage, 
              'created_at' => date('Y-m-d H:i:s'),
          ];

          $builder = $this->db->table('nft_collection');
          $ins = $builder->insert($data);

          if($ins){
              $this->session->setFlashdata('message',display('save_successfully')); 
              return  redirect()->to(base_url('user/add-collection')); 
          }else{ 
              $this->session->setFlashdata('exception', display('please_try_again')); 
              return  redirect()->to(base_url('user/add-collection'));
          } 

    }
    $error=$this->validation->listErrors();
    if($this->request->getMethod() == "post"){
          $this->session->setFlashdata('exception', $error);
          return  redirect()->to(base_url('user/add-collection'));
    }
    if ($this->session->getFlashdata('exception') != null) {  
        $data['exception'] = $this->session->getFlashdata('exception');
    }else if($this->session->getFlashdata('message') != null){
        $data['message'] = $this->session->getFlashdata('message');
    }

     
    $data['user_id']    = $this->user_id;
    $data['categories']  = $this->db->table('nft_category')->select('id, cat_name')->get()->getResult();
    $data['blockchain']  = $this->db->table('blockchain_network')->select('id, network_name')->where(['status'=>1])->get()->getRow(); 
    $data['settings']  = $this->db->table('setting')->get()->getRow(); 
    
    $data['title']  = "Add New Collection";
    $data['frontendAssets'] = base_url('public/assets/website');
    $data['content']        = view($this->BASE_VIEW . '\nfts\add_collection',$data);
    return $this->template->website_layout($data); 
  }

  
  private function _clean($string) {
     $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

     return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }



    public function update_collection($cid=null)
    {
      if (!$this->session->get('isLogIn')) {
            return redirect()->to(base_url('admin'));
      }
      if (empty($cid)) {
        return redirect()->to(base_url('user/dashboard'));
      } 
      $info = $this->db->table('nft_collection')->select('*')->where(['id'=>$cid])->get()->getRow();
      
      $this->validation->setRule('col_name', 'Collection Name','required');   
      $this->validation->setRule('banner_img', 'Banner image', 'ext_in[banner_img,png,jpg,gif,ico,jpeg]|is_image[banner_img]');
      $this->validation->setRule('profile_img', 'Profile image', 'ext_in[profile_img,png,jpg,gif,ico,jpeg]|is_image[profile_img]');

      if($this->validation->withRequest($this->request)->run()){
        $banner_img = $this->request->getFile('banner_img',FILTER_SANITIZE_STRING);
        $profile_img = $this->request->getFile('profile_img',FILTER_SANITIZE_STRING);
        if($banner_img){
          $savepath="public/uploads/collection/banner/";
          $old_image = $info->banner_image; 
          $image=$this->imagelibrary->image($banner_img,$savepath,$old_image,1400,400);
        }else{
          $image = null;
        }

        if($profile_img){
          $savepath="public/uploads/collection/profile/";
          $old_image = $info->logo_image;
          $froImage=$this->imagelibrary->image($profile_img,$savepath,$old_image,350,350);
        }else{
          $froImage = null;
        } 
      } 

      if ($this->validation->withRequest($this->request)->run()){

            $slug = $this->_clean($this->request->getVar('slug', FILTER_SANITIZE_STRING));
            if(empty($slug)){
              $slug = $this->_clean($this->request->getVar('col_name', FILTER_SANITIZE_STRING));
            }
            

            $data = [ 
                'title' => $this->request->getVar('col_name', FILTER_SANITIZE_STRING),
                'slug' => strtolower($slug),
                'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING),     
            ];
            if ($image) {
              $data['banner_image'] = $image ;
            }
            if($froImage){
              $data['logo_image'] = $froImage;
            }
            

            $builder = $this->db->table('nft_collection');
            $update = $this->common_model->update('nft_collection', ['id'=>$cid], $data);

            if($update){
                $this->session->setFlashdata('message',display('update_successfully')); 
                return  redirect()->to(base_url('user/edit-collection/'.$cid)); 
            }else{ 
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return  redirect()->to(base_url('user/edit-collection/'.$cid));
            } 

      }
      $error=$this->validation->listErrors();
      if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('customer/edit_collection'));
      }
      if ($this->session->getFlashdata('exception') != null) {  
          $data['exception'] = $this->session->getFlashdata('exception');
      }else if($this->session->getFlashdata('message') != null){
          $data['message'] = $this->session->getFlashdata('message');
      }

      $data['info']  = $info;
       
      $data['categories']  = $this->db->table('nft_category')->select('id, cat_name')->get()->getResult();
      $data['blockchain']  = $this->db->table('blockchain_network')->select('id, network_name')->where(['status'=>1])->get()->getRow();
      $data['settings']  = $this->db->table('setting')->get()->getRow(); 
       
        
      $data['title']  = "Update Collection";
      $data['frontendAssets'] = base_url('public/assets/website');
      $data['content']        = view($this->BASE_VIEW . '\nfts\edit_collection',$data);
      return $this->template->website_layout($data); 
    }
 
    

  public function nftDetails($id=null)
  {


    if (empty($id)) {
      redirect()->to(base_url('nft/list'));
    }

    $data['info'] = $this->common_model->where_row('nfts_store', ['id'=>$id]);

    $data['title']  = "NFT Details";
    $data['content'] = $this->BASE_VIEW . '\nfts\details';
    return $this->template->admin_layout($data);
  } 

  public function create_new_nft()
  {
    if (!$this->session->get('isLogIn')) {
        return redirect()->to('admin');
    } 

    $this->validation->setRule('item_name', 'Nft Name','required'); 
    $this->validation->setRule('collection', 'Colleection','required'); 
  
      
    if ($this->validation->withRequest($this->request)->run()){

      $file = $this->request->getFile('nft_file',FILTER_SANITIZE_STRING);
       
      if($file->getSize() == 0){
        $this->session->setFlashdata('exception',  'NFTs file is required'); 
        return  redirect()->to(base_url('nfts/create'));
      }else if(($file->getSize() / 1024) > 10245){
        $this->session->setFlashdata('exception',  'NTFs file size must be less than 10 MB'); 
        return  redirect()->to(base_url('nfts/create'));
      }
      
      $file_ext = pathinfo($_FILES["nft_file"]["name"], PATHINFO_EXTENSION);


      /* File Upload im serve */
      if($file_ext == 'mp4' || $file_ext =='webm'){
        $path1 = 'public/uploads/nfts/video';
        if ($file->isValid() && ! $file->hasMoved()) {
          $newName = $file->getRandomName();
          $file->move($path1, $newName);
          $image = $path1.'/'.$newName;
        }else{
          $this->session->setFlashdata('exception',  'This video is not valid'); 
          return  redirect()->to(base_url('customer/add_nft'));
        }
        
      }else if($file_ext == 'mp3'){ 
        $path2 = 'public/uploads/nfts/audio';
        
        if ($file->isValid() && ! $file->hasMoved()) {
          $newName = $file->getRandomName();
          $file->move($path2, $newName);
          $image = $path2.'/'.$newName; 
        }else{
          $this->session->setFlashdata('exception',  'This audio is not valid'); 
          return  redirect()->to(base_url('customer/add_nft'));
        }
      }else{
        $savepath="public/uploads/nfts/";
        $old_image = null; 
        $image=$this->imagelibrary->Image($file,$savepath,$old_image,1800,1800);
      }

       
      $typ = $this->request->getVar('opt_type[]', FILTER_SANITIZE_STRING);
      $val = $this->request->getVar('opt_val[]', FILTER_SANITIZE_STRING);
      $properties = null;
      if(isset($typ)){
        for ($i=0; $i < count($typ); $i++) { 
          $properties[$typ[$i]] = $val[$i];
        } 
      } 
       
      $collection_id = $this->request->getVar('collection', FILTER_SANITIZE_STRING);
      
      $col = $this->common_model->where_row('nft_collection', ['id'=>$collection_id]);  
     

      $contractAdd = $this->common_model->where_row('contract_setup', ['status'=>1]);
      if(!isset($contractAdd)){
        $this->session->setFlashdata('exception', 'Marketplace not setup, please contact to admin');
        return redirect()->to(base_url('nfts/create'));
      }

      $wdata = $this->common_model->where_row('admin_wallet'); 

      $userWalletInfo = $this->common_model->where_row('user_wallet', ['user_id'=>$this->session->get('user_id')]); 
      $networkdata = $this->common_model->where_row('blockchain_network'); 
      

      /** get user private data */
 
      $fromPrivateData = $this->blockchain->privateCredential($userWalletInfo); 

      $privatekey = '0x';
      $address = '0x';
      if($fromPrivateData->status === 'success'){
        $privatekey = $fromPrivateData->data->privatekey;
        $address = $fromPrivateData->data->address;
      } 
       
      $mintArr = [
        "privateKey" => $privatekey,   
        "rpc_url" => $networkdata->rpc_url, 
        "contractAddress" => $contractAdd->contract_address,
        "tokenURI" => base_url().$image
      ];


       
      /* Mint API Call */
      $mintRes = $this->blockchain->mintNft('api/transaction/mintNft', $mintArr);
       

      if(isset($mintRes->status)){ 

          $this->session->setFlashdata('exception', $mintRes->msg);
          return  redirect()->to(base_url('nfts/create')); 

      }else{
        $mintResDecode = json_decode($mintRes);
      }


      if(isset($mintResDecode)){  
         
        if($mintResDecode->status == 'error'){
          $this->session->setFlashdata('exception', substr($mintResDecode->msg, 0, 50));
          return  redirect()->to(base_url('nfts/create'));
        }

      } 

      /* Data for Database Insert */
      $data = array( 
        'user_id' => $this->user_id,
        'name' => $this->request->getVar('item_name', FILTER_SANITIZE_STRING),
        'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING), 
        'collection_id' => $this->request->getVar('collection', FILTER_SANITIZE_STRING), 
        'blockchain_id' => 2,
        'properties' => json_encode($properties),  
        'file' => $image,  
        'category_id' => $col->category_id, 
        'status' => 0,
        'token_standard'  => 'ERC721', 
        'created_by'  => $this->session->get('user_id'),
        'created_at'  => date('Y-m-d H:i:s'),
        'is_minted' => 1, 
        'token_id' => null, 
        'contract_address' => $mintResDecode->data->to,  
        'trx_hash' => $mintResDecode->data->hash,  
        'owner_wallet' => $mintResDecode->data->from,  
      );


      if($this->common_model->insert('nfts_store', $data)){
          $this->session->setFlashdata('message', 'Successfully mint your nft');
          return  redirect()->to(base_url('nfts/create'));
      }else{
          $this->session->setFlashdata('exception', display('please_try_again'));
          return  redirect()->to(base_url('nfts/create'));
      }


    }


    $error=$this->validation->listErrors();
    if($this->request->getMethod() == "post"){
          $this->session->setFlashdata('exception', $error);
          return  redirect()->to(base_url('nfts/create'));
    }
    if ($this->session->getFlashdata('exception') != null) {  
        $data['exception'] = $this->session->getFlashdata('exception');
    }else if($this->session->getFlashdata('message') != null){
        $data['message'] = $this->session->getFlashdata('message');
    }

    $data['network'] = $this->common_model->where_row('blockchain_network');
    $data['collections'] = $this->common_model->where_rows('nft_collection', ['user_id'=>$this->session->get('user_id')], 'id', 'asc');
    $data['title']  = "Create New NFT";  
    $data['frontendAssets'] = base_url('public/assets/website');
    $data['content']        = view($this->BASE_VIEW . '\nfts\create_nft',$data);
    return $this->template->website_layout($data); 
  }



  public function updateNft($tokenId = null, $nftId = null, $contract_address = null)
  {
      if (!$this->session->get('isLogIn')) {
        return redirect()->to('admin');
      } 
       
       
      $info = $this->common_model->where_row('nfts_store', ['id'=>$nftId, 'token_id'=>$tokenId]);


      $this->validation->setRule('item_name', 'Nft Name','required');  
      
        
      if ($this->validation->withRequest($this->request)->run()){
       
        $typ = $this->request->getVar('opt_type[]', FILTER_SANITIZE_STRING);
        $val = $this->request->getVar('opt_val[]', FILTER_SANITIZE_STRING);
        $properties = null;
        if(isset($typ)){
          for ($i=0; $i < count($typ); $i++) { 
            $properties[$typ[$i]] = $val[$i];
          } 
        } 


          $data = [ 
            'name' => $this->request->getVar('item_name', FILTER_SANITIZE_STRING),
            'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING),      
            'properties' => json_encode($properties), 
          ]; 

          
          $builder = $this->db->table('nfts_store');
          $builder->where(['id'=>$nftId, 'token_id'=>$tokenId]);
          $up = $builder->update($data);
             
          if($up){  
            $this->session->setFlashdata('message',display('update_successfully')); 
            return  redirect()->to(base_url("user/mynft_update/{$tokenId}/{$nftId}/{$contract_address}")); 
          }else{ 
            $this->session->setFlashdata('exception', display('please_try_again')); 
            return  redirect()->to(base_url("user/mynft_update/{$tokenId}/{$nftId}/{$contract_address}"));
          } 

      }


      $error=$this->validation->listErrors();
      if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('user/mynft_update/'.$tokenId.'/'.$nftId.'/'.$contract_address));
      }
      if ($this->session->getFlashdata('exception') != null) {  
          $data['exception'] = $this->session->getFlashdata('exception');
      }else if($this->session->getFlashdata('message') != null){
          $data['message'] = $this->session->getFlashdata('message');
      }

      
      $data['collections'] = $this->db->table('nft_collection')->select('id, title')->where(['user_id'=>$this->session->get('user_id')])->get()->getResult(); 
      $data['blockchain']  = $this->db->table('blockchain_network')->select('id, network_name')->where(['status'=>1, 'network_name'=>'ETHEREUM'])->get()->getRow();
      $data['network'] = $this->common_model->where_row('blockchain_network');

      $data['info']  = $info; 
      $data['title']  = "Update NFT"; 
      $data['frontendAssets'] = base_url('public/assets/website');
      $data['content']        = view($this->BASE_VIEW . '\nfts\editnft',$data);
      return $this->template->website_layout($data); 
  }


      

  public function checkWallet($address=null)
  { 

    if(!empty($address)){
      $result = $this->blockchain->checkValidWalletAddress($address);

      echo json_encode($result);
    }else{
      echo json_encode(['status'=>'err', 'value'=>'not found']);
    }
    
  }



  public function transferNft($nftId=null, $tokenId=null, $contractAdd=null)
  {  
 
    if(empty($nftId) || empty($tokenId)){
      return redirect()->to(base_url());
    }  

    $nftInfo = $this->common_model->where_row('nfts_store', ['id'=> $nftId]);

    if($nftInfo->user_id !== $this->user_id){
        $this->session->setFlashdata('exception', display('access_denied'));
        return redirect()->to(base_url('user/dashboard'));
    }

    $this->validation->setRule('towallet', 'To Wallet','required');  
    
        
    if ($this->validation->withRequest($this->request)->run()){

      $toWallet       = $this->request->getVar('towallet'); 
      $networkInfo    = $this->common_model->where_row('blockchain_network');
      $contractInfo   = $this->common_model->where_row('contract_setup');
      $fees           = $this->common_model->where_row('fees_tbl', ['level'=>'transfer']);


      if(!isset($networkInfo) || !isset($contractInfo) || !isset($fees)){

        $this->session->setFlashdata('exception', 'Please contact to admin for error setup');
        return redirect()->to(base_url('user/dashboard'));

      }

          
      if ($nftInfo->status == 2) {

      	$this->session->setFlashdata('exception', 'This NFT is on sale!'); 
      	return redirect()->to(base_url('user/dashboard'));

      }else if($nftInfo->status == 3){

      	$this->session->setFlashdata('exception', 'This NFT is suspend!');
      	return redirect()->to(base_url('user/dashboard'));

      }

      $toWalletInfo     = $this->common_model->where_row('user_wallet', ['wallet_address'=>str_replace('0x', '', $toWallet)]); 
      $fromWalletInfo   = $this->common_model->where_row('user_wallet', ['user_id' => $this->user_id]);
      

      if($nftInfo && $toWalletInfo){ 

        $fromPrivateData = $this->blockchain->privateCredential($fromWalletInfo); 
        
        $privatekey = '0x';
        $address = '0x';
        if($fromPrivateData->status === 'success'){
          $privatekey = $fromPrivateData->data->privatekey;
          $address = $fromPrivateData->data->address;
        }  

        // blockchain transfer
        $transferArr = [ 
          "privateKey"      => str_replace("0x","",$privatekey),
          "rpc_url"         => $networkInfo->rpc_url,
          "contractAddress" => $nftInfo->contract_address,
          "recieverAddress" => '0x'.$toWalletInfo->wallet_address,
          "tokenID"         => $tokenId,  
          "transferFee"     => $fees->fees
        ];

        $transferQuee = [   
          "nft_id"          => $nftId,   
          "from_wallet"     => '0x'.$address,  
          "to_wallet"       => '0x'.$toWalletInfo->wallet_address, 
        ];



        $upData = array(
          'owner_wallet' => '0x'.$toWallet,
          'user_id'      => $toWalletInfo->user_id 
        );
  
        $transfered = $this->blockchain->transferNft('api/transaction/transferNft', $transferArr);  

        
        if(isset($transfered->status)){  
            $this->session->setFlashdata('exception', $transfered->msg);
            return  redirect()->to(base_url("user/assets/transfer/{$nftId}/{$tokenId}/{$contractAdd}")); 
        }else{ 
          $resultDecode = json_decode($transfered); 
        }


        if(isset($resultDecode)){  
           
          if($resultDecode->status == 'error'){
            
            $this->session->setFlashdata('exception', $resultDecode->msg);
            return  redirect()->to(base_url("user/assets/transfer/{$nftId}/{$tokenId}/{$contractAdd}"));

          } else {

            $admin_wallet = $this->common_model->where_row('admin_wallet');
            
            $marketPlaceFee = ($admin_wallet->earned_fees + $fees->fees);
            
            $this->common_model->update('admin_wallet', ['awid'=>$admin_wallet->awid], ['earned_fees'=>$marketPlaceFee]);  
            $this->common_model->update('nfts_store', ['id'=>$nftId], $upData); 
            $this->nfts_model->nftStoreLogSave($nftId, 'transfer');

            $this->session->setFlashdata('message', 'Successfully transfered your item');
            return  redirect()->to(base_url("user/dashboard")); 
          }

        }
 
         
      }else{


        $this->session->setFlashdata('exception', 'This wallet not found the marketplace');
        return  redirect()->to(base_url("user/assets/transfer/{$nftId}/{$tokenId}/{$contractAdd}"));
      
      }
       

    }

     $error=$this->validation->listErrors();
      if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url("user/assets/transfer/{$nftId}/{$tokenId}/{$contractAdd}"));
      }

      if ($this->session->getFlashdata('exception') != null) {  
          $data['exception'] = $this->session->getFlashdata('exception');
      }else if($this->session->getFlashdata('message') != null){
          $data['message'] = $this->session->getFlashdata('message');
      }
 
 

      $data['fees']  = $this->common_model->where_row('fees_tbl', ['level'=>'transfer']);; 
      $data['nftInfo']  = $nftInfo; 
      $data['title']  = "Update NFT"; 
      $data['frontendAssets'] = base_url('public/assets/website');
      $data['content']        = view($this->BASE_VIEW . '\nfts\transfer',$data);
      return $this->template->website_layout($data);  

  }




  public function assetMethods($method=null, $tokenid=null, $nftTableId=null, $contract=null)
  {
    if(empty($tokenid)){
      redirect()->to(base_url());
    }
    if(empty($method)){
      redirect()->to(base_url());
    }

    if($method ==='bid'){ 

     

      $this->validation->setRule('amount', 'bid amount','required');  

      $nftInfo = $this->nfts_model->nfts_with_listing_info($tokenid, $nftTableId);

      if($nftInfo->user_id === $this->session->get('user_id')){
        
        $this->session->setFlashdata('exception', 'This is my nft'); 
        return  redirect()->to(base_url('user/dashboard'));
      }


      if ($this->validation->withRequest($this->request)->run()){
       
        $arr = [
          'nft_listing_id' => $nftInfo->listing_id,
          'nft_id' => $nftInfo->nftId, 
          'bid_from_id' => $this->session->get('user_id'),
          'bid_start_at' => date('Y-m-d H:i:s'),
          'bid_end_at' => date('Y-m-d H:i:s'),
          'bid_amount' => (string) $this->request->getVar('bid_amount', FILTER_SANITIZE_STRING), 
          'status' => 1,
        ];


        $builder = $this->db->table('nft_biding'); 
        $builder->insert($arr);
        $bidId = $this->db->insertID();

        if($bidId){
          /**  nft_listing table total bid update  */
          $bidInfo = $this->common_model->where_row('nft_biding', ['id'=>$bidId]);
          $listingInfo = $this->common_model->where_row('nft_listing', ['id'=>$bidInfo->nft_listing_id]);
          
          $this->common_model->update('nft_listing', ['id'=>$bidInfo->nft_listing_id], ['total_bid' => $listingInfo->total_bid+1]);

          $this->session->setFlashdata('message',display('save_successfully')); 
          return  redirect()->to(base_url("nft/asset/details/{$tokenid}/{$nftTableId}/{$contract}")); 
        }else{ 
            $this->session->setFlashdata('exception', display('please_try_again')); 
            return  redirect()->to(base_url("user/asset/bid/{$tokenid}/{$nftTableId}/{$contract}"));
        }

        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
              $this->session->setFlashdata('exception', $error);
              return  redirect()->to(base_url("user/asset/bid/{$tokenid}/{$nftTableId}/{$contract}"));
        }
        if ($this->session->getFlashdata('exception') != null) {  
            $data['exception'] = $this->session->getFlashdata('exception');
        }else if($this->session->getFlashdata('message') != null){
            $data['message'] = $this->session->getFlashdata('message');
        }
      }
      $data['nftInfo'] = $nftInfo;
      $data['allBid'] = $this->nfts_model->get_all('nft_biding', ['nft_id'=>$nftTableId, 'nft_listing_id'=>$nftInfo->listing_id], 'bid_start_at', 'DESC');
      $data['acInfo'] = $this->common_model->where_row('user_account', ['user_id'=>$this->session->get('user_id')]);
     
 

      $data['title']  = "Bid place for ".$nftInfo->name;
      $data['frontendAssets'] = base_url('public/assets/website');
      $data['content']        = view($this->BASE_VIEW . '\nfts\bid',$data);
      return $this->template->website_layout($data); 
 
    } elseif($method ==='buy') {

  
      if($nftTableId == null || $tokenid == null){
        return redirect()->to(base_url('user/dashboard'));
      }



      $nftInfo = $this->nfts_model->nfts_with_listing_info($tokenid, $nftTableId);
     
      if(empty($nftInfo)){
        $this->session->setFlashdata('exception', 'This is not lis for sale'); 
        return  redirect()->to(base_url('user/dashboard'));
      }
       
      if($nftInfo->user_id === $this->session->get('user_id')){
        
        $this->session->setFlashdata('exception', 'This is my nft'); 
        return  redirect()->to(base_url('user/dashboard'));
      }
 

      $buyerInfo    = $this->common_model->getUserWalletAccountInfo($this->user_id);
      $balanceRes   = $this->blockchain->baseCoinBalance($buyerInfo->wallet_address, $this->currency); 
      $balance      = number_format($balanceRes->data->balance, '5', '.', ',');



      $listingWhere = ['nft_store_id'=>$nftTableId, 'nft_token_id'=>$tokenid, 'nft_listing.status'=> 0]; 
      $listingInfo  = $this->common_model->getListingWithNftstoreInfo($listingWhere); 
        


      $sellerInfo       = $this->common_model->getUserWalletAccountInfo($listingInfo->list_from);
      $sellerWalletInfo = $this->common_model->where_row('user_wallet', ['user_id'=>$listingInfo->list_from]);


      $contractAdd      = $this->common_model->where_row('contract_setup', ['status'=>1]);
      $buyerWalletInfo  = $this->common_model->where_row('user_wallet', ['user_id' => $this->user_id]); 
      $networkdata      = $this->common_model->where_row('blockchain_network'); 
      

      
 
      if($listingInfo->auction_type == 'Fix'){

          if($balance > $listingInfo->min_price){  
           


            $buyerPrivateData  = $this->blockchain->privateCredential($buyerWalletInfo); 

            $privatekey   = '';
            $address      = '';

            if($buyerPrivateData->status === 'success'){

              $privatekey = $buyerPrivateData->data->privatekey;
              $address = $buyerPrivateData->data->address;

            } 
            
            $fees = $this->db->table('fees_tbl')->where('level', 'sale')->get()->getRow()->fees;
           
            $buyArr = [

              "privateKey"      => $privatekey,   
              "rpc_url"         => $networkdata->rpc_url, 
              "contractAddress" => $contractAdd->contract_address, 
              "tokenID"         => (int) $listingInfo->nft_token_id,
              "sellPrice"       => (string) $listingInfo->min_price,
              "fees"            => (int) $fees,
              "netWork"         => $this->network, 

            ];
             
           
            /* List for sale API Call */ 
            $result = $this->blockchain->buy('api/transaction/buyItems', $buyArr);
         


            if(isset($result->status)){ 

                $this->session->setFlashdata('exception', $result->msg);
                return  redirect()->to(base_url("nft/asset/details/{$tokenid}/{$nftTableId}/{$contract}"));

            }else{

              $resultDecode = json_decode($result);

            }


            if(isset($resultDecode)){  
               
              if($resultDecode->status == 'error'){
                $this->session->setFlashdata('exception', $resultDecode->msg);
                return  redirect()->to(base_url("nft/asset/details/{$tokenid}/{$nftTableId}/{$contract}"));
              }

            }



            $nftUpdateArr = [
                'user_id'       => $buyerInfo->user_id,
                'owner_wallet'  => '0x'.$buyerInfo->wallet_address,
                'status'        => 1,
            ];
            
            $admin_wallet = $this->common_model->where_row('admin_wallet');
            
            $marketPlaceFee = (($listingInfo->min_price * $fees) / 100) + ($admin_wallet->earned_fees);
            
            $this->common_model->update('admin_wallet', ['awid'=>$admin_wallet->awid], ['earned_fees'=>$marketPlaceFee]);

            $this->common_model->update('nfts_store', ['id'=>$listingInfo->nft_store_id, 'token_id'=>$listingInfo->nft_token_id], $nftUpdateArr);
            $this->common_model->update('nft_listing', ['id'=>$listingInfo->id], ['status'=>1]);
            $this->common_model->update('nft_biding', ['nft_listing_id'=>$listingInfo->id], ['cancel_status'=>1]); 


            /* Log save */ 
            $this->nfts_model->nftStoreLogSave($listingInfo->nft_store_id, 'buy');
            $this->nfts_model->saveListingLog2($listingInfo->id, 1);
              
            
            $this->session->setFlashdata('message', 'Successfully buy your nft');
            return redirect()->to(base_url('user/dashboard'));


        } 
        
        $this->session->setFlashdata('exception', 'Insufficient balance');
            return redirect()->to(base_url('user/dashboard'));
      } 


    }elseif($method ==='sale_cancel'){ 

      $nftInfo = $this->common_model->where_row('nfts_store', ['id'=>$nftTableId,'token_id'=>$tokenid]);
      $listingInfo = $this->common_model->where_row('nft_listing', ['nft_store_id'=>$nftTableId, 'nft_token_id'=>$tokenid]);

      
      if(!empty($nftInfo) && !empty($listingInfo) && $this->session->get('user_id') == $nftInfo->user_id){
        
        $update = $this->common_model->update('nft_listing', ['nft_store_id'=>$nftTableId, 'nft_token_id'=>$tokenid], ['status'=>3, 'updated_at'=>date('Y-m-d H:i:s')]);
        if($update){
          $res = $this->nfts_model->saveListingLog($listingInfo, 3);
          $this->common_model->update('nfts_store', ['id'=>$nftTableId], ['status'=>1]);
          $this->session->setFlashdata('message', 'Cancel Successfully'); 
          return  redirect()->to(base_url('user/dashboard')); 
        }else{
            $this->session->setFlashdata('exception', display('please_try_again')); 
            return  redirect()->to(base_url('user/dashboard'));
        }
      }else{
        
        $this->session->setFlashdata('exception', display('please_try_again'));     
        return  redirect()->to(base_url('user/dashboard'));
      }


    }elseif($method ==='sale'){


      $this->validation->setRule('price', 'price','required'); 
      $this->validation->setRule('duration', 'duration','required'); 

      if($this->request->getVar('sale_type') === 'Bid'){

        $this->validation->setRule('start_date', 'start date','required');
        $this->validation->setRule('end_date', 'end date','required');

      }


      $nftInfo = $this->common_model->where_row('nfts_store', ['id'=>$nftTableId,'token_id'=>$tokenid]);
      $listingInfo = $this->common_model->where_row('nft_listing', ['nft_store_id'=>$nftInfo->id]);


      if($nftInfo->is_verified != 1){
        $this->session->setFlashdata('exception', 'This item is not verified'); 
        return  redirect()->to(base_url('user/dashboard'));
      }


      if($nftInfo->status == 3){
        $this->session->setFlashdata('exception', 'Already listed this item'); 
        return  redirect()->to(base_url('user/dashboard'));
      }

      if ($this->validation->withRequest($this->request)->run()){

        $duration   = explode('-', $this->request->getVar('duration', FILTER_SANITIZE_STRING));
        $start      = str_replace('/', '-', $duration[0]);
        $end        = str_replace('/', '-', $duration[1]);

        $start_date = date('Y-m-d H:i:s', strtotime($start));
        $end_date   = date('Y-m-d H:i:s', strtotime($end));
        

        $arr = [ 
          'nft_store_id' => $nftInfo->id,
          'nft_token_id' => $nftInfo->token_id,
          'auction_type' => $this->request->getVar('sale_type', FILTER_SANITIZE_STRING),
          'min_price' => $this->request->getVar('price', FILTER_SANITIZE_STRING), 
          'reserve_price' => $this->request->getVar('reserve_price', FILTER_SANITIZE_STRING), 
          'list_from' => $this->session->get('user_id'), 
          'status' => 0, 
          'start_date' => $start_date,
          'end_date' => $end_date,
          'created_at' => date('Y-m-d H:i:s'),
        ];


        $contractAdd    = $this->common_model->where_row('contract_setup', ['status'=>1]);
        $userWalletInfo = $this->common_model->where_row('user_wallet', ['user_id' => $this->user_id]); 
        $networkdata    = $this->common_model->where_row('blockchain_network'); 
        

        $fromPrivateData  = $this->blockchain->privateCredential($userWalletInfo); 

        $privatekey   = '';
        $address      = '';

        if($fromPrivateData->status === 'success'){

          $privatekey = $fromPrivateData->data->privatekey;
          $address = $fromPrivateData->data->address;

        } 
       
        $listArr = [

          "privateKey"      => $privatekey,   
          "rpc_url"         => $networkdata->rpc_url, 
          "contractAddress" => $contractAdd->contract_address,
          "price"           => (string) $this->request->getVar('price', FILTER_SANITIZE_STRING),
          "tokenID"         => (int) $nftInfo->token_id,
          "netWork"         => $this->network,

        ];


        
        /* List for sale API Call */ 
        $listResult = $this->blockchain->listForSale('api/transaction/listingToken', $listArr);
       


        if(isset($listResult->status)){ 

            $this->session->setFlashdata('exception', substr($listResult->msg, 0, 74));
            return  redirect()->to(base_url("user/asset/sale/{$tokenid}/{$nftTableId}/{$contract}"));

        }else{
          $listResultDecode = json_decode($listResult);
        }


        if(isset($listResultDecode)){  
           
          if($listResultDecode->status == 'error'){
            $this->session->setFlashdata('exception', substr($listResultDecode->msg, 0, 50));
            return  redirect()->to(base_url("user/asset/sale/{$tokenid}/{$nftTableId}/{$contract}"));
          }

        } 


        $builder = $this->db->table('nft_listing'); 
        $builder->insert($arr);
        $listingId = $this->db->insertID();

        

        if($listingId){ 

          $arr['trx_info'] = $listResult; 
          $arr['listing_id'] = $listingId; 
          $this->common_model->insert('nft_listing_log', $arr);
          $this->common_model->update('nfts_store', ['id'=>$nftInfo->id], ['status'=>3, 'price'=>$this->request->getVar('price', FILTER_SANITIZE_STRING)]);

          
          $this->session->setFlashdata('message',display('save_successfully')); 
          return  redirect()->to(base_url('user/dashboard'));

        }else{ 
            $this->session->setFlashdata('exception', display('please_try_again')); 
            return  redirect()->to(base_url('user/dashboard'));
        }

        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
              $this->session->setFlashdata('exception', $error);
              return  redirect()->to(base_url("user/asset/sale/{$tokenid}/{$nftTableId}/{$contract}"));
        }
      }

      $error=$this->validation->listErrors();
      if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('user/asset/sale/'.$tokenid.'/'.$nftTableId.'/'.$contract));
      }

      if ($this->session->getFlashdata('exception') != null) {  
          $data['exception'] = $this->session->getFlashdata('exception');
      }else if($this->session->getFlashdata('message') != null){
          $data['message'] = $this->session->getFlashdata('message');
      }

      $data['selling_types'] = $this->common_model->where_rows('nft_selling_type', [], 'type_id','asc');
      $data['nftInfo'] = $nftInfo;
      
       

      $data['title']  = "List item for sale";
      $data['frontendAssets'] = base_url('public/assets/website');
      $data['content']        = view($this->BASE_VIEW . '\nfts\sale',$data);
      return $this->template->website_layout($data); 
    }
  }



  public function bidlist($nftId=null)
  {
    if(empty($nftId)){
      $this->session->setFlashdata('exception', 'Your are worng');
      return  redirect()->to(base_url('user/dashboard'));
    }
     
    $data['allBid']  = $this->common_model->where_rows('nft_biding', ['nft_id'=>$nftId,'accept_status'=>0, 'cancel_status'=>0], 'bid_datetime', 'DESC');
    $data['title']  = "Bid List";
    $data['content'] = $this->BASE_VIEW . '\nfts\bidlist';
    return $this->template->customer_layout($data);
    
  }


  public function checkColelctionName($data=null)
  {
      if($data){
          $data = base64_decode($data);
          $result = $this->common_model->where_row('nft_collection', ['title'=>$data]);
          if($result){
              echo json_encode(['status'=>'err', 'msg'=>'This collection already exists!', 'class'=>'text-danger']); 
         }else{
              echo json_encode(['status'=>'success', 'msg'=>'Valid Collection', 'class'=>'text-success']);
         }
          
      }else{
          echo json_encode(['status'=>'err', 'msg'=>'Collection not found', 'class'=>'text-danger']);
      } 
  }

  public function checkColelctionSlug($data=null)
  {
      if($data){
          $data = base64_decode($data);
          $result = $this->common_model->where_row('nft_collection', ['slug'=>$data]);
          if($result){
              echo json_encode(['status'=>'err', 'msg'=>'This URL already exists!', 'class'=>'text-danger']); 
         }else{
              echo json_encode(['status'=>'success', 'msg'=>'Valid URL', 'class'=>'text-success']);
         }
          
      }else{
          echo json_encode(['status'=>'err', 'msg'=>'Username not found', 'class'=>'text-danger']);
      } 
  }


  public function biding()
  {

    $userId       = $this->session->get('user_id');
    $acInfo       = $this->common_model->where_row('user_account', ['user_id'=>$userId]);
    $offerAmount  = $this->request->getVar('amount', FILTER_SANITIZE_STRING);

   

    $offerId;
    if(!empty($acInfo) && $acInfo->balance > $offerAmount){

      /* Hold balace */
      $holdBalance = ($acInfo->hold_balance + $offerAmount);

      /* check previous bid this user */
      $where = [
        'nft_listing_id'  => $this->request->getVar('listing_id', FILTER_SANITIZE_STRING),
        'nft_id'          => $this->request->getVar('nft_id', FILTER_SANITIZE_STRING),
        'bid_from_id'     => $userId,
      ];
      
      $getCheck = $this->common_model->where_row('nft_biding', $where);

      if($getCheck){ 
        echo json_encode(['status'=>'err', 'msg' => 'You are already offered this nfts']);
        return;
      } 

      $arr = [
        'nft_listing_id'  => $this->request->getVar('listing_id', FILTER_SANITIZE_STRING),
        'nft_id'          => $this->request->getVar('nft_id', FILTER_SANITIZE_STRING),
        'bid_from_id'     => $userId,
        'bid_start_at'    => date('Y-m-d H:i:s'), 
        'bid_amount'      => $offerAmount,
        'status'          => 1,
      ]; 


      $builder = $this->db->table('nft_biding')->insert($arr);
      $offerId = $this->db->insertID();


      $this->common_model->update('nfts_store', ['id'=>$this->request->getVar('nft_id', FILTER_SANITIZE_STRING)], ['status'=>3, 'price'=>$offerAmount]);
      /* Update user account */
      $this->common_model->update('user_account', ['user_id'=>$userId], ['hold_balance'=>$holdBalance]);
    }

    if($offerId){ 

      $arr['nft_bid_id'] = $offerId; 
      $this->db->table('nft_biding_log')->insert($arr);

      echo json_encode(['status'=>'success']);

    }else{

      echo json_encode(['status'=>'err']);

    }
    
  }
 
    
}