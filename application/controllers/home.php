<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 10/15/14
 * Time: 7:53 AM
 */
class Home extends MY_frontend_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        $this->load->model('visitor_counter_m');
        $this->load->model('from_dump_yard_m');

    }

    //admin home page
    function index()
    {

        //load statistics
        if($this->input->post('ajax'))
        {
            switch($this->input->post('ajax'))
            {
                //case of refreshing statistics
                case 'refresh_stats':
                    $this->load->view('admin/parts/topright_statistics');
                    break;
            }

        }else
        {
            //$this->db->show_tables();
            $data['main_content']='public/home_v';
            $data['pagetitle']='ACODE';//dashboard title
            $data['page_description']='Interactive sms platform';//dashboard title

            //Show all general messages
            $data['all_messages']=$this->from_dump_yard_m->get_all($trashed='n');

            //load the admin dashboard view
            $this->load->view('public/includes/frontend_template',$data);
            //redirect(base_url().'admin/login');
        }


    }

}
