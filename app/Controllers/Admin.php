<?php

namespace App\Controllers;

use \Config\Services;

class Admin extends BaseController
{

    protected function checkSession() 
    {
        // $session = \Config\Services::session();
        // if ($session->get('user_type'))
        // {
        //     return redirect()->to('admin');
        // }
        // else
        // {
        //     return redirect()->to('login');
        // }
        // if ($session->has('user_id') && $session->get('user_type') == 'ADMIN')
        // {
        //     return redirect('admin', 'refresh');
        //     exit();
        // }
        // else if ($session->has('user_id') && $session->get('user_type') == 'CUSTOMER') 
        // {
        //     return redirect('products', 'refresh');
        //     exit();
        // }
        // else
        // {
        //     return redirect('login', 'refresh');
        //     exit();
        // }
    }

    public function __construct()
    {
        $this->checkSession();
    }

    public function index()
    {
        // $this->checkSession();
        $data['meta_page'] = 'Dashboard';
        return view('admin/dashboard', $data);
    }
    public function dashboard()
    {
        $data['meta_page'] = 'Dashboard';
        return view('admin/dashboard', $data);
    }
}
