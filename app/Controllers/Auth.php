<?php

namespace App\Controllers;

class Auth extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();

        $this->check_ban_list();
    }

    // NEED TO DO SOMETHING ABOUT THE REDIRECT SINCE API NA LAHAT - TRIGGER??
    private function check_xss($data, $response, $function, $ban_remarks, $ban_duration)
        {
            $verdict = 1;

            foreach ($data as $key => $value)
            {
                if(gettype($value) == 'array')
                {
                    $value = json_encode($value);
                }

                if($this->security->xss_clean($value, TRUE) === TRUE)
                {

                }

                else
                {
                    $verdict = 0;
                }
            }

            if($verdict == 0)
            {
                $this->errorHandler(json_encode($response) . ' - ' . $function);

                // BAN IP
                $this->ban($ban_remarks, $ban_duration);

                // echo '<script>'.$response.'</script>';
                echo json_encode($response);

                session_destroy();
                redirect('ban?id=1', 'refresh');
            }
        }

    // NEED TO DO SOMETHING ABOUT THE REDIRECT SINCE API NA LAHAT - TRIGGER??
    private function check_ban_list()
    {
        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $date_now = date('Y-m-d H:i:s',$timestamp);

        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
        $ip = $_SERVER['HTTP_CLIENT_IP'].' - SHARE INTERNET';
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'].' - PASS FROM PROXY';
        }
        else if(!empty($_SERVER['HTTP_X_REAL_IP']))
        {
        $ip = $_SERVER['HTTP_X_REAL_IP'].' - NORMAL - HTTP_X_REAL_IP';
        }
        else
        {
        $ip = $_SERVER['REMOTE_ADDR'].' - NORMAL - REMOTE_ADDR';
        }

        $User_IP = $ip;

        // BLANK SINCE MAY MGA "NOT SET" SA RECORDS KAPAG IP LANG ANG NAKA BAN
        $account_number = '';

        if(isset($_SESSION['ACCOUNT_NUMBER']))
        {
        $account_number = $_SESSION['ACCOUNT_NUMBER'];
        }

        // JUST MAKE SURE NA WALANG BLANK ACCOUNT NUMBER DUN SA TABLE BAN LIST, DAPAT NOT SET KAPAG WALANG ACCOUNT NUMBER
        $Check_Ban_List = $this->db->query("SELECT * FROM tblbanlist WHERE (IP_ADDRESS = '$User_IP' OR ACCOUNT_NUMBER = '$account_number') AND STATE = 'ACTIVE';");

        if($Check_Ban_List->result() != null)
        {
        // redirect('ban?id=1','refresh');
        $redirect = 'ban?id=1';

        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Account Ban',
            'description' => 'Your account is currently banned.',
            'redirect' => $redirect
        );

        echo json_encode($response);
        exit();
        }
    }

    private function ban($remarks, $duration)
    {
        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $date_modified = date('Y-m-d H:i:s', $timestamp);
        $date_of_ban = $date_modified;

        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
        $ip = $_SERVER['HTTP_CLIENT_IP'].' - SHARE INTERNET';
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'].' - PASS FROM PROXY';
        }
        else if(!empty($_SERVER['HTTP_X_REAL_IP']))
        {
        $ip = $_SERVER['HTTP_X_REAL_IP'].' - NORMAL - HTTP_X_REAL_IP';
        }
        else
        {
        $ip = $_SERVER['REMOTE_ADDR'].' - NORMAL - REMOTE_ADDR';
        }

        if(isset($_SESSION['ACCOUNT_TYPE_NUMBER']))
        {
        $account_type_number = $_SESSION['ACCOUNT_TYPE_NUMBER'];
        }

        if(isset($_SESSION['ACCOUNT_NUMBER']))
        {
        $account_number = $_SESSION['ACCOUNT_NUMBER'];
        }

        $User_IP = $ip;
        $account_type_number = 'NOT SET';
        $account_number = 'NOT SET';

        $Insert_Ban = $this->db->query("INSERT INTO tblbanlist
        (
            IP_ADDRESS,
            ACCOUNT_TYPE_NUMBER,
            ACCOUNT_NUMBER,
            REMARKS,
            DATE_OF_BAN,
            DURATION,
            DATE_MODIFIED
        )
        VALUES
        (
            '$User_IP',
            '$account_type_number',
            '$account_number',
            '$remarks',
            '$date_of_ban',
            '$duration',
            '$date_modified'
        );");
    }

  // private function sign_token()
  // {
  //   date_default_timezone_set('Asia/Manila');
  //   $timestamp = time();
  //   $date_now = date('Y-m-d H:i:s', $timestamp);
  //
  //   $subject = 'PEPO';
  //   $secret_key = '2HYygpQZ4bCtS4hsQQYWMDMm2HkQlGS74Kg7ASdzHa';
  //
  //   $iat = $timestamp;
  //   $jti = $timestamp;
  //   $exp = strtotime(date('Y-m-d H:i:s', strtotime($date_now.' +1 day')));
  //
  //   $header = json_encode(array(
  //     'alg' => 'HS256',
  //     'typ' => 'JWT'
  //   ));
  //
  //   $payload = array(
  //     'sub' => $subject,
  //     'iat' => $iat,
  //     'jti' => $jti,
  //     'exp' => $exp
  //   );
  //
  //   $jwt = JWT::encode( $payload, $secret_key,'HS256');
  //   $_SESSION['token'] = $jwt;
  //
  //   return  $jwt;
  //   // echo  $jwt;
  // }

    private function validate_token()
    {
        // --- KAPAG HINDI VALID YUNG TOKEN ETO ERROR DIRECT ACCESS ---
        // Malformed UTF-8 characters
        try
        {
        if(isset($_SESSION['token']))
        {
            date_default_timezone_set('Asia/Manila');
            $timestamp = time();

            $secret_key = '2HYygpQZ4bCtS4hsQQYWMDMm2HkQlGS74Kg7ASdzHa';

            // TESTING PURPOSES FOR validate_token_parent
            // $decoded_token = JWT::decode($token, $secret_key, array('HS256'));
            $decoded_token = JWT::decode($_SESSION['token'], $secret_key, array('HS256'));

            $json_encode = json_encode($decoded_token);
            $json_decode = json_decode($json_encode, true);

            $exp = $json_decode['exp'];

            if($exp > $timestamp)
            {
            return 1;
            // echo 1;
            }

            else
            {
            $this->errorHandler('Token Expired - private function validate_token in Auth.php');
            return 0;
            // echo '0 expired';
            }
        }

        else
        {
            $this->errorHandler('Token Session is not set - private function validate_token in Auth.php');
            // NOT SURE WHAT TO RETURN
            return 0; // same effect I think, since di naman ia-allow
            // echo '0 session';
        }
        }
        catch (\Exception $e)
        {
        // $this->errorHandler('Signature Verification Failed(Try/Catch) - The token that the user is trying to submit is: '.$_SESSION['token'].' - private function validate_token in Auth.php');
        // die($e->getMessage());
        return 0;
        // echo '0 exception'.$token;
        }
    }

    public function errorHandler($remarks)
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
        $ip = $_SERVER['HTTP_CLIENT_IP'].' - SHARE INTERNET';
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'].' - PASS FROM PROXY';
        }
        else if(!empty($_SERVER['HTTP_X_REAL_IP']))
        {
        $ip = $_SERVER['HTTP_X_REAL_IP'].' - NORMAL - HTTP_X_REAL_IP';
        }
        else
        {
        $ip = $_SERVER['REMOTE_ADDR'].' - NORMAL - REMOTE_ADDR';
        }

        $User_IP = $ip;
        $account_type_number = 'NOT SET';
        $account_number = 'NOT SET';

        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $date_modified = date('Y-m-d H:i:s',$timestamp);

        if(isset($_SESSION['ACCOUNT_TYPE_NUMBER']))
        {
        $account_type_number = $_SESSION['ACCOUNT_TYPE_NUMBER'];
        }

        if(isset($_SESSION['ACCOUNT_NUMBER']))
        {
        $account_number = $_SESSION['ACCOUNT_NUMBER'];
        }

        $Error_Log = $this->db->query("INSERT INTO tblerrorhandler
        (
            IP_ADDRESS,
            ACCOUNT_TYPE_NUMBER,
            ACCOUNT_NUMBER,
            REMARKS,
            DATE_MODIFIED
        )
        VALUES
        (
            '$User_IP',
            '$account_type_number',
            '$account_number',
            '$remarks',
            '$date_modified'
        );");
    }

    public function login()
    {
        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $response_2 = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Something went wrong, please contact the administrators."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response_2;
        exit();
        }
        set_error_handler('anyError');

        // VALIDATE TOKEN
        $signature = $this->validate_token();

        if($signature == 0)
        {
        $response = array(
            'status_code' => '401',
            'status' => 'Unauthorized',
            'message' => 'Signature Verification Failed',
            'description' => 'Token is not valid, please re-open the app.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function login() in Auth.php');
        echo $response;
        exit();
        }

        if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != '' && $_POST['password'] != '')
        {
        $Cleaning_Username = $_POST['username'];
        $Cleaning_Password = $_POST['password'];

        // CHECK XSS
        $data = array
        (
            $Cleaning_Username,
            $Cleaning_Password
        );

        // $response = 'alert("Malicious data has been detected!");';
        // $function = 'public function login() in Auth.php';
        // $ban_remarks = 'XSS were detected upon logging in.';
        // $ban_duration = 'PERMANENT';
        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Malicious Data Has Been Detected',
            'description' => 'You have been banned.',
            'redirect' => 'ban?id=1'
        );
        $function = 'public function login() in Auth.php';
        $ban_remarks = 'XSS were detected upon logging in.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        $Username = $Cleaning_Username;
        $Password = $Cleaning_Password;

        $Username1 = $this->db->escape($Username);
        $Password1 = $this->db->escape($Password);

        $Select_Query = $this->db->query("SELECT * FROM tblaccount WHERE USERNAME = $Username1 AND PASSWORD = $Password1");

        if($Select_Query->result() != null)
        {
            date_default_timezone_set('Asia/Manila');
            $timestamp = time();
            $device_session = date('YmdHis',$timestamp);

            $state = $Select_Query->row("STATE");
            $status = $Select_Query->row("STATUS");
            $country = $Select_Query->row("COUNTRY");

            $account_number = $Select_Query->row('ACCOUNT_NUMBER');
            $account_type_number = $Select_Query->row('ACCOUNT_TYPE_NUMBER');
            $username = $Select_Query->row('USERNAME');
            $mobile_number = $Select_Query->row('MOBILE_NUMBER');
            $email_address = $Select_Query->row('EMAIL_ADDRESS');

            if($state == 'INACTIVE' && $status == 'UNVERIFIED')
            {
            $response = array(
                'status_code' => '401',
                'status' => 'Unauthorized',
                'message' => 'Account Declined',
                'description' => 'Your account has been declined.'
            );

            echo json_encode($response);
            exit();
            }

            if($status == 'VERIFIED')
            {
            if($state == 'ACTIVE')
            {
                // TURN OFF DEVICE CHECKER FOR MANUAL LOGIN/ANTI OTP SINCE WE DON'T HAVE SMS/EMAIL JUST YET
                // CHECK DEVICE SESSION
                if(isset($_SESSION['DEVICE_SESSION']))
                {
                $User_Sessions = array
                (
                    'ACCOUNT_NUMBER' => $account_number,
                    'ACCOUNT_TYPE_NUMBER' => $account_type_number,
                    'USERNAME'  => $username,
                    'MOBILE_NUMBER'  => $mobile_number,
                    'EMAIL_ADDRESS'  => $email_address,
                    'DEVICE_SESSION'  => $device_session
                );

                $this->session->set_userdata($User_Sessions);

                // UPDATE DEVICE_SESSION in tblaccount SO IT WILL LOGOUT ANY SESSION OF PREVIOUS DEVICE
                $Update_Device_Session = $this->db->query("UPDATE tblaccount SET DEVICE_SESSION = '$device_session' WHERE ACCOUNT_NUMBER = '$account_number';");

                /* NOTE:
                    ACC-TYPE-120210625151214 - ADMIN
                    ACC-TYPE-220210625151216 - PLAYER
                    ACC-TYPE-320210625151218 - OUTLET
                    ACC-TYPE-420210625151220 - ACCOUNTING
                */

                if($account_type_number == 'ACC-TYPE-120210625151214')
                {
                    $redirect = 'admin';
                }

                else if($account_type_number == 'ACC-TYPE-220210625151216')
                {
                    $redirect = 'player';
                }

                else if($account_type_number == 'ACC-TYPE-320210625151218')
                {
                    $redirect = 'outlet';
                }

                else if($account_type_number == 'ACC-TYPE-420210625151220')
                {
                    $redirect = 'accounting';
                }

                else if($account_type_number == 'ACC-TYPE-520210625151220')
                {
                    $redirect = 'pbb';
                }

                $response = array(
                    'status_code' => '200',
                    'status' => 'OK',
                    'message' => 'Authentication Success',
                    'description' => 'Correct credentials and device is known.',
                    'redirect' => $redirect
                );

                echo json_encode($response);
                }

                else if(!isset($_SESSION['DEVICE_SESSION']))
                {
                // $data['data'] = array
                // (
                //   'country' => $country,
                //   'account_number' => $account_number
                // );
                //
                // // $this->load->view('auth/send_otp', $data);
                // $this->load->view('auth/otp', $data);
                // $this->load->view('player/common/footer');

                $redirect = 'auth/otp';

                $_SESSION['OTP_ACCOUNT_NUMBER'] = $account_number;

                $response = array(
                    'status_code' => '200',
                    'status' => 'OK',
                    'message' => 'Authentication Success',
                    'description' => 'Correct credentials but device unknown.',
                    'redirect' => $redirect
                );

                echo json_encode($response);
                }
            }

            else if($state == 'INACTIVE')
            {
                // echo '<script type=text/javascript>alert("Your account is currently inactive, please contact your coordinator or the administrators.");</script>';
                //
                // $this->logout();

                $response = array(
                'status_code' => '401',
                'status' => 'Unauthorized',
                'message' => 'Account Inactive',
                'description' => 'Your account is currently inactive, please contact your coordinator or the administrators.'
                );

                echo json_encode($response);
            }

            // PARANG HINDI NA YATA MAPUPUNTA DITO? SINCE CHINI-CHECK NA SA CONSTRUCT? SO POSSIBLE NA MAWALA YUNG RECORD SA DB PERO STATE NYA IS BANNED PARIN>
            else if($state == 'BANNED')
            {
                // echo '<script type=text/javascript>alert("Your account has been banned, please contact your coordinator or the administrators.");</script>';
                //
                // $this->logout();

                $response = array(
                'status_code' => '401',
                'status' => 'Unauthorized',
                'message' => 'Account Ban',
                'description' => 'Your account is currently, please contact the administrators.'
                );

                echo json_encode($response);
            }
            }

            else if($status == 'UNVERIFIED')
            {
            $response = array(
                'status_code' => '401',
                'status' => 'Unauthorized',
                'message' => 'Account Unverified',
                'description' => 'Your account is currently unverified, please wait for approval.'
            );

            echo json_encode($response);
            }
        }

        else
        {
            // echo '<script type=text/javascript>alert("Username or Password is incorrect!");</script>';
            // redirect('home/login','refresh');

            $response = array(
            'status_code' => '404',
            'status' => 'Not Found',
            'message' => 'Account Not Found',
            'description' => 'Username or Password is incorrect.'
            );

            echo json_encode($response);
        }
        }

        else
        {
        // $response = 'alert("There are missing data passed to the server.");';
        // $this->errorHandler($response.' session or post data is missing - public function login() in Auth.php');
        // echo '<script>'.$response.'</script>';
        // redirect('home/login','refresh');

        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Missing Post Data',
            'description' => 'There are missing post fields upon submitting the form.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function login() in Auth.php');

        echo $response;
        }
    }

    public function logout()
    {
        // // CHECK THIS SOME TIME, SOMETHING FEELS WRONG, WHY CHECK THE TOKEN, EH MAG LA-LOGOUT NA? HM,,M, NOT SURE
        // // VALIDATE TOKEN
        // $signature = $this->validate_token();
        //
        // if($signature == 0)
        // {
        //   $response = array(
        //     'status_code' => '401',
        //     'status' => 'Unauthorized',
        //     'message' => 'Signature Verification Failed',
        //     'description' => 'Token is not valid, please re-open the app.'
        //   );
        //
        //   $response = json_encode($response);
        //
        //   $this->errorHandler($response.' - public function logout() in Auth.php');
        //   echo $response;
        //   exit();
        // }

        // DO NOT UNSET DEVICE SESSION
        unset($_SESSION['ACCOUNT_NUMBER']);
        unset($_SESSION['ACCOUNT_TYPE_NUMBER']);
        unset($_SESSION['USERNAME']);
        unset($_SESSION['MOBILE_NUMBER']);
        unset($_SESSION['EMAIL_ADDRESS']);

        redirect('home/login','refresh');
    }

    private function check_register_fields($data)
    {
        $verdict = true;
        $response = null;

        $return = array(
        'verdict' => $verdict,
        'response' => $response
        );

        foreach ($data as $key=>$value)
        {
        if($value == null)
        {
            $verdict = false;

            $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Missing Post Data',
            'description' => 'There are missing post fields upon submitting the form.'
            );

            $this->errorHandler(json_encode($response).' - private function check_register_fields($data) in Auth.php');

            $return = array(
            'verdict' => $verdict,
            'response' => $response
            );

            return $return;
            break;
        }
        }

        return $return;
    }

    private function check_username_length($username_length)
    {
        $verdict = true;
        $response = null;

        $username = $this->db->escape($username_length);

        if($username_length < 4)
        {
        $verdict = false;

        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Username Denied',
            'description' => 'The minimum username length must be equal or greater than 4.'
        );

        $this->errorHandler(json_encode($response).' - private function check_username_length($username_length) in Auth.php');
        }

        $return = array(
        'verdict' => $verdict,
        'response' => $response
        );

        return $return;
    }

    private function check_password_length($password_length)
    {
        $verdict = true;
        $response = null;

        $password = $this->db->escape($password_length);

        if($password_length < 6)
        {
        $verdict = false;

        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Password Denied',
            'description' => 'The minimum password length must be equal or greater than 6.'
        );

        $this->errorHandler(json_encode($response).' - private function check_password_length($password_length) in Auth.php');
        }

        $return = array(
        'verdict' => $verdict,
        'response' => $response
        );

        return $return;
    }

    private function check_username($username)
    {
        $verdict = true;
        $response = null;

        $username = $this->db->escape($username);
        $Check_Username = $this->db->query("SELECT * FROM tblaccount WHERE USERNAME = $username;");

        if($Check_Username->result() != null)
        {
        $verdict = false;

        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Account Already Exist',
            'description' => 'The username is already registered.'
        );

        $this->errorHandler(json_encode($response).' - private function check_username($username) in Auth.php');
        }

        $return = array(
        'verdict' => $verdict,
        'response' => $response
        );

        return $return;
    }

    private function check_mobile_number($mobile_number)
    {
        $verdict = true;
        $response = null;

        $mobile_number = $this->db->escape($mobile_number);
        $Check_Mobile_Number = $this->db->query("SELECT * FROM tblaccount WHERE MOBILE_NUMBER = $mobile_number;");

        if($Check_Mobile_Number->result() != null)
        {
        // if($Check_Mobile_Number->row('STATUS') == 'VERIFIED')
        // {
            $verdict = false;

            $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Mobile Number Already Exist',
            'description' => 'The mobile number is already registered.'
            );

            $this->errorHandler(json_encode($response).' - private function check_mobile_number($mobile_number) in Auth.php');
        // }
        }

        $return = array(
        'verdict' => $verdict,
        'response' => $response
        );

        return $return;
    }

    private function check_requirement_number($presenting_document)
    {
        $verdict = true;
        $response = null;

        $presenting_document = $this->db->escape($presenting_document);
        $Check_Requirement_Number = $this->db->query("SELECT * FROM tblrequirement WHERE REQUIREMENT_NUMBER = $presenting_document AND STATE = 'ACTIVE';");

        if($Check_Requirement_Number->result() == null)
        {
        $verdict = false;

        $response = array(
            'status_code' => '404',
            'status' => 'Not Found',
            'message' => 'Requirement Number Does Not Exist',
            'description' => 'The document to be presented is not valid.'
        );

        $this->errorHandler(json_encode($response).' - private function check_requirement_number($presenting_document) in Auth.php');
        }

        $return = array(
        'verdict' => $verdict,
        'response' => $response
        );

        return $return;
    }

    private function check_files($upload_document, $upload_document_with_selfie)
    {
        $verdict = true;
        $response = null;

        // IN BYTES
        $max_file_size = '26214400'; // 25mb

        // BROWSER AUTO CHECK
        // Your file couldn’t be accessed. It may have been moved, edited, or deleted.
        // ERR_FILE_NOT_FOUND

        // JUST IN CASE THE BROWSER DOESN'T SUPPORT FILE EXISTENCE CHECKING
        if(file_exists($upload_document['tmp_name']) && file_exists($upload_document_with_selfie['tmp_name']))
        {
        // CHECK IF IT MADE IN THE TEMPORARY STORAGE OF THE WEB SERVER
        if(is_uploaded_file($upload_document['tmp_name']) && is_uploaded_file($upload_document_with_selfie['tmp_name']))
        {
            // CHECK FILE TYPE
            $filename_upload_document = $upload_document['name'];
            $filename_upload_document_with_selfie = $upload_document_with_selfie['name'];

            $file_ext_upload_document = pathinfo($filename_upload_document,PATHINFO_EXTENSION);
            $file_ext_upload_document_with_selfie = pathinfo($filename_upload_document_with_selfie,PATHINFO_EXTENSION);

            // $allowed_types = array ('jpeg', 'jpg', 'png', 'bmp', 'tif', 'tiff', 'JPEG', 'JPG', 'PNG', 'BMP', 'TIF', 'TIFF');
            $allowed_types = array ('jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG');

            // CHECK IF THE FILE EXTENSION IS IN THE FOLLOWING ALLOWED TYPES
            if(in_array($file_ext_upload_document, $allowed_types) && in_array($file_ext_upload_document_with_selfie, $allowed_types))
            {
            $image_file_size_upload_document = $upload_document['size'];
            $image_file_size_upload_document_with_selfie = $upload_document_with_selfie['size'];

            // CHECK IF THE MAX FILE SIZE IS GREATER THAN THE UPLOADED IMAGE FILE SIZE
            if($max_file_size > $image_file_size_upload_document && $max_file_size > $image_file_size_upload_document_with_selfie)
            {
                // UPLOAD
                $return = array(
                'verdict' => $verdict,
                'response' => $response
                );

                return $return;
            }

            else
            {
                $response = array(
                'statusCode' => '400',
                'status' => 'Bad Request',
                'message' => 'File Size Exceed Limit',
                'description' => 'Uploaded image file size is larger than the maximum limit ('.($max_file_size / 1024 / 1024).'MB).'
                );

                $this->errorHandler(json_encode($response).' - private function check_files($upload_document, $upload_document_with_selfie) in Auth.php');

                $return = array(
                'verdict' => $verdict,
                'response' => $response
                );

                return $return;
            }
            }

            else
            {
            $response = array(
                'statusCode' => '400',
                'status' => 'Bad Request',
                'message' => 'Format Invalid',
                'description' => 'Image format is not allowed.'
            );

            $this->errorHandler(json_encode($response).' - private function check_files($upload_document, $upload_document_with_selfie) in Auth.php');

            $return = array(
                'verdict' => $verdict,
                'response' => $response
            );

            return $return;
            }
        }

        else
        {
            $response = array(
            'statusCode' => '400',
            'status' => 'Bad Request',
            'message' => 'Upload Failed',
            'description' => 'Image failed to save in the server.'
            );

            $this->errorHandler(json_encode($response).' - private function check_files($upload_document, $upload_document_with_selfie) in Auth.php');

            $return = array(
            'verdict' => $verdict,
            'response' => $response
            );

            return $return;
        }
        }

        else
        {
        $response = array(
            'statusCode' => '400',
            'status' => 'Bad Request',
            'message' => 'Path Does Not Exist',
            'description' => 'Path or Image might be moved, edited, or deleted.'
        );

        $this->errorHandler(json_encode($response).' - private function check_files($upload_document, $upload_document_with_selfie) in Auth.php');

        $return = array(
            'verdict' => $verdict,
            'response' => $response
        );

        return $return;
        }
    }

    private function create_requirements($presenting_document, $account_number, $upload_document, $upload_document_with_selfie)
    {
        // generate requirement then get requirement number
        $timestamp = time();
        $date_modified = date('Y-m-d H:i:s', $timestamp);
        $acc_req_datetime = date('YmdHis', $timestamp);

        $this->db->insert('tblaccountrequirement', array('REQUIREMENT_NUMBER' => $presenting_document, 'ACCOUNT_NUMBER' => $account_number, 'DATE_MODIFIED' => $date_modified));

        $get_latest = $this->db->query("SELECT MAX(ACC_REQ_ID) AS LATEST FROM tblaccountrequirement;");
        $latest = $get_latest->row("LATEST");

        $acc_requirement_number = 'ACC-RQN-'.$latest.$acc_req_datetime;

        $this->db->set("ACC_REQ_NUMBER", $acc_requirement_number);
        $this->db->where("ACC_REQ_ID", $latest);
        $this->db->update("tblaccountrequirement");

        // UPLOAD DOCUMENT
        //file config
        $config['upload_path'] = './assets/files/player/document_requirement';
        // $config['allowed_types'] = 'jpeg|jpg|png|bmp|tif|tiff|JPEG|JPG|PNG|BMP|TIF|TIFF';
        $config['allowed_types'] = 'jpeg|jpg|png|JPEG|JPG|PNG';
        $config['file_name'] = $acc_requirement_number;

        // Validate directory if it exists
        if (!file_exists($config['upload_path']))
        {
        mkdir($config['upload_path'], 0777, TRUE);
        }
        $this->load->library('upload', $config, 'DOCUMENT_REQUIREMENT');

        //initialize config DOCUMENT_REQUIREMENT
        $this->DOCUMENT_REQUIREMENT->initialize($config);

        // set file extension to db / also to verify if file is not NULL
        $file_extension = pathinfo($upload_document['name'], PATHINFO_EXTENSION) ? pathinfo($upload_document['name'], PATHINFO_EXTENSION) : NULL;

        if($file_extension)
        {
            $this->DOCUMENT_REQUIREMENT->do_upload('upload_document');

        $this->db->set("REQUIREMENT_FILE_EXT", $file_extension);
        $this->db->where("ACC_REQ_NUMBER", $acc_requirement_number);
        $this->db->where("ACCOUNT_NUMBER", $account_number);
        $this->db->update("tblaccountrequirement");
        }

        // UPLOAD DOCUMENT WITH SELFIE
        //file config
        $config['upload_path'] = './assets/files/player/document_requirement_selfie';
        // $config['allowed_types'] = 'jpeg|jpg|png|bmp|tif|tiff|JPEG|JPG|PNG|BMP|TIF|TIFF';
        $config['allowed_types'] = 'jpeg|jpg|png|JPEG|JPG|PNG';
        $config['file_name'] = $acc_requirement_number;

        // Validate directory if it exists
        if (!file_exists($config['upload_path']))
        {
        mkdir( $config['upload_path'], 0777, TRUE );
        }
        $this->load->library('upload', $config, 'DOCUMENT_REQUIREMENT_SELFIE');

        //initialize config DOCUMENT_REQUIREMENT_SELFIE
        $this->DOCUMENT_REQUIREMENT_SELFIE->initialize( $config );

        // set file extension to db / also to verify if file is not NULL
        $file_extension = pathinfo($upload_document_with_selfie['name'], PATHINFO_EXTENSION) ? pathinfo($upload_document_with_selfie['name'], PATHINFO_EXTENSION) : NULL;

        if($file_extension)
        {
            $this->DOCUMENT_REQUIREMENT_SELFIE->do_upload('upload_document_with_selfie');

        $this->db->set("SELFIE_FILE_EXT", $file_extension);
        $this->db->where("ACC_REQ_NUMBER", $acc_requirement_number);
        $this->db->where("ACCOUNT_NUMBER", $account_number);
        $this->db->update("tblaccountrequirement");
        }
        }

    private function generate_account_number()
    {
        $length = 6;

        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        // $characters = '123';

        $charactersLength = strlen($characters);

        $account_number = '';

        for($i = 0; $i < $length; $i++)
        {
        $account_number .= $characters[rand(0, $charactersLength - 1)];
        }

        return $account_number;
    }

    public function register()
    {
        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $response_2 = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Something went wrong, please contact the administrators."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response_2;
        exit();
        }
        set_error_handler('anyError');
        // VALIDATE TOKEN
            $signature = $this->validate_token();

            if($signature == 0)
            {
                $response = '{"statusCode":"498", "status":"Invalid Token", "message":"Signature Verification Failed", "description":"The token might not be set, invalid or expired."}';

                $this->errorHandler($response.' - public function accept_registration() in Accounting.php');
                echo $response;
                exit();
            }

        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $date_modified = date('Y-m-d H:i:s', $timestamp);
        $device_session = date('YmdHis',$timestamp);

        $username = $this->input->post('username');

        $mobile_number = $this->input->post('mobile_number');
        $mobile_number = str_replace(" ","", $mobile_number);

        $email_address = $this->input->post('email_address');
        $password = $this->input->post('password');
        $first_name = $this->input->post('first_name');
        $middle_name = $this->input->post('middle_name');
        $last_name = $this->input->post('last_name');
        $birth_date = $this->input->post('birth_date');
        $gender = $this->input->post('gender');
        $civil_status = $this->input->post('civil_status');
        $nationality = $this->input->post('nationality');
        $address = $this->input->post('address');
        $region = $this->input->post('region');
        $province = $this->input->post('province');
        $city = $this->input->post('city');
        $barangay = $this->input->post('barangay');
        $hidden_region = $this->input->post('hidden_region');
        $hidden_province = $this->input->post('hidden_province');
        $hidden_city = $this->input->post('hidden_city');
        $hidden_barangay = $this->input->post('hidden_barangay');
        $zip_code = $this->input->post('zip_code');
        $country = $this->input->post('country');
        $country = 'Philippines';
        $presenting_document = $this->input->post('presenting_document');

        $upload_document = $_FILES['upload_document'];
        $upload_document_with_selfie = $_FILES['upload_document_with_selfie'];

        // COUNT USERNAME IF MIN TO 4
        $username_length = strlen($username);

        $response = $this->check_username_length($username_length);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }

        // COUNT PASSWORD IF MIN TO 6
        $password_length = strlen($password);

        $response = $this->check_password_length($password_length);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }

        $username = $this->db->escape($username);
        $username = substr($username, 1, -1);

        $mobile_number = $this->db->escape($mobile_number);
        $mobile_number = substr($mobile_number, 1, -1);

        $email_address = $this->db->escape($email_address);
        $email_address = substr($email_address, 1, -1);

        $password = $this->db->escape($password);
        $password = substr($password, 1, -1);

        $first_name = $this->db->escape($first_name);
        $first_name = substr($first_name, 1, -1);

        $middle_name = $this->db->escape($middle_name);
        $middle_name = substr($middle_name, 1, -1);

        $last_name = $this->db->escape($last_name);
        $last_name = substr($last_name, 1, -1);

        $birth_date = $this->db->escape($birth_date);
        $birth_date = substr($birth_date, 1, -1);

        $gender = $this->db->escape($gender);
        $gender = substr($gender, 1, -1);

        $civil_status = $this->db->escape($civil_status);
        $civil_status = substr($civil_status, 1, -1);

        $nationality = $this->db->escape($nationality);
        $nationality = substr($nationality, 1, -1);

        $address = $this->db->escape($address);
        $address = substr($address, 1, -1);

        $hidden_region = $this->db->escape($hidden_region);
        $hidden_region = substr($hidden_region, 1, -1);

        $hidden_province = $this->db->escape($hidden_province);
        $hidden_province = substr($hidden_province, 1, -1);

        $hidden_city = $this->db->escape($hidden_city);
        $hidden_city = substr($hidden_city, 1, -1);

        $hidden_barangay = $this->db->escape($hidden_barangay);
        $hidden_barangay = substr($hidden_barangay, 1, -1);

        $zip_code = $this->db->escape($zip_code);
        $zip_code = substr($zip_code, 1, -1);

        $country = $this->db->escape($country);
        $country = substr($country, 1, -1);

        $date_modified = $this->db->escape($date_modified);
        $date_modified = substr($date_modified, 1, -1);

        // CHECK FIELDS
        $data = array(
        $username,
        $mobile_number,
        $email_address,
        $password,
        $first_name,
        $middle_name,
        $last_name,
        $birth_date,
        $gender,
        $civil_status,
        $nationality,
        $address,
        $region,
        $province,
        $city,
        $barangay,
        $hidden_region,
        $hidden_province,
        $hidden_city,
        $hidden_barangay,
        $zip_code,
        $country,
        $presenting_document
        );
        $response = $this->check_register_fields($data);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }

        // print_r($data);
        // exit();

        // CHECK XSS
        $response = array(
        'status_code' => '403',
        'status' => 'Forbidden',
        'message' => 'Malicious Data Has Been Detected',
        'description' => 'You have been banned.',
        'redirect' => 'ban?id=1'
        );
        $function = 'public function register() in Auth.php';
        $ban_remarks = 'XSS were detected upon trying to register the account.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        array_push($data, $upload_document, $upload_document_with_selfie);

        // CHECK IF USERNAME EXIST
        $response = $this->check_username($username);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }

        // CHECK IF MOBILE NUMBER EXIST
        $response = $this->check_mobile_number($mobile_number);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }

        // CHECK IF REQUIREMENT NUMBER EXIST
        $response = $this->check_requirement_number($presenting_document);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }

        // CHECK FILES
        $response = $this->check_files($upload_document, $upload_document_with_selfie);

        if($response['verdict'] == false)
        {
        echo json_encode($response['response']);
        exit();
        }



        /* NOTE:
        ACC-TYPE-120210625151214 - ADMIN
        ACC-TYPE-220210625151216 - PLAYER
        ACC-TYPE-320210625151218 - OUTLET
        ACC-TYPE-420210625151220 - ACCOUNTING
        ACC-TYPE-520210625151220 - PBB
        */

        for($i = 0; $i < 1; $i--)
        {
        $account_number = $this->generate_account_number();

        // CHECK ACCOUNT NUMBER THAT EXIST
        $Check_Exist = $this->db->query("SELECT * FROM tblaccount WHERE ACCOUNT_NUMBER = '$account_number';");

        if($Check_Exist->result() == null)
        {
            break;
        }
        }

        $data = array(
        'ACCOUNT_NUMBER' => $account_number,
        'ACCOUNT_TYPE_NUMBER' => 'ACC-TYPE-220210625151216',
        'USERNAME' => $username,
        'MOBILE_NUMBER' => $mobile_number,
        'EMAIL_ADDRESS' => $email_address,
        'PASSWORD' => $password,
        'FIRST_NAME' => $first_name,
        'MIDDLE_NAME' => $middle_name,
        'LAST_NAME' => $last_name,
        'BIRTH_DATE' => $birth_date,
        'GENDER' => $gender,
        'CIVIL_STATUS' => $civil_status,
        'NATIONALITY' => $nationality,
        'ADDRESS' => $address,
        'REGION' => $hidden_region,
        'PROVINCE' => $hidden_province,
        'CITY' => $hidden_city,
        'BARANGAY' => $hidden_barangay,
        'ZIP_CODE' => $zip_code,
        'COUNTRY' => $country,
        'DATE_MODIFIED' => $date_modified,
        'MODIFIED_BY' => 'SYSTEM'
        );

        $this->db->insert('tblaccount', $data, TRUE);

        // $get_latest = $this->db->query("SELECT MAX(ACCOUNT_ID) AS LATEST FROM tblaccount;");
        // $latest = $get_latest->row("LATEST");
        // $acc_datetime = $device_session;
        // $account_number = 'ACC-'.$latest.$acc_datetime;

        // $this->db->set("ACCOUNT_NUMBER", $account_number);
        // // WAG I-SET SINCE NEED PA NG OTP PAG LOGIN NIYA
        // // - TSAKA KULANG NG SET SESSION KAYA DI RIN GAGANA TO HAHAHA
        // // $this->db->set("DEVICE_SESSION", $device_session);
        // $this->db->where("ACCOUNT_ID", $get_latest->row("LATEST"));
        // $this->db->update("tblaccount");

        $this->create_requirements($presenting_document, $account_number, $upload_document, $upload_document_with_selfie);

        $redirect = 'home/login?d=ac';

        $response = array(
        'status_code' => '201',
        'status' => 'Created',
        'message' => 'Account Created',
        'description' => 'Account created successfully.',
        'redirect' => $redirect
        );
        echo json_encode($response);
    }
    // {
    //   // echo '{"test":"testing"}';
    //
    //   $response = $this->check_username_length(44);
    //
    //   if($response['verdict'] == false)
    //   {
    //     echo json_encode($response['response']);
    //     exit();
    //   }
    //
    //   echo '{"test":"continue"}';
    // }

    public function send_otp()
    {
        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $response_2 = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Something went wrong, please contact the administrators."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response_2;
        exit();
        }
        set_error_handler('anyError');

        // VALIDATE TOKEN
        $signature = $this->validate_token();

        if($signature == 0)
        {
        $response = array(
            'status_code' => '401',
            'status' => 'Unauthorized',
            'message' => 'Signature Verification Failed',
            'description' => 'Token is not valid, please re-open the app.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function send_otp() in Auth.php');
        echo $response;
        exit();
        }

        // if(isset($_POST['account_number']))
        if(isset($_SESSION['OTP_ACCOUNT_NUMBER']))
        {
        // CHECK XSS
        $data = array
        (
            // $_POST['account_number']
            $_SESSION['OTP_ACCOUNT_NUMBER']
        );

        // $response = 'alert("Malicious data has been detected!");';
        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Malicious Data Has Been Detected',
            'description' => 'You have been banned.',
            'redirect' => 'ban?id=1'
        );
        $function = 'public function login() in Auth.php';
        $ban_remarks = 'XSS were detected upon trying to send the OTP.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $date_modified = date('Y-m-d H:i:s',$timestamp);

        // $account_number_escaped = $this->db->escape($_POST['account_number']);
        $account_number_escaped = $this->db->escape($_SESSION['OTP_ACCOUNT_NUMBER']);
        $account_number = substr($account_number_escaped, 1, -1);

        // CHECK COUNTRY SO WE KNOW IF IT'S SMS OR EMAIL
        $Check_Country = $this->db->query("SELECT COUNTRY, MOBILE_NUMBER, EMAIL_ADDRESS FROM tblaccount WHERE ACCOUNT_NUMBER = '$account_number';");

        $country = $Check_Country->row('COUNTRY');
        $mobile_number = $Check_Country->row('MOBILE_NUMBER');
        $email_address = $Check_Country->row('EMAIL_ADDRESS');

        // CHECK IF 3 MINUTES HAS PASSED BEFORE SENDING ANOTHER OTP TO SMS/EMAIL
        $Check_OTP_Date_Sent = $this->db->query("SELECT OTP_DATE_SENT FROM tblaccount WHERE ACCOUNT_NUMBER = '$account_number';");

        $date_today = strtotime($date_modified);
        $otp_date_sent = strtotime($Check_OTP_Date_Sent->row('OTP_DATE_SENT'));
        $from_time = $otp_date_sent;
        $diffence_in_minutes = round(abs($date_today - $from_time) / 60,2);

        if($diffence_in_minutes >= 3)
        {
            $OTP = mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);

            if($country == 'Philippines')
            {
            // SMS
            $id = 'lotto_id';
            $secret_key = '1=YhVLy/?DRNP54f8ezlPprDB^c_@uo[ukBeykoGVo:gOdS4=AFNak6*HH[XHZc*(cbU-I!tGHMTEffEdo;3AOsQ7[BHVD@d%!:K';
            $recipient = $mobile_number;
            // sample: 09123456789 or +639123456789
            $content = 'OTP: '.$OTP;

            $data = array
            (
                'id' => $id,
                'secret_key' => $secret_key,
                'recipient' => $recipient,
                'content' => $content,
            );

            $url = 'https://smsapi.iamtechinc.com/send';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $output = curl_exec($ch);

            // if($output == FALSE)
            // {
            //   $response = 'alert("Failed to send OTP, please contact your coordinator or the administrators.");';
            //
            //   $this->errorHandler($response.' - cURL Error: '.curl_error($ch).' - public function send_otp() in Auth.php');
            //   echo '<script>'.$response.'</script>';
            //   redirect('home/login','refresh');
            // }
            //
            // else
            // {
            //   // UPDATE OTP IN tblaccount
            //   $Update_OTP = $this->db->query("UPDATE tblaccount SET OTP = '$OTP', OTP_DATE_SENT = '$date_modified' WHERE ACCOUNT_NUMBER = '$account_number");
            //
            //   $data['data'] = array
            //   (
            //     'account_number' => $account_number
            //   );
            //
            //   $this->load->view('auth/verify_otp', $data);
            // }

            $output = json_decode($output, true);

            if($output['status_code'] == 201)
            {
                // UPDATE OTP IN tblaccount
                $Update_OTP = $this->db->query("UPDATE tblaccount SET OTP = '$OTP', OTP_DATE_SENT = '$date_modified' WHERE ACCOUNT_NUMBER = '$account_number';");

                // $data['data'] = array
                // (
                //   'account_number' => $account_number
                // );

                // $this->load->view('auth/verify_otp', $data);

                $response = array(
                'status_code' => '201',
                'status' => 'Created',
                'message' => 'OTP Sent',
                'description' => 'OTP sent successfully.',
                'message_count' => $output['message_count']
                );
                echo json_encode($response);
            }

            else
                    {
                        $response = array(
                            'status_code' => '503',
                            'status' => 'Service Unavailable',
                            'message' => 'Unexpected Error',
                            'description' => 'Failed to send OTP, please contact your coordinator or the administrators.'
                        );
                        echo json_encode($response);
                    }

            curl_close($ch);
            }

            else
            {
            // // EMAIL
            // $recipient = $email_address;
            // $sender = 'pepolottomessenger@pepo.ph';
            // $subject = 'OTP';
            //
            // $mailContent = 'OTP: '.$OTP;
            //
            // $this->email->from($sender, 'Pepo Lotto Messenger' );
            // $this->email->to($recipient);
            // $this->email->subject($subject);
            // $this->email->message($mailContent);
            // $this->email->set_mailtype("html");
            //
            // if($this->email->send())
            // {
            //   // UPDATE OTP IN tblaccount
            //   $Update_OTP = $this->db->query("UPDATE tblaccount SET OTP = '$OTP', OTP_DATE_SENT = '$date_modified' WHERE ACCOUNT_NUMBER = '$account_number");
            //
            //   $data['data'] = array
            //   (
            //     'account_number' => $account_number
            //   );
            //
            //   $this->load->view('auth/verify_otp', $data);
            // }
            //
            // else
            // {
            //   $response = 'alert("Failed to send OTP, please contact your coordinator or the administrators.");';
            //
            //   $this->errorHandler($response.' - public function send_otp() in Auth.php');
            //   echo '<script>'.$response.'</script>';
            //   redirect('home/login','refresh');
            // }
            }
        }

        else
        {
            // $response = 'alert("Please wait 5 minutes before sending another OTP.");';
            //
            // $this->errorHandler($response.' - public function send_otp() in Auth.php');
            // echo '<script>'.$response.'</script>';
            // redirect('home/login','refresh');

            $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'OTP Not Sent',
            'description' => 'Please wait 3 minutes before sending another OTP.'
            );
            echo json_encode($response);
        }
        }

        else
        {
        // $response = 'alert("There are missing data passed to the server.");';
        //
        // $this->errorHandler($response.' session or post data is missing - public function send_otp() in Auth.php');
        // echo '<script>'.$response.'</script>';
        // redirect('home/login','refresh');

        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Missing Data',
            'description' => 'There are missing data passed to the server.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function send_otp() in Auth.php');

        echo $response;
        }
    }
        // {
        //   echo '{"status_code":"400"}';
        // }

    public function verify_otp()
    {
        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $response_2 = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Something went wrong, please contact the administrators."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response_2;
        exit();
        }
        set_error_handler('anyError');

        // VALIDATE TOKEN
        $signature = $this->validate_token();

        if($signature == 0)
        {
        $response = array(
            'status_code' => '401',
            'status' => 'Unauthorized',
            'message' => 'Signature Verification Failed',
            'description' => 'Token is not valid, please re-open the app.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function verify_otp() in Auth.php');
        echo $response;
        exit();
        }

        // if(isset($_POST['account_number']) && isset($_POST['otp']))
        if(isset($_SESSION['OTP_ACCOUNT_NUMBER']) && isset($_POST['otp']))
        {
        // CHECK XSS
        $data = array
        (
            // $_POST['account_number'],
            $_SESSION['OTP_ACCOUNT_NUMBER'],
            $_POST['otp']
        );

        // $response = 'alert("Malicious data has been detected!");';
        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Malicious Data Has Been Detected',
            'description' => 'You have been banned.',
            'redirect' => 'ban?id=1'
        );
        $function = 'public function verify_otp() in Auth.php';
        $ban_remarks = 'XSS were detected upon trying to verify the otp.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $device_session = date('YmdHis',$timestamp);

        // $account_number_escaped = $this->db->escape($_POST['account_number']);
        $account_number_escaped = $this->db->escape($_SESSION['OTP_ACCOUNT_NUMBER']);
        $account_number = substr($account_number_escaped, 1, -1);

        $otp_escaped = $this->db->escape($_POST['otp']);
        $otp = substr($otp_escaped, 1, -1);

        // CHECK IF OTP IS BLANK -BECAUSE BLANK OTP IN DATABSE DOESN'T HAVE OTP
        if($otp == '' || $otp == null)
        {
            $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Null OTP',
            'description' => 'OTP cannot be empty.'
            );

            echo json_encode($response);
            exit();
        }

        // CHECK IF IT IS THE CORRECT OTP
        $Check_OTP = $this->db->query("SELECT ACCOUNT_TYPE_NUMBER, USERNAME, MOBILE_NUMBER, EMAIL_ADDRESS FROM tblaccount WHERE ACCOUNT_NUMBER = '$account_number' AND OTP = '$otp';");

        // LMAO NANDITO KA NANAMAN HAHAHA! YUNG SOLUTION SA EXPIRATION NG OTP IS THAT PAG ENTER NG OTP, MAGIGING BLANK YUNG OTP SA DATABASE HEHE, SO HINDI TALAGA CHINI-CHECK YUNG OTP IF EXPIRED NABA OR WHAT
        if($Check_OTP->result() != null)
        {
            $account_type_number = $Check_OTP->row('ACCOUNT_TYPE_NUMBER');
            $username = $Check_OTP->row('USERNAME');
            $mobile_number = $Check_OTP->row('MOBILE_NUMBER');
            $email_address = $Check_OTP->row('EMAIL_ADDRESS');

            $User_Sessions = array
            (
            'ACCOUNT_NUMBER' => $account_number,
            'ACCOUNT_TYPE_NUMBER' => $account_type_number,
            'USERNAME'  => $username,
            'MOBILE_NUMBER'  => $mobile_number,
            'EMAIL_ADDRESS'  => $email_address,
            'DEVICE_SESSION'  => $device_session
            );

            $this->session->set_userdata($User_Sessions);

            // UPDATE DEVICE_SESSION in tblaccount SO IT WILL LOGOUT ANY SESSION OF PREVIOUS DEVICE
            // UPDATE OTP TO BLANK AS WELL
            $Update_Device_Session = $this->db->query("UPDATE tblaccount SET DEVICE_SESSION = '$device_session', OTP = '' WHERE ACCOUNT_NUMBER = '$account_number';");

            /* NOTE:
            ACC-TYPE-120210625151214 - ADMIN
            ACC-TYPE-220210625151216 - PLAYER
            ACC-TYPE-320210625151218 - OUTLET
            ACC-TYPE-420210625151220 - ACCOUNTING
            */
            if($account_type_number == 'ACC-TYPE-120210625151214')
            {
            $redirect = 'admin';
            }

            else if($account_type_number == 'ACC-TYPE-220210625151216')
            {
            $redirect = 'player';
            }

            else if($account_type_number == 'ACC-TYPE-320210625151218')
            {
            $redirect = 'outlet';
            }

            else if($account_type_number == 'ACC-TYPE-420210625151220')
            {
            $redirect = 'accounting';
            }

            else if($account_type_number == 'ACC-TYPE-520210625151220')
            {
            $redirect = 'pbb';
            }

            unset($_SESSION['OTP_ACCOUNT_NUMBER']);

            $response = array(
            'status_code' => '200',
            'status' => 'OK',
            'message' => 'OTP Verified',
            'description' => 'Correct OTP entered.',
            'redirect' => $redirect
            );

            echo json_encode($response);
        }

        else
        {
            // echo '<script>alert("Wrong OTP.");</script>';
            //
            // $data['data'] = array
            // (
            //   'account_number' => $account_number
            // );
            //
            // $this->load->view('auth/verify_otp', $data);

            $response = array(
            'status_code' => '404',
            'status' => 'Not Found',
            'message' => 'OTP Not Found',
            'description' => 'Wrong OTP entered.'
            );

            echo json_encode($response);
        }
        }

        else
        {
        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Missing Post Data',
            'description' => 'There are missing post fields upon submitting the form.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function verify_otp() in Auth.php');
        echo $response;
        }
    }

    public function change_password()
    {
        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $response_2 = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Something went wrong, please contact the administrators."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response_2;
        exit();
        }
        set_error_handler('anyError');

        // VALIDATE TOKEN
        $signature = $this->validate_token();

        if($signature == 0)
        {
        $response = array(
            'status_code' => '401',
            'status' => 'Unauthorized',
            'message' => 'Signature Verification Failed',
            'description' => 'Token is not valid, please re-open the app.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function change_password() in Auth.php');
        echo $response;
        exit();
        }

        if(isset($_SESSION['ACCOUNT_NUMBER']) && isset($_POST['current_password']) && isset($_POST['new_password']))
        {
        // CHECK XSS
        $data = array
        (
            $_POST['current_password'],
            $_POST['new_password']
        );

        // $response = 'alert("Malicious data has been detected!");';
        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Malicious Data Has Been Detected',
            'description' => 'You have been banned.',
            'redirect' => 'ban?id=1'
        );
        $function = 'public function change_password() in Auth.php';
        $ban_remarks = 'XSS were detected upon trying to change the password.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $date_modified = date('Y-m-d H:i:s',$timestamp);
        $date_modified_2 = date('YmdHis',$timestamp);


        $account_number = $this->db->escape($_SESSION['ACCOUNT_NUMBER']);
        $account_number = substr($account_number, 1, -1);

        $current_password = $this->db->escape($_POST['current_password']);
        $current_password = substr($current_password, 1, -1);

        $new_password = $this->db->escape($_POST['new_password']);
        $new_password = substr($new_password, 1, -1);

        // CHECK IF CURRENT PASSWORD IS CORRECT
        $Check_Current_Password = $this->db->query("SELECT * FROM tblaccount WHERE PASSWORD = '$current_password' AND ACCOUNT_NUMBER = '$account_number';");

        if($Check_Current_Password->result() != null)
        {
            // COUNT PASSWORD IF MIN TO 6
            $password_length = strlen($new_password);

            $response = $this->check_password_length($password_length);

            if($response['verdict'] == false)
            {
            echo json_encode($response['response']);
            exit();
            }

            // CHANGE PASSWORD
            $Change_Password = $this->db->query("UPDATE tblaccount SET PASSWORD = '$new_password' WHERE ACCOUNT_NUMBER = '$account_number';");

            $response = array(
            'status_code' => '200',
            'status' => 'OK',
            'message' => 'Resource Updated',
            'description' => 'Password changed successfully.'
            );

            echo json_encode($response);
        }
        else
        {
            $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Wrong Password',
            'description' => 'Password is incorrect.'
            );

            $response = json_encode($response);

            $this->errorHandler($response.' - public function change_password() in Auth.php');
            echo $response;
        }
        }

        else
        {
        $response = array(
            'status_code' => '400',
            'status' => 'Bad Request',
            'message' => 'Missing Data',
            'description' => 'There are missing data passed to the server.'
        );

        $response = json_encode($response);

        $this->errorHandler($response.' - public function change_password() in Auth.php');
        echo $response;
        }
    }

    public function test_sms()
    {
        // SMS
        // $id = 'lotto_id';
        // $secret_key = '1=YhVLy/?DRNP54f8ezlPprDB^c_@uo[ukBeykoGVo:gOdS4=AFNak6*HH[XHZc*(cbU-I!tGHMTEffEdo;3AOsQ7[BHVD@d%!:K';

        // $id = 'iAmTech';
        // $secret_key = '23G]D0ZOyVLGGGIqyWx|7L|AMS0}9)&_|n#d)bB28w@nufifc7FWlSf@pY8JA*[+AgHv:W#j452@y,0^Iiq0mEg?;1cUIeCyD4?[';

        $id = 'dealers_1plus1';
        $secret_key = 'M@f9V!fHt4GX0kOcb,BEFO[4mr80Mp;epg57vclM+j6&cFi*rvWk/(c#?cGjo|EC^Ew%w@m8R4rXeD:ln;OF_:U_T1F@C*,zHWOG';


        $recipient = '09993339030';
        // $recipient = '09271651869';
        // $recipient = '09309844642';
        // sample: 09123456789 or +639123456789
        $content = 'OTP: 123456';

        $data = array
        (
        'id' => $id,
        'secret_key' => $secret_key,
        'recipient' => $recipient,
        'content' => $content,
        );

        $url = 'https://smsapi.iamtechinc.com/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);

        curl_close($ch);

        echo $output;
    }

    public function otp()
    {
        if(isset($_SESSION['OTP_ACCOUNT_NUMBER']))
        {
        $this->load->view('player/common/header');
        $this->load->view('auth/otp');
        $this->load->view('player/common/footer');
        }

        else
        {
        redirect('home', 'refresh');
        }
    }

  // public function temp_send_otp()
  // {
  //   $this->load->view('auth/otp');
  //   $this->load->view('player/common/footer');
  // }
  //
  // public function temp_verify()
  // {
  //   $this->load->view('auth/otp');
  // }
  //
  // public function test_session()
  // {
  //   $account_number = 'it worked!';
  //
  //   $User_Sessions = array
  //   (
  //     'ACCOUNT_NUMBER' => $account_number
  //   );
  //
  //   $this->session->set_userdata($User_Sessions);
  // }

    public function otp_logout()
    {
        unset($_SESSION['OTP_ACCOUNT_NUMBER']);
        redirect('home/login', 'refresh');
    }

    public function validate_username()
    {
        header('Content-Type: application/json');

        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response;
        exit();
        }
        set_error_handler('anyError');

        // VALIDATE TOKEN
        $signature = $this->validate_token();

        if($signature == 0)
        {
        $response = '{"statusCode":"498", "status":"Invalid Token", "message":"Signature Verification Failed", "description":"The token might not be set, invalid or expired."}';

        $this->errorHandler($response.' - public function validate_username() in Auth.php');
        echo $response;
        exit();
        }

        if(isset($_GET['username']) && $_GET['username'] != '')
        {
        // CHECK XSS
        $data = array
        (
            $_GET['username']
        );

        // $response = 'alert("Malicious data has been detected!");';
        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Malicious Data Has Been Detected',
            'description' => 'You have been banned.',
            'redirect' => 'ban?id=1'
        );
        $function = 'public function validate_username() in Auth.php';
        $ban_remarks = 'XSS were detected upon trying to validate the username.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        $username = $this->db->escape($_GET['username']);

        // $get_username = $this->Account_Model->read_username( $username );
        $get_username = $this->db->query("SELECT USERNAME FROM tblaccount WHERE username = $username");

        if($get_username->result() == NULL)
        {
            echo '{"result": "true", "message": "Username available."}';
        }

        else
        {
            echo '{"result": "false", "message": "Username not available."}';
        }
        }

        else
        {
        echo '{"result": "false", "message": "Username not available."}';
        }
    }

    public function validate_mobile_number()
    {
        header('Content-Type: application/json');

        function anyError($error_code, $description, $file_name, $line)
        {
        $response = '{"statusCode":"500", "status":"Internal Server Error", "message":"Error Handler of Function Triggered", "description":"Custom Error Handler: ['.$error_code.'] '.$description.' - Error on line '.$line.' in '.$file_name.'."}';

        $CI =& get_instance();
        $CI->errorHandler($response);

        echo $response;
        exit();
        }
        set_error_handler('anyError');

        // VALIDATE TOKEN
        $signature = $this->validate_token();

        if($signature == 0)
        {
        $response = '{"statusCode":"498", "status":"Invalid Token", "message":"Signature Verification Failed", "description":"The token might not be set, invalid or expired."}';

        $this->errorHandler($response.' - public function validate_mobile_number() in Auth.php');
        echo $response;
        exit();
        }

        if(isset($_GET['mobile_number']) && $_GET['mobile_number'] != '')
        {
        // CHECK XSS
        $data = array
        (
            $_GET['mobile_number']
        );

        $response = array(
            'status_code' => '403',
            'status' => 'Forbidden',
            'message' => 'Malicious Data Has Been Detected',
            'description' => 'You have been banned.',
            'redirect' => 'ban?id=1'
        );
        $function = 'public function validate_mobile_number() in Auth.php';
        $ban_remarks = 'XSS were detected upon trying to validate the mobile number.';
        $ban_duration = 'PERMANENT';

        // PROCEED HERE IF IT IS CLEAN, IF NOT, BAN THE IP/USER AND THEN REDIRECT THEM TO BAN CONTROLLER
        $this->check_xss($data, $response, $function, $ban_remarks, $ban_duration);

        $mobile_number = $this->db->escape($_GET['mobile_number']);
        $mobile_number = str_replace(" ","", $mobile_number);

        $get_mobile_number = $this->db->query("SELECT MOBILE_NUMBER FROM tblaccount WHERE MOBILE_NUMBER = $mobile_number");

        if($get_mobile_number->result() == NULL)
        {
            echo '{"result": "true", "message": "Mobile number available."}';
        }

        else
        {
            echo '{"result": "false", "message": "Mobile number not available."}';
        }
        }

        else
        {
        echo '{"result": "false", "message": "Mobile number not available."}';
        }
    }
}