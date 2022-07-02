<?php 
namespace App\Modules\System_user\Controllers\Admin;
helper('text');
class Admin extends BaseController {
 	
 	
 
	public function index()
	{  
             
            $uri = service('uri','<?php echo base_url(); ?>');
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
            $data['admin'] = $this->admin_model->read();
            $total           = $this->common_model->countRow('admin');
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
	
            $data['title']      = display('admin_list');

            $data['content'] = $this->BASE_VIEW . '\admin\list';
            return $this->template->admin_layout($data);
	}
 
	public function form($id = null)
	{ 
            
		  $data['title']    = display('add_admin');
		
            //Check Validation
            $this->validation->setRule('firstname', display('firstname'), 'required|max_length[50]');
            $this->validation->setRule('lastname', display('lastname'), 'required|max_length[50]'); 
            $this->validation->setRule('about', display('about'), 'max_length[1000]');
            $this->validation->setRule('status', display('status'), 'required|max_length[1]');
            $this->validation->setRule('image', display('image'), 'ext_in[image,png,jpg,gif,ico]');

            if(isset($_POST['add'])){ 

                $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');

                $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');
            } else {

                if($this->request->getVar('password',FILTER_SANITIZE_STRING)){

                    $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');
    
                    $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');
    
                }

            }

            
		
		    if (!empty($id)){

            $this->validation->setRules(['email' =>"required|valid_email|max_length[100]|admin_email_check[$id]|trim"],['email' => [ 'admin_email_check' => 'The email is already registered.']]);

            }else{

            $this->validation->setRule('email', display('email'), 'required|valid_email|is_unique[admin.email]|max_length[100]');
            }
                //upload Image
            if($this->validation->withRequest($this->request)->run()){
                    $img = $this->request->getFile('image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/dashboard/new/";
                    $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING);

                    if($this->request->getMethod() == "post" && isset($img)){
                        $image=$this->imagelibrary->image($img,$savepath,$old_image,51,80);
                    }
            }
                    
            $data['admin'] = (object)$adminLevelData = array(
                'id' 		  => $this->request->getVar('id',FILTER_SANITIZE_STRING),
    			'firstname'       => $this->request->getVar('firstname',FILTER_SANITIZE_STRING),
    			'lastname' 	  => $this->request->getVar('lastname',FILTER_SANITIZE_STRING),
    			'email' 	  => $this->request->getVar('email',FILTER_SANITIZE_STRING), 
    			'about' 	  => $this->request->getVar('about',FILTER_SANITIZE_STRING),
    			'image'   	  => (!empty($image)?$image:$this->request->getVar('old_image',FILTER_SANITIZE_STRING)),
                 'last_login'      => null,
    			'last_logout'     => null,
    			'ip_address'      => null,
    			'status'          => $this->request->getVar('status',FILTER_SANITIZE_STRING),
    			'is_admin'        => 2
    		);
            if($this->request->getVar('password',FILTER_SANITIZE_STRING)){
                $adminLevelData['password'] = md5($this->request->getVar('password',FILTER_SANITIZE_STRING));
            }

		    if($this->validation->withRequest($this->request)->run()){ 
                
                
                if (empty($adminLevelData['id'])){
                    if ($this->common_model->insert('admin',$adminLevelData)){
                            $this->session->setFlashdata('message', display('save_successfully'));
                    } else{
                            $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/account/admin_information'));
                }else{
                    $where = array( 
                            'id'            => $id,
                            'is_admin !='   => 1
                     );
                    if ($this->common_model->update('admin',$where,$adminLevelData)) {
                            $this->session->setFlashdata('message', display('update_successfully'));
                    } else {
                            $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return  redirect()->to(base_url('backend/account/admin_information/'.$id));                            
                }
            }else{ 

                if(!empty($id)) {
                    $data['title'] = display('edit_admin');
                    $data['admin']   = $this->admin_model->single($id);
                }
            $data['content'] = $this->BASE_VIEW . '\admin\form';
            return $this->template->admin_layout($data);			
		}
	}


	public function delete($id = null)
	{ 
            $where=array(
                'id'  =>   $id
            );
            if ($this->common_model->deleteRow('admin',$where)) {
		      $this->session->setFlashdata('message', display('delete_successfully'));
            } else {
		      $this->session->setFlashdata('exception', display('please_try_again'));
            }
            return  redirect()->to(base_url('backend/account/admin_list'));
		
	}
    public function profile()
    {

        $data['title'] = display('profile'); 
        $data['user']  = $this->admin_model->profile($this->session->userdata('id'));
 
        $data['content'] = $this->BASE_VIEW . '\profile';
        return $this->template->admin_layout($data);
    }

        public function edit_profile()
        { 

            $data['title']    = display('edit_profile');
            $id = $this->session->userdata('id');
            /*-----------------------------------*/
            $this->validation->setRule('firstname', 'First Name','required|max_length[50]');
            $this->validation->setRule('lastname', 'Last Name','required|max_length[50]');
            #------------------------#
            $this->validation->setRule('email', 'Email Address', 'required|valid_email|max_length[100]');
            #------------------------#
        
            $this->validation->setRule('about', 'About','max_length[1000]');

            if($this->request->getVar('password',FILTER_SANITIZE_STRING)){

                $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');

                $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');

            }

            /*-----------------------------------*/ 
            //set config 
            if($this->validation->withRequest($this->request)->run()){
                $img = $this->request->getFile('image',FILTER_SANITIZE_STRING);
                    $savepath="public/uploads/dashboard/new/";
                    $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING);
                    if($this->request->getMethod() == "post"){

                        $image=$this->imagelibrary->image($img,$savepath,$old_image,100,100);

                    }
                }


            /*-----------------------------------*/
            $data['user'] = (object)$userData = array(
                'id'          => $this->request->getVar('id',FILTER_SANITIZE_STRING),
                'firstname'   => $this->request->getVar('firstname',FILTER_SANITIZE_STRING),
                'lastname'    => $this->request->getVar('lastname',FILTER_SANITIZE_STRING),
                'email'       => $this->request->getVar('email',FILTER_SANITIZE_STRING), 
                'about'       => $this->request->getVar('about',FILTER_SANITIZE_STRING),
                'image'       => (!empty($image)?$image:$this->request->getVar('old_image',FILTER_SANITIZE_STRING)) 
            );

            if($this->request->getVar('password',FILTER_SANITIZE_STRING)){
                $userData['password'] = md5($this->request->getVar('password',FILTER_SANITIZE_STRING));
            }
            /*-----------------------------------*/
            if ($this->validation->withRequest($this->request)->run()) {
 
                if ($this->admin_model->update_profile($userData)) 
                {

                    $this->session->set(array(
                        'fullname'   => $this->request->getVar('firstname',FILTER_SANITIZE_STRING).' '.$this->request->getVar('lastname',FILTER_SANITIZE_STRING),
                        'email'       => $this->request->getVar('email',FILTER_SANITIZE_STRING),
                        'image'       => (!empty($image)?$image:$this->request->getVar('old_image',FILTER_SANITIZE_STRING))
                    ));


                    $this->session->setFlashdata('message', display('update_successfully'));
                } else {
                    $this->session->setFlashdata('exception',  display('please_try_again'));
                }
                return redirect()->to(base_url('backend/account/edit_profile'));

            } else {
                                 
                $data['user']   = $this->admin_model->profile($id);

                $data['content'] = $this->BASE_VIEW . '\edit_profile';
                return $this->template->admin_layout($data);
            }
        }

       
}