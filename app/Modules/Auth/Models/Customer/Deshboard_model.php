<?php

namespace App\Modules\Auth\Models\customer;

class Deshboard_model
{
	public function __construct()
	{
		$this->db = db_connect();
		$this->session = \Config\Services::session();
	}
	


	public function my_info()
	{
		$builder = $this->db->table('user');
		$user_id = $this->session->get('user_id');

		$my_info = $builder->select('user.*, user_wallet.wallet_address, user_account.balance, user_account.symbol')
			->join('user_wallet', 'user_wallet.user_id=user.user_id', 'left')
			->join('user_account', 'user_account.user_id=user.user_id', 'left')
			->where('user.user_id', $user_id)
			->get()
			->getRow();



		return array('my_info' => $my_info);
	}


	public function my_sales()
	{
		$user_id = $this->session->get('user_id');
		$builder = $this->db->table('user');

		$result1 = $builder->select("*")
			->where('sponsor_id', $user_id)
			->limit(5)
			->orderBy('created', 'DESC')
			->get()
			->getResult();
		return $result1;
	}


	public function my_payout()
	{
		$builder = $this->db->table('earnings');
		$user_id = $this->session->get('user_id');

		$result1 = $builder->select("*")
			->where('user_id', $user_id)
			->where('earning_type', 'type2')
			->limit(5)
			->orderBy('date', 'DESC')
			->get()
			->getResult();

		return $result1;
	}



	public function my_total_investment($user_id)
	{
		$builder = $this->db->table('investment');
		$result = $builder->select("sum(amount) as total_amount")
			->where('user_id', $user_id)
			->get()
			->getRow();
		return $result;
	}

	public function pending_withdraw()
	{
		$builder = $this->db->table('withdraw');
		$user_id = $this->session->get('user_id');
		return $builder->select("*")
			->where('status', 1)
			->where('user_id', $user_id)
			->limit(5)
			->orderBy('request_date', 'DESC')
			->get()
			->getResult();
	}

	public function my_level_information($user_id)
	{
		$builder = $this->db->table('team_bonus');
		return $builder->select('level')
			->where('user_id', $user_id)
			->get()
			->getRow();
	}
}