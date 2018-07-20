<?php 
/*
#Author: Cengkuru Micheal
8/21/14
2:20 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('user_m');

        $this->load->model('user_additional_info_m');
        $this->load->model('project_subscription_m');
        $this->load->model('project_magement_m');

        $this->load->model('district_m');
        $this->load->model('parish_m');
        $this->load->model('sub_county_m');
		
		$this->load->library('cezpdf');
		$this->load->helper('url');
    }

    //admin home page
    function index()
    {	
        //redirect to page
        redirect(base_url() .$this->uri->segment(1).'/' . $this->uri->segment(2) . '/page');
    }

    function page()
    {
        $data['main_content']=$this->uri->segment(1).'/users_home';
        $data['pagetitle']='Users';
        $data['page_description']='All registered users';

        $data['all_users']=$this->user_m->get_all();

        $limit=25;
        $data['all_users_paginated']= $this->user_m->get_paginated($num=$limit,$this->uri->segment(4));
        //pagination configs
        $config=array
        (
            'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows'        => count($data['all_users']),
            'per_page'          => $limit,
            'num_links'         => $limit,
            'use_page_numbers'  => TRUE,
            'full_tag_open'     => '<div class="btn-group">',
            'full_tag_close'    => '</div>',
            'anchor_class'      => 'class="btn" ',
            'cur_tag_open'      => '<div class="btn">',
            'cur_tag_close'     => '</div>',
            'uri_segment'       => '4'

        );
        //initialise pagination
        $this->pagination->initialize($config);

        //add to data array
        $data['pages']=$this->pagination->create_links();
        //load view

        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);

    }

    function add()
    {
        //if form is posted
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
                            'rules'   => 'required|numeric|is_unique[users.tel]|min_length[10]|max_length[10]|is_unique[users.tel]|regex_match[/^07[0-9]{7,10}$/]|xss_clean'
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

                        $id = $this->user_m->create($user_data);
                        if($id > 0)
                        {
                            if($this->input->post('usertype') == 2)
                            {
                                $proj_data = array
                                (
                                    'projectid' => $this->input->post('projectid'),
                                    'userid' => $id,
                                    'datecreated' =>mysqldate(),
                                    'trash' => 'n',
                                );

                                $this->project_magement_m->create($proj_data);
                            }

                            //echo $this->db->last_query();
                            //if there were errors add them to the errors array
                            $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                            $str.='User was successfully added';
                            $str.=jquery_clear_fields();
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

                //getting projects
                case 'get_projects':
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Select project</label>
                        <div class="col-md-10">
                            <select id="project_id" required class="form-control">
                                <option disabled selected> --select project-- </option>
                                <?php

                                foreach(get_active_projects() as $project)
                                {

                                    ?>
                                    <option  value="<?=$project['id']?>"><?=ucwords($project['title'])?></option>

                                <?php


                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <?php

                    break;
                default:
                    $str.='<div class="alert alert-info">No parameter passed to switch in users controller line 75</div>';
            }

            echo $str;
        }
        else
        {
            //by default
            $data['main_content']='admin/new_user_v';
            $data['pagetitle']='Add a user';
            $data['page_description']='Register a new user';

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }
    }

    function edit()
    {
        if($this->input->post('ajax'))
        {
            //print_array($_POST);
            $str='';
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
                    'rules'   => 'valid_email|required'
                ),

                array
                (
                    'field'   => 'usertype',
                    'label'   => 'Usertype',
                    'rules'   => 'required'
                ),
                array
                (
                    'field'   => 'tel',
                    'label'   => 'Telephone number',
                    'rules'   => 'required|numeric|min_length[10]|max_length[10]|regex_match[/^07[0-9]{7,10}$/]|xss_clean'
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
                    'tel'       =>$this->input->post('tel'),
                    'dateadded' =>mysqldate()
                );
                if($this->user_m->update($this->input->post('id'),$user_data))
                {
                    //echo $this->db->last_query();
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                    $str.='Content was successfully Edited';
                    $str.='</div>';
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                    $str.='Content was not Edited. Please try one more time';
                    $str.='</div>';
                }

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $user_id=$this->user_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if user exists
            if($user_id)
            {
                //by default
                $data['main_content']='admin/edit_user_v';
                $data['pagetitle']='Edit user';
                $data['page_description']='Edit '.ucwords(get_user_info_by_id($user_id,'fullname'));
                $data['user_info']=$this->user_m->get_by_id($user_id);


                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);


            }
            else
            {
                show_404();
            }
        }

    }

    //Edit password
    function edit_password()
    {
        if($this->input->post('ajax'))
        {
            //print_array($_POST);
            $str='';
            $config = array
            (
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
                    'password'  =>md5($this->input->post('password')),
                );

                if($this->user_m->update_by('id',$this->input->post('id'),$user_data))
                {
                    //echo $this->db->last_query();
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Notice !</h3> ';
                    $str.='Password was successfully Edited';
                    $str.='</div>';
                }
                else
                {
                    echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Warning!</h3> ';
                    $str.='Password was not Edited. Please try one more time';
                    $str.='</div>';
                }

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $user_id=$this->user_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if user exists
            if($user_id)
            {
                //by default
                $data['main_content']='admin/edit_user_password_v';
                $data['pagetitle']='Edit user password';
                $data['page_description']='Edit '.ucwords(get_user_info_by_id($user_id,'fullname'));
                $data['user_info']=$this->user_m->get_by_id($user_id);


                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);


            }
            else
            {
                show_404();
            }
        }

    }

    function ajax_calls()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            //switch ajax calls accordingly
            switch($this->input->post('ajax'))
            {
                case 'src_users':
                    //search for user
                    $get_result=$this->user_m->search_by_name($name=$this->input->post('src_term'));
                    if($get_result)
                    {

                        //echo count($get_result);
                        foreach($get_result as $user)
                        {
                            if(get_usertype($user['user_type'],'trash')=='n')
                            {
                                ?>
                                <tr>
                                    <td><input type="checkbox" class=""></td>
                                    <td><img style="width: 32px; height: 32px;" class="img-circle" src="<?=base_url()?>uploads/avatars/<?=get_thumbnail($user['avatar'])?>"><br><?=ucwords($user['fname'].' '.$user['lname'])?></td>
                                    <td class="hidden-xs"><?=$user['email']?></td>
                                    <?php

                                    switch($user['user_type'])
                                    {
                                        //case of super users
                                        case '1':
                                            ?>
                                            <td><span class="label label-grape"><?=ucwords(get_usertype($user['user_type'],'title'))?></span></td>
                                            <?php
                                            break;
                                        //case of admins
                                        case '2':
                                            ?>
                                            <td><span class="label label-info"><?=ucwords(get_usertype($user['user_type'],'title'))?></span></td>
                                            <?php
                                            break;
                                        //by default
                                        default:
                                            ?>
                                                <td><span class="label label-primary"><?=ucwords(get_usertype($user['user_type'],'title'))?></span></td>
                                            <?php
                                    }

                                    ?>

                                </tr>
                            <?php
                            }

                        }
                    }
                    else
                    {
                        echo '<tr class="text-danger"><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td></tr>';


                    }
                    break;

                default:
                    echo '<div class="alert alert-dismissable alert-info">
								<strong>Heads up!</strong>
								No parameter passed to switch in users contrroller line 341
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							</div>';

            }
        }
    }

    function trashed()
    {
        $data['main_content']='admin/trashed_users_v';
        $data['pagetitle']='Trashed users';

        $data['all_usertypes']=$this->user_m->get_all($trashed='y');

        $limit=25;
        $data['all_usertypes_paginated']= $this->usertype_m->get_trashed_paginated($num=$limit,$this->uri->segment(3));
        //pagination configs
        $config=array
        (
            'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2),//contigure page base_url
            'total_rows'        => count($data['all_usertypes']),
            'per_page'          => $limit,
            'num_links'         => $limit,
            'use_page_numbers'  => TRUE,
            'full_tag_open'     => '<div class="btn-group">',
            'full_tag_close'    => '</div>',
            'anchor_class'      => 'class="btn" ',
            'cur_tag_open'      => '<div class="btn">',
            'cur_tag_close'     => '</div>',
            'uri_segment'       => '3'

        );
        //initialise pagination
        $this->pagination->initialize($config);

        //add to data array
        $data['pages']=$this->pagination->create_links();
        //load view

        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);
    }

    function restore()
    {
        $user_id=$this->user_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

        if($user_id)
        {
            $data['main_content']='admin/edit_user_img_v';
            $data['pagetitle']='Edit avatar';
            $data['page_description']='Edit '.ucwords(get_user_info_by_id($user_id,'fullname')).' avatar';
            $data['user_info']=$this->user_m->get_by_id($user_id);

            //if form is sent
            if($this->input->post('upload'))
            {

                $image_name=!$this->user_m->do_upload_update('avatars');
                if (!$image_name)
                {
                    //if it fails

                    $data['errors'] = $this->upload->display_errors();

                }
                else
                {
                    $data['success'] = TRUE;
                }

            }

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);

        }
        else
        {
            echo show_404();
        }

    }

    //user account
    function account()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
            $config = array
            (


                array
                (
                    'field'   => 'email',
                    'label'   => 'Email',
                    'rules'   => 'required|valid_email'
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
								<h3>Oh Snap!</h3> ';
                $str.=validation_errors();
                $str.='</div>';
            }
            elseif($this->user_m->verify_item($this->input->post('id'),$this->input->post('email'),'email')==TRUE)
            {
                //if there were errors add them to the errors array
                $str.='<div class="alert alert-dismissable alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Oh Snap!</h3> ';
                $str.='Email should be unique';
                $str.='</div>';
            }
            else
            {
                //gather user data
                $user_data=array
                (

                    'email'     =>$this->input->post('email'),
                    'user_type' =>$this->input->post('usertype'),
                    'password'  =>md5($this->input->post('password')),
                    'dateupdated' =>mysqldate(),
                );
                if($this->user_m->update($this->input->post('id'),$user_data))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3> ';
                    $str.='User info was successfully edited';
                    $str.='</div>';
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                    $str.='User info  was not added. Please try one more time';
                    $str.='</div>';
                }

            }

            echo $str;

        }
        else
        {
            if(!$this->uri->segment(4))
            {
                show_404();
            }
            else
            {
                //ensure profile exists
                $user_id=$this->user_m->check_by_slug($this->uri->segment(4));
                if(!$user_id)
                {
                    show_404();
                }
                else
                {

                    //print_array($this->profile_model->check_by_slug($this->uri->segment(4)));
                    $data['main_content']='admin/manage_user_account_v';
                    $data['pagetitle']='Manage account';

                    $where=array
                    (
                        'slug'=>$this->uri->segment(4)
                    );

                    $data['user_info']=$this->user_m->get_where($where);
                    $data['user_id']=$user_id;

                    //load the admin dashboard view
                    $this->load->view('admin/includes/dashboard_template',$data);



                }

            }
        }

    }

    //BASIC INFO
    //user account
    function basic_info()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
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


            );

            $this->form_validation->set_rules($config);

            $str='';

            if ($this->form_validation->run() == FALSE)
            {
                //if there were errors add them to the errors array
                $str.='<div class="alert alert-dismissable alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Oh Snap!</h3> ';
                $str.=validation_errors();
                $str.='</div>';
            }

            else
            {
                //gather user data
                $user_data=array
                (

                    'fname'         =>$this->input->post('fname'),
                    'lname'         =>$this->input->post('lname'),
                    'dateupdated'   =>mysqldate(),
                );
                if($this->user_m->update($this->input->post('id'),$user_data))
                {
                   //update additional info table
                    $where=array
                    (
                        'user_id'=>$this->input->post('id')
                    );

                    //if user is there update
                    if($this->user_additional_info_m->get_where($where))
                    {
                        $user_data=array
                        (

                            'telephone'     =>$this->input->post('tel'),
                            'address'       =>$this->input->post('address'),
                            'city'          =>$this->input->post('city'),
                            'd_o_b'         =>$this->input->post('d_o_b'),
                            'bio'           =>$this->input->post('bio'),
                            'dateupdated'   =>mysqldate(),
                        );
                        //if not updated
                        if(!$this->user_additional_info_m->update($this->input->post('id'),$user_data))
                        {
                            //if there were errors add them to the errors array
                            $str.='<div class="alert alert-dismissable alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Oh Snap!</h3> ';
                            $str.='Additional info not updated';
                            $str.='</div>';
                        }
                    }
                    else
                    {
                        //do the insert
                        $user_data=array
                        (

                            'telephone'     =>$this->input->post('tel'),
                            'address'       =>$this->input->post('address'),
                            'city'          =>$this->input->post('city'),
                            'bio'           =>$this->input->post('bio'),
                            'd_o_b'         =>$this->input->post('d_o_b'),
                            'user_id'           =>$this->input->post('user_id'),
                            'dateadded'   =>mysqldate(),
                        );
                        if(!$this->user_additional_info_m->create($user_data))
                        {
                            //if there were errors add them to the errors array
                            $str.='<div class="alert alert-dismissable alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Oh Snap!</h3> ';
                            $str.='Additional info not updated';
                            $str.='</div>';
                        }
                    }



                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3> ';
                    $str.='User info was successfully edited';
                    $str.='</div>';
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                    $str.='User info  was not added. Please try one more time';
                    $str.='</div>';
                }

            }

            echo $str;

        }
        else
        {
            if(!$this->uri->segment(4))
            {
                show_404();
            }
            else
            {
                //ensure profile exists
                $user_id=$this->user_m->check_by_slug($this->uri->segment(4));
                if(!$user_id)
                {
                    show_404();
                }
                else
                {


                    //print_array($this->profile_model->check_by_slug($this->uri->segment(4)));
                    $data['main_content']='admin/manage_user_basic_info_v';
                    $data['pagetitle']='Manage account';

                    $where=array
                    (
                        'slug'=>$this->uri->segment(4)
                    );

                    $data['user_info']=$this->user_m->get_where($where);
                    $data['user_id']=$user_id;

                    //load the admin dashboard view
                    $this->load->view('admin/includes/dashboard_template',$data);



                }

            }
        }

    }

    function edit_image()
    {
        //check slug availability
        $user_id=$this->user_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

        if($user_id)
        {
            $data['main_content']='admin/edit_user_img_v';
            $data['pagetitle']='Edit avatar';
            $data['page_description']='Edit '.ucwords(get_user_info_by_id($user_id,'fullname')).' avatar';
            $data['user_info']=$this->user_m->get_by_id($user_id);


            //if form is sent
            if($this->input->post('upload'))
            {

                $image_name=!$this->user_m->do_upload_update('avatars');
                if (!$image_name)
                {
                    //if it fails

                    $data['errors'] = $this->upload->display_errors();

                }
                else
                {
                    $data['success'] = TRUE;
                }

            }



            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);

        }
        else
        {
            echo show_404();
        }

    }

    function delete_image()
    {
        if($this->input->post('ajax'))
        {
            switch($this->input->post('ajax'))
            {
                case 'form_delete_img':
                    if($this->profilephoto_m->delete($this->input->post('img_id')))
                    {
                        $str='';
                        $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well done!</h3> ';
                        $str.='Profile was successfully deleted';
                        $str.='</div>';

                        echo $str;
                    }
                    break;
                default:
                    $data['img_id']=$this->input->post('img_id');
                    $this->load->view('confirm_box/confirm_delete_profile_img',$data);
            }


        }
    }


    //user profile page
    function profile()
    {
        //verify profile

        $user_id=$this->user_m->check_by_slug($this->uri->segment(4));
        //if user exists
        if($user_id)
        {
            $data['main_content']='admin/user_profile_v';

            $data['pagetitle']='User profile';
            $data['user_info']=$this->user_m->get_by_id($user_id);
            $data['pagetitle']          ='Profile ';
            $data['page_description']   =ucwords(get_user_info_by_id($user_id,'fullname'));
            $data['passed_id']          =$user_id;

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }
        else
        {
            show_404();
        }
    }

    function delete()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            //if addition was successful
            $str='';
            $delete_id = $this->user_m->delete($this->input->post('passed_id'));
            if($delete_id)
            {
                $where = array
                (
                    'trash'=>'y',
                );
                $this->project_subscription_m->update_by('user_id',$this->input->post('passed_id'),$where);
                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well done!</h3> ';
                $str.='User was successfully deleted';
                $str.='</div>';

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $user_id=$this->user_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if user exists
            if($user_id)
            {
                //by default
                $data['main_content']       ='admin/confirm_box/confirm_delete_user_f';
                $data['pagetitle']          ='Delete '.ucwords(get_user_info_by_id($user_id,'fullname'));
                $data['page_description']   ='delete '.ucwords(get_user_info_by_id($user_id,'fullname'));
                $data['passed_id']          =$user_id;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }
        }


    }

    //edit user location
    function edit_location()
    {
        if($this->input->post('ajax'))
        {
            $str='';
            //swirtch by ajax value
            switch($this->input->post('ajax'))
            {
                //if its edit_location
                case 'edit_location':
                    //print_array($_POST);

                    $config = array
                    (

                        array
                        (
                            'field'   => 'district',
                            'label'   => 'District',
                            'rules'   => 'required'
                        ),


                    );

                    $this->form_validation->set_rules($config);

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
                            'district'          =>$this->input->post('district'),
                            'parish'            =>$this->input->post('parish'),
                            'subcounty'        =>$this->input->post('county'),
                            //'dateupdated'       =>mysqldate()
                        );
                        //check if user exists
                        $where=array
                        (
                            'id'=>$this->input->post('id')
                        );
                        $user=$this->user_m->get_where($where);
                        //id user exits update
                        if($user)
                        {
                            if($this->user_m->update_by('id',$this->input->post('id'),$user_data))
                            {
                                //echo $this->db->last_query();
                                //echo $this->db->last_query();
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                                $str.='Content was successfully Edited';
                                $str.='</div>';
                            }
                            else
                            {
                                echo $this->db->last_query();
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                                $str.='Content was not Edit. Please try one more time';
                                $str.='</div>';
                            }
                        }
                        //else insert
                        else
                        {
                            $user_data['user_id']=$this->input->post('id');
                            if($this->user_additional_info_m->create($user_data))
                            {
                                //echo $this->db->last_query();
                                //echo $this->db->last_query();
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                                $str.='Content was successfully Edited';
                                $str.='</div>';
                            }
                            else
                            {
                                echo $this->db->last_query();
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                                $str.='Content was not Edit. Please try one more time';
                                $str.='</div>';
                            }

                        }


                    }
                    break;
                case 'get_counties':

                    $where=array
                    (
                        'district_id'   => $this->input->post('district')

                    );
                    $sub_counties=$this->sub_county_m->get_where($where);
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sub counties</label>
                        <div class="col-md-10">
                            <select id="usr_counties" class="form-control">

                                <?php

                                foreach($sub_counties as $sub_county)
                                {

                                    ?>
                                    <option  value="<?=$sub_county['id']?>"><?=ucwords($sub_county['title'])?></option>

                                <?php


                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <script>
                        $("#usr_counties").change(function(){
                            //alert($("#usertype").val());
                            $(".parish").show('slow');
                            $(".parish").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');


                            var counties           =$('#usr_counties').val();
                            var form_data =
                            {

                                county:         counties,
                                ajax:        'get_parishes'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg)
                                {

                                    $('.parish').html(msg);

                                }
                            });

                        });
                    </script>
                    <?php


                    break;

                case 'get_parishes':
                    //echo $this->input->post('county');

                    $where=array
                    (
                        'sub_county_id'   => $this->input->post('county')

                    );
                    $parishes=$this->parish_m->get_where($where);
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Parishes</label>
                        <div class="col-md-10">
                            <select id="usr_parishes" class="form-control">

                                <?php

                                foreach($parishes as $parish)
                                {

                                    ?>
                                    <option  value="<?=$parish['id']?>"><?=ucwords($parish['title'])?></option>

                                <?php


                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php


                    break;
            }


            echo $str;
        }
        else
        {
            //check slug availability
            $user_id=$this->user_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if user exists
            if($user_id)
            {
                //by default
                $data['main_content']='admin/edit_user_location_v';
                $data['pagetitle']='Edit user Location';
                $data['page_description']='Edit '.ucwords(get_user_info_by_id($user_id,'fullname')).' Location Information';
                $data['user_info']=$this->user_m->get_by_id($user_id);
                $data['user_additional_info']=$this->user_additional_info_m->get_user_additional_info($user_id);


                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);


            }
            else
            {
                show_404();
            }
        }

    }

    function usertype()
    {
        //ensure the type actually exists
        $usertype_id=$this->usertype_m->check_by_slug($this->uri->segment(4));
        if($usertype_id)
        {
            $data['main_content']=$this->uri->segment(1).'/users_by_type_v';
            $data['pagetitle']=get_usertype_by_type_id($usertype_id,'title');
            $data['page_description']='Users by category';

            $where=array
            (
                'usertype'=>$usertype_id,
                'trash'=>'n',
            );

            $data['all_users_by_type']=$this->user_m->get_where($where);

            //print_array($data['all_users_by_type']);

            $limit=25;
            $data['all_users_by_type_paginated']= $this->user_m->get_paginated_by_criteria($num=$limit,$this->uri->segment(4),$where);
            //pagination configs
            $config=array
            (
                'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/usertype',//contigure page base_url
                'total_rows'        => count($data['all_users_by_type']),
                'per_page'          => $limit,
                'num_links'         => $limit,
                'use_page_numbers'  => TRUE,
                'full_tag_open'     => '<div class="btn-group">',
                'full_tag_close'    => '</div>',
                'anchor_class'      => 'class="btn" ',
                'cur_tag_open'      => '<div class="btn">',
                'cur_tag_close'     => '</div>',
                'uri_segment'       => '4'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages']=$this->pagination->create_links();
            //load view

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }
        else
        {
            //show 404
            show_404();
        }

    }


    //import
    function  import()
    {
        $data['main_content']=$this->uri->segment(1).'/import_users_v';
        $data['pagetitle']='Import Users';
        $data['page_description']='Import from Excel spreadsheets or CSV file';

        //if form is sent
        if($this->input->post('upload'))
        {

            $file_path=$this->user_m->do_file_upload('csv');

            //check if file was uploaed
            if(check_file_existance($file_path))
            {
                //print_array($file_path);
                //$data['success'] = TRUE;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file_path);

                //convert values to array
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                //print_array($sheetData);


                //get content
                foreach (array_slice($sheetData,1) as $head => $value)
                {
                    foreach ($value as $thingToDo){
                        $content[]=$thingToDo;
                    }
                }

                //loop through content and save it(only one column expected with the 1 row being title)
                //print_array($content);
                foreach($content as $telephone)
                {
                    //do not save only numeric values
                    if(is_numeric($telephone))
                    {
                        //prevent duplication

                        if(!get_user_info_by_telephone($telephone))
                        {
                            $user_data=array
                            (
                                'tel'     =>$telephone,
                                'usertype'=>'4',
                                'dateadded' =>mysqldate(),
                                'fname'=>'',
                                'lname'=>'',
                                'email'=>'',
                                'password'=>'',
                                'avatar'=>'avatar.jpg',
                                'lastlogin'=>default_timestamp(),
                                'slug'=>now().random_string('numeric',8),
                                'dateupdated'=>default_timestamp(),
                                'temp_pass'=>'0',
                                'subcounty'=>'0',
                                'parish'=>'0',
                                'district'=>'0'


                            );

                            //save to db
                            $this->user_m->create($user_data);

                            //echo $this->db->_error_message();

                        }

                    }

                }
                //delete the file to prevent overloading of the server
                $this->load->helper('file');
                delete_files($file_path);
                $data['success']=TRUE;
            }
            else
            {
                //if file not uploaed

                $data['errors'] = 'Please upload file';
            }

        }

        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);
    }
	
    function unsubscribers()
    {
        $data['main_content']=$this->uri->segment(1).'/unsubscribed_all';
        $data['pagetitle']='Users';
        $data['page_description']='All unsubscribed users';

        $where = array
        (
            'trash'=>'y',
        );

        $data['all_unsubscribers']=$this->user_m->get_where($where);

        $limit=25;
        $data['all_unsubscribers_paginated']= $this->user_m->get_paginated_by_criteria($num=$limit,$this->uri->segment(4),$where);
        //pagination configs
        $config=array
        (
            'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows'        => count($data['all_unsubscribers']),
            'per_page'          => $limit,
            'num_links'         => $limit,
            'use_page_numbers'  => TRUE,
            'full_tag_open'     => '<div class="btn-group">',
            'full_tag_close'    => '</div>',
            'anchor_class'      => 'class="btn" ',
            'cur_tag_open'      => '<div class="btn">',
            'cur_tag_close'     => '</div>',
            'uri_segment'       => '4'

        );
        //initialise pagination
        $this->pagination->initialize($config);

        //add to data array
        $data['pages']=$this->pagination->create_links();
        //load view

        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);
    }
	
	//Search function
	function search()
	{
		$data['query'] = $this->user_m->get_search();
		$this->load->view(‘books’, $data);
	}
}

 
