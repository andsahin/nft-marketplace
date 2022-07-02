<?php 
namespace App\Modules\Setting\Controllers\Admin;
class Setting extends BaseController {
	public function index()
    {
        $data['title'] = display('application_setting');
        $this->check_setting();
                //check validation
                $this->validation->setRule('title', display('website_title'),'required|max_length[50]');
                $this->validation->setRule('description', display('address'),'max_length[255]');
                $this->validation->setRule('email', display('email'),'max_length[100]|valid_email');
                $this->validation->setRule('phone', display('phone'),'max_length[20]');
                $this->validation->setRule('language', display('language'),'max_length[250]');
                $this->validation->setRule('footer_text', display('footer_text'),'max_length[255]');
                $this->validation->setRule('time_zone', display('time_zone'),'required|max_length[100]');
                $this->validation->setRule('logo', display('logo'), 'ext_in[logo,png,jpg,gif,ico]|is_image[logo]');
                $this->validation->setRule('logo_web', display('logo_web'), 'ext_in[logo_web,png,jpg,gif,ico]|is_image[logo_web]');
                $this->validation->setRule('favicon', display('favicon'), 'ext_in[favicon,png,jpg,gif,ico]|is_image[favicon]');
                $this->validation->setRule('header_bg_img', display('Header_Background_Img'), 'ext_in[header_bg_img,png,jpg]|is_image[header_bg_img]');
                $this->validation->setRule('footer_bg_img', display('Footer_Background_Img'), 'ext_in[footer_bg_img,png,jpg]|is_image[footer_bg_img]');


        if ($this->validation->withRequest($this->request)->run()){
                    //logo upload
                    $imglogo        = $this->request->getFile('logo',FILTER_SANITIZE_STRING);
                    $savepath_logo  ="public/uploads/settings/";
                    $old_logo       = $this->request->getVar('old_logo', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $logo       =   $this->imagelibrary->image($imglogo,$savepath_logo,$old_logo,184,42);
                    }

                    //Web logo_web upload
                    $imglogo_web        = $this->request->getFile('logo_web',FILTER_SANITIZE_STRING);
                    $savepath_logo_web  ="public/uploads/settings/";
                    $old_logo_web       = $this->request->getVar('old_web_logo', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $logo_web       =   $this->imagelibrary->image($imglogo_web,$savepath_logo_web,$old_logo_web,163,50);
                    }

                    //favicon upload
                    $img = $this->request->getFile('favicon',FILTER_SANITIZE_STRING);
                    $savepath   ="public/uploads/dashboard/";
                    $old_image  = $this->request->getVar('old_favicon', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $favicon=$this->imagelibrary->image($img,$savepath,$old_image,32,32);
                    }


                    //header bg image upload
                    $header_img = $this->request->getFile('header_bg_img',FILTER_SANITIZE_STRING);
                    $header_savepath   ="public/uploads/settings/";
                    $old_header_bg_image  = $this->request->getVar('old_header_bg_img', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $header_bg_img=$this->imagelibrary->image($header_img,$header_savepath,$old_header_bg_image,1968,462);
                    }
  

                    //footer bg image upload
                    $footer_img = $this->request->getFile('footer_bg_img',FILTER_SANITIZE_STRING);
                    $footer_savepath   ="public/uploads/settings/";
                    $old_footer_bg_img  = $this->request->getVar('old_footer_bg_img', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){
                        $footer_bg_img=$this->imagelibrary->image($footer_img,$footer_savepath,$old_footer_bg_img,1920,900);
                    }

                    $data['setting'] = (object)$postData = [
                            'setting_id'  => $this->request->getVar('setting_id',FILTER_SANITIZE_STRING),
                            'title'       => $this->request->getVar('title',FILTER_SANITIZE_STRING),
                            'description' => $this->request->getVar('description',FILTER_SANITIZE_STRING),
                            'email'       => $this->request->getVar('email',FILTER_SANITIZE_STRING),
                            'phone'       => $this->request->getVar('phone',FILTER_SANITIZE_STRING),
                            'logo'    => (!empty($logo)?$logo:$this->request->getVar('old_logo',FILTER_SANITIZE_STRING)),
                            'logo_web'    => (!empty($logo_web)?$logo_web:$this->request->getVar('old_web_logo',FILTER_SANITIZE_STRING)),

                            'favicon'     => (!empty($favicon)?$favicon:$this->request->getVar('old_favicon',FILTER_SANITIZE_STRING)),
                            'header_bg_img'=> (!empty($header_bg_img)?$header_bg_img:$this->request->getVar('old_header_bg_img',FILTER_SANITIZE_STRING)),
                            'footer_bg_img' => (!empty($footer_bg_img)?$footer_bg_img:$this->request->getVar('old_footer_bg_img',FILTER_SANITIZE_STRING)),

                            'language'    => $this->request->getVar('language',FILTER_SANITIZE_STRING), 
                            'time_zone'   => $this->request->getVar('time_zone',FILTER_SANITIZE_STRING), 
                            'site_align'  => $this->request->getVar('site_align',FILTER_SANITIZE_STRING), 
                            'office_time' => $this->request->getVar('office_time',FILTER_SANITIZE_STRING), 
                            'latitude'    => $this->request->getVar('latitude',FILTER_SANITIZE_STRING), 
                            'footer_text' => $this->request->getPost('footer_text',FILTER_SANITIZE_STRING),
                    ]; 

  
                    if (empty($postData['setting_id'])) {
                        if ($this->common_model->insert('setting',$postData)) {
                                #set success message
                                $this->session->setFlashdata('message',display('save_successfully'));
                        } else {
                                #set exception message
                                $this->session->setFlashdata('exception',display('please_try_again'));
                        }
                    }else{
                        $where= array(
                            'setting_id'=>$this->request->getVar('setting_id')
                        );
                        if ($this->common_model->update('setting',$where,$postData)){
                                #set success message
                                $this->session->setFlashdata('message',display('update_successfully'));
                        } else {
                                #set exception message
                                $this->session->setFlashdata('exception', display('please_try_again'));
                        } 
                    } 
                    return  redirect()->to(base_url('backend/setting/app_setting'));
        }else{ 
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                        return  redirect()->to(base_url('backend/setting/app_setting'));
                    }
                    $data['languageList'] = $this->languageList(); 
                    $data['setting'] = $this->common_model->read('setting');
                    $data['content'] = $this->BASE_VIEW . '\setting';
                    return $this->template->admin_layout($data);
        } 
    }
        
        #----------------------------
        #Fees Setting form view
        #----------------------------
          

    public function fees_setting()
    {
            $data['title'] = display('fees_setting');
            $data['fees_data']= $this->common_model->get_all('fees_tbl',$where=array(),0,0,'id','asc');
            $data['content'] = $this->BASE_VIEW . '\fees_setting';
            return $this->template->admin_layout($data);
    }
      
        #---------------------
        #Fees Setting save
        #---------------------

    public function fees_setting_save()
    {
            $where = array( 
                'level'  => $this->request->getvar('level')
            );
            $check=$this->common_model->countRow('fees_tbl',$where);
            if($check>0){
                $this->session->setFlashdata('exception','This Level Already Exist!');
                return  redirect()->to(base_url('backend/setting/fees_setting'));
             }else{
                $fees = array(
                    'level' =>$this->request->getVar('level'),
                    'fees'  =>$this->request->getVar('fees')
                );
                $this->common_model->insert('fees_tbl',$fees);
                $this->session->setFlashdata('message',display('fees_setting_successfully'));
                return  redirect()->to(base_url('backend/setting/fees_setting'));
             }
    }
               
        #----------------------------
        #Delete Fees Setting 
        #----------------------------
        
    public function delete_fees_setting($id=NULL)
    {
            $where=array(
              'id'  =>   $id
            );
            if ($this->common_model->deleteRow('fees_tbl',$where) ){
                $this->session->setFlashdata('message', display('delete_successfully'));
            } else {
                $this->session->setFlashdata('exception', display('please_try_again'));
            }
            return  redirect()->to(base_url('backend/setting/fees_setting'));
    }
        
    //check setting table row if not exists then insert a row
    public function check_setting()
    {
            if ($this->db->table('setting')->countAll() == 0) {
                $this->db->insert('setting',[
                    'title' => 'bdtask Treading System',
                    'description' => '123/A, Street, State-12345, Demo',
                    'time_zone' => 'Asia/Dhaka',
                    'footer_text' => '2018&copy;Copyright',
                ]);
            }
    }

       

        public function languageList()
        { 
            if ($this->db->tableExists("language")) { 

                    $fields = $this->db->getFieldData("language");

                    $result = array();
                    $i = 1;
                    foreach ($fields as $field)
                    {  
                        if ($i++ > 2)
                            if($field->name == 'english'){
                                 $result[$field->name] = ucfirst($field->name);
                            } 
                    }
                    if (!empty($result)) 
                        return $result;
            } else {
                return false;
            }
        }

 
      
        #----------------------------
        #Email Gateway View
        #----------------------------
        public function email_gateway()
    {
            $data['title'] = "Email Gateway";
            $where=array(
                'es_id' => 2
            );
            $data['email']=$this->common_model->read('email_sms_gateway',$where);
            $data['userrole'] = $this->setting_model->getMenuSingelRoleInfo(30);

            $data['content'] = $this->BASE_VIEW . '\email_gateway';
            return $this->template->admin_layout($data);
    }
        #----------------------------
        #Update Email Gateway 
        #----------------------------
        public function update_email_gateway()
        {

                $this->validation->setRule('email_password', display('email_password'),'required');
                $this->validation->setRule('email_title', display('email_title'),'required');
                $this->validation->setRule('email_protocol', display('email_protocol'),'required');
                $this->validation->setRule('email_host', display('email_host'),"required|max_length[50]");
                $this->validation->setRule('email_user', display('email_user'),'required|valid_email');
                $this->validation->setRule('email_mailtype', display('email_mailtype'),'required');
                $this->validation->setRule('email_charset', display('email_charset'),'required');
                
                if($this->validation->withRequest($this->request)->run()){
                    $email = $this->request->getVar('es_id',FILTER_SANITIZE_EMAIL);
                $pass = '';
                $builder=$this->db->table("email_sms_gateway");
                $password = $builder->select('password')->where('es_id', 2)->get()->getRow();

                if($password->password == base64_decode($this->request->getVar('email_password',FILTER_SANITIZE_STRING))){
                    $pass = $password->password;
                }else{
                    $pass = $this->request->getVar('email_password',FILTER_SANITIZE_STRING);
                }
                $data = array(
                        'title'     =>$this->request->getVar('email_title',FILTER_SANITIZE_STRING),
                        'protocol'  =>$this->request->getVar('email_protocol',FILTER_SANITIZE_STRING),
                        'host'          =>$this->request->getVar('email_host',FILTER_SANITIZE_STRING),
                        'port'          =>$this->request->getVar('email_port',FILTER_SANITIZE_STRING),
                        'user'          =>$this->request->getVar('email_user',FILTER_SANITIZE_STRING),
                        'password'  =>$pass,
                        'mailtype'  =>$this->request->getVar('email_mailtype',FILTER_SANITIZE_STRING),
                        'charset'   =>$this->request->getVar('email_charset',FILTER_SANITIZE_STRING)
                );
                $where=array(
                    'es_id' => $email
                );
                $this->common_model->update('email_sms_gateway',$where,$data); 
                $this->session->setFlashdata('message',display('update_successfully'));
                }else {
                    $error=$this->validation->listErrors();
                    if($this->request->getMethod() == "post"){
                        $this->session->setFlashdata('exception', $error);
                    }
            }
               return  redirect()->to(base_url('backend/setting/email_gateway'));
        }
        
        #--------------
        #Testing Email
        #-------------
        public function test_email()
    {
                $this->validation->setRule('email_to', display('email'),'required|valid_email');
                $this->validation->setRule('email_sub', display('Subject'),'required|max_length[100]');
        $this->validation->setRule('email_message', display('Message'),'required|max_length[100]');
                
        if($this->validation->withRequest($this->request)->run()){

                    $post = array(
                    'title'             => "Test Email Gateway",
                    'subject'           => $this->request->getVar('email_sub'),
                    'to'                => $this->request->getVar('email_to'),
                    'message'           => $this->request->getVar('email_message'),
                    );

                    if($this->common_model->send_email($post)){
                        $this->session->setFlashdata('message','Email Send Successfully!');
                    }else{
                        $this->session->setFlashdata('exception',"Email not configured in server.");
                    }
                }else{
                    $this->session->setFlashdata('exception',validation_errors());
        }
                return  redirect()->to(base_url('backend/setting/email_gateway'));
    }
        
    #--------------------------------------
    #SMS and Email Template lIST/view Code
    #--------------------------------------
    public function sms_email_template($value='')
    {
        $data['title'] = "Email/SMS template";
       
        #-------------------------------#
        #pagination starts
        #-------------------------------#
         $page               = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number        = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $data['template']   = $this->common_model->get_all('dbt_sms_email_template', $pagewhere=array(),20,($page_number-1)*20,'id','asc');
         $total              = $this->common_model->countRow('dbt_sms_email_template');
         $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------  
         
         $data['content'] = $this->BASE_VIEW . '\email_sms_template_list';
         return $this->template->admin_layout($data);
    }
    
    #--------------------------------------
    #SMS and Email Template Update Code
    #--------------------------------------
    public function sms_email_template_form($id='')
    {
            $data['title'] = "Email Template";
            $where=array(
                'id'    =>$id
            );
            $typecheck=$this->common_model->read('dbt_sms_email_template',$where);
            if($typecheck->sms_or_email != 'sms'){
                $this->validation->setRule('subject_en', display('Template title/subject'),'required|max_length[255]');
            }
            $this->validation->setRule('template_en', display('Template'),'required');
             
            
            $data['template']   = (object)$userdata = array(
                'id'        => $this->request->getVar('id',FILTER_SANITIZE_STRING),
                'subject_en'     => $this->request->getVar('subject_en',FILTER_SANITIZE_STRING), 
                'template_en'    => $this->request->getVar('template_en',FILTER_SANITIZE_STRING)
            );

      //From Validation Check
        if ($this->validation->withRequest($this->request)->run()){
          
            $where=array(
                'id'  => $userdata["id"]
            );
            $update_tmp = $this->common_model->update('dbt_sms_email_template',$where,$userdata);
            if ($update_tmp) {
                 $this->session->setFlashdata('message', display('update_successfully'));
            } else {
                 $this->session->setFlashdata('exception', display('please_try_again'));
            }
            return  redirect()->to(base_url('backend/setting/smsemail_templateform/'.$id));
        }else {
            $error=$this->validation->listErrors();
            if($this->request->getMethod() == "post"){
                $this->session->setFlashdata('exception', $error);
                return  redirect()->to(base_url('backend/setting/smsemail_templateform/'.$id));
            }
            if(!empty($id)) {
               $data['template']   = $this->common_model->read('dbt_sms_email_template',$where);
            }
        }

         $data['content'] = $this->BASE_VIEW . '\email_sms_template_form';
         return $this->template->admin_layout($data);
  
    }

    public function api_list()
    {
        $data['title']  = display('external_api_setup');

        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
         $data['apis'] = $this->common_model->get_all('external_api_setup', $pagewhere=array(),20,($page_number-1)*20,'id','asc');
         $total           = $this->common_model->countRow('external_api_setup',$pagewhere);
         $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------
         $data['content'] = $this->BASE_VIEW . '\external_api\list';
         return $this->template->admin_layout($data);
    }
 
    public function api_form($id = null)
    { 
        $data['title']  = display('add_payment_gateway');

        //SET VALIDATION    
                $this->validation->setRule('name', display('name'),'required|max_length[50]|alpha_numeric_punct');
                $this->validation->setRule('api_key', display('API'),'required|max_length[100]|alpha_numeric_punct');
        
        //SET API DATA
        $data['apis']   = (object)$userdata = array(
            'id'        => $this->request->getVar('id',FILTER_SANITIZE_STRING),
            'name'      => $this->request->getVar('name',FILTER_SANITIZE_STRING),
            'data'      => json_encode(array( 'api_key'=> $this->request->getVar('api_key',FILTER_SANITIZE_STRING))),
            'status'    => $this->request->getVar('status',FILTER_SANITIZE_STRING)
        );

        //CHECK VALIDATION
        if ($this->validation->withRequest($this->request)->run()) 
        {
                        $where=array(
                            'id' => $id
                        );
                        $dataupdate=$this->common_model->update('external_api_setup',$where,$userdata);
            

            if ($dataupdate) {
                $this->session->setFlashdata('message', display('update_successfully'));
            } else {
                $this->session->setFlashdata('exception', display('please_try_again'));
            }
                        return  redirect()->to(base_url('backend/externalapi/external_api_setup/'.$id));
            
        }else{
                        $error=$this->validation->listErrors();
                        if($this->request->getMethod() == "post"){
                            $this->session->setFlashdata('exception', $error);
                        }
            if(!empty($id)) {
                $data['title'] = 'Edit API';
                                $pagewhere=array(
                                    'id' => $id
                                );
                $data['apis']  = $this->common_model->read('external_api_setup',$pagewhere);
                        }           
        }
        $data['content'] = $this->BASE_VIEW . '\external_api\form';
         return $this->template->admin_layout($data);  
    }
    
         
    
}
