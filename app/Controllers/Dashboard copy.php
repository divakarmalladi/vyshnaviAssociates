<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Dashboard extends BaseController
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
        if (!$this->session->loginId) {
            echo 'Permission Denied';
            //return $this->response->redirect(site_url('/'));
            header('Location:'. site_url('/'));
            exit;
            // return  redirect()->route('/');
        }
        
    }
    
    public function home()
    {
        $data = [];
        return view('common/header', $data)
            . view('pages/dashboard')
            . view('common/footer');
    }
    public function userList()
    {
        if ($this->session->userData['user_type'] == '3') {
            echo 'Restricted Access';
            return false;
        }
        $data = [];
        $builder = $this->db->table('va_users'); 
        $data['users'] = $builder->orderBy('user_id', 'DESC')->get()->getResultarray();
        return view('common/header', $data)
            . view('pages/users')
            . view('common/footer');
    }
    public function clientList()
    {
        $data = [];
        $builder = $this->db->table('va_clients');
        if ($this->session->userData['user_type'] == '3') {
            $data['clients'] = $builder->where('alloted_id', $this->session->userData['login_id'])->orderBy('client_id', 'ASC')->get()->getResultarray();
        } else {
            $data['clients'] = $builder->orderBy('client_id', 'ASC')->get()->getResultarray();
        }
        
        $userBuilder = $this->db->table('va_users'); 
        $data['users'] = $userBuilder->where(['user_type' => '3', 'user_status' => '1'])->orderBy('user_id', 'DESC')->get()->getResultarray();

        return view('common/header', $data)
            . view('pages/clients')
            . view('common/footer');
    }
    public function clientRegistration()
    {
        
        if ($this->request->is('post')) {
            $userRegData = $this->request->getJSON();
            $userData = json_decode(json_encode($userRegData), true);
            // echo '<pre>'; print_r($userData);
            $customerName = $userData['customer_name'];
            $ClientKey = 'CI';
            if ($customerName) {
                $names = explode(' ', $customerName);
                if (count($names) > 1) {
                    $ClientKey  = substr($names[0], 0,1).substr($names[1], 0,1);
                } else {
                    $ClientKey  = substr($customerName, 0,2);
                }
            }
            $address = $userData['address'];
            // $encPassowrd = $this->encryptDecryptString($password, 'encrypt');
            $reference = $userData['reference'];
            $aadharNumber = $userData['aadhar_number'];
            $dateOfBirth = $userData['date_of_birth'];
            $contactNumber = $userData['contact_number'];
            $loginId = $this->session->loginId;
            $typeOfProject = $userData['type_of_project'];
            // $clientId = $userData['client_id'];
            $customerId = $userData['customer_id'];
            $pageAction = $customerId ? 'edit' : 'add';
            if ($pageAction === 'add') {
                $builder = $this->db->table('va_clients'); 
                $userListData = $builder->orderBy('client_id', 'DESC')->get(0,1)->getRow();
                $year = date('Y'); 
                if (!empty($userListData)) {
                    $customerId =  $year.'VY0' . strtoupper($ClientKey) . (str_pad(($userListData->client_id + 1), 3, '0', STR_PAD_LEFT));
                } else {
                    $customerId = $year.'VY0' . strtoupper($ClientKey) . (str_pad((1), 3, '0', STR_PAD_LEFT));
                }
            }

            $data = ['customer_name' => $customerName, 'address' => $address, 'reference' => $reference, 'aadhar_number' => $aadharNumber, 'date_of_birth' => $dateOfBirth, 'type_of_project' => $typeOfProject, 'login_id' => $loginId, 'customer_id' => $customerId, 'customer_status' => '1', 'status' => '1', 'contact_number' => $contactNumber ];

            $this->validation->setRuleGroup('clientRegistration');
            if (!$this->validation->run($data)) {
                $errors['errors'] = $this->validation->getErrors();
                $errors['status'] = 201;
                return json_encode($errors);
                exit;
            } else {
                $builder = $this->db->table('va_clients'); 
                if ($pageAction === 'add') {
                    $builder->insert($data);
                    $insertId = $this->db->insertID();
                    $redirectUrl = base_url().'/clients';
                } else {
                    $insertId = $this->db->escapeString($data['customer_id']);
                    unset($data['customer_id']);
                    $builder->where('customer_id', $insertId);
                    $builder->update($data);
                    $redirectUrl = '';
                }
                
                return json_encode(['message' => ($pageAction === 'add' ? 'Registered': 'Updated').' Successfully','status' => 200, 'page' => 'dashboard', 'userId' => $insertId, 'redirectUrl' => $redirectUrl]);
                exit;
            }
        } else {
            $data = [];
            $uri = service('uri'); 
            $data['userPath'] =  $uri->getSegment(1);
            $data['pageName'] = ucwords(str_replace('-',' ',$data['userPath']));
            $data['customerId'] = $uri->getSegment(2);
            $data['ajaxUrl'] =  'client-registration';
            if (!$data['customerId'] && $this->session->userData['user_type'] == '3') {
                echo 'Restricted Access';
                return false;
            }
            if ($data['customerId']) {
                $builder = $this->db->table('va_clients'); 
                $userListData = $builder->where('customer_id', $this->db->escapeString($data['customerId']))->orderBy('client_id', 'DESC')->get(0,1)->getRow();
                if (!empty($userListData)) {
                    $data['clientData'] = $userListData;
                    if ($userListData->alloted_id !== $this->session->loginId && $this->session->userData['user_type'] == '3') {
                        echo 'Restricted Access';
                        return false;
                    }
                } elseif (empty($userListData) && $data['userPath'] == 'edit-client') {
                    echo 'Restricted Access';
                        return false;
                }

                $docbuilder = $this->db->table('va_client_documents'); 
                $docData = $docbuilder->where('customer_id', $this->db->escapeString($data['customerId']))->get()->getResultArray();
                if (!empty($docData)) {
                    $docInfo = [];
                    foreach($docData as $key => $val) {
                        $docInfo[$val['checklist']][$val['subchecklist']][] = $val;
                    }
                    $data['docData'] = $docInfo;
                }
                // echo '<pre>'; print_r($data); echo '</pre>';

                $notebuilder = $this->db->table('va_clients_notes'); 
                $noteData = $notebuilder->where('status', '1')->get()->getResultArray();
                if (!empty($noteData)) {
                    $noteInfo = [];
                    foreach($noteData as $key => $val) {
                        $noteInfo[$val['checklist']][$val['note_id']] = $val;
                    }
                    $data['noteData'] = $noteInfo;
                }

            }
            return view('common/header', $data)
                . view('pages/client-registration')
                . view('common/footer');
        }
    }
    public function uploadDocs()
    {
        if ($this->request->is('post')) {
            
            $file_name = str_replace('formFileSm', '', $_POST['file_name']);
            $checklist = preg_replace('/[0-9]/','',$file_name);
            $subChecklist = filter_var($file_name, FILTER_SANITIZE_NUMBER_INT);
            $subChecklistName = strtolower(str_replace(' ', '_',preg_replace('/[^a-zA-Z ]/','',CHECK_LIST_SUB_ITEMS[$checklist][$subChecklist]))); 
            $customerId = $_POST['customer_id'];
            // echo '<pre>'; print_r($_FILES['verifyDocs']['name'][$checklist][$subChecklist]); print_r($_FILES); echo '</pre>';exit;
        foreach ($_FILES['verifyDocs']['name'][$checklist][$subChecklist] as $fileKey => $fileVal) {

            
            $uploadedFileName = $_FILES['verifyDocs']['name'][$checklist][$subChecklist];
            $file_extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
            // $fileNametoBeSave = $checklist.'_'.$subChecklist.'_'.$customerId.'.'.$file_extension;
            $fileNametoBeSave = $subChecklistName.'.'.$file_extension;
            // $mainFolderPath = './documents/'.$customerId;
            // $folderPath = './documents/'.$customerId.'/'.$checklist;
            $mainFolderPath = '\\\\DESKTOP-MGHQQLT\fileUploads/'.$customerId;
            $folderPath = '\\\\DESKTOP-MGHQQLT\fileUploads/'.$customerId.'/'.$checklist;
            
            if (!is_dir($mainFolderPath)) {
                mkdir($mainFolderPath, 0777, TRUE);
            }
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, TRUE);
            }
            
            $uploadData = ['customer_id' => $customerId, 'user_id' => $this->session->loginId, 'file_name'=> $fileNametoBeSave, 'file_path' => $folderPath, 'actual_file_name' => $uploadedFileName, 'checklist' => $checklist, 'subchecklist' => $subChecklist, 'status' => '1', 'file_status' => '1'];

            $builder = $this->db->table('va_client_documents'); 
            $message = '';
            $docData = $builder->where(['customer_id' => $this->db->escapeString($customerId), 'checklist' => $checklist, 'subchecklist' => $subChecklist])->get(0,1)->getRow();
            if (!empty($docData)) {
                if (file_exists($docData->file_path.'/'.$docData->file_name)) {
                    unlink($docData->file_path.'/'.$docData->file_name);
                }
                $uploadStatus = move_uploaded_file($_FILES['verifyDocs']['tmp_name'][$checklist][$subChecklist], $folderPath.'/'.$fileNametoBeSave);
                if ($uploadStatus) {
                    $message = 'File Updated Successfully';
                } else {
                    $message = 'Something went wrong, Please try again';
                }
                
                $docId = $this->db->escapeString($docData->doc_id);
                unset($uploadData['customer_id']);
                unset($uploadData['status']); unset($uploadData['file_status']);
                unset($uploadData['checklist']); unset($uploadData['subchecklist']);
                $builder->where('doc_id', $docId);
                $builder->update($uploadData);
            } else {
                $uploadStatus = move_uploaded_file($_FILES['verifyDocs']['tmp_name'][$checklist][$subChecklist], $folderPath.'/'.$fileNametoBeSave);
                if ($uploadStatus) {
                    $builder->insert($uploadData);
                    $docId = $this->db->insertID();
                    $message = 'File Uploaded Successfully';
                } else {
                    $message = 'Something went wrong, Please try again';
                }
            }
        } 
            return json_encode(['message' => $message, 'status' => 200, 'page' => 'dashboard', 'customerId' => $customerId, 'checklist' => $checklist, 'subchecklist' => $subChecklist, 'file_path' => $fileNametoBeSave, 'doc_id' => $docId, 'redirectUrl' => '']);
            exit;
            
        }
    }
    public function viewOrDownloadFile()
    {
        $uri = service('uri');
        $page =  $uri->getSegment(1);
        $fileId =  $uri->getSegment(2);
        $builder = $this->db->table('va_client_documents'); 
        $docData = $builder->where('doc_id', $this->db->escapeString($fileId))->get(0,1)->getRow();
        if (!empty($docData)) {
            if (file_exists($docData->file_path.'/'.$docData->file_name)) {
                // if ($page == 'view-file') {
                //     $mimeType = mime_content_type($docData->file_path.'/'.$docData->file_name);
                //     $this->response->setHeader('Content-Type', $mimeType)->setHeader('Content-Disposition', 'inline;filename='.$docData->file_path.'/'.$docData->file_name);
                // } else {
                    return $this->response->download($docData->file_path.'/'.$docData->file_name, null)->setFileName($docData->customer_id.'-'.$docData->checklist.'-'.$docData->file_name);
                // }
            }
        }
    }

    public function saveNotes()
    {
        if ($this->request->is('post')) {
            $userRegData = $this->request->getJSON();
            $userData = json_decode(json_encode($userRegData), true);
            $notes = $userData['notes'];
            $action = isset($userData['action'])?$userData['action']:'';
            $loginId = $this->session->loginId;
            if (!$notes) {
                $errors['errors'] = 'Something went wrong, Please try again';
                $errors['status'] = 201;
                return json_encode($errors);
                exit;
            } else {
                $builder = $this->db->table('va_clients_notes'); 
                if ($action == 'update') {
                    $data = ['notes' => $notes, 'user_id' => $loginId];
                    $insertId = $this->db->escapeString($userData['note_id']);
                    $builder->where('note_id', $insertId);
                    $builder->update($data);
                    
                } else {
                    $checklist = $userData['checklist'];
                    $customer_id = $userData['customer_id'];
                    $data = ['notes' => $notes, 'checklist' => $checklist, 'customer_id' => $customer_id, 'user_id' => $loginId, 'status' => '1' ];
                    $builder->insert($data);
                    $insertId = $this->db->insertID();
                }
                return json_encode(['message' => 'Notes Saved Successfully','status' => 200, 'notesId' => $insertId, 'userId' => $loginId]);
                exit;
            }
        }
    }
    public function deleteNotes()
    {
        if ($this->request->is('post')) {
            $postData = $this->request->getJSON();
            $delData = json_decode(json_encode($postData), true);
            $noteId = $delData['noteId'];
            $builder = $this->db->table('va_clients_notes'); 
            $noteData = $builder->where('note_id', $this->db->escapeString($noteId))->get(0,1)->getRow();
            if (!empty($noteData)) {
                $builder->delete(['note_id' => $this->db->escapeString($noteId)]);
                $affectedRows = $this->db->affectedRows();
                if ($affectedRows > 0) {
                    return json_encode(['message' => 'Note Deleted successfully','status' => 200]);
                }   
            } else {
                return json_encode(['message' => 'Something went wrong, Please try again','status' => 500]);
            }
        }
    }
    public function updateFileStatus()
    {
        if ($this->request->is('post')) {
            $userRegData = $this->request->getJSON();
            $userData = json_decode(json_encode($userRegData), true);
            $customer_id = $userData['customerId'];
            $text = $userData['notesText'];
            $fileStatus = $userData['fileStatus'];
            $loginId = $this->session->loginId;
            $data = ['file_status_code' => $fileStatus, 'file_text' => $text, 'login_id' => $loginId];
            if (!$fileStatus) {
                $errors['errors'] = 'Something went wrong, Please try again';
                $errors['status'] = 201;
                return json_encode($errors);
                exit;
            } else {
                $builder = $this->db->table('va_clients'); 
                $customer_id = $this->db->escapeString($customer_id);
                $builder->where('customer_id', $customer_id);
                $builder->update($data);
                return json_encode(['message' => 'File status updated successfully','status' => 200]);
                exit;
            }
        }
    }
    public function allotClientToEmployee()
    {
        if ($this->request->is('post')) {
            $userRegData = $this->request->getJSON();
            $userData = json_decode(json_encode($userRegData), true);
            $customer_id = $userData['customerId'];
            $loginId = $userData['loginId'];
            $data = ['alloted_id' => $loginId];
            if (!$loginId) {
                $errors['errors'] = 'Something went wrong, Please try again';
                $errors['status'] = 201;
                return json_encode($errors);
                exit;
            } else {
                $builder = $this->db->table('va_clients'); 
                $customer_id = $this->db->escapeString($customer_id);
                $builder->where('customer_id', $customer_id);
                $builder->update($data);
                return json_encode(['message' => 'Client allotted successfully','status' => 200]);
                exit;
            }
        }
    }
    public function deleteClient()
    {
        $uri = service('uri'); 
        $data['customer_id'] = $uri->getSegment(2);
        $builder = $this->db->table('va_clients'); 
        $userListData = $builder->where('customer_id', $this->db->escapeString($data['customer_id']))->get(0,1)->getRow();
        if (!empty($userListData)) {
            
        
            $builder->delete(['customer_id' => $this->db->escapeString($data['customer_id'])]);
            $affectedRows = $this->db->affectedRows();
            if ($affectedRows > 0) {
                $docBuilder = $this->db->table('va_client_documents');
                $docBuilder->delete(['customer_id' => $this->db->escapeString($data['customer_id'])]);

                $noteBuilder = $this->db->table('va_clients_notes');
                $noteBuilder->delete(['customer_id' => $this->db->escapeString($data['customer_id'])]);

                $mainFolderPath = './documents/'.$data['customer_id'];
                if (is_dir($mainFolderPath)) {
                    $files = glob($mainFolderPath.'/*'); // get all file names
                    foreach($files as $file){ // iterate files
                        if(is_dir($file)) {
                            $filessub = glob($file.'/*'); 
                            foreach($filessub as $filesub){
                                if(is_file($filesub)) {
                                    unlink($filesub); // delete file
                                }
                            }
                            rmdir($file);
                        }
                    }
                    rmdir($mainFolderPath);
                }
                
                return $this->response->redirect(site_url('/clients'));
            }   
        }
        return $this->response->redirect(site_url('/dashboard'));
    }
    public function deleteFile()
    {
        if ($this->request->is('post')) {
            $postData = $this->request->getJSON();
            $delData = json_decode(json_encode($postData), true);
            $customerId = $delData['customerId'];
            $fileId = $delData['fileId'];
            // $data = ['alloted_id' => $loginId];

            $builder = $this->db->table('va_client_documents'); 
            $fileData = $builder->where('doc_id', $this->db->escapeString($fileId))->get(0,1)->getRow();
            // echo '<pre>';print_r($fileData);exit;
            if (!empty($fileData)) {
                $builder->delete(['doc_id' => $this->db->escapeString($fileId)]);
                $affectedRows = $this->db->affectedRows();
                if ($affectedRows > 0) {
                    $filePath = $fileData->file_path.'/'.$fileData->file_name;
                    if(is_file($filePath)) {
                        unlink($filePath); // delete file
                        return json_encode(['message' => 'File Deleted successfully','status' => 200]);
                    }
                }   
            } else {
                return json_encode(['message' => 'Something went wrong, Please try again','status' => 500]);
            }
        }
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
            $loginId = $userData['login_id'];
            $pageAction = $loginId ? 'edit' : 'add';
            if ($pageAction === 'add') {
                $builder = $this->db->table('va_users'); 
                $userListData = $builder->orderBy('user_id', 'DESC')->get(0,1)->getRow();
                if (!empty($userListData)) {
                    if ($userType == '2') {
                        $loginId =  'VYSHNAVI' . (str_pad(($userListData->user_id + 1), 2, '0', STR_PAD_LEFT));
                    } else {
                        $loginId =  '2023VY0' . (str_pad(($userListData->user_id + 1), 3, '0', STR_PAD_LEFT));
                    }
                }
            }

            $data = ['user_name' => $userName, 'user_email' => $userEmail, 'user_password' => $password, 'confirm_password' => $confirmPassword, 'phone_number' => $userPhone, 'login_id' => $loginId, 'user_type' => $userType, 'user_status' => '1' ];

            // Need to Validate Form Data
            // echo '<pre>'; print_r($data); echo '</pre>';exit;
            $this->validation->setRuleGroup('createUser');
            // $this->validation->setRule('user_email', 'Email', 'required|min_length[3]');
            if (!$this->validation->run($data)) {
                $errors['errors'] = $this->validation->getErrors();
                $errors['status'] = 201;
                return json_encode($errors);
                exit;
            } else {
                $data['user_password'] = $encPassowrd;
                unset($data['confirm_password']);
                
                $builder = $this->db->table('va_users'); 
                if ($pageAction === 'add') {
                    $builder->insert($data);
                    $insertId = $this->db->insertID();
                    $redirectUrl = base_url().'/users';
                } else {
                    $insertId = $this->db->escapeString($data['login_id']);
                    unset($data['login_id']);
                    $builder->where('login_id', $insertId);
                    $builder->update($data);
                    $redirectUrl = '';
                }
                
                return json_encode(['message' => ($pageAction === 'add' ? 'Registered': 'Updated').' Successfully','status' => 200, 'page' => 'dashboard', 'userId' => $insertId, 'redirectUrl' => $redirectUrl]);
                exit;
            }
        } else {
            $data = [];
            $uri = service('uri'); 
            $data['userPath'] =  $uri->getSegment(1);
            $data['pageName'] = ucwords(str_replace('-',' ',$data['userPath']));
            $data['loginId'] = $uri->getSegment(2);
            $data['ajaxUrl'] =  'add-user';
            if ($data['userPath'] != 'edit-profile' && $this->session->userData['user_type'] == '3') {
                echo 'Restricted Access';
                return false;
            }
            if ($data['loginId']) {
                $builder = $this->db->table('va_users'); 
                $userListData = $builder->where('login_id', $this->db->escapeString($data['loginId']))->orderBy('user_id', 'DESC')->get(0,1)->getRow();
                if (!empty($userListData)) {
                    $userListData->user_password = $this->encryptDecryptString($userListData->user_password, 'decrypt');
                    $userListData->confirm_password = $userListData->user_password;
                    $data['userData'] = $userListData;
                }
            }
            // print_r($data);
            return view('common/header', $data)
                . view('pages/create-user', $data)
                . view('common/footer', $data);
        }
    }

    public function deleteUser()
    {
        $uri = service('uri'); 
        $data['loginId'] = $uri->getSegment(2);
        $builder = $this->db->table('va_users'); 
        $userListData = $builder->where('login_id', $this->db->escapeString($data['loginId']))->orderBy('user_id', 'DESC')->get(0,1)->getRow();
        if (!empty($userListData)) {
            $builder->delete(['login_id' => $this->db->escapeString($data['loginId'])]);
            echo $affectedRows = $this->db->affectedRows();
            if ($affectedRows > 0) {
                return $this->response->redirect(site_url('/users'));
            }
        }
    }
    
}
