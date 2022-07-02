<?php namespace App\Modules\CMS\Models\Admin;

class Language_model {
 
	public function single($id = null){
        $db=  db_connect();
        $builder=$db->table("web_language");
		return $builder->select("*")
                                ->where('id', $id)
                                ->get()
                                ->getRow();	
	}

	public function update($data = array())
	{
        $db=  db_connect();
       
		return $db->where('id', $data["id"])
			->update("web_language", $data);
	}

	
}
