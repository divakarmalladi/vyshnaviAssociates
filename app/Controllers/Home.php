<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{
    private $encrypter;
    protected $request;
    private $validation;
    private $db;
    private $session;
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // Add your code here.
        $this->request = \Config\Services::request();
        $this->encrypter = \Config\Services::encrypter();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }
    
    public function index()
    {
        $data = [];
        return view('common/header', $data)
            . view('pages/home')
            . view('common/footer');
    }
    public function encryptDecryptString($text, $type)
    {
        if ($type === 'encrypt') {
            $text = bin2hex($this->encrypter->encrypt($text));
        } 
        elseif ($type === 'decrypt') {
            $text = $this->encrypter->decrypt(hex2bin($text));
        }
        return $text;
    }
    public function userLogin()
    {   
        
        if ($this->request->is('post')) {
            $userLoginData = $this->request->getJSON();
            $loginData = json_decode(json_encode($userLoginData), true);
            // echo '<pre>';print_r($loginData);echo '</pre>';exit;
            $this->validation->setRuleGroup('userLogin');
            if (!$this->validation->run($loginData)) {
                $errors = $this->validation->getErrors();
                $errors['status'] = 201;
                return json_encode($errors);
            } else {
                $builder = $this->db->table('va_users'); 
                $query = $builder->where('login_id', $loginData['login_id'])->orWhere('user_email',  $loginData['login_id'])->get(1,0);
                $resultData = $query->getResultArray();
                if (!empty($resultData)) {
                    $password = $this->encryptDecryptString($resultData[0]['user_password'], 'decrypt');
                    if ($password === $loginData['user_password'] && USER_TYPES[$loginData['user_type']] == $resultData[0]['user_type']) {
                        $this->session->set(['userData' => $resultData[0], 'loginId' => $resultData[0]['login_id'], 'userId' => $resultData[0]['user_id'] ]);
                        $this->session->loginId;
                        return json_encode(['status' => 200, 'message' => 'Loggedin Successfully']);
                    } else {
                        return json_encode(['status' => 201, 'user_password' => 'Password and Login Id not matched', 'message' => 'Invalid Logins']);
                    }
                    return json_encode($password);
                } else {
                    return json_encode(['status' => 201, 'login_id' => 'Login Id not existed', 'message' => 'Invalid Logins']);
                }
            }
            exit;
        } else {
            $data = [];
            $uri = service('uri'); 
            $data['userPath'] =  $uri->getSegment(1);
            $data['pageName'] = ucwords(str_replace('-',' ',$data['userPath']));
            // print_r($data);
            return view('common/header', $data)
                . view('pages/login', $data)
                . view('common/footer');
        }
        
    }
    public function createUser()
    {
        if ($this->request->is('post')) {
            $userRegData = $this->request->getJSON();
            $userData = json_decode(json_encode($userRegData), true);

            $password = $userData['user_password'];
            $confirmPassword = $userData['confirm_password'];
            $encPassowrd = $this->encryptDecryptString($password, 'encrypt');
            $userName = $userData['user_name'];
            $userEmail = $userData['user_email'];
            $userPhone = $userData['phone_number'];
            $userType = $userData['user_type'];
            $loginId = '2023VY001';
            $builder = $this->db->table('va_users'); 
            $userListData = $builder->orderBy('user_id', 'DESC')->get(0,1)->getRow();
            if (!empty($userListData)) {
                $loginId =  '2023VY0' . (str_pad(($userListData->user_id + 1), 3, '0', STR_PAD_LEFT));
            }

            $data = ['user_name' => $userName, 'user_email' => $userEmail, 'user_password' => $password, 'confirm_password' => $confirmPassword, 'phone_number' => $userPhone, 'login_id' => $loginId, 'user_type' => $userType, 'user_status' => '1' ];

            $this->validation->setRuleGroup('createUser');

            if (!$this->validation->run($data)) {
                $errors['errors'] = $this->validation->getErrors();
                $errors['status'] = 201;
                return json_encode($errors);
                exit;
            } else {
                $data['user_password'] = $encPassowrd;
                unset($data['confirm_password']);
                
                $builder = $this->db->table('va_users'); 
                $builder->insert($data);
                $insertId = $this->db->insertID();
                $redirectUrl = '';
            
                return json_encode(['message' => 'Registered Successfully, Please Login to Continue','status' => 200, 'page' => 'home', 'loginId' => $loginId, 'userId' => $insertId, 'redirectUrl' => $redirectUrl]);
                exit;
            }
        } else {
            $data = [];
            $uri = service('uri'); 
            $data['userPath'] =  $uri->getSegment(1);
            $data['pageName'] = ucwords(str_replace('-',' ',$data['userPath']));
            $data['userType'] = $uri->getSegment(2);
            $data['ajaxUrl'] =  'register';
            return view('common/header', $data)
                . view('pages/create-user', $data)
                . view('common/footer', $data);
        }
    }
    
    public function userLogout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}
