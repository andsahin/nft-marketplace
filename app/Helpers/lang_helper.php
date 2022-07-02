<?php 
 if(!function_exists('lan')) {
     

    function display($text = null)
    {
        $session = \Config\Services::session();
        $CI = db_connect();
        $table         = 'language';
        $phrase        = 'phrase';
        $setting_table = 'setting';
        $default_lang  = 'english';

        //set language  
        $user_id = $session->userdata('user_id');
        if(!empty($user_id)){
            $default_lang  = 'english';
            $setting_table = 'user';
            $builder = $CI->table($setting_table);
            $data = $builder->where('user_id',$user_id)->get()->getRow();
        } else {

            $default_lang  = 'english';
            $setting_table = 'setting';
                    //set language  
            $builder = $CI->table($setting_table);
            $data = $builder->get()->getRow();
        }#end

        if (!empty($data->language)) {
            $language = $data->language; 
        } else {
            $language = $default_lang; 
        } 
 
        if (!empty($text)) {

            if ($CI->tableExists($table)) { 

                if ($CI->fieldExists($phrase, $table)) { 

                    if ($CI->fieldExists($language, $table)) {

                        $row = $CI->table($table)
                              ->select($language)
                              ->where($phrase, $text)
                             ->get()
                             ->getRow();

                        if (!empty($row->$language)) {
                            return $row->$language;
                        } else {
                            return str_replace('_', ' ', $text);
                        }

                    } else {
                        return false;
                    }

                } else {
                    return false;
                }

            } else {
                return false;
            }            
        } else {
            return false;
        }  

    }
 
}

