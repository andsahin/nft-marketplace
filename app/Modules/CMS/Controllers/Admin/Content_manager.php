<?php namespace App\Modules\CMS\Controllers\Admin;

class Content_manager extends BaseController {
 	
	public function index()
	{
        $data['title']      = display('content_list');
        
        

        $data['content']    = $this->BASE_VIEW . '\content_manager\all_content_manager';
        return $this->template->admin_layout($data);
	}

}
