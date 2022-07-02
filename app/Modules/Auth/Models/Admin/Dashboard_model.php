<?php

namespace App\Modules\Auth\Models\Admin;

class Dashboard_model
{

    public function __construct(){
        $this->db = db_connect();
        $this->session = \Config\Services::session();
    }

    public function countRow($table, $where = array())
    {
        return $this->db->table($table)->where($where)->countAllResults();
    }
    


    public function getReport()
    {
        $totalNft   = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nfts_store")->getRow();

        
        $totalList  = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nft_listing_log WHERE status = 0 ")->getRow();


        $totalSell   = $this->db->query("SELECT COUNT(1) AS total FROM dbt_nft_listing_log WHERE status = 1 ")->getRow();

        return array('nfts' => isset($totalNft) ? $totalNft : 0, 'list' => isset($totalList) ? $totalList : 0, 'sell' => isset($totalSell) ? $totalSell : 0);
    }
   
   

     
}