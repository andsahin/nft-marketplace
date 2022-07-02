<?php 
namespace App\Modules\Nfts\Controllers\Admin;
helper('text');
class Categories extends BaseController {
 	
 	
 
	public function index()
	{   
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 
    $uri = service('uri','<?php echo base_url(); ?>');
    #-------------------------------#
    #pagination starts
    #-------------------------------#
    $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
    $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
    $data['categories']  = $this->common_model->get_all('nft_category',array(),20,($page_number-1)*20,'id','desc');
    $total           = $this->common_model->countRow('nft_category');
    $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
    #------------------------
    #pagination ends
    #------------------------

    $data['title']      = display('nft_cat_list');

    $data['content'] = $this->BASE_VIEW . '\category\index';

    return $this->template->admin_layout($data);
	}

  public function add()
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 

    $this->validation->setRule('cat_name', 'Category Name','required'); 
    $this->validation->setRule('status', 'Status','required'); 
    $this->validation->setRule('logo', 'Logo image', 'ext_in[logo,png,jpg,gif,ico,jpeg]|is_image[logo]');
    if($this->validation->withRequest($this->request)->run()){ 

      $logo = $this->request->getFile('logo',FILTER_SANITIZE_STRING);
      if($logo->getSize() == 0){
        $this->session->setFlashdata('exception',  'logo image is required'); 
        return  redirect()->to(base_url('backend/nft/add_category'));
      }else if(($logo->getSize() / 1024) > 10245){
        $this->session->setFlashdata('exception',  'logo image size must be less than 10 MB'); 
        return  redirect()->to(base_url('backend/nft/add_category'));
      }

      if($logo){
        $savepath="public/uploads/category/logo/";
        $old_image = null; 
        $image=$this->imagelibrary->image($logo,$savepath,$old_image,350,350);
      }else{
        $image = null;
      }
    }


    if ($this->validation->withRequest($this->request)->run()){
          $slug = $this->_slug_clean($this->request->getVar('cat_name', FILTER_SANITIZE_STRING));
          $data = [
              'cat_name' => $this->request->getVar('cat_name', FILTER_SANITIZE_STRING),
              'slug' => strtolower($slug),
              'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING),
              'status' => $this->request->getVar('status', FILTER_SANITIZE_STRING),
              'logo' => $image 
          ];

          $builder = $this->db->table('nft_category');
          $ins = $builder->insert($data);

          if($ins){
              $this->session->setFlashdata('message',display('save_successfully')); 
              return  redirect()->to(base_url('backend/nft/categories')); 
          }else{ 
              $this->session->setFlashdata('exception', display('please_try_again')); 
              return  redirect()->to(base_url('backend/nft/add_category'));
          } 

    }
    $error=$this->validation->listErrors();
    if($this->request->getMethod() == "post"){
          $this->session->setFlashdata('exception', $error);
          return  redirect()->to(base_url('backend/nft/add_category'));
    }

    $data['title']  = "Add New Category";
    $data['content'] = $this->BASE_VIEW . '\category\add';
    return $this->template->admin_layout($data);
  }
       
  public function update($id=null)
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    }  
    if (empty($id)) {
          return redirect()->to(base_url('backend/nft/categories'));
    }

    $builder = $this->db->table('nft_category'); 
    $info = $builder->select('*')->where(['id'=>$id])->get()->getRow(); 

    $this->validation->setRule('cat_name', 'Category Name','required'); 
    $this->validation->setRule('status', 'Status','required'); 
    $this->validation->setRule('logo', 'Logo image', 'ext_in[logo,png,jpg,gif,ico,jpeg]|is_image[logo]');

    if($this->validation->withRequest($this->request)->run()){ 
      $logo = $this->request->getFile('logo',FILTER_SANITIZE_STRING);
      if($logo){
        $savepath="public/uploads/category/logo/";
        $old_image = $info->logo; 
        $image=$this->imagelibrary->image($logo,$savepath,$old_image,350,350);
      }else{
        $image = null;
      }
    }

    if ($this->validation->withRequest($this->request)->run()){
          $slug = $this->_slug_clean($this->request->getVar('cat_name', FILTER_SANITIZE_STRING));
          $data = [
              'cat_name' => $this->request->getVar('cat_name', FILTER_SANITIZE_STRING),
              'slug' => strtolower($slug),
              'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING),
              'status' => $this->request->getVar('status', FILTER_SANITIZE_STRING)   
          ];
          if($image){
            $data['logo'] = $image;
          }
          
          $builder = $this->db->table('nft_category');
          $ins = $builder->where(['id'=>$id])->update($data);

          if($ins){
              $this->session->setFlashdata('message',display('save_successfully')); 
              return  redirect()->to(base_url('backend/nft/update_category/'.$id)); 
          }else{ 
              $this->session->setFlashdata('exception', display('please_try_again')); 
              return  redirect()->to(base_url('backend/nft/update_category/'.$id));
          } 

    }
    $error=$this->validation->listErrors();
    if($this->request->getMethod() == "post"){
          $this->session->setFlashdata('exception', $error);
          return  redirect()->to(base_url('backend/nft/update_category/'.$id));
    }
     
    $data['info']  = $info; 
    $data['title']  = "Update Category";
    $data['content'] = $this->BASE_VIEW . '\category\edit';
    return $this->template->admin_layout($data);
  }
      
  public function category_delete($id=null)
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 
    if (empty($id)) {
          return redirect()->to(base_url('backend/nft/categories'));
    }

    $builder = $this->db->table('nft_category');
    $result = $builder->where(['id'=>$id])->delete();

    if($result){
        $this->session->setFlashdata('message',display('save_successfully')); 
        return  redirect()->to(base_url('backend/nft/categories')); 
    }else{ 
        $this->session->setFlashdata('exception', display('please_try_again')); 
        return  redirect()->to(base_url('backend/nft/categories'));
    } 
  }

  public function user_collection()
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 
    $uri = service('uri','<?php echo base_url(); ?>');
    #-------------------------------#
    #pagination starts
    #-------------------------------#
    $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
    $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
   
    /** get user wise all collections */
    $builder = $this->db->table('nft_collection');
    $builder->select('*');
    $builder->join('user', 'user.user_id = nft_collection.user_id');
    $data['collections'] = $builder->get()->getResult(); 
    /** end get user all collections */

    $total           = $this->common_model->countRow('nft_collection');
    $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
    #------------------------
    #pagination ends
    #------------------------

    $data['title']      = display('nft_collection_list');

    $data['content'] = $this->BASE_VIEW . '\category\user_collection';

    return $this->template->admin_layout($data);
  }

  public function addCollection()
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 

    $this->validation->setRule('col_name', 'Collection Name','required'); 
    $this->validation->setRule('user', 'User','required'); 
    $this->validation->setRule('category', 'Category','required'); 
    $this->validation->setRule('banner_img', 'Banner image', 'ext_in[banner_img,png,jpg,gif,ico,jpeg]|is_image[banner_img]');
    $this->validation->setRule('profile_img', 'Profile image', 'ext_in[profile_img,png,jpg,gif,ico,jpeg]|is_image[profile_img]');

    if($this->validation->withRequest($this->request)->run()){
      $banner_img = $this->request->getFile('banner_img',FILTER_SANITIZE_STRING);
      $profile_img = $this->request->getFile('profile_img',FILTER_SANITIZE_STRING);


      if($banner_img->getSize() == 0){
        $this->session->setFlashdata('exception',  'Banner image is required'); 
        return  redirect()->to(base_url('backend/nft/add_collection'));
      }else if(($banner_img->getSize() / 1024) > 1024){
        $this->session->setFlashdata('exception',  'Banner image size must be less than 1 MB'); 
        return  redirect()->to(base_url('backend/nft/add_collection'));
      }
 
      if($profile_img->getSize() == 0){
        $this->session->setFlashdata('exception',  'logo image is required'); 
        return  redirect()->to(base_url('backend/nft/add_collection'));
      }else if(($profile_img->getSize() / 1024) > 1024){
        $this->session->setFlashdata('exception',  'logo image size must be less than 1 MB'); 
        return  redirect()->to(base_url('backend/nft/add_collection'));
      }



      if($banner_img){
        $savepath="public/uploads/collection/banner/";
        $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING); 
        $image=$this->imagelibrary->image($banner_img,$savepath,$old_image,1400,400);
      }else{
        $image = null;
      }

      if($profile_img){
        $savepath="public/uploads/collection/profile/";
        $old_image = $this->request->getVar('old_image', FILTER_SANITIZE_STRING); 
        $froImage=$this->imagelibrary->image($profile_img,$savepath,$old_image,350,350);
      }else{
        $froImage = null;
      } 
    } 

    if ($this->validation->withRequest($this->request)->run()){

          $data = [
              'user_id' => $this->request->getVar('user', FILTER_SANITIZE_STRING),
              'title' => $this->request->getVar('col_name', FILTER_SANITIZE_STRING),
              'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING), 
              'category_id' => $this->request->getVar('category', FILTER_SANITIZE_STRING), 
              'logo_image' => $this->request->getVar('user', FILTER_SANITIZE_STRING), 
              'banner_image' => $image, 
              'logo_image' => $froImage, 
          ];

          $builder = $this->db->table('nft_collection');
          $ins = $builder->insert($data);

          if($ins){
              $this->session->setFlashdata('message',display('save_successfully')); 
              return  redirect()->to(base_url('backend/nft/collections')); 
          }else{ 
              $this->session->setFlashdata('exception', display('please_try_again')); 
              return  redirect()->to(base_url('backend/nft/add_collection'));
          } 

    }
    $error=$this->validation->listErrors();
    if($this->request->getMethod() == "post"){
          $this->session->setFlashdata('exception', $error);
          return  redirect()->to(base_url('backend/nft/add_collection'));
    }

    $data['users']  = $this->db->table('user')->select('user_id, f_name, l_name')->where(['status'=>1])->get()->getResult();
    $data['categories']  = $this->db->table('nft_category')->select('id, cat_name')->get()->getResult();
    $data['title']  = "Add New Collection";
    $data['content'] = $this->BASE_VIEW . '\category\add_collection';
    return $this->template->admin_layout($data);
  }
       
  public function updateCollection($cid=null)
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to(base_url('admin'));
    }
    if (empty($cid)) {
      return redirect()->to(base_url('admin'));
    } 
    $info = $this->db->table('nft_collection')->select('*')->where(['id'=>$cid])->get()->getRow();
    
    $this->validation->setRule('col_name', 'Collection Name','required'); 
    $this->validation->setRule('user', 'User','required'); 
    $this->validation->setRule('category', 'Category','required'); 
    $this->validation->setRule('banner_img', 'Banner image', 'ext_in[banner_img,png,jpg,gif,ico,jpeg]|is_image[banner_img]');
    $this->validation->setRule('profile_img', 'Profile image', 'ext_in[profile_img,png,jpg,gif,ico,jpeg]|is_image[profile_img]');

    if($this->validation->withRequest($this->request)->run()){
      $banner_img = $this->request->getFile('banner_img',FILTER_SANITIZE_STRING);
      $profile_img = $this->request->getFile('profile_img',FILTER_SANITIZE_STRING);
      if($banner_img){
        $savepath="public/uploads/collection/banner/";
        $old_image = $info->banner_image; 
        $image=$this->imagelibrary->image($banner_img,$savepath,$old_image,1400,400);
      }else{
        $image = null;
      }

      if($profile_img){
        $savepath="public/uploads/collection/profile/";
        $old_image = $info->logo_image;
        $froImage=$this->imagelibrary->image($profile_img,$savepath,$old_image,350,350);
      }else{
        $froImage = null;
      } 
    } 

    if ($this->validation->withRequest($this->request)->run()){

          $data = [
              'user_id' => $this->request->getVar('user', FILTER_SANITIZE_STRING),
              'title' => $this->request->getVar('col_name', FILTER_SANITIZE_STRING),
              'description' => $this->request->getVar('description', FILTER_SANITIZE_STRING), 
              'category_id' => $this->request->getVar('category', FILTER_SANITIZE_STRING)    
          ];
          if ($image) {
            $data['banner_image'] = $image ;
          }
          if($froImage){
            $data['logo_image'] = $froImage;
          }
          

          $builder = $this->db->table('nft_collection');
          $update = $this->common_model->update('nft_collection', ['id'=>$cid], $data);

          if($update){
              $this->session->setFlashdata('message',display('update_successfully')); 
              return  redirect()->to(base_url('backend/nft/collections')); 
          }else{ 
              $this->session->setFlashdata('exception', display('please_try_again')); 
              return  redirect()->to(base_url('backend/nft/update_collection'));
          } 

    }
    $error=$this->validation->listErrors();
    if($this->request->getMethod() == "post"){
          $this->session->setFlashdata('exception', $error);
          return  redirect()->to(base_url('backend/nft/update_collection'));
    }

    $data['info']  = $info;
    $data['users']  = $this->db->table('user')->select('user_id, f_name, l_name')->where(['status'=>1])->get()->getResult();
    $data['categories']  = $this->db->table('nft_category')->select('id, cat_name')->get()->getResult();
    $data['title']  = "Update Collection";
    $data['content'] = $this->BASE_VIEW . '\category\edit_collection';
    return $this->template->admin_layout($data);
  }
      
  public function deletCollection($id=null)
  {
    if (!$this->session->get('isLogIn') && !$this->session->get('isAdmin')) {
          return redirect()->to('admin');
    } 
    if (empty($id)) {
          return redirect()->to(base_url('backend/nft/categories'));
    }

    $builder = $this->db->table('nft_category');
    $result = $builder->where(['id'=>$id])->delete();

    if($result){
        $this->session->setFlashdata('message',display('save_successfully')); 
        return  redirect()->to(base_url('backend/nft/categories')); 
    }else{ 
        $this->session->setFlashdata('exception', display('please_try_again')); 
        return  redirect()->to(base_url('backend/nft/categories'));
    } 
  }

  private function _slug_clean($string) {
     $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

     return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }



}