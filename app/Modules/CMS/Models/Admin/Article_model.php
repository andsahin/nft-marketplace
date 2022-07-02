<?php 
namespace App\Modules\CMS\Models\Admin;
class Article_model  {
        
        public function __construct(){
            $this->db = db_connect();
            $this->session = \Config\Services::session();
        }

	public function single($article_id = null)
	{
            	
                $builder=$this->db->table("web_article");
		return $builder->select("*")
                        ->where('article_id', $article_id)
			->get()
			->getRow();
	}

	public function catidBySlug($slug=NULL)
        {
	
            $builder=$this->db->table("web_category");
            return  $builder->select("cat_id")
                        ->where('slug', $slug)
			->get()
			->getRow(); 
            
	}

	public function articleByCatid($id=NULLL){
            
            $builder = $this->db->table("web_article");
            return $builder->select("*")
                            ->where('cat_id', $id)
                            ->get()
                            ->getRow();
	}

}
