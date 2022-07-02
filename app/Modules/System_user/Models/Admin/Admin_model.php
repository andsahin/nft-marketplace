<?php namespace App\Modules\System_user\Models\Admin;

class Admin_model  {
        public function __construct()
        {
            $this->db = db_connect();
        }
	public function read()
	{
            
            $admin= $this->db->table('admin');
            return $admin->select("admin.*, 
				CONCAT(' ', firstname, lastname) AS fullname ")
			->orderBy('id', 'desc')
                        ->limit(20)
			->get()
			->getResult();
	}

	public function single($id = null)
	{
          
            $builder=$this->db->table('admin');
            return $builder->select('*')
                    ->where('id', $id)
                    ->get()
                    ->getRow();
	}
    private $table = "admin"; 
public function profile($id = null)
    {
                $builder = $this->db->table('admin');
        return $builder->select("
                admin.*, 
                CONCAT_WS(' ', firstname, lastname) AS fullname, 
                IF (dbt_admin.is_admin=1, 'Admin', 'User') as user_level")
                                ->where('id', $id)
                                ->get()
                                ->getRow();
    } 

    public function update_profile($data = array())
    {
            $builder=$this->db->table('admin');
                return $builder->where('id', $data['id'])
                               ->update($data);
    }

}
