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

        // $data['meta_page'] = 'Login';
        // return view('login', $data);

        $data['meta_page'] = '';
        return view('landing-page', $data);
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
        $getCategory = $this->db->query("SELECT * FROM tbl_category WHERE state = 'ACTIVE'");
        $data['category_data'] = $getCategory->getResult();

        $getProducts = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id WHERE a.state = 'ACTIVE'");
        $data['product_data'] = $getProducts->getResult();

        $data['meta_page'] = 'Products';
        return view('customer/products', $data);
    }
    
    public function about()
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

        // $data['meta_page'] = 'Login';
        // return view('login', $data);

        $data['meta_page'] = '';
        return view('about', $data);
    }
}
