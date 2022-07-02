<?php 
namespace App\Modules\CMS\Models\Admin;
class Category_model {
 
	public function single($cat_id = null)
	{
                $db      =  db_connect();
                $builder = $db->table("web_category");
		return $builder->select('*')
			->where('cat_id', $cat_id)
			->get()
			->getRow();
	}
	
}
