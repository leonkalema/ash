<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/12/2014
 * Time: 11:32 PM
 */
class Content extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('category_m');

        $this->load->model('page_m');

    }

    //admin home page
    function index()
    {
        //redirect to page
        redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/page');
    }

    function categories()
    {
        $data['main_content']='admin/categories_home_v';
        $data['pagetitle']='Page categories';
        $data['page_description']='Listing of page categories';

        $data['all_categories'] = $this->category_m->get_all();

        $limit = 25;
        $data['all_categories_paginated'] = $this->category_m->get_paginated($num = $limit, $this->uri->segment(4));
        //pagination configs
        $config = array
        (
            'base_url' => base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3),//contigure page base_url
            'total_rows' => count($data['all_categories']),
            'per_page' => $limit,
            'num_links' => $limit,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<div class="btn-group">',
            'full_tag_close' => '</div>',
            'anchor_class' => 'class="btn" ',
            'cur_tag_open' => '<div class="btn">',
            'cur_tag_close' => '</div>',
            'uri_segment' => '3'

        );
        //initialise pagination
        $this->pagination->initialize($config);

        //add to data array
        $data['pages'] = $this->pagination->create_links();
        //load view



        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);
    }


    //add new
    function add_category()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {

            $config = array
            (

                array
                (
                    'field'   => 'category',
                    'label'   => 'Category name',
                    'rules'   => 'required|is_unique[content_categories.title]'
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
                //gather  data
                $cat_data=array
                (
                    'title'     =>$this->input->post('category'),
                    'slug'      =>strtolower(seo_url($this->input->post('category'))),
                    'dateadded' =>mysqldate(),
                    'author'    =>$this->session->userdata('user_id')
                );
                if($this->category_m->create($cat_data))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                    $str.='Category was successfully added';
                    $str.=jquery_clear_fields();
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                    $str.='Category was not added. Please try one more time';
                    $str.='</div>';
                }

            }
            echo $str;
        }
        else
        {
            $data['main_content']='admin/new_category_v';
            $data['pagetitle']='New Category';
            $data['page_description']='Add a new content segment';



            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }


    }

    //edit
    function edit_category()
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
                    'field'   => 'category',
                    'rules'   => 'trim',
                    'label'   =>  'Category name'
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

                //build db data
                $dbdata=array
                (
                    'title'     =>$this->input->post('category'),
                    'slug'     =>strtolower(seo_url($this->input->post('category'))),
                    'author'=>$this->session->userdata('user_id')
                );

                if($this->category_m->update($this->input->post('id'),$dbdata))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                    $str.=$this->input->post('category').' was successfully Edited';
                    $str.='</div>';
                }
                else
                {
                    //echo $this->db->last_query();
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

            $category_info=$this->category_m->get_where($where);

            if($category_info)
            {
                $data['main_content']='admin/edit_category_v';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description']='Edit '.remove_underscore($this->uri->segment(4));

                $data['category_info']=$category_info;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }

        }


    }

    //delete
    function delete_category()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            //if addition was successful
            $str='';
            if($this->category_m->delete($this->input->post('passed_id')))
            {
                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                $str.='Category was successfully deleted';
                $str.='</div>';

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $category_id=$this->category_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if district exists
            if($category_id)
            {
                //by default
                $data['main_content']       ='admin/confirm_box/confirm_delete_category_f';
                $data['pagetitle']          ='Delete '.ucwords(get_category_by_id($category_id,'title'));
                $data['page_description']   ='delete '.ucwords(get_category_by_id($category_id,'title'));
                $data['passed_id']          =$category_id;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }
        }


    }

    function pages()
    {
        $category=$this->category_m->check_by_slug($this->uri->segment(4));

        if($category)
        {
            $where=array
            (
                'category_id'=>$category,
                'trash'=>'n'
            );

            $data['main_content']='admin/cat_pages_home_v';
            $data['pagetitle']=get_category_by_id($category,'title').' Pages';
            $data['page_description']='Listing of category specific pages';

            $data['all_pages']=$this->page_m->get_where($where);

            $limit = 25;
            $data['all_pages_paginated'] = $this->page_m->get_paginated_by_criteria($num = $limit, $this->uri->segment(4),$where);
            //pagination configs
            $config = array
            (
                'base_url' => base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3),//contigure page base_url
                'total_rows' => count($data['all_pages']),
                'per_page' => $limit,
                'num_links' => $limit,
                'use_page_numbers' => TRUE,
                'full_tag_open' => '<div class="btn-group">',
                'full_tag_close' => '</div>',
                'anchor_class' => 'class="btn" ',
                'cur_tag_open' => '<div class="btn">',
                'cur_tag_close' => '</div>',
                'uri_segment' => '3'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages'] = $this->pagination->create_links();
            //load view



            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }
        else
        {
            show_404();
        }

    }

    function new_page()
    {
      if($this->input->post('ajax'))
      {

          $config = array
          (

              array
              (
                  'field'   => 'title',
                  'label'   => 'Title name',
                  'rules'   => 'required|is_unique[content_pages.title]'
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
              //print_array($_POST);
              //print_array($slug_info);
              $page_data=array
              (
                  'title'=>$this->input->post('title'),
                  'content'=>$this->input->post('content'),
                  'category_id'=>$this->input->post('category'),
                  'slug'=>seo_url($this->input->post('title')),
                  'author'=>$this->session->userdata('user_id')
              );

              //if article created
              if($this->page_m->create($page_data))
              {
                  //echo $this->db->last_query();
                  //echo get_category_by_slug($this->input->post('content'));
                  $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                  $str.='Article successfully created';
                  $str.='</div>';
              }
          }

          //print_array($_POST);
          //echo $this->input->post('content')



          echo $str;
      }else
      {
          $category=$this->category_m->check_by_slug($this->uri->segment(4));

          if($category)
          {
              $data['main_content']='admin/new_page_v';
              $data['pagetitle']=get_category_by_id($category,'title').' New Page';
              $data['page_description']='Post a new article';
              $data['slug_id']=$category;

              //load the admin dashboard view
              $this->load->view('admin/includes/dashboard_template',$data);
          }
          else
          {
              show_404();
          }
      }

    }

    function edit_page()
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
                    'field'   => 'title',
                    'rules'   => 'trim|required',
                    'label'   =>  'Title'
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

                //build db data
                $dbdata=array
                (
                    'title'     =>$this->input->post('title'),
                    'slug'     =>strtolower(seo_url($this->input->post('title'))),
                    'content'   =>$this->input->post('content'),
                    'dateupdated'=>mysqldate(),
                    'author'=>$this->session->userdata('user_id')
                );

                if($this->page_m->update($this->input->post('id'),$dbdata))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3>';
                    $str.=$this->input->post('title').' was successfully Edited';

                    $str.=jquery_countdown_redirect(base_url().'admin/content/categories');
                    $str.='</div>';
                }
                else
                {
                    //echo $this->db->last_query();
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

            $page_info=$this->page_m->get_where($where);

            if($page_info)
            {
                $data['main_content']='admin/edit_page_v';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description']='Edit '.remove_underscore($this->uri->segment(4));

                $data['page_info']=$page_info;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }

        }

    }

    function delete_page()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            //if addition was successful
            $str='';
            if($this->page_m->delete($this->input->post('passed_id')))
            {
                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Notice !</h3> ';
                $str.='Page was successfully deleted';
                $str.='</div>';

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $page_id=$this->page_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if district exists
            if($page_id)
            {
                //by default
                $data['main_content']       ='admin/confirm_box/confirm_delete_page_f';
                $data['pagetitle']          ='Delete '.ucwords($this->uri->segment(4));
                $data['page_description']   ='delete '.ucwords($this->uri->segment(4));
                $data['passed_id']          =$page_id;

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