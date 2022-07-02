<?php namespace App\Modules\Nfts\Models\Admin;

class Nfts_model  {
    
    public function __construct(){
        $this->db = db_connect();
        $this->request = \Config\Services::request();

    }

    public function create($data = array())
	{
            return $this->db->insert('user', $data);
	}

	function get_datatables($table,$column_order=array(),$column_search=array(),$order,$where=array())
	{ 
  		
        $builder = $this->db->table($table);
		
		$i = 0;

		foreach ($column_search as $item)
		{
             
            if(!empty($_POST)){   
				if($_POST['search']['value']) 
				{
	                            
	                                
					if($i===0) 
					{
						$builder->groupStart(); 
						$builder->like($item, $_POST['search']['value']);
					}
					else
					{
						$builder->orLike($item, $_POST['search']['value']);
					}

					if(count($column_search) - 1 == $i) 
						$builder->groupEnd(); 
				}
			}
			$i++;
		}
		
		$builder->select($table.'.*, user.f_name, user.l_name, nft_category.cat_name, nft_collection.title as collection_title');
		 
		$builder->join('user', 'user.user_id=nfts_store.user_id', 'left');
        $builder->join('nft_category', 'nft_category.id=nfts_store.category_id', 'left');
        $builder->join('nft_collection', 'nft_collection.id=nfts_store.collection_id', 'left'); 
		 
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


	public function count_all($table,$where=array())
	{

        $db      = db_connect();
        $builder = $db->table($table);
		$builder->where($where);
		return $builder->countAllResults();
			
	}

	function count_filtered($table,$column_order=array(),$column_search=array(),$order,$where=array())
	{
        $this->get_datatables($table,$column_order,$column_search,$order);
        $db      = db_connect();
        $builder = $db->table($table);
		$builder->where($where);
		return $builder->countAllResults();
	}


}