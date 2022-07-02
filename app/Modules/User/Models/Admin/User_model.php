<?php namespace App\Modules\User\Models\Admin;

class User_model  {
    
    public function __construct(){
        $this->db = db_connect();
        $this->request = \Config\Services::request();

    }
    
 
	public function create($data = array())
	{
            return $this->db->insert('user', $data);
	}

	public function read($limit, $offset)
	{
             $db      = db_connect();
             return $db->query("select (CONCAT(' ', f_name, l_name) AS fullname) from user")->getResult();
	}

	public function single($uid = null)
	{

		
            $db=  db_connect();
            $builder=$db->table('user');
            return $builder->select('*')
                    ->where('uid', $uid)
                    ->get()
                    ->getRow();
	}

	public function update($data = array())
	{
		return $this->db->where('user_id', $data["user_id"])
			->update("user", $data);
	}

	public function delete($user_id = null)
	{
		return $this->db->where('user_id', $user_id)
			->delete("user");
	}

	public function dropdown()
	{
		$data = $this->db->select("user_id, CONCAT_WS(' ', f_name, l_name) AS fullname")
			->from("user")
			->where('status', 1)
			->get()
			->result();
		$list[''] = lan('select_option');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->fullname;
			return $list;
		} else {
			return false; 
		}
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
                $builder = $this->db->table($table);
		return $builder->select('*')
                                ->where($table.'_id',$id)
                                ->get()
                                ->getRow();
	}

	
	
}
