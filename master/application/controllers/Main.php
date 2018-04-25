<?php
    class Main extends CI_Controller{
        public function __construct(){
            parent::__construct();
            //$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
            $this->load->library('ion_auth');
            $this->load->helper('form');
        }
        
        public function index(){
            if (!$this->ion_auth->logged_in())
            {
                redirect('login');
            } else {
                echo "Hello";
            }
        }

        public function view($main = 'home'){
            if ( ! file_exists(APPPATH.'views/main/'.$main.'.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            } else {
                $data['title'] = ucfirst($main); // Capitalize the first letter

                $this->load->view('templates/header', $data);
                $this->load->view('main/'.$main, $data);
                $this->load->view('templates/footer', $data);
            }
        }

        public function login(){
            if(!$this->input->post()){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('identity', 'Identity', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('remember', 'Remember me', 'integer');
                if($this->form_validation->run()===FALSE){
                    $data['message'] = '';
                    $data['identity'] = '';
                    $data['password'] = '';
                    $this->load->view('auth/login', $data);
                } else {
                    $identity = $this->input->post('identity');
                    $password = $this->input->post('password');
                    $message = $this->input->post('message');
                    if($this->ion_auth->login($identity, $password, $message)){
                        redirect('home');
                    }
                }
            } 
            /*if($this->input->post()){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('identity', 'Identity', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('remember', 'Remember me', 'integer');
                if($this->form_validation->run()===FALSE){
                    $message = "error";
                    $identity = '';
                    $password = '';
                    if(!$this->ion_auth->login($identity, $password, $message)){
                        $this->load->view('auth/login');
                    }
                } else {
                    $remember = (bool) $this->input->post('remember');
                    $identity = $this->input->post('identity');
                    $password = $this->input->post('password');
                    $this->load->view('auth/login');
                }
            }*/
        }

        public function register(){
            $data['message'] = "";
            $data['first_name'] = '';
            $data['last_name'] = '';
            $data['identity'] = '';
            $data['identity_column'] = '';
            $data['company'] = '';
            $data['email'] = '';
            $data['phone'] = '';
            $data['password'] = '';
            $data['password_confirm'] = '';
            $this->load->view('auth/create_user', $data);
        }
    }
?>