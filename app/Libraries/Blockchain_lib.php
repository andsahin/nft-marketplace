<?php
namespace App\Libraries;
//define('UPDATE_INFO_URL','https://update.bdtask.com/nftbox/autoupdate/update_info');

/**
 * Developed By Bdtask Ltd. (Blockchain Team)
 * First Release 2021-10-07, Version v1.0
 * Second Release 2021-12-20, Version v1.1
 * Network ERC-20 and BEP-20
 * Request Data Object
 * Response Data True,False,Object
 */

class Blockchain_lib
{
    private $endpoints;
    private $explorarurl;
    private $symbol;
    private $network;
    public function __construct()
    {
        $this->network = BNETWORK;
        $this->db    = db_connect();
        $networkInfo = $this->db->table('blockchain_network')->get()->getRow();

        if(isset($networkInfo)){
            $this->endpoints    = 'http://'.$networkInfo->server_ip.':'.$networkInfo->port.'/'; 
            $this->explorarurl  = $networkInfo->explore_url;
            $this->symbol       = $networkInfo->currency_symbol;
        }
        
    }

    /** User new wallet generates on blockchain */
    public function createWallet(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('User Data is required');
        }

        $walletinfo = $this->curlExcute('api/account/createWallet');

        $walletinfo = $this->toJsonDecode($walletinfo);
        if ($walletinfo) {
            if ($walletinfo->status == 'success') {
                $user_id    = $data->user_id;
                $wallet     = $walletinfo->data->address;
                $privateKey = $walletinfo->data->privateKey;
                $password   = time().$data->password; 
       
                $builder = $this->db->table('user_wallet');
                $checkuser  = $builder->select('uwid')->where('user_id', $user_id)->get()->getRow();
                if ($checkuser) {
                    return $this->errorResponse("The user's wallet has already been created");
                }
                $encryppassw = $this->encrypt($password); 
                if ($encryppassw) {
                    $encryptinfo = $this->curlExcute('api/account/privateKeyEncrypt', ['privateKey' => $privateKey, 'password' => $encryppassw]);
                    $encryptinfo = $this->toJsonDecode($encryptinfo);
                    $todaytimes  = date('Y-m-d H:i:s');
                    
                    if ($encryptinfo) {
                        $encryptinsertdata = array(
                            'version'      => $encryptinfo->data->version,
                            'id'           => $encryptinfo->data->id,
                            'wallet_address'=> $encryptinfo->data->address,
                            'ciphertext'   => $encryptinfo->data->crypto->ciphertext,
                            'iv'           => $encryptinfo->data->crypto->cipherparams->iv,
                            'cipher'       => $encryptinfo->data->crypto->cipher,
                            'kdf'          => $encryptinfo->data->crypto->kdf,
                            'dklen'        => $encryptinfo->data->crypto->kdfparams->dklen,
                            'salt'         => $encryptinfo->data->crypto->kdfparams->salt,
                            'n'            => $encryptinfo->data->crypto->kdfparams->n,
                            'r'            => $encryptinfo->data->crypto->kdfparams->r,
                            'p'            => $encryptinfo->data->crypto->kdfparams->p,
                            'mac'          => $encryptinfo->data->crypto->mac,
                            'encrypt_val'  => $password,
                            'user_id'      => $user_id,
                            'balance'      => 0,
                            'created_at'   => $todaytimes,
                            'update_at'    => $todaytimes,
                        );
                        $builder = $this->db->table('user_wallet');
                        $result = $builder->insert($encryptinsertdata); 
                        
                        return $this->successResponse('Wallet Address Created successfully');
                    } else {
                        return $this->errorResponse("Something went wrong");
                    }
                } else {
                    return $this->errorResponse("The user's data not found");
                }
            } else {
                return $walletinfo;
            }
        } else {
            return $this->errorResponse("Something went wrong");
        }
    }


    public function importWallet($key=null, $id=null)
    {
        if (empty($key)) {
            return $this->errorResponse('User Data is required');
        }

        $password = 'bdt@nft4321';
        $encryppassw = $this->encrypt($password);
        if ($encryppassw) {
            $encryptinfo = $this->curlExcute('api/account/privateKeyEncrypt', ['privateKey' => $key, 'password' => $encryppassw]);
            $encryptinfo = $this->toJsonDecode($encryptinfo);
            $todaytimes  = date('Y-m-d H:i:s');

            if ($encryptinfo) {
                $encryptinsertdata = array(
                    'version'      => $encryptinfo->data->version,
                    'id'           => $encryptinfo->data->id,
                    'wallet_address'=> '0x'.$encryptinfo->data->address,
                    'ciphertext'   => $encryptinfo->data->crypto->ciphertext,
                    'iv'           => $encryptinfo->data->crypto->cipherparams->iv,
                    'cipher'       => $encryptinfo->data->crypto->cipher,
                    'kdf'          => $encryptinfo->data->crypto->kdf,
                    'dklen'        => $encryptinfo->data->crypto->kdfparams->dklen,
                    'salt'         => $encryptinfo->data->crypto->kdfparams->salt,
                    'n'            => $encryptinfo->data->crypto->kdfparams->n,
                    'r'            => $encryptinfo->data->crypto->kdfparams->r,
                    'p'            => $encryptinfo->data->crypto->kdfparams->p,
                    'mac'          => $encryptinfo->data->crypto->mac,
                    'encrypt_val'  => $password, 
                    'created_at'   => $todaytimes, 
                );

                $builder1 = $this->db->table('admin_wallet');
                $checkuser  = $builder1->select('awid')->where('wallet_address', '0x'.$encryptinfo->data->address)->get()->getRow();
                if ($checkuser) {
                    return $this->errorResponse("The user's wallet has already been created");
                }

                // Insert encrypt data 
                $builder = $this->db->table('admin_wallet');
                $result = $builder->insert($encryptinsertdata); 
                 

                $res = $this->baseCoinBalance('0x'.$encryptinfo->data->address, $this->network);
                 
                if($res){ 
                    $builder = $this->db->table('admin_wallet'); 
                    $builder->where(['wallet_address'=>'0x'.$encryptinfo->data->address])->update(['balance'=> $res->data->balance]);
                }else{
                    return $this->errorResponse("Something went wrong");
                }

                return $this->successResponse('Wallet Address Created successfully');
            } else {
                return $this->errorResponse("Something went wrong");
            }
        } else {
            return $this->errorResponse("The user's data not found");
        }
    }


    /** Export wallet private key from blockchain */
    private function exportPrivateKey(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse("Export token data is required");
        }

        $password = $this->encrypt($data->encrypt_val);
        if ($password) {
            $etherdata = array(
                'version'    => $data->version,
                'id'         => $data->id,
                'address'    => $data->address,
                'ciphertext' => $data->ciphertext,
                'iv'         => $data->iv,
                'cipher'     => $data->cipher,
                'kdf'        => $data->kdf,
                'dklen'      => $data->dklen,
                'salt'       => $data->salt,
                'n'          => $data->n,
                'r'          => $data->r,
                'p'          => $data->p,
                'mac'        => $data->mac,
                'password'   => $password
            );
            $privatekeyinfo = $this->curlExcute('api/account/privateKeyDycrypt', $etherdata);
            $privatekeyinfo = $this->toJsonDecode($privatekeyinfo);
            if ($privatekeyinfo) {
                return $privatekeyinfo;
            } else {
                return $this->errorResponse("Something went wrong");
            }
        } else {
            return $this->errorResponse("Users data is missing");
        }
    }

    /** Encrypt plain text with key by md5 hash method */
    private function encrypt(String $plaintext = null)
    {
        if (empty($plaintext)) {
            return false;
        }

        $key        = "Bdtask@#NFT@#2022";
        $ciphertext = md5($plaintext . $key);
        return $ciphertext;
    }

    /** Check Blockchain Transaction Status By Hash */
    public function checkTx(String $hash = null)
    {
        if (empty($hash)) {
            return $this->errorResponse("Transaction hash field is required");
        }

        $txhash = $this->curlExcute('api/transaction/getTransactionReceipt', ['txHash' => $hash, 'netWork'=>$this->network]);

        $txhash = $this->toJsonDecode($txhash);

        if ($txhash) {

            if($txhash->status=="success"){

                if($txhash->data){
                    if($txhash->data->status){
                        return $this->successResponse($txhash->msg, $txhash);
                    }
                    else{
                        return $this->cancelResponse();
                    }
                }
                else{
                    $getTranas = $this->curlExcute('api/transaction/getTransaction', ['txHash' => $hash]);
                    $getTranas = $this->toJsonDecode($getTranas);

                    if($getTranas){
                        if($getTranas->status=="success"){
                            if($getTranas->data){
                                return $this->pendingResponse($txhash->msg, $txhash);
                            }
                            else{
                                return $this->wrongResponse('Sorry, We are unable to locate this TxnHash');
                            }
                        }
                        else{
                            return $txhash;
                        }
                    }
                    else{
                        return $this->errorResponse('Something went wrong');
                    }
                }
            }
            else{
                return $txhash;
            }
        } else {
            return $this->errorResponse("Something went wrong");
        }
    }

    public function getTokenid(String $hash = null)
    {
        if (empty($hash)) {
            return $this->errorResponse("Transaction hash field is required");
        }

        $txhash = $this->curlExcute('api/transaction/getTokenIdFromTrx', ['txHash' => $hash, 'netWork'=>$this->network]);

        $txhash = $this->toJsonDecode($txhash);
         
        if ($txhash) {

            if($txhash->status=="success"){ 
                if($txhash->data){   
                    return $this->successResponse($txhash->msg, $txhash); 
                }
                else{
                    $getTranas = $this->curlExcute('api/transaction/getTransaction', ['txHash' => $hash]);
                    $getTranas = $this->toJsonDecode($getTranas);

                    if($getTranas){
                        if($getTranas->status=="success"){
                            if($getTranas->data){
                                return $this->pendingResponse($txhash->msg, $txhash);
                            }
                            else{
                                return $this->wrongResponse('Sorry, We are unable to locate this TxnHash');
                            }
                        }
                        else{
                            return $txhash;
                        }
                    }
                    else{
                        return $this->errorResponse('Something went wrong');
                    }
                }
            }
            else{
                return $txhash;
            }
        } else {
            return $this->errorResponse("Something went wrong");
        }
    }

    /** Send P2P base coin */
    public function sendP2PBaseCoin(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Send data field is required');
        }


        $walletinfo     = $this->db->select('*')->from('admin_wallet')->where('wallet', $data->fromAddress)->get()->row();
        $privateKeyInfo = $this->exportPrivateKey($walletinfo);
        if($privateKeyInfo->status=="success"){
            $tokendata = [
                'formAddress'    => $data->fromAddress,
                'toAddress'      => $data->toAddress,
                'sendAmount'     => $data->sendAmount,
                'privateKey'     => $privateKeyInfo->data->privateKey,
            ];
            $txinfo  = $this->curlExcute('api/transaction/sendBaseCoin', $tokendata);
            $txinfo  = $this->toJsonDecode($txinfo);
            if ($txinfo) {
                return $txinfo;
            }
            else{
                return $this->errorResponse('Something went wrong');
            }
        }
        else{
            return $privateKeyInfo;
        }
    }


    public function sendBuyerToSellerAccount(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Send data field is required');
        }

        
         
            $txinfo  = $this->curlExcute('api/transaction/sendBaseCoin', (array) $data);
            $txinfo  = $this->toJsonDecode($txinfo);
            
            if ($txinfo) {
                return $txinfo;
            }
            else{
                return $this->errorResponse('Something went wrong');
            } 
         
    }


    /** Send P2P base coin */
    public function sendP2PToken(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Send data field is required');
        }

        $coininfo       = $this->coinInfo();
        $walletinfo     = $this->db->select('*')->from('dbt_admin_wallet')->where('wallet', $data->fromAddress)->get()->row();
        $privateKeyInfo = $this->exportPrivateKey($walletinfo);
        if($privateKeyInfo->status=="success"){

            $tokendata = [
                'formAddress'     => $data->fromAddress,
                'contractAddress' => $coininfo->contract_address,
                'toAddress'       => $data->toAddress,
                'sendAmount'      => $data->sendAmount,
                'privateKey'      => $privateKeyInfo->data->privateKey,
            ];
            
            $txinfo  = $this->curlExcute('api/transaction/sendToken', $tokendata);
            $txinfo  = $this->toJsonDecode($txinfo);
            if ($txinfo) {
                return $txinfo;
            }
            else{
                return $this->errorResponse('Something went wrong');
            }
        }
        else{
            return $privateKeyInfo;
        }
    }

    /** Send Token From System Wallet */
    public function adminToSendToken(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Send information is required');
        }

        $systeminfo = $this->adminCredential($data->tx_type, $data->useing_for);

        if ($systeminfo->status=="success") {

            $fromAddress    = $systeminfo->data->address;
            $fromPrivateKey = $systeminfo->data->privatekey;
            $coininfo       = $this->coinInfo();
           
            if ($coininfo) {

                $balanceinfo   = $this->tokenBalance($fromAddress);
                if ($balanceinfo->status=="success") {
                    $walletbalance = $balanceinfo->data->tokenBalance;
                    if ($walletbalance < $data->send_amount) {
                        $this->db->where('aw_id', $systeminfo->data->aw_id)->update('dbt_admin_wallet', ['status' => 0]);
                        return $this->errorResponse('System wallet have not enough balance');
                    }
                }
                else{
                    return $balanceinfo;
                }

                $tokendata = [
                    'formAddress'     => $fromAddress,
                    'contractAddress' => $coininfo->contract_address,
                    'toAddress'       => $data->to_address,
                    'sendAmount'      => $data->send_amount,
                    'privateKey'      => $fromPrivateKey,
                ];
                $txinfo  = $this->curlExcute('api/transaction/sendToken', $tokendata);
                $txinfo  = $this->toJsonDecode($txinfo);
                if ($txinfo) {
                    if ($txinfo->status == "success") {
                        $ci->db->where('aw_id', $systeminfo->data->aw_id)->update('dbt_admin_wallet', ['status' => 1]);
                        return $this->successResponse('Token send successfully',(object)['txHash'=>$txinfo->data->txHash,'formAddress'=>$fromAddress]);
                    }else{
                        
                        /*new code start*/
                        $gasFee = $this->txFees();
                        if($gasFee->status=="success"){
                            $fees            = $gasFee->data->txFees;
                            $basebalanceinfo = $this->baseCoinBalance($fromAddress);
                            if ($basebalanceinfo->status == 'success') {
                                $balance = $basebalanceinfo->data->balance;
                                if ($balance < $fees) {
                                    $ci->db->where('aw_id', $systeminfo->data->aw_id)->update('dbt_admin_wallet', ['status' => 0]);
                                }
                            }
                        }
                        /*new code end*/

                        return $txinfo;
                    }
                } else {
                    return $this->errorResponse('Something went wrong');
                }
            } else {
                return $this->errorResponse('The system coin does not exist');
            }
        } else {
            return $systeminfo;
        }
    }
    /** Find idle system wallet and export private key */
    private function adminCredential(String $txType = 'EARNINGS', String $usingFor = 'TOKEN')
    {
      
        $data        = $this->db->select('*')->from('dbt_admin_wallet')->where('status', 2)->where('tnx_type', $txType)->where('using_for', $usingFor)->get()->row();

        if ($data) {
            $exportdata = (object)[
                'version'     => $data->version,
                'id'          => $data->id,
                'address'     => $data->address,
                'ciphertext'  => $data->ciphertext,
                'iv'          => $data->iv,
                'cipher'      => $data->cipher,
                'kdf'         => $data->kdf,
                'dklen'       => $data->dklen,
                'salt'        => $data->salt,
                'n'           => $data->n,
                'r'           => $data->r,
                'p'           => $data->p,
                'mac'         => $data->mac,
                'encrypt_val' => $data->encrypt_val,
            ];
            $privateKey = $this->exportPrivateKey($exportdata);
            if($privateKey->status=="success"){
                return $this->successResponse('Data found',(object)['address' => $data->wallet, 'privatekey' => $privateKey->data->privateKey, 'aw_id' => $data->aw_id]);
            }
            else{
                return $privateKey;
            }
        } else {
            return $this->errorResponse('System credential not found');
        }
    }

    /** all private key export */
    public function privateCredential($data=null)
    { 
        if ($data) {
            $exportdata = (object)[
                'version'     => $data->version,
                'id'          => $data->id,
                'address'     => $data->wallet_address,
                'ciphertext'  => $data->ciphertext,
                'iv'          => $data->iv,
                'cipher'      => $data->cipher,
                'kdf'         => $data->kdf,
                'dklen'       => $data->dklen,
                'salt'        => $data->salt,
                'n'           => $data->n,
                'r'           => $data->r,
                'p'           => $data->p,
                'mac'         => $data->mac,
                'encrypt_val' => $data->encrypt_val,
            ];  
            
            $privateKey = $this->exportPrivateKey($exportdata);
            if($privateKey->status=="success"){
                return $this->successResponse('Data found',(object)['address' => $data->wallet_address, 'privatekey' => $privateKey->data->privateKey]);
            }
            else{
                return $privateKey;
            }
        } else {
            return $this->errorResponse('System credential not found');
        }
    }


    /** Return Token Balance By Wallet Address */
    public function tokenBalance(String $address = null,String $network = null)
    {


        if (!$address || !$network) {
            return $this->errorResponse('Data is required');
        }

        $coininfo = $this->coinInfo($network);

        if ($coininfo) {
            $tokendata = [
                'netWork'         => $network,
                'address'         => $address,
                'contractAddress' => $coininfo->contract_address,
                'decimal'         => $coininfo->token_decimal
            ];

            $txinfo  = $this->curlExcute('api/account/getTokenBalance', $tokendata);
            $txinfo  = $this->toJsonDecode($txinfo);

            if ($txinfo) {
                if($txinfo->status=="success"){
                    return $this->successResponse('Wallet Address Balance',(object)['tokenBalance'=>$txinfo->data->tokenBalance]);
                }
                else{
                    return $txinfo;
                }
            } else {
                return $this->errorResponse('Something went wrong');
            }
        } else {
            return $this->errorResponse('The system coin does not exist');
        }
    }

    /** Return user internal wallet balance by user Id */
    public function userTokenBalance(String $user_id = null)
    {
        if(empty($user_id)){
            return $this->errorResponse('UserId field is required');
        }

       
        $walletinfo = $this->db->select('wallet_address')->from('dbt_user_wallet')->where('user_id',$user_id)->get()->row();
        if(!$walletinfo){
            return $this->errorResponse('User Wallet does not exist');
        }

        $address = $walletinfo->wallet_address;
        $balance = $this->tokenBalance($address);

        return $balance;
    }

    /** Generate or Import System wallet */
    public function setAdminWallet(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Wallet setup data is required');
        }
        //walletType = generate,export
        $walletType = $data->walletType;
        $password   = $data->password;
        $useingFor  = $data->useingFor;
        $tnx_type   = $data->tnx_type;
        $network    = $data->network;

        if(empty($network)){
            $network = 'bsc';
        }

        if ($walletType == 'generate') {

            $walletinfo = $this->curlExcute('api/account/createWallet');
            $walletinfo = $this->toJsonDecode($walletinfo);
            if ($walletinfo) {
                if ($walletinfo->status == 'success') {
                    $address    = $walletinfo->data->address;
                    $privateKey = $walletinfo->data->privateKey;
                } else {
                    return $walletinfo;
                }
            } else {
                return $this->errorResponse('Something went wrong');
            }
        } else {
            $privateKey = $data->privateKey;
            if (empty($privateKey)) {
                return $this->errorResponse('Private key is required');
            }

            $accountinfo  = $this->curlExcute('api/account/privateKeyToAddress', ['privateKey' => $privateKey]);
            $accountinfo  = $this->toJsonDecode($accountinfo);
            if ($accountinfo) {
                if ($accountinfo->status == 'success') {
                    $address = $accountinfo->data->address;
                    
                    $checkDuplicate = $this->db->select('aw_id')->from('dbt_admin_wallet')->where('wallet',$address)->get()->row();
                    if($checkDuplicate){
                        return $this->errorResponse('Wallet address already exists');
                    }
                } else {
                    return $accountinfo;
                }
            } else {
                return $this->errorResponse('Something went wrong');
            }
        }

        $encryppassw = $this->encrypt($password);
        if ($encryppassw) {
            $encryptinfo = $this->curlExcute('api/account/privateKeyEncrypt', ['privateKey' => $privateKey, 'password' => $encryppassw]);
            $encryptinfo = $this->toJsonDecode($encryptinfo);
            $todaytimes  = date('Y-m-d H:i:s');

            if ($encryptinfo) {
                if($encryptinfo->status=="success"){
                    $encryptinsertdata = array(
                        'version'      => $encryptinfo->data->version,
                        'id'           => $encryptinfo->data->id,
                        'address'      => $encryptinfo->data->address,
                        'ciphertext'   => $encryptinfo->data->crypto->ciphertext,
                        'iv'           => $encryptinfo->data->crypto->cipherparams->iv,
                        'cipher'       => $encryptinfo->data->crypto->cipher,
                        'kdf'          => $encryptinfo->data->crypto->kdf,
                        'dklen'        => $encryptinfo->data->crypto->kdfparams->dklen,
                        'salt'         => $encryptinfo->data->crypto->kdfparams->salt,
                        'n'            => $encryptinfo->data->crypto->kdfparams->n,
                        'r'            => $encryptinfo->data->crypto->kdfparams->r,
                        'p'            => $encryptinfo->data->crypto->kdfparams->p,
                        'mac'          => $encryptinfo->data->crypto->mac,
                        'encrypt_val'  => $password,
                        'wallet'       => $address,
                        'using_for'    => $useingFor,
                        'tnx_type'     => $tnx_type,
                        'network'      => $network,
                        'status'       => 2,
                        'created_at'   => $todaytimes,
                        'update_at'    => $todaytimes,
                    );
                    
                    $result = $ci->db->insert('dbt_admin_wallet', $encryptinsertdata);
                    if($result){
                        return $this->successResponse('System wallet setup successfully');
                    }
                    else{
                        return $this->errorResponse('Something went wrong');
                    }
                }
                else{
                    return $encryptinfo;
                }
            } else {
                return $this->errorResponse('Something went wrong');
            }
        } else {
            return $this->errorResponse('Something went wrong');
        }
    }

    /** Return token information by contract address from Blockchain */
    public function tokenInfo(String $contractAddress = null,String $network = null)
    {
        if (empty($contractAddress)) {
            return $this->errorResponse('Contract Address is required');
        }

        $tokeninfo = $this->curlExcute('api/account/getTokenInfo', ['contractAddress' => $contractAddress,'netWork'=>$network]);
        $tokeninfo = $this->toJsonDecode($tokeninfo);
        
        if ($tokeninfo) {
            return $tokeninfo;
        }
        else{
            return $this->errorResponse('Something went wrong');
        }
    }

    /** Transfer Token From User Internal wallet to External wallet */
    public function userToSendToken(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Token send data is required');
        }

        $usercredintial = $this->userCredential($data->user_id);
        if ($usercredintial->status=="success") {
            $privateKey  = $usercredintial->data->privatekey;
            $fromAddress = $data->fromAddress;
            $coininfo    = $this->coinInfo();

            if ($coininfo) {
                //check user wallet token balance
                $balanceinfo   = $this->tokenBalance($fromAddress);
                if ($balanceinfo->status=="success") {
                    $walletbalance = $balanceinfo->data->tokenBalance;
                    if ($walletbalance < $data->send_amount) {
                        return $this->errorResponse('Does not have sufficient balance');
                    }
                }
                else {
                    return $balanceinfo;
                }

                $tokendata = [
                    'formAddress'     => $fromAddress,
                    'contractAddress' => $coininfo->contract_address,
                    'toAddress'       => $data->to_address,
                    'sendAmount'      => $data->send_amount,
                    'privateKey'      => $privateKey,
                ];
                $txinfo  = $this->curlExcute('api/transaction/sendToken', $tokendata);
                $txinfo  = $this->toJsonDecode($txinfo);
                if ($txinfo) {
                    /** new code start */
                    if($txinfo->status=="error"){
                        $walletinfo = $this->checkValidWalletAddress($data->to_address);
                        if($walletinfo->status=="error"){
                            return $this->cancelResponse($walletinfo->msg);
                        }
                    }
                    /** new code end */
                    return $txinfo;
                }
                else{
                    return $this->errorResponse('something went wrong');
                }
            }
            else {
                return $this->errorResponse('The system coin does not exist');
            }
        }
        else{
            return $usercredintial;
        }
    }

    /**  After mint admin wallet to transfer creator wallet  */
    public function adminToSendNft($data = array())
    {
        if (empty($data)) {
            return $this->errorResponse('Token send data is required');
        }


        $res = $this->curlExcute('api/transaction/transferNftToken', $data);
        if ($res) {
            return $res;
        }
        else{
            return $this->errorResponse('Something went wrong');
        }
         
    }


    public function contract_deploy(String $method = null, array $data = null)
    {
        $dep  = $this->curlExcute($method, $data);
        if($dep){
            return $dep;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }


    public function set_contract(String $method = null, array $data = null)
    {
        $dep  = $this->curlExcute($method, $data);
        if($dep){
            return $dep;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }


    public function mintNft(String $method = null, array $data = null)
    {
         
        $add  = $this->curlExcute($method, $data);
         
        if($add){
            return $add;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }


    public function listForSale(String $method = null, array $data = null)
    {
         
        $list  = $this->curlExcute($method, $data);
         
        if($list){
            return $list;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }


    public function unListForSale(String $method = null, array $data = null)
    {
         
        $list  = $this->curlExcute($method, $data);
         
        if($list){
            return $list;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }



    public function buy(String $method = null, array $data = null)
    {
         
        $list  = $this->curlExcute($method, $data);
         
        if($list){
            return $list;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }

    public function transferNft(String $method = null, array $data = null)
    {
         
        $list  = $this->curlExcute($method, $data);
         
        if($list){
            return $list;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }


    public function withdraw(String $method = null, array $data = null)
    {
         
        $result  = $this->curlExcute($method, $data);
         
        if($result){
            return $result;
        }else{
            return $this->errorResponse('Something went wrong');
        }
    }

    /** Check valid wallet address*/
    public function checkValidWalletAddress(String $address = null)
    {
        $walletinfo  = $this->curlExcute('api/account/isValidWallet', ['address'=>$address]);
        $walletinfo  = $this->toJsonDecode($walletinfo);
        if($walletinfo){
            return $walletinfo;
        }
        else{
            return $this->errorResponse('something went wrong');
        }
    }

    /** Export private key from user internal wallet */
    private function userCredential(String $user_id = null)
    {
     
        $userInfo = $this->db->select('*')->from('dbt_encrypt_data')->where('user_id', $user_id)->get()->row();

        if ($userInfo) {
        
            $exportdata = (object)[
                'version'     => $userInfo->version,
                'id'          => $userInfo->id,
                'address'     => $userInfo->address,
                'ciphertext'  => $userInfo->ciphertext,
                'iv'          => $userInfo->iv,
                'cipher'      => $userInfo->cipher,
                'kdf'         => $userInfo->kdf,
                'dklen'       => $userInfo->dklen,
                'salt'        => $userInfo->salt,
                'n'           => $userInfo->n,
                'r'           => $userInfo->r,
                'p'           => $userInfo->p,
                'mac'         => $userInfo->mac,
                'encrypt_val' => $userInfo->encrypt_val,
            ];
            $privateKey = $this->exportPrivateKey($exportdata);
            if($privateKey->status=="success"){
                return $this->successResponse('Data found',(object)['privatekey' => $privateKey->data->privateKey]);
            }
            else{
                return $privateKey;
            }
        }
        else{
            return $this->errorResponse('User Data not found');
        }
    }

    /** reset private key */
    public function updatePrivateKey(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('User data is required');
        }

        $email        = $data->email;
        $newPassword  = $data->newPassword;
        $userInfo     = $this->db->select('dbt_encrypt_data.*')->from('dbt_encrypt_data')->join('user_registration','dbt_encrypt_data.user_id=user_registration.user_id','left')->where('user_registration.email',$email)->get()->row();
        if($userInfo){

            $privatekey = $this->exportPrivateKey($userInfo);
            if($privatekey->status=="success"){
                
                $encryppassw  = $this->encrypt($newPassword);
                if ($encryppassw) {
                    $encryptinfo = $this->curlExcute('api/account/privateKeyEncrypt', ['privateKey' => $privatekey->data->privateKey, 'password' => $encryppassw]);
                    $encryptinfo = $this->toJsonDecode($encryptinfo);
                    $todaytimes  = date('Y-m-d H:i:s');

                    if ($encryptinfo) {
                        if($encryptinfo->status=="success"){
                            $encryptinsertdata = array(
                                'version'      => $encryptinfo->data->version,
                                'id'           => $encryptinfo->data->id,
                                'address'      => $encryptinfo->data->address,
                                'ciphertext'   => $encryptinfo->data->crypto->ciphertext,
                                'iv'           => $encryptinfo->data->crypto->cipherparams->iv,
                                'cipher'       => $encryptinfo->data->crypto->cipher,
                                'kdf'          => $encryptinfo->data->crypto->kdf,
                                'dklen'        => $encryptinfo->data->crypto->kdfparams->dklen,
                                'salt'         => $encryptinfo->data->crypto->kdfparams->salt,
                                'n'            => $encryptinfo->data->crypto->kdfparams->n,
                                'r'            => $encryptinfo->data->crypto->kdfparams->r,
                                'p'            => $encryptinfo->data->crypto->kdfparams->p,
                                'mac'          => $encryptinfo->data->crypto->mac,
                                'encrypt_val'  => $newPassword,
                                'user_id'      => $userInfo->user_id,
                                'created_at'   => $todaytimes,
                                'update_at'    => $todaytimes,
                            );
                            
                            $result = $ci->db->where('user_id',$userInfo->user_id)->update('dbt_encrypt_data', $encryptinsertdata);
                            if($result){
                                return $this->successResponse('Update successfully');
                            }
                            else{
                                return $this->errorResponse('Something went wrong');
                            }
                        }
                        else{
                            return $encryptinfo;
                        }
                    }else{
                        return $this->errorResponse('Something went wrong');
                    }
                }else{
                    return $this->errorResponse('Something went wrong');
                }
            }else{
                return $privatekey;
            }
        }else{
            return $this->errorResponse('User Data not found');
        }
    }

    /** Return Transaction Gas Fees Amount */
    public function txFees()
    {
        $txfees  = $this->curlExcute('api/transaction/getTransactionFee');
        $txfees  = $this->toJsonDecode($txfees);

        if($txfees){
            return $txfees;
        }
        else{
            return $this->errorResponse('Something went wrong');
        }
    }

    /** Send transaction gas fees */
    public function sendFees(object $data = null)
    {
        if (empty($data)) {
            return $this->errorResponse('Fees data field is required');
        }

        $systeminfo = $this->adminCredential($data->tx_type, $data->useing_for);
        if ($systeminfo->status=="success") {

            $fromAddress    = $systeminfo->data->address;
            $fromPrivateKey = $systeminfo->data->privatekey;
            $fees           = $data->send_amount;
            
            $basebalanceinfo = $this->baseCoinBalance($fromAddress);
            if ($basebalanceinfo->status == 'success') {
                $balance = $basebalanceinfo->data->balance;
            }
            else{
                return $basebalanceinfo;
            }

            if($balance<=0 || $balance < $fees){
                $this->db->where('aw_id', $systeminfo->data->aw_id)->update('dbt_admin_wallet', ['status' => 0]);
                return $this->errorResponse('Does not have sufficient balance in system wallet');
            }

            $tokendata = [
                'formAddress'    => $fromAddress,
                'toAddress'      => $data->to_address,
                'sendAmount'     => $fees,
                'privateKey'     => $fromPrivateKey,
            ];
            $txinfo  = $this->curlExcute('api/transaction/sendBaseCoin', $tokendata);
            $txinfo  = $this->toJsonDecode($txinfo, ['formAddress' => $fromAddress]);
            if ($txinfo) {
                if ($txinfo->status == "success") {
                    $ci->db->where('aw_id', $systeminfo->data->aw_id)->update('dbt_admin_wallet', ['status' => 1]);
                    return $this->successResponse('Fees send successfully',(object)['txHash'=>$txinfo->data->txHash,'formAddress'=>$fromAddress]);
                }
                else{
                    return $txinfo;
                }
            }
            else{
                return $this->errorResponse('Something went wrong');
            }
        }
        else{
            return $systeminfo;
        }
    }

    /** Return Transaction Fees For Success transaction */
    public function hasFees(String $address = null)
    {
        if (empty($address)) {
            return false;
        }

        $basebalanceinfo = $this->baseCoinBalance($address);
        if ($basebalanceinfo->status == 'success') {
            $balance = $basebalanceinfo->data->balance;
        }
        else{
            return $basebalanceinfo;
        }

        $feesinfo = $this->txFees();
        if ($feesinfo->status=="success") {
            $fees = $feesinfo->data->txFees;

            if ($balance < $fees) {
                $collect_fees = number_format($fees - $balance,8,'.','');
                if($collect_fees>0){
                    $fees_percent = number_format($fees/3,8,'.','');
                    $collect_fees = $collect_fees+$fees_percent;
                    return $this->requiredResponse('Transaction gas fees are required',(object)['fees' => $collect_fees,'basebalanceinfo'=>$basebalanceinfo]);
                }
                else{
                    return $this->requiredResponse('Transaction gas fees are required',(object)['fees' => $fees]);
                }
            } else {
                return $this->successResponse('Fees are chargeable',(object)['fees'=>0]);
            }
        }
        else{
            return $feesinfo;
        }
    }

    /** Return base coin balance (Basecoin-ETH,BNB) */
    public function baseCoinBalance(String $address = null,String $network = null)
    {
       
        if (empty($address)) {
            return $this->errorResponse('Address field is required');
        } 
        
        $balanceinfo  = $this->curlExcute('api/account/getBalance', ['address' => $address,'netWork'=>$network]);
        
        $balanceinfo  = $this->toJsonDecode($balanceinfo);
        
        if ($balanceinfo) {
            return $balanceinfo;
        }
        else{
            return $this->errorResponse('Something went wrong');
        }
    }

    /** Return ICO coin information  sahin */
    public function coinInfo(String $network = 'bsc')
    {
        $builder = $this->db->table('coin_setup');
        
        return $builder->select('*')->where('network',$network)->where('status', 1)->get()->getRow();
    }

    /** Return blockchain explorar url */
    public function explorUrl()
    {
        return $this->explorarurl;
    }

    /** Return 4 status Transaction pending data (4 status = 0=cancel, 1=success, 2=pending, 3=hash pending, 4=pause pending) */
    public function queueData4TxPendingStatus(String $table = null, int $limit = 0)
    {
        $datainfo = $this->statusQuery($table, 2, $limit);

        if (!$datainfo) {
            $datainfo = $this->statusQuery($table, 4, $limit);
            if (!$datainfo) {
                return false;
            }
        }
        return $datainfo;
    }

    /** Return hash pending queue */
    public function queueHashPendingData(String $table = null, int $limit = 0)
    {
        $datainfo = $this->statusQuery($table, 3, $limit);
        return $datainfo;
    }

    /** Return hash success queue */
    public function queueHashSuccessData(String $table = null)
    {
        $datainfo = $this->statusQuery($table, 1);
        return $datainfo;
    }

    /** Return 6 status Transaction pending data (4 status = 0=cancel, 1=success, 2=pending, 3=hash pending, 4=pause pending, 5=send gas, 6=important pending) */
    public function queueData6TxPendingStatus(String $table = null, int $limit = 0)
    {
        $datainfo = $this->statusNewQuery($table, "status=6 OR status=2", $limit);

        if (!$datainfo) {
            $datainfo = $this->statusNewQuery($table, "status=4", $limit);
            if (!$datainfo) {
                return false;
            }
        }

        return $datainfo;
    }

    // Library configration ->

    /** Excute queue query */
    private function statusQuery(String $table = null, int $status = null, $limit = 0)
    {
  

        if ($limit) {
            $datainfo = $this->db->select('*')->from($table)->where('status', $status)->limit($limit)->get()->result();
        } else {
            $datainfo = $this->db->select('*')->from($table)->where('status', $status)->get()->row();
        }

        return $datainfo;
    }

    /** Excute queue query */
    private function statusNewQuery(String $table = null, String $where = null, $limit = 0)
    {
   

        if ($limit) {
            $datainfo = $this->db->select('*')->from($table)->where($where)->limit($limit)->get()->result();
        } else {
            $datainfo = $this->db->select('*')->from($table)->where($where)->get()->row();
        }

        return $datainfo;
    }

    /** Convert json to array and merge extra array if exists */
    public function toJsonDecode(String $jsondata = null)
    {
        if (!empty($jsondata)) {
            return json_decode($jsondata);
        } else {
            return "";
        }
    }

    


    /** Execute node API */
    public function curlExcute(String $method = null, array $data = null)
    {
        $curl = curl_init();

        if(!empty($data)){ 
            if(!array_key_exists('netWork',$data))
                $data['netWork'] = 'bsc';
            $data = json_encode($data); 
        }

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->endpoints . $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }

    /** Convert array to object data */
    public function toObject(array $data = null)
    {
        return (object)$data;
    }

    private function errorResponse(String $msg = null,object $data = null)
    {
        return (object)['status'=>'error','msg'=>$msg,'data'=>$data];
    }

    private function successResponse(String $msg = null,object $data = null)
    {
        return (object)['status'=>'success','msg'=>$msg,'data'=>$data];
    }

    private function pendingResponse(String $msg = null,object $data = null)
    {
        return (object)['status'=>'pending','msg'=>$msg,'data'=>$data];
    }

    private function cancelResponse(String $msg = null)
    {
        return (object)['status'=>'cancel','msg'=>$msg];
    }

    public function wrongResponse(String $msg = null)
    {
        return (object)['status'=>'wrong','msg'=>$msg];
    }

    public function requiredResponse(String $msg = null,object $data = null)
    {
        return (object)['status'=>'required','msg'=>$msg,'data'=>$data];
    }
}