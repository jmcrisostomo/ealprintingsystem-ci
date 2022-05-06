<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CheckSessionAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        // if ($session->has('user_id') && $session->get('user_type') == 'ADMIN')
        // {
        //     return redirect()->to(site_url(). '/admin');
        //     exit();
        // }
        // else if ($session->has('user_id') && $session->get('user_type') == 'CUSTOMER') 
        // {
        //     return redirect()->to(site_url(). '/products');
        //     exit();
        // }
        // else
        // {
        //     // $uri = new \CodeIgniter\HTTP\URI();
        //     // $uri = current_url(true);
        //     // if ($uri->getPath() !== '/home/login')
        //     // {
        //         return redirect()->to(site_url(). 'home/login');
        //     //     exit();
        //     // }
        // }
        
        // $headers = apache_request_headers();
        // print_r($headers);

        // if (!$session->has('user_id'))
        // {
        //     return redirect()->to(site_url(). 'home/login');
        // }
        // else if ($session->get('user_type') !== 'ADMIN')
        // {
        //     return redirect()->to(site_url(). 'home/products');
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
