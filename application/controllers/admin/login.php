<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 04/07/14
 * Time: 02:07
 */
class Login extends MY_frontend_controller
{
    function __construct()
    {
        parent::__construct();

        //load the user model
        $this->load->model('user_m');
    }

    function index()
    {
        $data['main_content']='admin/login_v';//login view
        $data['pagetitle']='User Login';//dynamic page title


        //if form is posted
        if($this->input->post('login_usr'))
        {
            //print_array($_POST);
            $config=array
            (
                //username
                array
                (
                    'field'   => 'username',
                    'rules'   => 'trim|required',
                    'label'   =>  'Username'
                ),

                //password
                array
                (
                    'field'   => 'password',
                    'rules'   => 'required',
                    'label'   =>  'Password'
                ),
            );

            //set rules
            $this->form_validation->set_rules($config);

            if($this->form_validation->run()== FALSE){
                //if there were errors add them to the errors array
                $data['errors']=validation_errors();

            }
            else
            {

                //var_dump($user_credentials);

                //if number is provided
                if(is_numeric($this->input->post('username')))
                {
                    //check by phone
                    //remove trailing zero
                    //check for trailing zero
                    if(substr($this->input->post('username'),0,1)==0)
                    {
                        $tel=substr($this->input->post('username'),1);
                    }
                    else
                    {
                        $tel=$this->input->post('username');
                    }

                    $user_credentials_by_tel=array
                    (
                        'tel'     => $tel,
                        'password'  => md5($this->input->post('password'))
                    );
                    //get user info
                    $user_info=$this->user_m->authenticate_user($user_credentials_by_tel);
                }
                else
                {
                    //check by email
                    $user_credentials=array
                    (
                        'email'     => $this->input->post('username'),
                        'password'  => md5($this->input->post('password'))
                    );

                    //check by email
                    //get user info
                    $user_info=$this->user_m->authenticate_user($user_credentials);
                }



               //echo  $this->db->last_query();

                //var_dump($user_info);

                //if user actually exists
                if($user_info)
                {
                    foreach($user_info as $info)
                    {
                        $user_id        =$info['id'];
                        $user_avatar    =$info['avatar'];
                        $usertype       =$info['usertype'];
                        $user_slug      =$info['slug'];
                    }

                    //update the last login field
                    $login_data=array
                    (
                        'lastlogin'=>mysqldate()
                    );

                    $this->user_m->update($user_id,$login_data);

                    //set session variebles

                    $logged_in_user_data = array
                    (
                        'username'              => $this->input->post('username'),
                        'email'                 => $this->input->post('username'),
                        'logged_in_user_id'     => $user_id,
                        'logged_in_usertype'    => $usertype,
                        'logged_in_user_avater'    => $user_avatar,
                        'logged_in'             => TRUE,
                        'user_id'               => $user_id,
                        'logged_in_user_slug'   =>$user_slug

                        //TODO save extra user info if available
                    );

                    //start session
                    $this->session->set_userdata($logged_in_user_data);

                    //redirect the user
                    redirect(base_url().'admin/dashboard');


                }else
                {
                    $data['errors']='Username/Password combination does not match';
                }

            }

        }

        //pass to view
        $this->load->view('admin/includes/login_template',$data);
    }


    //to logout user
    function logout(){
        //destroy the session

        $this->session->sess_destroy();
        //redirect to login page

        redirect(base_url().'admin/login');

    }

}