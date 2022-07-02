<?php 
namespace App\Modules\Nfts\Controllers\Admin;
class Nfts extends BaseController 
{
  


    public function index()
    {    

        $data['title']  = 'NFT List';
        $uri = service('uri','<?php echo base_url(); ?>'); 

        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page           = ($uri->getSegment(3)) ? $uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getVar('page'))?$this->request->getVar('page'):1);
       
        $total           = $this->common_model->countRow('user');
        $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------

        $data['content'] = $this->BASE_VIEW . '\nfts\index';
        return $this->template->admin_layout($data);
    }

    /*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    public function ajax_list()
    {
        $table = 'nfts_store';

        $column_order = array(null, 'nfts_store.name','nfts_store.token_id','nft_category.cat_name', 'nft_collection.title', 'nfts_store.user_id', 'user.f_name', 'nfts_store.owner_wallet','nfts_store.status'); //set column field database for datatable orderable

        $column_search = array('nfts_store.name','nfts_store.token_id', 'nfts_store.user_id', 'nfts_store.owner_wallet', 'user.f_name', 'user.l_name', 'nft_category.cat_name', 'nft_collection.title'); //set column field database for datatable searchable 

        $order = array('id' => 'DESC'); // default order   
        $where = array(); // default order   
        $list = $this->nfts_model->get_datatables($table,$column_order,$column_search,$order,$where); 
        $data = array();
        $no = $this->request->getvar('start');
        foreach ($list as $value) {

            /** status valuse */
            $val =''; 
            if($value->status == 0){

              $val = '<div class="nftHtmlData_'.$value->id.'"><span class="btn btn-warning btn-md update-class_'.$value->id.' nftstatus_'.$value->id.'" id="channge_status_list" nftid="'.$value->id.'" nftstatus="'.$value->status.'" onclick="mfun('.$value->id.', '.$value->status.')">Pending <i class="fas fa-angle-down" ></i></span></div>';

            }else if($value->status == 1){

              $val = '<div class="nftHtmlData_'.$value->id.'"><span class="btn btn-success btn-md update-class_'.$value->id.' nftstatus_'.$value->id.'" id="channge_status_list" nftid="'.$value->id.'" nftstatus="'.$value->status.'" onclick="mfun('.$value->id.', '.$value->status.')">Verified <i class="fas fa-angle-down" ></span></div>';

            }else if($value->status == 2){

              $val = '<div class="nftHtmlData_'.$value->id.'"><span class="btn btn-danger btn-md update-class_'.$value->id.' nftstatus_'.$value->id.'" id="channge_status_list" nftid="'.$value->id.'" nftstatus="'.$value->status.'" onclick="mfun('.$value->id.', '.$value->status.')">Suspend <i class="fas fa-angle-down"></span>';}else{$val = '<span class="btn btn-info">On sell</span></div>';
            }
            /** status valuse end */

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->name; 
            $row[] = $value->token_id;
            $row[] = $value->cat_name;
            $row[] = $value->collection_title; 
            $row[] = $value->user_id; 
            $row[] = $value->f_name.' '.$value->l_name; 
            $row[] = $value->owner_wallet;  
            $row[] = $val;
            $row[] = '<a href="'.base_url("backend/nft/details/{$value->id}").'"'.' class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Details"><i class="fas fa-book"></i></a>'; 
            $data[] = $row;
        }

        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->nfts_model->count_all($table),
                "recordsFiltered" => $this->nfts_model->count_filtered($table,$column_order,$column_search,$order),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }

    public function nftDetails($id=null)
    {

      if (empty($id)) {
        redirect()->to(base_url('nft/list'));
      }

      $builder = $this->db->table('nfts_store');
      $builder->select('nfts_store.*, user.f_name, user.l_name, nft_category.cat_name, nft_collection.title as collection_title');
      $builder->where('nfts_store.id', $id);
      $builder->join('user', 'user.user_id=nfts_store.user_id', 'left');
      $builder->join('nft_category', 'nft_category.id=nfts_store.category_id', 'left');
      $builder->join('nft_collection', 'nft_collection.id=nfts_store.collection_id', 'left'); 
      $query = $builder->get(); 
      $data['info'] = $query->getRow(); 

      $data['network'] = $this->common_model->where_row('blockchain_network');
      $data['title']  = "NFT Details";
      $data['content'] = $this->BASE_VIEW . '\nfts\details';
      return $this->template->admin_layout($data);
    } 

    

    public function ajax_collection($id=null)
    {
      if($id){
         $collections = $this->db->table('nft_collection')->select('id, title')->where(['user_id'=>$id])->get()->getResult(); 
          
         $cl[''] = 'Select Collection';
         foreach ($collections as $key => $value) {
             $cl[$value->id] = $value->title;
         }
         
         $att = [
            "id"=>"category",  
            "class"=>"form-control",   
            "required"=>"required"   
          ];
               
          $rt = form_dropdown('collection', $cl, '', $att); 
          echo ($rt);
     }else{
           $att = [
            "id"=>"category",  
            "class"=>"form-control",   
            "required"=>"required"   
          ];
          $cl[''] = 'Select Collection';   
          $rt = form_dropdown('collection', $cl, '', $att); 
          echo ($rt);
     } 
      
    }

    public function change_status($nftId=null, $status=null)
    {
        if (!empty($nftId)) {

          $nftInfo = $this->common_model->where_row('nfts_store', ['id'=>$nftId]);

          if($status == 2){

            $this->validation->setRule('suspend_msg', 'Message','required'); 
            if ($this->validation->withRequest($this->request)->run()){

              $suspend_msg = $this->request->getVar('suspend_msg', FILTER_SANITIZE_STRING);
              $data = ['status'=>$status, 'suspend_msg'=>$suspend_msg];

              $update = $this->common_model->update('nfts_store', ['id'=>$nftId], $data);

              if ($update) {
                $this->session->setFlashdata('message',display('save_successfully'));  
                return redirect()->to(base_url('backend/nft/details/'.$nftId)); 
              }else{
                $this->session->setFlashdata('exception', display('please_try_again')); 
                return redirect()->to(base_url('backend/nft/details/'.$nftId));
              }
            }
            else{ 
              $error=$this->validation->listErrors();
              $this->session->setFlashdata('exception', $error);
              return redirect()->to(base_url('backend/nft/details/'.$nftId));
            }

          }else{
          if($status == 1){ $v = 1; }else { $v = 0; }

          $arr =  ['status'=>$status, 'is_verified'=>$v, 'suspend_msg'=>null];
          $update = $this->common_model->update('nfts_store', ['id'=>$nftId], $arr);
          if ($update) {
            echo json_encode(['status'=>'success', 'msg'=>'updated']);
          }else{
            echo json_encode(['status'=>'err', 'msg'=>'unknown error']);
          }

        }
        }else{
          echo json_encode(['status'=>'err', 'msg'=>'your nft not found']);
        }
    }



    public function isFeatured(int $nftId=null, $method=null)
    {
      if($nftId==null || $method==null){
        redirect()->to(base_url());
      }

      if($nftId && $method == 'check'){

        $this->common_model->update('nfts_store', array(), ['is_featured'=>0]);
        $this->common_model->update('nfts_store', array('id'=>$nftId), ['is_featured'=>1]);

        echo json_encode(['status'=>true, 'msg'=>'Set is featured']);

      }else if($nftId){

        $this->common_model->update('nfts_store', array(), ['is_featured'=>0]);  

        echo json_encode(['status'=>true, 'msg'=>'Unset featured']);
      }
    }


}