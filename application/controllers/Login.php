<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	private $nik;

	private $password;

	public $captcha_component;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('maccount', 'account');

		$this->load->library('email');
		
		$this->nik = $this->input->post('nik');

		$this->password = $this->input->post('password');

		$this->captcha_component = array(
			'word' => '', 
			'word_length' => 4, 
			'img_path' => './public/captcha/',   
			'img_url' => base_url() .'public/captcha/',
			'font_path' => FCPATH . 'system/fonts/arial.ttf',
			'img_width' => '250',
			'img_height' => 65,  
			'font_size' => 25,
			'expiration' => 3600 ,
	        'colors'        => array(
	           	'background' => array(255, 255, 255),
	           	'border' => array(255, 255, 255),
	           	'text' => array(225,180,51),
	           	'grid' => array(40, 40, 40)
	        )
		);
	}

	public function index()
	{
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_validate_captcha');

		$data['captcha'] = create_captcha($this->captcha_component);
		
        if ($this->form_validation->run() == FALSE)
        {
		 	$this->session->set_userdata( array('captcha' => $data['captcha']) );

            $this->load->view('login-form', $data);
        } 
        else 
        {
        	$nik = $this->input->post('nik');
        	$password = $this->input->post('password');

        	/* get data account */
        	$account = $this->_get_account($nik);

        	/* authentifaction dengan password verify */
        	if (password_verify($password, $account->password)) 
        	{
                $this->db->update('users', array('login_status' => 1), array('user_id' => $account->user_id));

        		/* set session data */
        		$this->_set_account_login($account);

        		/* if session destroy in other page */
        		if( $this->input->get('from_url') != '')
        		{
        			redirect( $this->input->get('from_url') );
        		} else {
        			redirect('main');
        		}
        	} else {
				$this->template->alert(
					'Nik dan password tidak valid.', 
					array('type' => 'danger','icon' => 'times')
				);
        		$this->load->view('login-form', $data);
        	}
        }
	}

	/**
	 * Take a data  accounts
	 *
	 * @param String (nik)
	 * @access private
	 * @return Object
	 **/
	private function _get_account($param = 0)
	{
		$query = $this->db->get_where('users', array('nip' => $param, 'active' => 1));

		if($query->num_rows() == 1)
		{
			return $query->row();
		} else {
			return (Object) array('password' => '');
		}
	}

	/**
	 * Create Login Session
	 *
	 * @param String
	 * @access private
	 * @return void 
	 **/
	private function _set_account_login($account)
	{
		$this->delete_captcha();

        $account_session = array(
        	'authentifaction' => TRUE,
        	'ID' => $account->user_id,
        	'account' => $account
        );	
        $this->session->set_userdata( $account_session );
	}

	/**
	 * Sign Out session Destroy
	 *
	 * @return Void (destroy session)
	 **/
	public function signout()
	{
        $this->db->update('users', array('login_status' => 0), array('user_id' => $this->session->userdata('ID') ));

		$this->session->sess_destroy();

		redirect($this->input->get('from_url'));
	}

	public function delete_captcha()
	{
        if(isset($this->session->userdata['image']))
        {
            $lastImage = FCPATH . "public/captcha/" . $this->session->userdata['image'];

            if(file_exists($lastImage))
                unlink($lastImage);
        }

        return;
    }

	public function captcha_refresh()
	{
		$captcha = create_captcha($this->captcha_component);

		echo $captcha['word'];
	}

	public function validate_captcha()
	{
	    if($this->input->post('captcha') != $this->session->userdata('captcha')['word'])
	    {
	    	if(!$this->input->post('captcha'))
	    	{
		        $this->form_validation->set_message('validate_captcha', 'Kode Captcha ini diperlukan.');
		        
		        return false;
	    	}
	        
	        $this->form_validation->set_message('validate_captcha', 'Kode Captcha yang anda masukkan salah.');
	        
	        return false;
	   
	    } else {
	        return true;
	    }
	}


    

    public function reset_password()  
    {  
       	$token = $this->base64url_decode($this->uri->segment(4));       

       	$cleanToken = $this->security->xss_clean($token);  
         
       	$user_info = $this->account->isTokenValid($cleanToken);     
         
       	if( ! $user_info ) 
       	{  
			$this->template->alert(
				'Token tidak valid atau kadaluarsa', 
				array('type' => 'danger','icon' => 'times')
			);
 
         	redirect(site_url('login'),'refresh');   
       	}    
   
       	$data = array(  
         	'title'=> 'Halaman Reset Password',  
         	'nama'=> $user_info->name,   
         	'email'=>$user_info->email,   
         	'token'=>$this->base64url_encode($token)  
       	);  
         
       	$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');  
       	$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');         
         
       	if ($this->form_validation->run() == FALSE) 
       	{    
         	$this->load->view('user/account/v_reset_password', $data);  
       	} else {  
                           
         	$post = $this->input->post(NULL, TRUE);          
         	
         	$cleanPost = $this->security->xss_clean($post);          
         	
         	$hashed = password_hash($cleanPost['password'], PASSWORD_DEFAULT);          
         	
         	$cleanPost['password'] = $hashed;  
         	
         	$cleanPost['user_id'] = $user_info->user_id;  
         	
         	unset($cleanPost['passconf']);      

         	if(!$this->account->updatePassword($cleanPost)) 
         	{  
    			$this->template->alert(
    				'Update password gagal.', 
    				array('type' => 'danger','icon' => 'times')
    			);
         	} else {  
    			$this->template->alert(
    				'Password anda sudah diperbaharui. Silakan login.', 
    				array('type' => 'success','icon' => 'check')
    			);
         	}  

         	redirect(site_url('login'),'refresh');         
       	}  
    }  

   	public function base64url_encode($data) 
   	{   
    	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');   
   	}   
   
   	public function base64url_decode($data) 
   	{   
    	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));   
   	} 

    /**
     * Check Login Via AJAX
     *
     * @return Boolean
     **/
    public function login_check_status()
    {
        if($this->session->has_userdata('android_login')==FALSE)
        {
            $this->db->update('users', array('login_status' => 0), array('user_id' => $this->session->userdata('ID') ));

            $this->data = array(
                'status' => 'error'
            );
        } else {
            $this->data = array(
                'status' => 'success'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));
    }
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */