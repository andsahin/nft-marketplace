<?php

namespace App\Modules\Finance\Models\Customer;

class Finance_model
{
	public function __construct()
	{
		$this->db = db_connect();
		$this->session = \Config\Services::session();
		$this->request 		 = \Config\Services::request();
	}

		/*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    
	function get_datatables($table,$column_order=array(),$column_search=array(),$order,$where=array(),$join=null,$secondtable=null)
	{ 
  	 

        $builder = $this->db->table($table);
		
		$i = 0;
		foreach ($column_search as $item) // loop column 
		{
                    
			if($_POST['search']['value']) // if datatable send POST for search
			{
                            
                                
				if($i===0) // first loop
				{
					$builder->groupStart(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$builder->like($item, $_POST['search']['value']);
				}
				else
				{
					$builder->orLike($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i) //last loop
					$builder->groupEnd(); //close bracket
			}
			$i++;
		}
		if($join != null){
			$builder->select('*');
			$builder->join($secondtable,$join,'left');
		}
		if($where != null) // here order processing
		{
			$builder->where($where);
		}

		if(isset($_POST['order'])) // here order processing
		{
			$builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($order))
		{
			$order = $order;
			$builder->orderBy(key($order), $order[key($order)]);
		}
		if($this->request->getvar('length') != -1)
		$builder->limit($this->request->getvar('length'), $this->request->getvar('start'));
		$query = $builder->get();
		return $query->getResult();
	}

	function count_filtered($table,$column_order=array(),$column_search=array(),$order,$where=array())
	{
            $this->get_datatables($table,$column_order,$column_search,$order);
            $db      = db_connect();
            $builder = $db->table($table);
			$builder->where($where);
			return $builder->countAllResults();
	}

	public function count_all($table,$where=array())
	{

            $db      = db_connect();
            $builder = $db->table($table);
			$builder->where($where);
			return $builder->countAllResults();
			
	}
	
	

	public function getFees($table,$id)
	{
                $builder=$this->db->table("$table");
		return $builder ->select('*')
                                ->where($table.'_id',$id)
                                ->get()
                                ->getrow();
	}

	 public function save_transfer_verify($data)
	{
            $builder=$this->db->table('verify_tbl');
                    $builder->insert($data);
                    return array('id'=>$this->db->insertId());
	}
	public function get_verify_data($id)
	{
                $builder = $this->db->table('verify_tbl');
		$v = $builder->select('*')
		->where('id',$id)
		->where('session_id', $this->session->userdata('isLogIn'))
		->where('ip_address', $this->request->getIPAddress())
		->get()
		->getRow();

		return $v;
	}
	public function get_withdraw_by_id($id)
	{
                $builder = $this->db->table('withdraw');
		return $builder->select('*')
		->where('withdraw_id',$id)
		->where('user_id',$this->session->userdata('user_id'))
		->get()->getRow();
	}
	public function withdraw($data)
	{
                $builder=$this->db->table('withdraw');
                $builder->insert($data);
		return array('withdraw_id'=>$this->db->insertId());
	}
}