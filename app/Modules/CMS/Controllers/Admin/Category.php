<?php namespace App\Modules\CMS\Controllers\Admin;

class Category extends BaseController {
 		
 
	public function index()
	{  
             
       $data['title']        = display('cat_list');
       $data['web_language'] = $this->language_model->single('1');
		
       #-------------------------------#
        #pagination starts
       #-------------------------------#
        $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $data['category']   = $this->common_model->get_all('web_category', $pagewhere=array(),20,($page_number-1)*20,'cat_id','DESC');
        $total              = $this->common_model->countRow('web_category');
        $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        echo view($this->BASE_VIEW . '\category\list', $data);

    }

	
	public function form($cat_id = null)
	{ 
		$data['title']        = display('add_cat');	
		$data['web_language'] = $this->language_model->single('1');	

		//Set Rules From validation
		if (!empty($cat_id)){
            $this->validation->setRules(['cat_name_en' => "required|max_length[255]|cat_slug_check[$cat_id]"],['cat_name_en' => [ 'cat_slug_check' => 'The Category Name is already registered.']]);
        }else{
             $this->validation->setRule('cat_name_en', display('cat_name_en'),'required|is_unique[web_category.cat_name_en]|max_length[255]');
         }
		$slug = url_title(strip_tags($this->request->getVar('cat_name_en')), '-', FILTER_SANITIZE_STRING);

                //upload Image
                if($this->validation->withRequest($this->request)->run()){
                $img = $this->request->getFile('cat_image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/";
                    $old_image = $this->request->getVar('cat_image_old', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image,400,40);
                    }
                }
                
		$data['category']   = (object)$userdata = array(
			'cat_id'            => $this->request->getVar('cat_id', FILTER_SANITIZE_STRING),
			'slug'              => $slug,
			'cat_name_en'       => $this->request->getVar('cat_name_en', FILTER_SANITIZE_STRING),
			'cat_name_fr'       => $this->request->getVar('cat_name_fr', FILTER_SANITIZE_STRING), 
			'parent_id'         => $this->request->getVar('parent_id', FILTER_SANITIZE_STRING), 
			'cat_image'         => (!empty($image)?$image:$this->request->getVar('cat_image_old')),
			'cat_title1_en'     => $this->request->getVar('cat_title1_en', FILTER_SANITIZE_STRING),
			'cat_title1_fr'     => $this->request->getVar('cat_title1_fr', FILTER_SANITIZE_STRING),
			'cat_title2_en'     => $this->request->getVar('cat_title2_en', FILTER_SANITIZE_STRING),
			'cat_title2_fr'     => $this->request->getVar('cat_title2_fr', FILTER_SANITIZE_STRING),
			'menu'              => $this->request->getVar('menu', FILTER_SANITIZE_STRING),
			'position_serial'   => $this->request->getVar('position_serial', FILTER_SANITIZE_STRING),
			'status'            => $this->request->getVar('status', FILTER_SANITIZE_STRING)
		);
		
		//From Validation Check
		if ($this->validation->withRequest($this->request)->run()){

                    if (empty($cat_id)) 
                    {
                        if ($this->common_model->insert('web_category',$userdata)) {
                            $this->session->setFlashdata('message', display('save_successfully'));
                        } else {
                            $this->session->setFlashdata('exception', display('please_try_again'));
                        }
                        return  redirect()->to(base_url('backend/category/info'));     
                    }else{
                        $where = array( 
                            'cat_id'   => $cat_id
                        );
                        if ($this->common_model->update('web_category',$where,$userdata)) {
                                $this->session->setFlashdata('message', display('update_successfully'));
                        } else {
                                $this->session->setFlashdata('exception', display('please_try_again'));
                        }
                        return  redirect()->to(base_url('backend/category/info/'.$cat_id));
                    }
		}else{ 
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                        return  redirect()->to(base_url('backend/category/info/'.$cat_id));

                    }
                    $data['parent_cat']     = $this->common_model->get_all('web_category',$newhere=array(),null,null,'cat_id','DESC');
                    if(!empty($cat_id)){
                        $data['title']      = display('edit_cat');
                        $data['category']   = $this->category_model->single($cat_id);
                    }
		}
        $data['content'] = $this->BASE_VIEW . '\category\form';
        return $this->template->admin_layout($data);

	}

    
    public function cat_update($cat_id = null)
    { 
        $data['title']        = display('add_cat'); 
        $data['web_language'] = $this->language_model->single('1'); 

        //Set Rules From validation
        if (!empty($cat_id)){
            $this->validation->setRules(['cat_name_en' => "required|max_length[255]|cat_slug_check[$cat_id]"],['cat_name_en' => [ 'cat_slug_check' => 'The Category Name is already registered.']]);
        }else{
             $this->validation->setRule('cat_name_en', display('cat_name_en'),'required|is_unique[web_category.cat_name_en]|max_length[255]');
         }
        $slug = url_title(strip_tags($this->request->getVar('cat_name_en')), '-', FILTER_SANITIZE_STRING);

                //upload Image
                if($this->validation->withRequest($this->request)->run()){
                $img = $this->request->getFile('cat_image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/";
                    $old_image = $this->request->getVar('cat_image_old', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image,400,40);
                    }
                }
                
        $data['category']   = (object)$userdata = array(
            'cat_id'            => $this->request->getVar('cat_id', FILTER_SANITIZE_STRING),
            'slug'              => $slug,
            'cat_name_en'       => $this->request->getVar('cat_name_en', FILTER_SANITIZE_STRING),
            'cat_name_fr'       => $this->request->getVar('cat_name_fr', FILTER_SANITIZE_STRING), 
            'parent_id'         => $this->request->getVar('parent_id', FILTER_SANITIZE_STRING), 
            'cat_image'         => (!empty($image)?$image:$this->request->getVar('cat_image_old')),
            'cat_title1_en'     => $this->request->getVar('cat_title1_en', FILTER_SANITIZE_STRING),
            'cat_title1_fr'     => $this->request->getVar('cat_title1_fr', FILTER_SANITIZE_STRING),
            'cat_title2_en'     => $this->request->getVar('cat_title2_en', FILTER_SANITIZE_STRING),
            'cat_title2_fr'     => $this->request->getVar('cat_title2_fr', FILTER_SANITIZE_STRING),
            'menu'              => $this->request->getVar('menu', FILTER_SANITIZE_STRING),
            'position_serial'   => $this->request->getVar('position_serial', FILTER_SANITIZE_STRING),
            'status'            => $this->request->getVar('status', FILTER_SANITIZE_STRING)
        );
        
        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()){

            if (empty($cat_id)) 
            {
                if ($this->common_model->insert('web_category',$userdata)) {
                    $this->session->setFlashdata('message', display('save_successfully'));
                } else {
                    $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/category/info'));     
            }else{
                $where = array( 
                    'cat_id'   => $cat_id
                );
                if ($this->common_model->update('web_category',$where,$userdata)) {
                        $this->session->setFlashdata('message', display('update_successfully'));
                } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                }
                return  redirect()->to(base_url('backend/category/info/'.$cat_id));
            }
        }

    }

}
