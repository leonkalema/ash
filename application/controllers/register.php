<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 10/15/14
 * Time: 7:53 AM
 */
class Register extends MY_frontend_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();


    }

    //admin home page
    function index()
    {
        //if there is an ajax post process it
        if($this->input->post('ajax'))
        {
            $str='';
            //switch depending on post type
            switch($this->input->post('ajax'))
            {
                //case of registering
                case 'register':
                    $config = array
                    (

                        array
                        (
                            'field'   => 'fname',
                            'label'   => 'First name',
                            'rules'   => 'required'
                        ),
                        array
                        (
                            'field'   => 'lname',
                            'label'   => 'Last name',
                            'rules'   => 'required'
                        ),
                        array
                        (
                            'field'   => 'email',
                            'label'   => 'Email',
                            'rules'   => 'valid_email|is_unique[users.email]'
                        ),

                        array
                        (
                            'field'   => 'tel',
                            'label'   => 'Telephone number',
                            'rules'   => 'required|numeric|is_unique[users.tel]|min_length[10]|max_length[10]|regex_match[/^07[0-9]{7,10}$/]|xss_clean'
                        ),

                        array
                        (
                            'field'   => 'usertype',
                            'label'   => 'Usertype',
                            'rules'   => 'required'
                        ),
                        array
                        (
                            'field'   => 'password',
                            'label'   => 'Password',
                            'rules'   => 'required|matches[cpassword]'
                        ),
                        array
                        (
                            'field'   => 'cpassword',
                            'label'   => 'Confirm Password',
                            'rules'   => 'required'
                        ),


                    );

                    $this->form_validation->set_rules($config);

                    $str='';

                    if ($this->form_validation->run() == FALSE)
                    {
                        //if there were errors add them to the errors array
                        $str.='<div class="alert alert-dismissable alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                        $str.=validation_errors();
                        $str.='</div>';
                    }
                    else
                    {
                        //gather user data
                        $user_data=array
                        (
                            'fname'     =>$this->input->post('fname'),
                            'lname'     =>$this->input->post('lname'),
                            'email'     =>$this->input->post('email'),
                            'usertype' =>$this->input->post('usertype'),
                            'password'  =>md5($this->input->post('password')),
                            'tel'       =>$this->input->post('tel'),
                            'dateadded' =>mysqldate()
                        );
                        if($this->user_m->create($user_data))
                        {
                            //echo $this->db->last_query();
                            //if there were errors add them to the errors array
                            $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3> ';
                            $str.='Registration was a success. You will be redirected shortly';
                            $str.= _countdown_redirect(base_url());//jquery_countdown_redirect(base_url().'admin/login');
                        }
                        else
                        {
                            //if there were errors add them to the errors array
                            $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                            $str.='User was not added. Please try one more time';
                            $str.='</div>';
                        }

                    }
                    break;
                default:
                    $str.='<div class="alert alert-info">No parameter passed to switch in users controller line 75</div>';
            }

            echo $str;
        }
        else
        {
            $data['main_content']='public/register_v';
            $data['pagetitle']='User registration';//dashboard title
            $data['page_description']='Register to get personalised feedback';//dashboard title





            //load the admin dashboard view
            $this->load->view('public/includes/frontend_template',$data);
            //redirect(base_url().'admin/login');
        }

    }

}
