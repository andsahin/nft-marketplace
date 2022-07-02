<?php 
namespace App\Modules\Setting\Controllers\Admin;
class Internal_api extends BaseController
{

    public function getemailsmsgateway()
    {
        
        $db=  db_connect();
        $builder=$db->table("email_sms_gateway");
        $sms    =   $builder->select('*')->where('es_id', 1)->get()->getRow();

        echo json_encode($sms);
    }


   

}