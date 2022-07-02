<?php namespace App\Modules\CMS\Controllers\Admin;

class Social_link extends BaseController {
 	
 
	public function index()
	{
            
        $data['title']  = display('social_link');
        
        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
        $data['social_link']     = $this->common_model->get_all('web_social_link', $pagewhere=array(),20,($page_number-1)*20,'id','DESC');
        $total              = $this->common_model->countRow('web_social_link');
        $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        echo view($this->BASE_VIEW . '\content_manager\social_list', $data);
		
	}
 

	public function form()
	{ 
		$data['title']        = display('Edit_Link');

        $id                   = $this->request->getVar('id',FILTER_SANITIZE_STRING);        
        $where                =  array('id' => $id);
        $data['social_link']  = $this->common_model->read('web_social_link',$where);

        echo view($this->BASE_VIEW.'\content_manager\social', $data);
		
	}
 
    public function social_update()
    { 
        $data['title']  = display('Edit_Link');

        $id                   = $this->request->getVar('id',FILTER_SANITIZE_STRING);

        //Set Rules From validation
        $this->validation->setRule('name', display('name'),'required|max_length[100]');
        $this->validation->setRule('link', display('link'),'required|max_length[100]');
        $this->validation->setRule('icon', display('icon'),'required|max_length[100]');
        
        $data['social_link']   = (object)$userdata = array(
            'id'            => $this->request->getVar('id',FILTER_SANITIZE_STRING),
            'name'          => $this->request->getVar('name',FILTER_SANITIZE_STRING),
            'link'          => $this->request->getVar('link',FILTER_SANITIZE_STRING), 
            'icon'          => $this->request->getVar('icon',FILTER_SANITIZE_STRING), 
            'status'        => $this->request->getVar('status',FILTER_SANITIZE_STRING)
        );

        //From Validation Check
        if ($this->validation->withRequest($this->request)->run()) 
        {
            $where = array( 
                'id'   => $id
            );
            if ($this->common_model->update('web_social_link', $where, $userdata)){
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
