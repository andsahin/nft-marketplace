<?php

namespace App\Modules\Auth\Controllers\Admin;


helper('date');
class Dashboard extends BaseController
{
    public function index()
    {
         
        if (!$this->session->get('isLogIn')) {
            return redirect()->route('login');
        } 
         
        $data['activeUsers']         = $this->dashboard_model->countRow('user', ['status'=>1]);
        $data['inactiveUsers']       = $this->dashboard_model->countRow('user', ['status'=>0]);
        $data['totalListingForSale'] = $this->dashboard_model->countRow('nft_listing', ['status'=>0]);
        $data['totalNft']            = $this->dashboard_model->countRow('nfts_store');

        $data['info']                = $this->dashboard_model->getReport();
        $data['earned_fees']         = $this->common_model->where_row('admin_wallet');
        
        $data['title']   = display('Dashboard');   
        $data['content'] = $this->BASE_VIEW . '\dashboard';
        return $this->template->admin_layout($data);
    }
    

    public function ajaxCheck()
    {
        if ($this->request->isAJAX()) {
            echo esc($this->request->getVar('id', FILTER_SANITIZE_STRING));
        }
    }
     
        
        
}