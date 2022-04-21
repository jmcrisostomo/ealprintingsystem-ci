<?php

namespace App\Controllers;

class Admin extends BaseController
{
    protected $checkSession;

    public function __construct()
    {
        $this->checkSessionAdmin();
    }

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
}
