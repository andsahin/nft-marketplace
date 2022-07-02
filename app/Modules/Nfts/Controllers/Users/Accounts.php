<?php 
namespace App\Modules\Nfts\Controllers\Users;
class Accounts extends BaseController 
{
	function __construct()
    {
        $this->network = BNETWORK;
        $this->currency = SYMBOL;
    }

	public function getBalance()
	{
		$myWallet 		= $this->common_model->where_row('user_wallet', ['user_id'=>$this->user_id])->wallet_address; 
		$myAc 			= $this->common_model->where_row('user_account', ['user_id'=>$this->user_id]); 
		$balanceRes 	= $this->blockchain->baseCoinBalance($myWallet, $this->network);

		$balance = $myAc->balance;
		if(isset($balanceRes->status)){
			if($balanceRes->status == 'success'){
				$balance = $balanceRes->data->balance;
			}
		}

		$acData = array( 
			'balance' => $balance, 
		);

		$result = $this->common_model->update('user_account', ['user_id'=>$this->user_id], $acData);

		if($result){
			echo json_encode(['status'=>'success', 'balance'=> $balanceRes->data->balance]);
		}else{
			echo json_encode(['status'=>'err']);
		}
	}


}