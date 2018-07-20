<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 10:06 PM
 */
class Current_projects extends MY_frontend_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load dependencies
        $this->load->model('project_m');

        $this->load->model('project_subscription_m');

        $this->load->model('from_dump_yard_m');
    }

    function index()
    {

        redirect(base_url().'current_projects/page');
    }

    function page()
    {
        //print_array($this->project_m->get_all());
        $data['main_content']='public/current_projects_v';
        $data['pagetitle']=ucwords('CURRENT PLATFORMS');//dashboard title
        $data['page_description']='Listing of currently active platforms';//dashboard title
        $data['all_projects']=$this->project_m->get_all();

        $limit = 25;
        $data['all_projects_paginated'] = $this->project_m->get_paginated($num = $limit, $this->uri->segment(4));
        //pagination configs
        $config = array
        (
            'base_url' => base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows' => count($data['all_projects']),
            'per_page' => $limit,
            'num_links' => $limit,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<div class="btn-group">',
            'full_tag_close' => '</div>',
            'anchor_class' => 'class="btn" ',
            'cur_tag_open' => '<div class="btn">',
            'cur_tag_close' => '</div>',
            'uri_segment' => '4'

        );
        //initialise pagination
        $this->pagination->initialize($config);

        //add to data array
        $data['pages'] = $this->pagination->create_links();
        //load view

        //load the admin dashboard view
        $this->load->view('public/includes/frontend_template',$data);

    }

    function details()
    {
       if($this->input->post('ajax'))
       {
          //print_array($_POST) ;
           //then update
           $config = array
           (
               //user type name
               array
               (
                   'field'   => 'tel',
                   'rules'   => 'trim|required|numeric|min_length[10]|max_length[10]|is_unique[users.tel]|regex_match[/^07[0-9]{7,10}$/]|xss_clean',
                   'label'   =>  'Telephone number'
               ),
           );

           $this->form_validation->set_rules($config);

           $str='';
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
               if(get_user_id_by_telephone($this->input->post('tel')))
               {
                  //0789567456
                   $userdata=array
                   (
                       'project_id'=>get_project_id_by_slug($this->uri->segment(3)),
                       'user_id'=>get_user_id_by_telephone($this->input->post('tel'))
                   );

                   if($this->project_subscription_m->create($userdata))
                   {
                       $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                       $str.='You have been successfully subscribed';

                       $str.='</div>';
                   }

               }
               else
               {
                   $userdata=array
                   (
                       'tel'=>$this->input->post('tel')
                   );
                   $user_id=$this->user_m->create($userdata);

                   if($user_id)
                   {
                       $userdata=array
                       (
                           'project_id'=>get_project_id_by_slug($this->uri->segment(3)),
                           'user_id'=>$user_id
                       );

                       if($this->project_subscription_m->create($userdata))
                       {
                           $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                           $str.='You have been successfully subscribed';

                           $str.='</div>';
                       }
                       else
                       {
                           $str.='<div class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                           $str.='Please try again';

                           $str.='</div>';
                       }
                   }
               }
           }

           echo $str;


       }
        else
        {
            //$this->db->show_tables();
            $data['main_content']='public/project_details_v';
            $data['pagetitle']=$this->uri->segment(3);//dashboard title
            $data['page_description']='Description and subscription';//dashboard title

            //load the admin dashboard view
            $this->load->view('public/includes/frontend_template',$data);
            //redirect(base_url().'admin/login');
        }

    }

    function unsubscribe()
    {
        if($this->input->post('ajax'))
        {
            //then update
            $config = array
            (
                //user type name
                array
                (
                    'field'   => 'tel',
                    'rules'   => 'trim|required|numeric|min_length[10]|max_length[10]|regex_match[/^07[0-9]{7,10}$/]|xss_clean',
                    'label'   =>  'Telephone number'
                ),

            );

            $this->form_validation->set_rules($config);

            $str='';
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
                if(get_user_id_by_telephone($this->input->post('tel')))
                {
                    $userdata=array
                    (
                        'tel'=>$this->input->post('tel')
                    );

                    $id = get_user_id_by_telephone($this->input->post('tel'));

                    $user_id=$this->user_m->delete($id);

                    if($user_id)
                    {

                        $where = array
                        (
                            'trash'=>'y',
                        );

                        

                        if($this->project_subscription_m->update_by('user_id',$id,$where))
                        {
                            $str.='<div class="alert alert-dismissable alert-success">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h3>Notice !</h3>';
                            $str.='You have been successfully unsubscribed';

                            $str.='</div>';
                        }
                        else
                        {
                            $str.='<div class="alert alert-dismissable alert-danger">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h3>Notice !</h3>';
                            $str.='Please try again';

                            $str.='</div>';
                        }
                    }
                }
            }

            echo $str;

        }
        else
        {
            //$this->db->show_tables();
            $data['main_content']='public/project_details_v';
            $data['pagetitle']=$this->uri->segment(3);//dashboard title
            $data['page_description']='Description and subscription';//dashboard title

            //load the admin dashboard view
            $this->load->view('public/includes/frontend_template',$data);
            //redirect(base_url().'admin/login');
        }

    }
}
