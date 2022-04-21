<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function __construct()
    {
        
    }

    public function login () 
    {
        if (!isset($_POST['username']) || !isset($_POST['password']))
        {
            return redirect('login', 'refresh');
        }
        else
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $db = $this->db;
            $getQuery = $db->query("SELECT a.*, b.user_type FROM tbl_user a 
            INNER JOIN tbl_user_type b ON a.user_type_id = b.user_type_id 
            WHERE username = '$username' AND password = '$password'");

            if ($getQuery->getResult())
            {
                
                $sessionData = [
                    'user_id'       => $getQuery->getRow()->user_id,
                    'username'      => $getQuery->getRow()->username,
                    'first_name'    => $getQuery->getRow()->first_name,
                    'last_name'     => $getQuery->getRow()->last_name,
                    'user_type'     => $getQuery->getRow()->user_type,
                    'time_login'    => date('Y-m-d H:i:s')
                ];
                
                // echo json_encode($sessionData);
                
                $session = \Config\Services::session();
                $session->set($sessionData);

                if ($getQuery->getRow()->user_type == 'ADMIN')
                {
                    return redirect('admin/dashboard', 'refresh');
                }
                else if ($getQuery->getRow()->user_type == 'CUSTOMER')
                {
                    return redirect('products', 'refresh');
                }
                else
                {
                    return redirect('login', 'refresh');
                }
            }
            else
            {
                return redirect('login', 'refresh');
            }
        }
    }

    public function logout ()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect('login', 'refresh');
    }
}