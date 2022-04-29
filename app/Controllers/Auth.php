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


    public function loginTest ($response = NULL) 
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!isset($_POST['username']) || !isset($_POST['password']) || empty($_POST['username']) || empty($_POST['password']))
            {
                $response = [
                    'status_code' => 412,
                    'status'      => 'Precondition Failed',
                    'message'      => 'Username or Password not set',
                    'description'  => 'Please input username and password',
                ];
                echo json_encode($response);
                exit();
            }
            else
            {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $db = $this->db;
                $getQuery = $db->query("SELECT a.*, b.user_type FROM tbl_user a 
                INNER JOIN tbl_user_type b ON a.user_type_id = b.user_type_id 
                WHERE username = '$username'");

                if ($getQuery->getResult())
                {
                    $verifiedUsername = $getQuery->getRow()->username;

                    $validatePassword = $db->query("SELECT a.*, b.user_type FROM tbl_user a 
                    INNER JOIN tbl_user_type b ON a.user_type_id = b.user_type_id 
                    WHERE username = '$verifiedUsername' AND password = '$password'");

                    if ($validatePassword->getResult())
                    {
                        $sessionData = [
                            'user_id'       => $getQuery->getRow()->user_id,
                            'username'      => $getQuery->getRow()->username,
                            'first_name'    => $getQuery->getRow()->first_name,
                            'last_name'     => $getQuery->getRow()->last_name,
                            'user_type'     => $getQuery->getRow()->user_type,
                            'time_login'    => date('Y-m-d H:i:s')
                        ];
                        
                        $session = $this->session;
                        $session->set($sessionData);
    
                        if ($getQuery->getRow()->user_type == 'ADMIN')
                        {
                            $response = [
                                'status_code' => 200,
                                'status'      => 'OK',
                                'message'      => 'Login Success',
                                'description'  => 'Account Admin login successfully',
                                'redirect_url' => base_url('admin/dashboard')    
                            ];
                            echo json_encode($response);
                            exit();
                        }
                        else if ($getQuery->getRow()->user_type == 'CUSTOMER')
                        {
                            $response = [
                                'status_code' => 200,
                                'status'      => 'OK',
                                'message'      => 'Login Success',
                                'description'  => 'Account Customer login successfully',
                                'redirect_url' => base_url('products')    
                            ];
                            echo json_encode($response);
                            exit();
                        }
                    }
                    else
                    {
                        $response = [
                            'status_code' => 412,
                            'status'      => 'Precondition Failed',
                            'message'      => 'Invalid Password',
                            'description'  => 'Invalid Password',
                        ];
                        echo json_encode($response);
                        exit();
                    }
                }
                else
                {
                    $response = [
                        'status_code' => 404,
                        'status'      => 'Not Found',
                        'message'      => 'Account not found',
                        'description'  => 'Account does not exist',
                    ];
                    echo json_encode($response);
                    exit();
                    
                }
            }
        }
        else
        {
            $response = [
                'status_code' => 405,
                'status'      => 'Method Not Allowed',
                'message'      => 'Method Not Allowed',
                'description'  => 'Please use other request method',
            ];
            echo json_encode($response);
            exit();
        }
    }

    public function logout ()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect('login', 'refresh');
    }
}