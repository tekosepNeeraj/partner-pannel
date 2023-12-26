<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/login');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);

            //pre($result); die;
            
            if (!empty($result))
            {
                if ($result->isAdmin != SYSTEM_ADMIN && ($result->roleStatus == 2 || $result->isRoleDeleted == 1))
                {
                    $this->session->set_flashdata('error', 'The user doesn\'t have any role or the role is deactivated');
                    redirect('login');
                }

                $lastLogin = $this->login_model->lastLoginInfo($result->userId);

                $accessInfo = $this->accessInfo($result->roleId);

                $sessionArray = array('userId'=>$result->userId,
                                        'role'=>$result->roleId,
                                        'roleText'=>$result->role,
                                        'name'=>$result->name,
                                        'isAdmin'=>$result->isAdmin,
                                        'accessInfo'=>$accessInfo,
                                        'lastLogin'=> $lastLogin->createdDtm,
                                        'isLoggedIn' => TRUE
                                );

                $this->session->set_userdata($sessionArray);

                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin'], $sessionArray['accessInfo']);

                $loginInfo = array("userId"=>$result->userId, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());

                $this->login_model->lastLogin($loginInfo);
                
                redirect('/dashboard');
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                redirect('login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = strtolower($this->security->xss_clean($this->input->post('login_email')));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo->name;
                        $data1["email"] = $userInfo->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('users/newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = strtolower($this->input->post("email"));
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password reset successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password reset failed';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }

    /**
     * This method use to build access information for modules from json to array.
     * @param number $roleId: This is role id
     * @return array $finalMatrixArray: This is converted array
     */
    private function accessInfo($roleId)
    {
        $finalMatrixArray = [];
        $matrix = $this->login_model->getRoleAccessMatrix($roleId);
        
        if(!empty($matrix)) {
            $accessMatrix = json_decode($matrix->access);
            foreach($accessMatrix as $moduleMatrix) {
                $finalMatrixArray[$moduleMatrix->module] = (array) $moduleMatrix;
            }
        }
        
        return $finalMatrixArray;
    }

    function partner_register(){
        $this->load->view('users/register');
    }
    
    function registerMe(){
        $password = '';
        $desired_length = rand(8, 12);
        for($length = 0; $length < $desired_length; $length++) {
          $password .= chr(rand(32, 126));
        }
            $dataArray=array(
                'product'=>trim($this->input->post('primary_product')),
                'partnertype'=>trim($this->input->post('partnertype')),
                'pancard'=>trim($this->input->post('pancard')),
				'name'=>trim($this->input->post('name')),
                'pin'=>trim($this->input->post('pincode')),
                'city'=>trim($this->input->post('city')),
                'state'=>trim($this->input->post('state')),
				'mobile'=>trim($this->input->post('mobile')),
                'email'=>trim($this->input->post('email')),
				'password'=>$password,
                'createdDtm'=>date('Y-m-d H:i:s')
			  );
			 $this->db->insert('tbl_users',$dataArray);
			 $lastId=$this->db->insert_id();
			 if($lastId)
			 {
                $otp = random_int(100000, 999999);
                $dataArray=array(
                    'mobile'=>trim($this->input->post('mobile')),
                    'number'=>$otp,
                    'created_at'=>date('Y-m-d H:i:s')
                  );
                $this->db->insert('tbl_otp',$dataArray);
			    $insertedId=$this->db->insert_id();
                if($insertedId){
                    $response['type'] = '1';
                    $response['msg'] = 'Registration has been successfully';
                    $response['redirect'] = '<?php echo base_url()?>login';
                    echo json_encode($response);
                }else{
                    $response['type'] = '0';
                    $response['msg'] = 'Failed to register try again';
                    $response['redirect'] = '';
                    echo json_encode($response);
                }
			 }else{
                $response['type'] = '0';
                $response['msg'] = 'Something Went wrong';
                $response['redirect'] = '';
                echo json_encode($response);
			 }
    }

    public  function varify_OTP(){
        $otp=trim($this->input->post('otpnumber'));
        $findOTP = $this->login_model->listRecord('tbl_otp',array('number'=>$otp));
        if(!empty($findOTP)){
            $response['type'] = '1';
            $response['msg'] = 'Registration has been successfully';
            $response['redirect'] ="<?php echo base_url();?>/login";
            echo json_encode($response);
        }else{
            $response['type'] = '0';
            $response['msg'] = 'Invalid OTP';
            $response['redirect'] = '';
            echo json_encode($response);

        }

    }
}

?>