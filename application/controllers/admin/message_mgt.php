<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Message_mgt extends MY_admin_controller
{
    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load dependencies
        $this->load->model('project_m');

        $this->load->model('project_subscription_m');

        $this->load->model('received_msg_m');

        $this->load->model('user_m');

        $this->load->model('sent_message_m');

        $this->load->model('project_magement_m');
        
        $this->load->model('from_dump_yard_m');

    }

    //admin home page
    function index()
    {
        redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page');
    }

    function page()
    {
        $data['main_content']=$this->uri->segment(1).'/msg_mgt_home';
        $data['pagetitle']='Project messages';
        $data['page_description']='Listing of all messages by project  ';

        //$test=$this->usertype_m->count_all($tablename='usertypes');
        //echo $test;

        $data['all_projects']=$this->project_m->get_all($trashed='n');

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
    
    function inbox()
    {
    	$data['main_content']=$this->uri->segment(1).'/general_inbox';
        $data['pagetitle']='Messages';
        $data['page_description']='Listing of all general messages';

        //$test=$this->usertype_m->count_all($tablename='usertypes');
        //echo $test;

        $data['all_messages']=$this->from_dump_yard_m->get_all($trashed='n');

        $limit=25;
        $data['all_messages_paginated']= $this->from_dump_yard_m->get_paginated($num=$limit,$this->uri->segment(4));
        //pagination configs
        $config=array
        (
            'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows'        => count($data['all_messages']),
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
                    'label'   => 'Project Name',
                    'rules'   => 'required|is_unique[projects.title]'
                ),

                array
                (
                    'field'   => 'shortcode',
                    'label'   => 'Shortcode',
                    'rules'   => 'required|is_unique[projects.shortcode]'
                ),

                array
                (
                    'field'   => 'details',
                    'label'   => 'Project Details'
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
                    $str.='Project was successfully added';
                    $str.=jquery_clear_fields();
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                    $str.='Project was not added. Please try one more time';
                    $str.='</div>';
                }

            }

            echo $str;

        }
        else
        {
            $data['main_content']='admin/new_project_v';
            $data['pagetitle']='New Project';
            $data['page_description']='Add New Project';

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
                    'label'   =>  'Project Name'
                ),
                array
                (
                    'field'   => 'pdetails',
                    'rules'   => 'trim|required',
                    'label'   =>  'Project Details'
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
                    'title' =>strtolower($this->input->post('project')),
                    'projectdetails' =>strtolower($this->input->post('pdetails')),
                );

                if($this->project_m->update($this->input->post('id'),$dbdata))
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                    $str.='Project name was successfully Edited';
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
                $str .= 'Project was successfully deleted';
                $str .= '</div>';

            }

            echo $str;

        } else {
            //ensure value exists
            $id = $this->project_m->check_by_slug($this->uri->segment(4));
            echo $this->db->last_query();

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
                $str .= 'User was removed from project';
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

                    //prevent duplicate subscription
                    $subscribers=get_subscribers_by_project($this->input->post('project_slug'));
                    //if there are already subscribers then filter
                    if($subscribers)
                    {
                        foreach($subscribers as $subscriber)
                        {
                            //loop through users
                            foreach($users as $user)
                            {
                                if($user['tel']!=$subscriber['user_tel'])
                                {
                                    //then subscribe user
                                    $subscriber_data=array
                                    (
                                        'user_tel'=>$user['tel'],
                                        'project_id'=>get_project_id_by_slug($this->input->post('project_slug'))
                                    );

                                    //prevent duplicate
                                    if(!check_subscriber_by_number($user['tel'],get_project_id_by_slug($this->input->post('project_slug'))))
                                    {
                                        $this->project_subscription_m->create($subscriber_data);
                                    }



                                }
                            }
                        }
                    }
                    else
                    {
                        //just add
                        foreach($users as $user)
                        {
                            //then subscribe user
                                $subscriber_data=array
                                (
                                    'user_tel'=>$user['tel'],
                                    'project_id'=>get_project_id_by_slug($this->input->post('project_slug'))
                                );
                            //prevent duplicate
                            if(!check_subscriber_by_number($user['tel'],get_project_id_by_slug($this->input->post('project_slug'))))
                            {
                                $this->project_subscription_m->create($subscriber_data);
                            }


                        }
                    }
                    //$str.=$this->db->last_query();
                    $str.='<div class="alert alert-success">
													<strong>Well done!</strong> Subscription was successful
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
													<strong>Well done!</strong> Users unsubscribed
												</div>';
                    $str.=jquery_countdown_redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add_subscribers/'.$this->input->post('project_slug'));

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

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }
        }

    }

    function send()
    {
        redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/send_by_num');
    }

    function send_by_num()
    {
        if($this->input->post('ajax'))
        {
            //print_array($_POST);
            $str='';

            //then update
            $config = array
            (
                //user type name
                array
                (
                    'field'   => 'tel',
                    'rules'   => 'trim|required|numeric|min_length[10]|max_length[10]',
                    'label'   =>  'Telephone number'
                ),
                array
                (
                    'field' => 'content',
                    'rules'   => 'trim|required',
                    'label'   =>  'Message'
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
                //personalisation
                $user_id=get_user_id_by_telephone($this->input->post('tel'));

                //if user does not exist register them
                if(!$user_id)
                {
                    $user_data=array
                    (
                        'tel'=>$this->input->post('tel')
                    );

                    $user_id=$this->user_m->create($user_data);

                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                    $str.='Number was registered';
                    $str.='</div>';
                }

                //save message the blast it out
                $message_data=array
                (
                    'tel'=>$this->input->post('tel'),
                    'message'=>$this->input->post('content'),
                    'instructions'=>$this->input->post('instructions'),
                    'author'=>$this->session->userdata('user_id'),
                    'user_id'=>$user_id
                );

                //check for duplicates
                $where=array
                (
                    'user_id'=>$user_id,
                    'message'=>$this->input->post('content')
                );

                if($this->sent_message_m->get_where($where))
                {
                    //if its a duplicate
                    $str.='<div class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                    $str.='Simillar message was already sent to <b>'.$this->input->post('tel').'</b> ';
                    $str.='</div>';
                }
                else
                {
                   //if its the first of its kind
                    //if message saved then send it
                    if($this->sent_message_m->create($message_data))
                    {
                        $msg=$this->input->post('salutation').' '.$this->input->post('content').' '.$this->input->post('instructions');

                        $url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to='.$this->input->post('tel').'&from=newwave&text='.$msg;
                        $msg=$this->input->post('salutation').' ';

                        //personalise message
                        $msg.=get_user_info_by_id(get_user_id_by_telephone(get_user_info_by_id(get_user_id_by_telephone($user_id),'tel')),'fullname');
                        $msg.=$this->input->post('content').' ';
                        $msg.=$this->input->post('instructions');

                        $url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to=256'.remove_zeros($this->input->post('tel')).'&from=newwave&text='.rawurlencode($msg).'';
                        $ch = curl_init($url);
                        if($ch)
                        {
                            $sent=TRUE;
                        }
                        else
                        {
                            $sent=FALSE;
                        }
                        curl_exec($ch);
                        curl_close($ch);

                        //echo $url_the_new;

                        //if message is sent
                        if($sent==TRUE)
                        {
                            $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                            $str.='Message sent to <b>'.$this->input->post('tel').'</b>';
                            $str.='</div>';
                        }

                    }
                    else
                    {
                        $str.='<div class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                        $str.='Message not sent please try again';

                        $str.='</div>';
                    }
                }


            }

            echo $str;
        }
        else
        {

            $data['main_content']=$this->uri->segment(1).'/send_msg_by_num_v';
            $data['pagetitle']='Send Messages';
            $data['page_description']='Send messages to users';
            //echo remove_zeros('87759570998');

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }

    }



    function from_excel()
    {
        $data['main_content']=$this->uri->segment(1).'/send_from_excel_v';
        $data['pagetitle']='Send Messages';
        $data['page_description']='Send messages to users from an excel sheet';
        //echo remove_zeros('87759570998');

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
                //print_array($sheetData)s


                //get content
                foreach (array_slice($sheetData,1) as $head => $value) {
                    foreach ($value as $thingToDo){
                        $content[]=$thingToDo;
                    }
                }

                //loop through content and save it(only one column expected with the 1 row being title)
                foreach($content as $item)
                {
                    //do not save bumeric districts
                    if(is_numeric($item))
                    {
                        //personalisation
                        $user_id=get_user_id_by_telephone($item);

                        //if user does not exist register them
                        if(!$user_id)
                        {
                            $user_data=array
                            (
                                'tel'=>$item
                            );

                            $user_id=$this->user_m->create($user_data);
                        }

                        //save message the blast it out
                        $message_data=array
                        (
                            'tel'=>$item,
                            'message'=>$this->input->post('content'),
                            'instructions'=>$this->input->post('instructions'),
                            'author'=>$this->session->userdata('user_id'),
                            'user_id'=>$user_id
                        );

                        //check for duplicat
                        $where=array
                        (
                            'user_id'=>$user_id,
                            'message'=>$this->input->post('content')
                        );

                        if($this->sent_message_m->get_where($where))
                        {

                            $data['errors']= 'Simillar message was already sent to <b>'.$item.'</b> ';
                        }
                        else
                        {
                            //if its the first of its kind
                            //if message saved then send it
                            if($this->sent_message_m->create($message_data))
                            {

                                $msg=$this->input->post('salutation').',';

                                //personalise message
                                $msg.=get_user_info_by_id(get_user_id_by_telephone(get_user_info_by_id($user_id,'tel')),'fullname');
                                $msg.=$this->input->post('content');
                                //then blast the message
                                //$url = 'http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to='.$this->input->post('tel')."&from=newwave&text=".$msg;
                                //$url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to='.$this->input->post('tel').'&from=newwave&text='.$msg;
                                //$url_the_new = str_replace('', '%20', $url);

                                $url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to=256'.remove_zeros($item).'&from=newwave&text='.rawurlencode($msg).'';
                                $ch = curl_init($url);
                                if($ch)
                                {
                                    $sent=TRUE;
                                }
                                else
                                {
                                    $sent=FALSE;
                                }
                                curl_exec($ch);
                                curl_close($ch);

                                $data['success']=TRUE;


                            }
                            else
                            {

                                $data['errors']='Messages not sent';
                            }
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

    function send_by_project()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
			echo $this->input->post('ajax');
            //print_array(get_subscribers_by_project($this->input->post('project')));
            //check if project has subscribers
            if(count(get_subscribers_by_project($this->input->post('project'))))
            {

                    $subscribers=get_subscribers_by_project($this->input->post('project'));
                    //extract their ids
                    foreach($subscribers as $subscriber)
                    {
                        $message_data=array
                        (
                            'tel'=>get_user_info_by_id($subscriber['user_id'],'tel'),
                            'message'=>$this->input->post('content'),
                            'instructions'=>$this->input->post('instructions'),
                            'project'=>$this->input->post('project'),
                            'author'=>$this->session->userdata('user_id'),
                            'user_id'=>$subscriber['user_id']
                        );

                        //check for duplicates
                        $where=array
                        (
                            'user_id'=>$subscriber['user_id'],
                            'message'=>$this->input->post('content')
                        );

                        if($this->sent_message_m->get_where($where))
                        {
                            //if its a duplicate
                            $str.='<div class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                            $str.='Simillar message was already sent to <b>'.get_user_info_by_id($subscriber['user_id'],'tel').'</b> ';
                            $str.='</div>';
                        }
                        else
                        {
                            //if message saved then send it
                            if($this->sent_message_m->create($message_data))
                            {
                                $msg=$this->input->post('salutation').' ';

                                //personalise message
                                $msg.=get_user_info_by_id(get_user_id_by_telephone(get_user_info_by_id($subscriber['user_id'],'tel')),'fullname');
                                $msg.=$this->input->post('content').' ';
                                $msg.=$this->input->post('instructions');
                                $url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to=256'.remove_zeros(get_user_info_by_id($subscriber['user_id'],'tel')).'&from=newwave&text='.rawurlencode($msg).'';
                                $ch = curl_init($url);
                                if($ch)
                                {
                                    $sent=TRUE;
                                }
                                else
                                {
                                    $sent=FALSE;
                                }
                                curl_exec($ch);
                                curl_close($ch);
                            }

                        }
                    }

                    if($sent==TRUE)
                    {
                        //if message is sent
                        if($sent==TRUE)
                        {
                            $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                            $str.='Message sent to all <b>'.$this->uri->segment(4).'</b> subscribers';
                            $str.='</div>';
                        }
                    }

            }
            else
            {
                $str.='<div class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                $str.='Project has no subscribers';

                $str.='</div>';
            }
            echo $str;
        }
        else
        {
            //if a project is chosen
            if($this->uri->segment(4))
            {
                $data['main_content']=$this->uri->segment(1).'/project_sms_v';
                $data['pagetitle']=remove_dashes($this->uri->segment(4)).' Messages';
                $data['page_description']='Send messages to '.remove_dashes($this->uri->segment(4));
                //echo remove_zeros('87759570998');



                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                $data['main_content']=$this->uri->segment(1).'/send_msg_by_project_v';
                $data['pagetitle']='Send Messages';
                $data['page_description']='Send messages to users by project';
                //echo remove_zeros('87759570998');
                //print_array($this->session->all_userdata());
                $limit=25;
                if($this->session->userdata('logged_in_usertype')==1)
                {
                    $data['all_projects']=$this->project_m->get_all($trashed='n');


                    $data['all_projects_paginated']= $this->project_m->get_paginated($num=$limit,$this->uri->segment(4));
                }
                else
                {
                    $where=array
                    (
                        'userid'=>$this->session->userdata('user_id'),
                        'trash'=>'n'
                    );

                    //extract id
                    $project_info=$this->project_magement_m->get_where($where);

                    //echo $this->db->last_query();

                    foreach($project_info as $info)
                    {
                        $id=$info['projectid'];
                    }



                    $data['all_projects']=$this->project_m->get_by_id($id);

                    $where=array
                    (
                        'id'=>$id
                    );



                    $data['all_projects_paginated']= $this->project_m->get_paginated_by_criteria($num=$limit,$this->uri->segment(4),$where);
                }

                //pagination configs
                $config=array
                (
                    'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/send_by_project',//contigure page base_url
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
        }

    }

    function sent_items()
    {
        $data['main_content']=$this->uri->segment(1).'/sent_items_v';
        $data['pagetitle']='Sent Messages';
        $data['page_description']='Listing of all outbound messages';
        //echo remove_zeros('87759570998');
        $limit=25;

        $where=array
        (
            'userid'=>$this->session->userdata('user_id'),
            'trash'=>'n'
        );
        //$this->project_magement_m->get_where($where);
        //print_array( $this->project_magement_m->get_where($where));
        if($this->session->userdata('user_id')==1)
        {
            $data['all_messages']=$this->sent_message_m->get_all($trashed='n');


            $data['all_messages_paginated']= $this->sent_message_m->get_paginated($num=$limit,$this->uri->segment(4));
        }
        else
        {
            foreach($this->project_magement_m->get_where($where) as $row)
            {
                $project=$row['projectid'];
            }
            $where=array
            (
                'project'=>$project,
                'trash'=>'n'
            );
            $data['all_messages']=$this->sent_message_m->get_where($where);


            $data['all_messages_paginated']= $this->sent_message_m->get_paginated_by_criteria($num=$limit,$this->uri->segment(4),$where);
        }


        //pagination configs
        $config=array
        (
            'base_url'          => base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows'        => count($data['all_messages']),
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
	
	function Outgoing_pdf()
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		foreach($data['all_messages']=$this->sent_message_m->get_all($trashed='n') as $outgoing)
        {
			$db_data[] = array('id' => $outgoing['id'], 'tel' => '0'.$outgoing['tel'], 'message' => $outgoing['message'], 'instructions' => $outgoing['message'], 'datecreated' => $outgoing['datecreated']);
		}
		
		$col_names = array(
			'id'		=> 'No.'	,
			'tel'		=> 'Contact Number',
			'message' => 'SMS Sent',
			'instructions'	=> 'Instructions',
			'datecreated' => 'Date sent'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE SENT SMS', array('width'=>550));
		$this->cezpdf->ezStream();
	}
	


}