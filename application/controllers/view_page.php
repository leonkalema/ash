<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 7:44 AM
 */
class View_page extends MY_frontend_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load dependencies
        $this->load->model('category_m');
        $this->load->model('page_m');
    }

    function index()
    {
        //verify category
        //print_array($this->category_m->get_all());
        $where=array
        (
            'slug'=>$this->uri->segment(2)
        );

        //if it exists verify page as well
        if($this->category_m->get_where($where))
        {
            $where=array
            (
                'slug'=>$this->uri->segment(3)
            );
            //print_array($this->page_m->get_all());
            if($this->page_m->get_where($where))
            {
                $data['main_content']='public/page_details_v';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(3)));//dashboard title
                $data['page_description']=ucwords(remove_dashes($this->uri->segment(2)).' | '.remove_dashes($this->uri->segment(3)));//dashboard title
                $data['page_info']=$this->page_m->get_where($where);

                //load the admin dashboard view
                $this->load->view('public/includes/frontend_template',$data);

            }
            else
            {
                //if page does not exist
                show_404();
            }

        }
        else
        {
            show_404();
        }

    }
}