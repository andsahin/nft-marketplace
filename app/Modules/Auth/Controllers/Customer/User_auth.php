<?php

namespace App\Modules\Auth\Controllers\Customer;

helper('captcha');
class User_auth extends BaseController
{

    public function index()
    {
          return redirect()->to(base_url('user/signin'));
    }

    //customer logout function
    public function logout()
    { 
        $this->session->destroy();
        return redirect()->to(base_url());
    }
}