<?php

namespace App\Controllers;

class Home extends BaseController
{
    
    public function index()
    {
        return view('welcome_message');
    }
    public function login()
    {
        $data['meta_page'] = 'Login';
        return view('login', $data);
    }

    public function products()
    {
        $data['meta_page'] = 'Products';
        return view('customer/products', $data);
    }
}
