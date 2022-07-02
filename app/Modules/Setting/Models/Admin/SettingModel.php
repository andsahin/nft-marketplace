<?php  
namespace App\Modules\Setting\Models\Admin;

class SettingModel
{
	
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = \Config\Services::session();
    }

        public function languageList()
        { 
            if ($this->db->tableExists("language")) { 

                $fields = $this->db->getFieldData("language");

                $i = 1;
                foreach ($fields as $field)
                {  
                    if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
                }
                if (!empty($result)) 
                    return $result;
            } else {
                return false; 
            }
        }

        private $table = "setting";


	//new add 
	public function getMenuSingelRoleInfo($id="")
	{
            $role_id = $this->session->userdata('role_id');
            if($role_id!=0){
                $builder=$this->db('dbt_role_permission');
                return $builder->select('*')
                        ->where('role_id',$role_id)
                        ->where('sub_menu_id',$id)
                        ->get()
                        ->getrow();
            }else{
                return "";
            }
	}

   
}