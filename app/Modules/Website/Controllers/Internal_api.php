<?php namespace App\Modules\Website\Controllers;
class Internal_api extends BaseController
{

    /*********************
    |Websites Internal API|
    **********************/

    public function getStream()
    { 
        $builder = $this->db->table('cryptolist');
        $cryptocoins    = $builder->select("Symbol")
                                    ->orderBy('SortOrder', 'asc')
                                    ->limit(200, 0)
                                    ->get()
                                    ->getResult();

        $coin_stream = array();
        foreach ($cryptocoins as $coin_key => $coin_value) {
            array_push($coin_stream, "5~CCCAGG~".$coin_value->Symbol."~USD");
        }
          
        echo json_encode($coin_stream);
    }
    public function Settings()
    { 
        $builder       = $this->db->table('setting') ;
        $settings      = $builder->select("*")
                            ->get()
                            ->getRow();
          
        echo json_encode(array('nsetting'=> $settings));
    }

}