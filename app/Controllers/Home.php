<?php

namespace App\Controllers;

class Home extends BaseController
{
    
    public function index()
    {
        $data['meta_page'] = 'Login';
        return view('login', $data);
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
