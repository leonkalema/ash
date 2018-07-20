<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * controls tha administrators view
 */

class Dashboard extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('user_m');

        //load user type model model

    }

    //admin home page
    function index()
    {
        $data['main_content']='admin/dashboard_home';//the dashboard view
        $data['pagetitle']='Dashboard';//dashboard title
        if($this->session->userdata('logged_in_usertype')==1)
        {
            $data['page_description']='ACODE';//dashboard title
        }elseif($this->session->userdata('logged_in_usertype')==2){
            $data['page_description']='Project Manager';//dashboard title
        }else
        {
            $data['page_description']='User Profile';//dashboard title
        }

        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);//pass to view
    }

}
