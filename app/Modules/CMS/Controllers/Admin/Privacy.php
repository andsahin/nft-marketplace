<?php 
namespace App\Modules\CMS\Controllers\Admin;

class Privacy extends BaseController {
 	

    public function index()
    {  
        $data['title']  = display('privacy');

        $slug3          = 'privacy';
        $cat_id         = $this->article_model->catidBySlug($slug3)->cat_id;
    
        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page            = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number     = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $pagewhere       = array('cat_id'  => $cat_id);

        $data['article'] = $this->common_model->get_all('web_article', $pagewhere,20,($page_number-1)*20,'article_id','DESC');
        $total           = $this->common_model->countRow('web_article',$pagewhere);
        $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        echo view($this->BASE_VIEW . '\content_manager\privacy_list', $data);
            
    }

	public function form()
	{  
        $data['title']        = display('Edit_Privacy');

        $slug3                = 'privacy';
        $cat_id               = $this->article_model->catidBySlug($slug3)->cat_id;
        $article_id           = $this->article_model->articleByCatid($cat_id)->article_id;
        $data['article']      = $this->article_model->single($article_id);

        echo view($this->BASE_VIEW.'\content_manager\privacy', $data);
	}

    public function privacy_update()
    {  
        $data['title']        = display('Edit_Privacy');
        
        $slug3                = 'privacy';
        $cat_id               = $this->article_model->catidBySlug($slug3)->cat_id;
        $article_id           = $this->article_model->articleByCatid($cat_id)->article_id;
        
        //Set Rules From validation
        $this->validation->setRule('headline_en', display('headline_en'), 'required|max_length[255]');
        $data['article']   = (object)$userdata = array(
                'article_id'         => $this->request->getVar('article_id',FILTER_SANITIZE_STRING),
                'headline_en'        => $this->request->getVar('headline_en',FILTER_SANITIZE_STRING), 
                'article2_en'        => str_replace(array("<script>", "</script>"),"[]",$this->request->getVar('article2_en')),
                'cat_id'             => $cat_id,
                'publish_date'       => date("Y-m-d h:i:s"),
                'publish_by'         => $this->session->userdata('email',FILTER_SANITIZE_EMAIL)
        );
        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()){
            $where = array( 
                'article_id'   => $article_id
             );
            if ($this->common_model->update('web_article', $where, $userdata)){
                $data['validation']['message'] = display('update_successfully');
                echo json_encode($data['validation'], true);
                exit;
            }else{
                $data['validation']['exception'] = display('please_try_again');
                echo json_encode($data['validation'], true);
                exit;
            }
        }

        $data['validation']['filter'] = $this->validation->getErrors();
        echo json_encode($data['validation'], true);
        exit;
        
    }

}
