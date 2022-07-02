<?php 
namespace App\Modules\Nfts\Controllers\Admin;
class Nfts_setup extends BaseController 
{
    function __construct()
    {
        $this->network = BNETWORK;
        $this->currency = SYMBOL;
    }

	public function index()
    {

     	if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
			 return redirect()->to('admin');
		  }

        $data['title']  = "Admin Wallet";

        #-------------------------------#
         #pagination starts
        #-------------------------------#
        $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $data['wallets'] = $this->common_model->get_all('admin_wallet', $pagewhere=array(),20,($page_number-1)*20,'awid','desc');
         
        #------------------------
        #pagination ends
        #------------------------

        $data['networks'] = $this->common_model->get_all('blockchain_network', $pagewhere=array(),20,($page_number-1)*20,'id','desc');
        $data['file_gateway'] = $this->common_model->where_row('file_gateway');
        $data['selling_types'] = $this->common_model->where_rows('nft_selling_type', [], 'type_id','asc');
        
        $data['symbol'] = $this->symbol;
        $data['content'] = $this->BASE_VIEW . '\nft-setup\index';
        return $this->template->admin_layout($data);
    }


    public function wallet_setup()
    {
     	if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
			return redirect()->to('admin');
	   }


     	$this->validation->setRule('private_key', 'Private key','required');

     	if ($this->validation->withRequest($this->request)->run()){

     		$private_key = $this->request->getVar('private_key',FILTER_SANITIZE_STRING);
     		$private_key64 = strlen($private_key);
     		if($private_key64 !== 64){
     			$this->session->setFlashdata('exception','It\'s worng! Please enter your 64 characters private key'); 
     			return  redirect()->to(base_url('backend/nft/wallet_import'));
     		}else{
     			$admin_id = $this->session->userdata('id');

     			$res = $this->blockchain->importWallet($private_key, $admin_id);

     			if($res->status === 'success'){

	     			$this->session->setFlashdata('message',display('save_successfully')); 
	     			return  redirect()->to(base_url('backend/nft/nft_setup')); 
     			}else{ 
     				$this->session->setFlashdata('exception', $res->msg); 
     				return  redirect()->to(base_url('backend/nft/nft_setup'));
     			} 
 
     		} 	
 
     	}

     	$data['title']  = "Admin Wallet Setup";
     	$data['content'] = $this->BASE_VIEW . '\nft-setup\wallet_setup';
        return $this->template->admin_layout($data);
    }

    public function network_setup()
    { 

        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
            return redirect()->to('admin');
        } 

        $protocol = 'http://';

        $this->validation->setRule('network_name', 'Network name','required');
        $this->validation->setRule('chain_id', 'chain id','required');
        $this->validation->setRule('currency_symbol', 'currency symbol','required');
        $this->validation->setRule('rpc_url', 'RPC','required');
        $this->validation->setRule('explorer_url', 'Blockchain explorer url','required');
        $this->validation->setRule('port', 'Port','required|alpha_numeric');
        $this->validation->setRule('server_ip', 'Server IP','required');
         
        if ($this->validation->withRequest($this->request)->run()){

            $data = [
                'network_name'      => $this->request->getVar('network_name', FILTER_SANITIZE_STRING),
                'chain_id'          => $this->request->getVar('chain_id', FILTER_SANITIZE_STRING),
                'currency_symbol'   => $this->request->getVar('currency_symbol', FILTER_SANITIZE_STRING),
                'rpc_url'           => $this->request->getVar('rpc_url', FILTER_SANITIZE_STRING),
                'explore_url'       => $this->request->getVar('explorer_url', FILTER_SANITIZE_STRING),
                'port'              => $this->request->getVar('port', FILTER_SANITIZE_STRING),
                'server_ip'         => $this->request->getVar('server_ip', FILTER_SANITIZE_STRING)
            ];

         
            $path1       = 'app/Libraries/node/server.js';
            $write1      = file_get_contents($path1);
            $existLine = "81";

            $new1  = str_replace($existLine, $this->request->getVar('port', FILTER_SANITIZE_STRING), $write1);

            // Write the new database.php file
            $handle1 = fopen($path1,'w+');

            // Chmod the file, in case the user forgot
            @chmod($path1, 0777);
            // Verify file permissions
            if (is_writable($path1)) {
                // Write the file
                if (fwrite($handle1,$new1)) {
                    @chmod($path1,0755); 
                }
            } 



            $builder = $this->db->table('blockchain_network');
            $ins = $builder->insert($data);

            if($ins){
                $this->session->setFlashdata('message',display('save_successfully')); 
                return  redirect()->to(base_url('backend/nft/nft_setup')); 
            }else{ 
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return  redirect()->to(base_url('backend/nft/add_network'));
            } 
 
        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('backend/nft/add_network'));
        }
        $data['title']  = "Network Setup";
        $data['content'] = $this->BASE_VIEW . '\nft-setup\network_setup';
        return $this->template->admin_layout($data);
    }


    public function networkUpdate($id=null)
    { 

        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
            return redirect()->to('admin');
        } 
        if (empty($id)) {
            return redirect()->to('admin');
        }

        $protocol = 'http://';

        $info = $this->common_model->where_row('blockchain_network');

        $this->validation->setRule('network_name', 'Network name','required');
        $this->validation->setRule('chain_id', 'chain id','required');
        $this->validation->setRule('currency_symbol', 'currency symbol','required');
        $this->validation->setRule('rpc_url', 'RPC','required');
        $this->validation->setRule('explorer_url', 'Blockchain explorer url','required');
        $this->validation->setRule('port', 'Port','required|numeric');
        $this->validation->setRule('server_ip', 'Server IP','required');

        if ($this->validation->withRequest($this->request)->run()){

            $data = [
                'network_name'      => $this->request->getVar('network_name', FILTER_SANITIZE_STRING),
                'chain_id'          => $this->request->getVar('chain_id', FILTER_SANITIZE_STRING),
                'currency_symbol'   => $this->request->getVar('currency_symbol', FILTER_SANITIZE_STRING),
                'rpc_url'           => $this->request->getVar('rpc_url', FILTER_SANITIZE_STRING),
                'explore_url'       => $this->request->getVar('explorer_url', FILTER_SANITIZE_STRING),
                'port'              => $this->request->getVar('port', FILTER_SANITIZE_STRING),
                'server_ip'         => $this->request->getVar('server_ip', FILTER_SANITIZE_STRING)
            ];

            
            $path1       = 'app/Libraries/node/server.js';
            $write1      = file_get_contents($path1);

            if($info->port){
                $existLine = $info->port;
            }else{
                $existLine = "81";
            }
            

            $new1  = str_replace($existLine, $this->request->getVar('port', FILTER_SANITIZE_STRING), $write1);

            // Write the new database.php file
            $handle1 = fopen($path1,'w+');

            // Chmod the file, in case the user forgot
            @chmod($path1, 0777);
            // Verify file permissions
            if (is_writable($path1)) {
                // Write the file
                if (fwrite($handle1,$new1)) {
                    @chmod($path1,0755); 
                }
            } 

  

            $builder = $this->db->table('blockchain_network');
            $ins = $builder->where(['id'=>$id])->update($data);

            if($ins){
                $this->session->setFlashdata('message',display('save_successfully')); 
                return  redirect()->to(base_url('backend/nft/nft_setup')); 
            }else{ 
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return  redirect()->to(base_url('backend/nft/update_network/'.$id));
            } 
 
        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('backend/nft/update_network/'.$id));
        }
        $data['network'] = $info;
        $data['title']  = "Network Update";
        $data['content'] = $this->BASE_VIEW . '\nft-setup\network_update';
        return $this->template->admin_layout($data);
    }



    public function wallet_balance($id=null)
    {
     	if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
			return redirect()->to('admin');
		}

		if(empty($id)){
			return redirect()->to('backend/nft/nft_setup');
		} 
 

		$builder = $this->db->table('admin_wallet');
        $info  = $builder->select('*')->where('awid', $id)->get()->getRow();
      
        $res = $this->blockchain->baseCoinBalance($info->wallet_address, $this->network); 
          
        if($res->status === 'success'){
        	 
        	$builder = $this->db->table('admin_wallet');
        	$builder->where(['wallet_address'=>$info->wallet_address])->update(['balance'=> $res->data->balance]); 

 
	     	echo json_encode(['status' =>'success', 'balance'=> $res->data->balance,'msg'=>'update successfully']); 
	     	exit;
        }else{ 

     		echo json_encode(['status' =>'error', 'msg'=>'error']); 
	     	exit;
        }  

    }



    public function contract_setup()
    {
        $this->validation->setRule('contract_name', 'contract name','required');
        $this->validation->setRule('contract_symbol', 'contract symbol','required');
        $this->validation->setRule('max_supply', 'max supply','required');

        if ($this->validation->withRequest($this->request)->run()){ 
              
            /**  contract deploy */
            $networkdata        = $this->common_model->where_row('blockchain_network'); 
            $adminWalletInfo    = $this->common_model->where_row('admin_wallet'); 
            $adminPrivateData   = $this->blockchain->privateCredential($adminWalletInfo); 

            $privatekey         = '0x';
            $address            = '0x';

            if($adminPrivateData->status === 'success'){

              $privatekey   = $adminPrivateData->data->privatekey;
              $address      = $adminPrivateData->data->address;

            } 

            $contranctInfo = [ 
                'privateKey'        => $privatekey, 
                'contractName'      =>$this->request->getVar('contract_name', FILTER_SANITIZE_STRING), 
                'contractSymbol'    => $this->request->getVar('contract_symbol', FILTER_SANITIZE_STRING),
                'gotMaxTokenSupply' => $this->request->getVar('max_supply', FILTER_SANITIZE_STRING),
                'rpc_url'           => $networkdata->rpc_url,  
            ]; 

          

            $depInfo        = $this->blockchain->contract_deploy('api/transaction/contractDeploy', $contranctInfo); 
            $depInfoDecode  = json_decode($depInfo);
             
            if($depInfoDecode->status == 'success'){
                $data = [
                    'contract_name'     => $this->request->getVar('contract_name', FILTER_SANITIZE_STRING),
                    'contract_symbol'   => $this->request->getVar('contract_symbol', FILTER_SANITIZE_STRING),
                    'max_token_supply'  => $this->request->getVar('max_supply', FILTER_SANITIZE_STRING),
                    'contract_address'  => $depInfoDecode->data->address,
                    'tnx_hash'          => $depInfoDecode->data->deployTransaction->hash, 
                    'status'            => '1',
                    'create_at'         => date('Y-m-d H:i:s')
                ];

                $setContract = [  

                    'privateKey'        => $privatekey,
                    'rpc_url'           => $networkdata->rpc_url,
                    'contractAddress'   => $depInfoDecode->data->address,
                    
                ]; 
 
                $builder    = $this->db->table('contract_setup');
                $builder->insert($data);

                $insertId        = $this->db->insertID();   
                
                if($insertId){

                    $this->session->setFlashdata('message',display('save_successfully')); 
                    return  redirect()->to(base_url('backend/nft/contract'));  

                }else{
                    $this->session->setFlashdata('exception', $res->msg); 
                    return  redirect()->to(base_url('backend/nft/contract'));
                 
                } 

            }else{

                $this->session->setFlashdata('exception', substr($depInfoDecode->msg, 0, 74));  
                return  redirect()->to(base_url('backend/nft/contract'));
            }
             
        }

        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
              $this->session->setFlashdata('exception', $error);
              return  redirect()->to(base_url('backend/nft/add_category'));
        }
        $data['network'] = $this->common_model->where_row('blockchain_network');
        $data['info'] = $this->common_model->where_row('contract_setup', ['status'=>1]);
        $data['title']  = "Contract Setup";
        $data['content'] = $this->BASE_VIEW . '\nft-setup\contract_setup';
        return $this->template->admin_layout($data);
    }


    public function contract_setup_ajax()
    {
        /**  contract deploy */
        $networkdata        = $this->common_model->where_row('blockchain_network'); 
        $adminWalletInfo    = $this->common_model->where_row('admin_wallet'); 
        $adminPrivateData   = $this->blockchain->privateCredential($adminWalletInfo); 

        $privatekey         = '0x';
        $address            = '0x';

        if($adminPrivateData->status === 'success'){

          $privatekey   = $adminPrivateData->data->privatekey;
          $address      = $adminPrivateData->data->address;

        } 

        $contranctInfo = [ 
            'privateKey'        =>  $privatekey, 
            'contractName'      =>  $this->request->getVar('contract_name', FILTER_SANITIZE_STRING), 
            'contractSymbol'    =>  $this->request->getVar('contract_symbol', FILTER_SANITIZE_STRING),
            'gotMaxTokenSupply' =>  $this->request->getVar('max_supply', FILTER_SANITIZE_STRING),
            'rpc_url'           =>  $networkdata->rpc_url,  
        ]; 
 

        $depInfo        = $this->blockchain->contract_deploy('api/transaction/contractDeploy', $contranctInfo); 
        $depInfoDecode  = json_decode($depInfo);
         
        if($depInfoDecode->status == 'success'){

            $data = [
                'contract_name'     => $this->request->getVar('contract_name', FILTER_SANITIZE_STRING),
                'contract_symbol'   => $this->request->getVar('contract_symbol', FILTER_SANITIZE_STRING),
                'max_token_supply'  => $this->request->getVar('max_supply', FILTER_SANITIZE_STRING),
                'contract_address'  => $depInfoDecode->data->address,
                'tnx_hash'          => $depInfoDecode->data->deployTransaction->hash, 
                'status'            => '1',
                'create_at'         => date('Y-m-d H:i:s')
            ];

            
                $builder    = $this->db->table('contract_setup');
                $builder->insert($data);

                $insertId   = $this->db->insertID();    
                if($insertId){ 
                   echo json_encode(['status' => 'success', 'msg' => 'Successfully deployed your contract']);
                   exit;
                }else{
                    echo json_encode(['status' => 'err', 'msg' => 'please try again']);
                    exit;
                } 

            }else{ 
                echo json_encode(['status' => 'err', 'msg' => 'please try again', 'message' => substr($depInfoDecode->msg, 0, 74)]);
                exit;
            }
 
    }


    public function setContract($value='')
    {
        $networkdata        = $this->common_model->where_row('blockchain_network'); 
        $contractInfo       = $this->common_model->where_row('contract_setup'); 
        $adminWalletInfo    = $this->common_model->where_row('admin_wallet'); 
        $adminPrivateData   = $this->blockchain->privateCredential($adminWalletInfo); 

        $privatekey         = '0x';
        $address            = '0x';

        if($adminPrivateData->status === 'success'){ 
          $privatekey   = $adminPrivateData->data->privatekey;
          $address      = $adminPrivateData->data->address; 
        } 

        $set = [   
            'privateKey'        => $privatekey,
            'rpc_url'           => (isset($networkdata->rpc_url)) ? $networkdata->rpc_url : '',
            'contractAddress'   => (isset($contractInfo->contract_address)) ? $contractInfo->contract_address : '', 
        ]; 
 
        $set = $this->blockchain->set_contract('api/transaction/setContract', $set);
        if(isset($set)){
            echo json_encode(['status' => 'success']);
            exit; 
        }
        echo json_encode(['status' => 'err', 'msg' => 'please try again']);
        exit;
    }



    public function fileGateway()
    {
        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
            return redirect()->to('admin');
        } 



        $this->validation->setRule('gateway_name', 'Gateway name','required');
        $this->validation->setRule('api_key', 'API Key','required');
        $this->validation->setRule('secret_key', 'secret_key','required'); 

        if ($this->validation->withRequest($this->request)->run()){

            $data = [
                'gateway_name' => $this->request->getVar('gateway_name', FILTER_SANITIZE_STRING),
                'api_key' => $this->request->getVar('api_key', FILTER_SANITIZE_STRING),
                'secret_key' => $this->request->getVar('secret_key', FILTER_SANITIZE_STRING), 
                'created_at' => date('Y-m-d H:i:s')
            ];

            $builder = $this->db->table('file_gateway');
            $ins = $builder->insert($data);

            if($ins){
                $this->session->setFlashdata('message',display('save_successfully')); 
                return  redirect()->to(base_url('backend/nft/file_gateway_setup')); 
            }else{ 
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return  redirect()->to(base_url('backend/nft/file_gateway_setup'));
            } 
 
        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('backend/nft/file_gateway_setup'));
        }
        $data['file_gateway'] = $this->common_model->where_row('file_gateway');
        $data['title']  = "File Gateway Setup";
        $data['content'] = $this->BASE_VIEW . '\nft-setup\file_gateway_setup';
        return $this->template->admin_layout($data);
    }



    public function fileGatewayUpdate($id=null)
    {
        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
            return redirect()->to('admin');
        } 
        if(empty($id)){
           return redirect()->to('admin'); 
        }
 

        $this->validation->setRule('gateway_name', 'Gateway name','required');
        $this->validation->setRule('api_key', 'API Key','required');
        $this->validation->setRule('secret_key', 'secret_key','required'); 

        if ($this->validation->withRequest($this->request)->run()){

            $data = [
                'gateway_name' => $this->request->getVar('gateway_name', FILTER_SANITIZE_STRING),
                'api_key' => $this->request->getVar('api_key', FILTER_SANITIZE_STRING),
                'secret_key' => $this->request->getVar('secret_key', FILTER_SANITIZE_STRING)  
            ];

            $builder = $this->db->table('file_gateway');
            $ins = $builder->where(['id'=> $id])->update($data);

            if($ins){
                $this->session->setFlashdata('message',display('update_successfully')); 
                return  redirect()->to(base_url('backend/nft/nft_setup')); 
            }else{ 
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return  redirect()->to(base_url('backend/nft/file_gateway_update'));
            } 
 
        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('backend/nft/file_gateway_update'));
        }
        $data['file_gateway'] = $this->common_model->where_row('file_gateway');
        $data['title']  = "File Gateway Setup";
        $data['content'] = $this->BASE_VIEW . '\nft-setup\file_gateway_update';
        return $this->template->admin_layout($data);
    }


    public function bidingType()
    {
        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
            return redirect()->to('admin');
        } 



        $this->validation->setRule('gateway_name', 'Gateway name','required');
        $this->validation->setRule('api_key', 'API Key','required');
        $this->validation->setRule('secret_key', 'secret_key','required'); 

        if ($this->validation->withRequest($this->request)->run()){

            $data = [
                'gateway_name' => $this->request->getVar('gateway_name', FILTER_SANITIZE_STRING),
                'api_key' => $this->request->getVar('api_key', FILTER_SANITIZE_STRING),
                'secret_key' => $this->request->getVar('secret_key', FILTER_SANITIZE_STRING), 
                'created_at' => date('Y-m-d H:i:s')
            ];

            $builder = $this->db->table('file_gateway');
            $ins = $builder->insert($data);

            if($ins){
                $this->session->setFlashdata('message',display('save_successfully')); 
                return  redirect()->to(base_url('backend/nft/nft_setup')); 
            }else{ 
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return  redirect()->to(base_url('backend/nft/file_gateway_setup'));
            } 
 
        }
        $error=$this->validation->listErrors();
        if($this->request->getMethod() == "post"){
            $this->session->setFlashdata('exception', $error);
            return  redirect()->to(base_url('backend/nft/file_gateway_setup'));
        }
        $data['title']  = "File Gateway Setup";
        $data['content'] = $this->BASE_VIEW . '\nft-setup\file_gateway_setup';
        return $this->template->admin_layout($data);
    }



    public function type_status_change($typeId=null, $status=null)
    {
        if (!empty($typeId)) {

          $typeInfo = $this->common_model->where_row('nft_selling_type', ['type_id'=>$typeId]);

          $update = $this->common_model->update('nft_selling_type', ['type_id'=>$typeId], ['status'=>$status]);
          if ($update) {
            echo json_encode(['status'=>'success', 'msg'=>'updated']);
          }else{
            echo json_encode(['status'=>'err', 'msg'=>'unknown error']);
          }

        
        }else{
          echo json_encode(['status'=>'err', 'msg'=>'your nft not found']);
        }
    }


    public function saleTypeControl()
    {
        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
             return redirect()->to('admin');
          } 

        $data['title']  = "Admin Wallet";

        #-------------------------------#
         #pagination starts
        #-------------------------------#
        $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $data['wallets'] = $this->common_model->get_all('admin_wallet', $pagewhere=array(),20,($page_number-1)*20,'awid','desc');
       
        #------------------------
        #pagination ends
        #------------------------

        $data['networks'] = $this->common_model->get_all('blockchain_network', $pagewhere=array(),20,($page_number-1)*20,'id','desc');
        $data['file_gateway'] = $this->common_model->where_row('file_gateway');
        $data['selling_types'] = $this->common_model->where_rows('nft_selling_type', [], 'type_id','asc');
         
        $data['content'] = $this->BASE_VIEW . '\nft-setup\sale_type_control';
        return $this->template->admin_layout($data);
    }


    public function transferOption()
    {
        if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
             return redirect()->to('admin');
          } 

        $data['title']  = "Transfer Options";
 
     
        $data['transfer_option'] = $this->common_model->where_rows('nft_transfer_option', [], 'option_id','asc');
         
        $data['content'] = $this->BASE_VIEW . '\nft-setup\transfer_option';
        return $this->template->admin_layout($data);
    }



    public function transfer_option_status_change($optionId=null, $status=null)
    {
        if (!empty($optionId)) {

          $typeInfo = $this->common_model->where_row('nft_transfer_option', ['option_id'=>$optionId]);

          $update = $this->common_model->update('nft_transfer_option', ['option_id'=>$optionId], ['status'=>$status]);
          if ($update) {
            echo json_encode(['status'=>'success', 'msg'=>'updated']);
          }else{
            echo json_encode(['status'=>'err', 'msg'=>'unknown error']);
          }

        
        }else{
          echo json_encode(['status'=>'err', 'msg'=>'your nft not found']);
        }
    }


    
   
}
