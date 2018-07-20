<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usertypes extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('usertype_m');

        //load user type model model

    }

    //admin home page
    function index()
    {
        redirect(base_url().'admin/'.$this->uri->segment(2).'/page');
    }

    function page()
    {
        $data['main_content']='admin/usertype_home';
        $data['pagetitle']='User Groups';
        $data['page_description']='Listing of all available user groups ';

        //$test=$this->usertype_m->count_all($tablename='usertypes');
        //echo $test;


        $data['all_usertypes']=$this->usertype_m->get_all($trashed='n');

        $limit=25;
        $data['all_usertypes_paginated']= $this->usertype_m->get_paginated($num=$limit,$this->uri->segment(4));
        //pagination configs
        $config=array
        (
            'base_url'          => base_url().'admin/usertypes/page',//contigure page base_url
            'total_rows'        => count($data['all_usertypes']),
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


    function ajax_calls()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            //switch ajax calls accordingly
            switch($this->input->post('ajax'))
            {


                //add new item form post
                case 'add_usertype_f':
                    $str='';
                    if($this->session->userdata('edit_usertype')==TRUE)
                    {


                        $config=array
                        (
                            //user type
                            array
                            (
                                'field'   => 'usertype',
                                'rules'   => 'trim|required',
                                'label'   =>  'User type'
                            ),

                        );
                    }
                    else
                    {
                        $config=array
                        (
                            //firstname
                            array
                            (
                                'field'   => 'usertype',
                                'rules'   => 'trim|required|is_unique[usertypes.usertype]',
                                'label'   =>  'User group'
                            ),



                        );
                    }


                    //set rules
                    $this->form_validation->set_rules($config);

                    if($this->form_validation->run()== FALSE)
                    {
                        //if there were errors add them to the errors array
                        $str.='<div class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                        $str.=validation_errors();

                        $str.='</div>';


                    }
                    else
                    {

                        //build user data
                        $dbdata=array
                        (
                            'usertype'      =>strtolower($this->input->post('usertype')),
                        );

                        //when editing
                        if($this->session->userdata('edit_usertype'))
                        {

                            //var_dump($dbdata);
                            //ENSURE they are not editing to a value that exists
                            if($this->usertype_m->verify_edit($this->session->userdata('edit_usertypeid'),strtolower($this->input->post('usertype')))==FALSE)
                            {
                                $str.='<div class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                                $str.='Name has been taken';

                                $str.='</div>';
                            }

                            else
                            {
                               //var_dump($dbdata);
                                //echo 'foo2';
                                //edit user
                                if($this->usertype_m->update($this->session->userdata('edit_usertypeid'),$dbdata))
                                {
                                    //if there were errors add them to the errors array
                                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                                    $str.='User Group was successfully Edited';

                                    $str.='</div>

                                    <script>
                                        $(document).ready(function(){
                                           // alert("foo");
                                    setTimeout(function() {
                                        $(\'.form_area\').fadeOut(\'fade\');
                                    }, 1000); // <-- time in milliseconds

                                        });
                                    </script>';

                                    //unset values

                                    $this->session->unset_userdata('edit_usertypeid');
                                    $this->session->unset_userdata('edit_usertype');

                                }
                                else
                                {
                                    $str.='<div id="alert_message" class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                                    $str.='User Group was successfully Edited';

                                    $str.='</div>
                                    <script>
                                        $(document).ready(function(){
                                           // alert("foo");
                                    setTimeout(function() {
                                        $(\'.form_area\').fadeOut(\'fade\');
                                    }, 1000); // <-- time in milliseconds

                                        });
                                    </script>';

                                    //unset values

                                    $this->session->unset_userdata('edit_usertypeid');
                                    $this->session->unset_userdata('edit_usertype');
                                }
                            }
                        }
                        else
                        {
                            //var_dump($dbdata);
                            //add user
                            if($this->usertype_m->create($dbdata))
                            {
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                                $str.='User Group was successfully created';

                                $str.='</div>
                             <script>
							  $(".form-horizontal")[0].reset();
							  </script>';

                            }
                        }



                    }
                    echo $str;
                    break;

                //case of viewing profiles
                case 'view_profile':
                    //get user id
                    $user_id=$this->input->post('user_id');

                    //start session
                    $this->session->set_userdata('user_profile',$user_id);
                    //get user info
                    $user_name=ucfirst(get_user_info($user_id,'firstname') .'_'. get_user_info($user_id,'lastname'));
                    $user_data=array
                    (
                        'users_name'    => $user_name,
                        'destination'   =>'profile'
                    );

                    ?>
                    <script>
                        window.location='<?=base_url().'admin/members/profile/'.$user_name?>'
                    </script>
                    <?php

                    //send info to ajax redirector
                    $this->load->view('ajax_results/ajax_router',$user_data);

                    break;

                    echo $str;
                    break;
                default:
                    echo '<div class="alert alert-dismissable alert-info">
								<strong>Notice !</strong>
								There must be confusion somewhere
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							</div>';

            }
        }
    }

    //add new
    function add()
    {
        $data['main_content']='admin/new_usertype_v';
        $data['pagetitle']='New user ';
        $data['page_description']='Create a new user group';



        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);

    }

    function edit()
    {
        //if ajax post is sent
        if($this->input->post('ajax'))
        {
            //echo $this->input->post('id');
            $str='';

                       //then update
                        $config=array
                        (
                            //user type name
                            array
                            (
                                'field'   => 'usertype',
                                'rules'   => 'trim|required',
                                'label'   =>  'User type'
                            ),


                        );

                        $this->form_validation->set_rules($config);

                        if($this->form_validation->run()== FALSE)
                        {
                            //if there were errors add them to the errors array
                            $str.='<div class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                            $str.=validation_errors();

                            $str.='</div>';


                        }
                        else
                        {

                            //build user data
                            $dbdata=array
                            (
                                'usertype'     =>strtolower($this->input->post('usertype')),
                            );

                            if($this->usertype_m->update($this->input->post('id'),$dbdata))
                            {
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                                $str.='User Group was successfully Edited';
                                $str.='</div>';
                            }
                            else
                            {
                                //if there were errors add them to the errors array
                                $str.='<div class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                                $str.='No change was made';
                                $str.='</div>';
                            }

                        }


            echo $str;

        }
        else
        {
            //verify if usertype exists
            $where=array
            (
                'slug'=>$this->uri->segment(4)
            );

            $usertype_info=$this->usertype_m->get_where($where);

            if($usertype_info)
            {
                $data['main_content']='admin/edit_usertype_v';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description']='Edit '.remove_underscore($this->uri->segment(4));

                $data['usertype_info']=$usertype_info;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }

        }


    }

    function trashed()
    {
        $data['main_content']='admin/trashed_usertype_v';
        $data['pagetitle']='Trashed user groups';
        $criteria=array
        (
            'trash'   =>'y'
        );


        $data['all_usertypes']=$this->usertype_m->get_where($criteria);


        $limit=25;
        $data['all_usertypes_paginated']= $this->usertype_m->get_paginated_by_criteria($num=$limit,$this->uri->segment(3),$criteria);
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
        if($this->input->post('ajax'))
        {
            //echo $this->input->post('id');
            $str='';
            switch($this->input->post('ajax'))
            {
                case 'restore':
                    $passed_id=$this->input->post('usertype_id');

                    //build user data
                    $dbdata=array
                    (
                        'trash'     =>'n',
                    );

                    if($this->usertype_m->update($passed_id,$dbdata))
                    {
                        //redirect user to edit page
                        jquery_redirect(base_url().'admin/usertypes');
                    }
                    else
                    {
                        //if there were errors add them to the errors array
                        $str.='<div class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                        $str.='No change was made';
                        $str.='</div>';
                    }

                    break;



                default:
                    echo 'No parameters passed to switch in usertypes controller line 485';
            }

            echo $str;

        }
        else
        {
            redirect(base_url().'admin/usertypes');
        }


    }


    function delete()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
            if($this->usertype_m->delete($this->input->post('passed_id')))
            {
                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                $str.='User group was successfully deleted';
                $str.='</div>';

            }

            echo $str;

        }
        else
        {
            //ensure value exists
            $id=$this->usertype_m->check_by_slug($this->uri->segment(4));

            if($id)
            {

                $data['main_content']='admin/confirm_box/confirm_delete_usertype_f';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description']='Delete '.remove_underscore($this->uri->segment(4));

                $data['passed_id']=$id;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);


            }
            else
            {
                show_404();
            }
        }


    }

}

 