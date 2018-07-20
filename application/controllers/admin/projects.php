<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Projects extends MY_admin_controller
{
    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('project_m');

        $this->load->model('project_subscription_m');

        //load user type model model

    }

    //admin home page
    function index()
    {
        redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page');
    }

    function page()
    {
        $data['main_content']=$this->uri->segment(1).'/projects_home';
        $data['pagetitle']='Platforms';
        $data['page_description']='Listing of all platforms';

        //$test=$this->usertype_m->count_all($tablename='usertypes');
        //echo $test;
        if($this->session->userdata('logged_in_usertype')==2)
        {
            $data['all_projects'] = $this->project_m->project_assigned_to_user($this->session->userdata('user_id'),$trashed = 'n');
        }
        elseif($this->session->userdata('logged_in_usertype')==1)
        {
            $data['all_projects']=$this->project_m->get_all($trashed='n');
        }

        $limit=25;
        $data['all_projects_paginated']= $this->project_m->get_paginated($num=$limit,$this->uri->segment(4));
        //pagination configs
        $config=array
        (
            'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows'        => count($data['all_projects']),
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

    //add project
    function add()
    {
        if($this->input->post('ajax'))
        {

            //echo $_POST;

            $config = array
            (

                array
                (
                    'field'   => 'project',
                    'label'   => 'Platform Name',
                    'rules'   => 'required|is_unique[projects.title]'
                ),

                array
                (
                    'field'   => 'shortcode',
                    'label'   => 'Shortcode',
                    'rules'   => 'required|is_unique[projects.shortcode]|min_length[4]|max_length[4]|numeric'
                ),

                array
                (
                    'field'   => 'details',
                    'label'   => 'Platform Details',
                    'rules'   => 'trim|required'
                ),

            );

            $this->form_validation->set_rules($config);

            $str='';

            if ($this->form_validation->run() == FALSE)
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
                //gather project data
                $project = array
                (
                    'title'     => $this->input->post('project'),
                    'shortcode'     => $this->input->post('shortcode'),
                    'projectdetails' => $this->input->post('details'),
                    'author'   => $this->session->userdata('logged_in_user_id'),
                    'slug'     => strtolower(seo_url($this->input->post('project'))),
                );

                if($this->project_m->create($project))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Notice !</h3> ';
                    $str.='Platform was successfully added';
                    $str.=jquery_clear_fields();
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Notice !</h3> ';
                    $str.='Platform was not added. Please try one more time';
                    $str.='</div>';
                }

            }

            echo $str;

        }
        else
        {
            $data['main_content']='admin/new_project_v';
            $data['pagetitle']='New Platform';
            $data['page_description']='Add New Platform';

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);

        }


    }

    //show subscribers
    function registered()
    {

        //echo 'foo';
        //verify if project exists
        //get project id
        $project_id=$this->project_m->check_by_slug($this->uri->segment(4));

        if($project_id)
        {
            //echo $project_id;
            $data['main_content'] = $this->uri->segment(1).'/subscribers_v';
            $data['pagetitle'] = ucwords(remove_dashes($this->uri->segment(4)));
            $data['page_description'] =' Subscribers for '.remove_underscore($this->uri->segment(4));
            
            //where_variables
            $where=array
            (
                'project_id'=>$project_id,
                'trash'     =>'n',
            );

            $data['all_subscribers']=$this->project_subscription_m->get_where($where);

            //print_array($data['all_subscribers']);

            $limit='25';
            $data['all_subscribers_paginated']= $this->project_subscription_m->get_paginated_by_criteria($num=$limit,$this->uri->segment(5),$where);
            //print_array($data['all_subscribers_paginated']);
            // echo count($data['all_subscribers_paginated']);

            //pagination configs
            $config=array
            (
                'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4),//configure page base_url
                'total_rows'        => count($data['all_subscribers']),
                'per_page'          => $limit,
                'num_links'         => $limit,
                'use_page_numbers'  => TRUE,
                'full_tag_open'     => '<div class="btn-group">',
                'full_tag_close'    => '</div>',
                'anchor_class'      => 'class="btn" ',
                'cur_tag_open'      => '<div class="btn">',
                'cur_tag_close'     => '</div>',
                'uri_segment'       => '5'

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
            show_404();
        }

    }

    function edit()
    {
        //if ajax post is sent
        if($this->input->post('ajax'))
        {
            //echo $this->input->post('id');
            $str = '';

            //then update
            $config = array
            (
                //user type name
                array
                (
                    'field'   => 'project',
                    'rules'   => 'trim|required',
                    'label'   =>  'Platform Name'
                ),

                array
                (
                    'field'   => 'pcode',
                    'rules'   => 'required|min_length[4]|max_length[4]|numeric',
                    'label'   =>  'Platform shortcode'
                ),

                array
                (
                    'field'   => 'pdetails',
                    'rules'   => 'trim|required',
                    'label'   =>  'Platform Details'
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
                $dbdata = array
                (
                    'title'             =>strtolower($this->input->post('project')),
                    'shortcode'    =>strtolower($this->input->post('pcode')),
                    'projectdetails'    =>strtolower($this->input->post('pdetails')),
                    'slug'              =>seo_url($this->input->post('project'))
                );

                if($this->project_m->update($this->input->post('id'),$dbdata))
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Notice !</h3>';
                    $str.='Platform name was successfully Edited';
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
            //verify if project exists
            $where=array
            (
                'slug'=>$this->uri->segment(4)
            );

            $project_info = $this->project_m->get_where($where);

            if($project_info)
            {
                $data['main_content'] = 'admin/edit_project_v';
                $data['pagetitle'] = ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description'] =' Edit '.remove_underscore($this->uri->segment(4));

                $data['project_info'] = $project_info;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }

        }


    }

    function delete()
    {
        //if there is an ajax post
        if ($this->input->post('ajax')) {
            $str = '';
            if ($this->project_m->delete($this->input->post('passed_id'))) {
                $str .= '<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                $str .= 'Platform was successfully deleted';
                $str .= '</div>';

            }

            echo $str;

        } else {
            //ensure value exists
            $id = $this->project_m->check_by_slug($this->uri->segment(4));
            //echo $this->db->last_query();

            if ($id) {

                $data['main_content'] = 'admin/confirm_box/confirm_delete_project_f';
                $data['pagetitle'] = ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description'] = 'Delete ' . remove_underscore($this->uri->segment(4));

                $data['passed_id'] = $id;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template', $data);


            } else {
                show_404();
            }
        }

    }

    //delete subscriber from project
    function remove()
    {
        //if there is an ajax post
        if ($this->input->post('ajax')) {
            $str = '';
            if ($this->project_subscription_m->delete($this->input->post('passed_id'))) {
                $str .= '<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                $str .= 'User was removed from platform';
                $str .= '</div>';

            }

            echo $str;

        } else {
            //ensure value exists
            $id = $this->project_subscription_m->get_by_id($this->uri->segment(4));

            if ($id) {

                $data['main_content'] = 'admin/confirm_box/confirm_delete_subscriber_f';
                $data['pagetitle'] = ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description'] = 'Delete ' . remove_underscore($this->uri->segment(4));

                $data['passed_id'] = $id;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template', $data);


            } else {
                show_404();
            }
        }

    }

    //add subscribers
    function add_subscribers()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
            //switch depending on ajax value
            switch($this->input->post('ajax'))
            {
                //subscribe by group
                case 'subscribe_by_group':
                    //get users by usergroup
                    $users=get_users_by_usertype($this->input->post('usr_grp'));

                            //loop through users
                            foreach($users as $user)
                            {

                                    //then subscribe user
                                    $subscriber_data=array
                                    (
                                        'user_id'=>$user['id'],
                                        'project_id'=>get_project_id_by_slug($this->input->post('project_slug'))
                                    );

                                    //prevent duplicate
                                    if(!check_subscriber_by_id($user['id'],get_project_id_by_slug($this->input->post('project_slug'))))
                                    {
                                        $this->project_subscription_m->create($subscriber_data);
                                    }
                            }



                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Subscription was successful
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));

                    break;

                //subscribe by group
                case 'unsubscribe_by_group':
                    //prevent duplicate subscription
                    $subscribers=get_subscribers_by_project($this->input->post('project_slug'));
                    //unsubscribe each user
                    foreach($subscribers as $subscriber)
                    {
                        $this->project_subscription_m->hard_delete($subscriber['id']);
                    }
                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Users unsubscribed
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));

                    break;

                case 'subscribe_by_district':
                    //print_array($_POST);

                    $users=get_users_by_district($this->input->post('district'));
                    //loop through users
                    foreach($users as $user)
                    {

                        //then subscribe user
                        $subscriber_data=array
                        (
                            'user_id'=>$user['id'],
                            'project_id'=>get_project_id_by_slug($this->input->post('project_slug'))
                        );

                        //prevent duplicate
                        if(!check_subscriber_by_id($user['id'],get_project_id_by_slug($this->input->post('project_slug'))))
                        {
                            $this->project_subscription_m->create($subscriber_data);
                        }
                    }

                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Subscription was successful
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));


                    break;

                case 'unsubscribe_by_district':
                    //prevent duplicate subscription
                    $subscribers=get_subscribers_by_project($this->input->post('project_slug'));

                    $users=get_users_by_district($this->input->post('district'));
                    //loop thru users
                    foreach($users as $user)
                    {
                        //loop through subscribers
                        foreach($subscribers as $subscriber)
                        {
                            //if ids match delete
                            if($subscriber['user_id']==$user['id'])
                            {

                                    $this->project_subscription_m->hard_delete($subscriber['id']);


                            }
                        }
                    }

                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Users unsubscribed
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));

                    break;

                case 'subscribe_by_project':
                    //print_array($_POST);


                    $users=get_subscribers_by_project(get_project_by_type_id($this->input->post('project'),'slug'));
                    //loop through users
                    foreach($users as $user)
                    {

                        //then subscribe user
                        $subscriber_data=array
                        (
                            'user_id'=>$user['user_id'],
                            'project_id'=>get_project_id_by_slug($this->input->post('project_slug'))
                        );

                        //prevent duplicate
                        if(!check_subscriber_by_id($user['user_id'],get_project_id_by_slug($this->input->post('project_slug'))))
                        {
                            $this->project_subscription_m->create($subscriber_data);
                        }
                    }

                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Subscription was successful
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));


                    break;


                case 'unsubscribe_by_project':
                    //prevent duplicate subscription
                    $subscribers=get_subscribers_by_project($this->input->post('project_slug'));

                    //loop thru users

                        //loop through subscribers
                        foreach($subscribers as $subscriber)
                        {
                            //if ids match delete

                                $this->project_subscription_m->hard_delete($subscriber['id']);

                        }

                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Users unsubscribed
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));


                    break;

                case 'manual_add_user':
                    //print_array($_POST);
                    $config = array
                    (

                        array
                        (
                            'field'   => 'tel',
                            'label'   => 'Telephone number',
                            'rules'   => 'required|numeric|min_length[10]|max_length[10]'
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
                        //if not registered add user
                        if(!get_user_id_by_telephone($this->input->post('tel')))
                        {
                            //add user
                            $manual_data=array
                            (
                                'tel'=>$this->input->post('tel'),
                            );

                            $this->user_m->create($manual_data);
                        }


                        if(!check_subscriber_by_id(get_user_id_by_telephone($this->input->post('tel')),get_project_id_by_slug($this->input->post('project_slug'))))
                        {
                            //just unsubscribe
                            $sub_scription_data=array
                            (
                                'user_id'=>get_user_id_by_telephone($this->input->post('tel')),
                                'project_id'=>get_project_id_by_slug($this->input->post('project_slug'))
                            );
                            $this->project_subscription_m->create($sub_scription_data);

                        }



                        $str.='<div class="alert alert-success">
													<strong>Notice !</strong> Subscription was successful
												</div>';
                        $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));


                    }
                    break;

            }
            echo $str;
        }
        else
        {
            //verify that project actually exists
            $project_id=$this->project_m->check_by_slug($this->uri->segment(4));

            //if there procees
            if($project_id)
            {
                $data['main_content']=$this->uri->segment(1).'/subscribe_users_home';
                $data['pagetitle']=remove_dashes($this->uri->segment(4));
                $data['page_description']='Subscribe members to '.remove_dashes($this->uri->segment(4));


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
                        //print_array($sheetData)s


                        //get content
                        foreach (array_slice($sheetData,1) as $head => $value) {
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

                                    );

                                    //save to db
                                    $this->user_m->create($user_data);

                                }

                            }


                            //get user info
                            $new_users=get_user_info_by_telephone($telephone);
                            foreach($new_users as $new_user)
                            {
                                $new_user_data=array
                                (
                                    'user_id'=>$new_user['id'],
                                    'project_id'=>get_project_id_by_slug($this->uri->segment(4))
                                );

                                $this->project_subscription_m->create($new_user_data);
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
            else
            {
                show_404();
            }
        }

    }



    function project_managers()
    {

        //add project managers		1
        //edit project managers 2
        //trash project managers 3
        //view archivers 4
        //restore project managers 5
        //delete project managers 6
        //load add form 7
        //load edit form 8
        /* $user_data=array
                (
                    'fname'     =>$this->input->post('fname'),
                    'lname'     =>$this->input->post('lname'),
                    'email'     =>$this->input->post('email'),
                    'usertype' =>$this->input->post('usertype'),
                    'password'  =>md5($this->input->post('password')),
                    'tel'       =>$this->input->post('tel'),
                    'dateupdated' =>mysqldate()
                );
                if($this->user_m->update($this->input->post('id'),$user_data))
                { */

        $selector = $data['selector']= $this->uri->segment(4);
        $projectid = $this->uri->segment(5);
        $data['projectdata']=$this->project_m->get_project_by_id($projectid);
        $data['userss'] = $this->user_m->get_all();


        switch($selector)
        {
            case 1:
                $this->load->model('project_magement_m');
                $userid = $this->uri->segment(6);
                $projectid =  $this->uri->segment(5);

                $num = $this->project_magement_m->get_manager_by_id($userid,$projectid);

                if(!$num)
                {
                    $where=array
                    (
                        'userid'=>$userid,
                        'projectid'=>$projectid
                    );

                    $this->project_magement_m->create($where);
                    echo 1;

                }
                else
                {
                    echo 0;
                }
                //make subscription
                // first check if the user is subscribed if no subscribe::
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:
                $this->load->model('project_magement_m');
                $projectm =  $this->uri->segment(5);

                $userdata = array('trash'=>'y');
                if($this->project_magement_m->update($projectm,$userdata))
                {
                    $data['managers'] = $this->project_magement_m->get_manager_by_id('','');

                    // first load all the project managers  ::
                    $data['main_content']='admin/project_managers_home';
                    $data['pagetitle']='Platform Managers';
                    $data['page_description']='Add New Platform';

                    //load the admin dashboard view
                    $this->load->view('admin/includes/dashboard_template',$data);
                }

                break;
            case 5:
                break;
            case 6:
                break;
            case 7:

                $this->load->view('admin/forms/project_managers',$data);
                break;
            case 9:
                $this->load->model('project_magement_m');
                $data['managers'] = $this->project_magement_m->get_manager_by_id('','');

                $data['main_content']='admin/project_managers_home';
                $data['pagetitle']='Platform Managers';
                $data['page_description']='Platform Managers';

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);

                break;
        }

    }


}