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

        $getQuery = $this->db->query("SELECT * FROM tbl_category WHERE state = 'ACTIVE'");
        $data['category_data'] = $getQuery->getResult();
        
        return view('admin/show_product', $data);
    }

    public function show_product_category()
    {
        $data['meta_page'] = 'Category';

        $getQuery = $this->db->query("SELECT * FROM tbl_category WHERE state = 'ACTIVE'");
        $data['category_data'] = $getQuery->getResult();
        
        return view('admin/show_product_category', $data);
    }
}
