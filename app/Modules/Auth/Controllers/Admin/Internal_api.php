<?php 
namespace App\Modules\Auth\Controllers\Admin;
class Internal_api extends BaseController
{


    public function gateway()
    { 
        $builder = $this ->db->table('payment_gateway');
        $gateway        = $builder->select('*')
                            ->where('id', 4)
                            ->where('status', 1)
                            ->get()
                            ->getRow();
          
        echo json_encode($gateway);
    }
 
    public function barchartdata($year='')
    {
        $current_year = date('Y');
        
        if(!empty($year)){
            $query = $this->db->query("SELECT MAX(DATE_FORMAT(created_at,'%m')) AS month, COUNT(1) AS total FROM dbt_nfts_store WHERE YEAR(created_at) = $year GROUP BY MONTH(created_at)")->getResult();
        }else{
            $query = $this->db->query("SELECT MAX(DATE_FORMAT(created_at,'%m')) AS month, COUNT(1) AS total FROM dbt_nfts_store WHERE YEAR(created_at) = $current_year GROUP BY MONTH(created_at)")->getResult();
        }
        


        $num = []; 

        for ($i=1; $i < 13; $i++) { 
          
            $num[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
              
        } 
        
 
       
        $getMonthData = []; 
        foreach ($num as $k => $value) { 

            foreach ($query as $k2 => $value2) {
                  
                if($value2->month == $value) {

                    $getMonthData[$k] = $value2->total;
                    break;
                } else {

                    $getMonthData[$k] = 0;
                }
            } 

        }


        $monthsVal = array();
        $totalVal = array();
        foreach ($getMonthData as $key => $value) {
            array_push($monthsVal, date("F", mktime(0, 0, 0, $key, 10)));
            array_push($totalVal, $value);
        }
         
        echo json_encode(array('months'=>$monthsVal,'total'=>$totalVal));
    }

    public function getpiechartdata($value='')
    {
        $year= $value;

        $current_year   = date('Y');
        $this->db       = db_connect();

        if(!empty($year)){


            $totalNft   = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nfts_store WHERE YEAR(created_at) = $year GROUP BY YEAR(created_at)")->getRow();

            

            $totalList  = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nft_listing_log WHERE YEAR(created_at) = $year AND status = 0 GROUP BY YEAR(created_at)")->getRow();



            $totalSell   = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nft_listing_log WHERE YEAR(created_at) = $year AND status = 1 GROUP BY YEAR(created_at)")->getRow();
             

        } else {
            


            $totalNft   = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nfts_store WHERE YEAR(created_at) = $current_year GROUP BY YEAR(created_at)")->getRow(); 

            $totalList  = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nft_listing_log WHERE YEAR(created_at) = $current_year AND status = 0 GROUP BY YEAR(created_at)")->getRow();

            $totalSell   = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nft_listing_log WHERE YEAR(created_at) = $current_year AND status = 1 GROUP BY YEAR(created_at)")->getRow();
        } 
 

        $returnArr = array(); 
        
        array_push($returnArr, isset($totalSell->total) ? $totalSell->total : 0);
        array_push($returnArr, isset($totalNft->total) ? $totalNft->total : 0);
        array_push($returnArr, isset($totalList->total) ? $totalList->total : 0);
         

        $level = array();

        isset($totalSell->total)    ? array_push($level, "Total Sell NFTs")          : array_push($level, "");
        isset($totalNft->total)     ? array_push($level, "Total Minted NFTs")               : array_push($level, "");
        isset($totalList->total)    ? array_push($level, "NFTs List for Sell ")      : array_push($level, "");
        

        $color = array();

        isset($totalSell->total)    ? array_push($color, "#ff9800")   : array_push($color, "");
        isset($totalNft->total)     ? array_push($color, "#4ea752")   : array_push($color, "");
        isset($totalList->total)    ? array_push($color, "#26c6da")   : array_push($color, "");
        



        echo json_encode(array('data' => $returnArr, 'level' => $level, 'color' => $color));
    }
    public function userchartdata()
    {
        $current_year = date('Y');
        
        $this->db=  db_connect();

        $user = $this->db->query("SELECT MONTHNAME(`created`) as month, Count(`user_id`) as user FROM `user_registration` WHERE YEAR(`created`) = '".$current_year."'GROUP BY YEAR(CURDATE()), MONTH(`created`)")->getresult();

 
        
        $monthsu            = array();
        $userno       = array();
        
        if(!empty($user)){
            foreach ($user as $key => $value) {
                array_push($userno,$value->user);
                array_push($monthsu,$value->month);
            }
        }

        
        $months = array_merge($monthsu);
        
        echo json_encode(array('userno'=>$userno,'months'=>$months));
        
    }

}