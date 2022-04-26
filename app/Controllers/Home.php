<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function index()
    {

        $session = $this->session;
        if ($session->get('user_type') == 'ADMIN')
        {
            return redirect()->to(site_url('admin'));
        }
        else if ($session->get('user_type') == 'CUSTOMER') 
        {
            return redirect()->to(site_url(). 'home/login');
        }

        $data['meta_page'] = 'Login';
        return view('login', $data);
    }
    public function login()
    {
        $session = $this->session;
        if ($session->get('user_type') == 'ADMIN')
        {
            return redirect()->to(site_url('admin'));
        }
        else if ($session->get('user_type') == 'CUSTOMER') 
        {
            return redirect()->to(site_url(). 'home/login');
        }
        
        $data['meta_page'] = 'Login';
        return view('login', $data);
    }

    public function products()
    {
        $data['meta_page'] = 'Products';
        return view('customer/products', $data);
    }
}
