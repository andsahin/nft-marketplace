<?php 
namespace App\Modules\CMS\Models\Admin;
class News_model  {
 
	public function single($article_id = null)
	{
            
                $db     =  db_connect();
                $builder=$db->table("web_news");
                return $builder->select("*")
                        ->where('article_id', $article_id)
                        ->get()
                        ->getRow();

	}


        public function parent_cat($where=array())
        {
            $db=  db_connect();
            $builder=$db->table("web_category");
            return     $builder->select("cat_id")
			->where($where)
			->get()
			->getRow();
        }
        public function child_cat($where=array())
        {
            $db=  db_connect();
            $builder=$db->table("web_category");
            return     $builder->select("*")
			->where($where)
			->get()
			->getResult();

        }
}
