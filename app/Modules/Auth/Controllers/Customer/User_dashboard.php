<?php

namespace App\Modules\Auth\Controllers\Customer;

use \CodeIgniter\HTTP\URI;

helper('date');
class User_dashboard extends BaseController
{
    public function index()
    { 
        $data['title']              = "Dashboard"; 
        $data['info']               = $this->dashboard_model->my_info();  
        $data['limit']              = 20;
        $data['tab'] = $tab         = $this->request->getVar('my');
         

        $data['userInfo'] = $userInfo   = $this->common_model->where_row('user', ['user_id'=>$this->session->get('user_id')]); 
        $data['totalCollected']         = $this->common_model->countRow('nfts_store', ['nfts_store.user_id'=>$userInfo->user_id]);
        $data['totalCreated']           = $this->common_model->countRow('nfts_store', ['nfts_store.created_by'=>$userInfo->user_id, 'nfts_store.user_id'=>$userInfo->user_id]);
        $data['totalFav']               = $this->common_model->countRow('favorite_items', ['favorite_items.user_id'=>$userInfo->user_id]);
   


        if ($this->session->getFlashdata('exception') != null) {  
            $data['exception'] = $this->session->getFlashdata('exception');
        }else if($this->session->getFlashdata('message') != null){
            $data['message'] = $this->session->getFlashdata('message');
        }
         
        $data['frontendAssets'] = base_url('public/assets/website'); 

        $data['content']        = view($this->BASE_VIEW . '/dashboard',$data);
        
        return $this->template->website_layout($data);
    }


    public function mynfts($loadmore=1, $mytab=null)
    {
         
        $limit = 20;
        $userInfo = $this->common_model->where_row('user', ['user_id' => $this->session->get('user_id')]); 

         
        $where = ['nfts_store.user_id'=>$userInfo->user_id];

        if($mytab == 'created'){

            $where = ['nfts_store.user_id'=>$userInfo->user_id, 'nfts_store.created_by'=>$userInfo->user_id];

        }else if($mytab == 'favorite'){

            $fav = $this->common_model->where_rows('favorite_items', ['user_id'=>$userInfo->user_id], 'fv_id', 'asc');
            $favArr = [];
           
            foreach ($fav as $key => $fv) { 
                $favArr[] = $fv->nft_id;
            }

            $where = $favArr; 
            
        }else if($mytab == 'activity'){
            $where = ['nfts_store.user_id'=>9999999];
        }

       
        $data['mytab'] = $mytab;
        $data['userNfts'] = $this->web_model->getUserDashboardNfts($where, ($loadmore*$limit), $mytab); 
        $result = view($this->BASE_VIEW . '/nfts',$data);
        
        echo json_encode(['status'=>true, 'data'=>$result, 'tab'=>$mytab]); 
    }
}