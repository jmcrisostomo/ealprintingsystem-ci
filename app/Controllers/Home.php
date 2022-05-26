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

        

        if ($this->request->getGet('category'))
        {
            $categoryId = $this->request->getGet('category');
            $getProducts = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id WHERE a.state = 'ACTIVE' AND a.category_id = $categoryId");
            
            
            $getCategory = $this->db->query("SELECT * FROM tbl_category WHERE state = 'ACTIVE' AND category_id = $categoryId");

            $categoryName = $getCategory->getRowArray();
            $data['breadcrumb_data'] = $categoryName['category_name'];

            // if ($getProducts->getNumRows() < 1)
            // {
            //     return redirect()->to('/products');
            // }

        }
        else
        {
            $getProducts = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id WHERE a.state = 'ACTIVE'");

            $data['breadcrumb_data'] = NULL;
        }

        $data['product_data'] = $getProducts->getResult();

        $data['meta_page'] = 'Products';
        return view('customer/products', $data);
    }
    
    public function products_single ($productId)
    {
        $productId = $productId;

        // $session = $this->session;
        // if ($session->get('user_type') == 'ADMIN')
        // {
        //     return redirect()->to(site_url('admin'));
        // }
        // else if ($session->get('user_type') == 'CUSTOMER') 
        // {
        //     return redirect()->to(site_url(). 'home/login');
        // }
        $getProducts = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id WHERE a.state = 'ACTIVE' AND a.product_id = $productId");
        
        //get category data
        $categoryId = $getProducts->getRow()->category_id;
        $productName = $getProducts->getRow()->product_name;
        $getCategory = $this->db->query("SELECT * FROM tbl_category WHERE state = 'ACTIVE' AND category_id = $categoryId");


        $data['meta_page'] = $productName;
        $data['product_single'] = $getProducts->getRow();
        $data['breadcrumb_data'] = $getCategory->getRow()->category_name;
        $data['breadcrumb_category_id'] = $getCategory->getRow()->category_id;

        return view('customer/products_single', $data);
    }

    public function cart ()
    {

        $session = $this->session;
        if ($session->has('user_id'))
        {
            $userId = $session->has('user_id');
            $getCart = $this->db->query("SELECT a.*, b.product_name, b.product_image, b.price as default_price FROM tbl_cart a INNER JOIN tbl_product b ON a.product_id = b.product_id WHERE user_id = $userId");
            $data['cart_data'] = $getCart->getResult();
        }
        else
        {
            $data['cart_data'] = NULL;
        }

        $data['meta_page'] = 'Cart';
        return view('customer/cart', $data);
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
