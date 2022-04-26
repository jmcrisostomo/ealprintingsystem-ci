<?php

namespace App\Controllers;

use \Config\Services;

class Admin extends BaseController
{
    public function index()
    {
        $data['meta_page'] = 'Dashboard';
        return view('admin/dashboard', $data);
    }
    public function dashboard()
    {
        $data['meta_page'] = 'Dashboard';
        return view('admin/dashboard', $data);
    }
    public function show_product()
    {
        $data['meta_page'] = 'Products';
        return view('admin/show_product', $data);
    }
}
