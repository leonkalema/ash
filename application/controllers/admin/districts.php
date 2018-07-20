<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/5/2014
 * Time: 11:45 PM
 */

class Districts extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('district_m');

    }

    //admin home page
    function index()
    {
        //redirect to page
        redirect(base_url() .$this->uri->segment(1).'/' . $this->uri->segment(2) . '/page');
    }

    function page()
    {
        $data['main_content'] = $this->uri->segment(1).'/districts_home';
        $data['pagetitle'] = 'Districts';
        $data['page_description'] = 'All districts listing';

        $data['all_districts'] = $this->district_m->get_all();

        $limit = 25;
        $data['all_districts_paginated'] = $this->district_m->get_paginated($num = $limit, $this->uri->segment(4));
        //pagination configs
        $config = array
        (
            'base_url' => base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/page',//contigure page base_url
            'total_rows' => count($data['all_districts']),
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
        $this->load->view('admin/includes/dashboard_template', $data);

    }

    //add new
    function add()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
            $config = array
            (

                array
                (
                    'field'   => 'district',
                    'label'   => 'District name',
                    'rules'   => 'required|is_unique[districts.title]'
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
                //gather district data
                $district_data=array
                (
                    'title'     =>$this->input->post('district'),
                    'slug'      =>strtolower(seo_url($this->input->post('district'))),
                    'dateadded' =>mysqldate()
                );
                if($this->district_m->create($district_data))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3> ';
                    $str.='District was successfully added';
                    $str.=jquery_clear_fields();
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                    $str.='District was not added. Please try one more time';
                    $str.='</div>';
                }

            }
            echo $str;
        }
        else
        {
            $data['main_content']='admin/new_district_v';
            $data['pagetitle']='New district';
            $data['page_description']='Add a new district';



            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }


    }

    //edit
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
                    'field'   => 'district',
                    'rules'   => 'trim',
                    'label'   =>  'District name'
                ),


            );

            $this->form_validation->set_rules($config);

            if($this->form_validation->run()== FALSE)
            {
                //if there were errors add them to the errors array
                $str.='<div class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Oh Snap!</h3>';
                $str.=validation_errors();

                $str.='</div>';


            }
            else
            {

                //build db data
                $dbdata=array
                (
                    'title'     =>$this->input->post('district'),
                    'slug'     =>strtolower(seo_url($this->input->post('district'))),
                );

                if($this->district_m->update($this->input->post('id'),$dbdata))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3>';
                    $str.=$this->input->post('usertype').' was successfully Edited';
                    $str.='</div>';
                }
                else
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Heads Up!</h3>';
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

            $district_info=$this->district_m->get_where($where);

            if($district_info)
            {
                $data['main_content']='admin/edit_district_v';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description']='Edit '.remove_underscore($this->uri->segment(4));

                $data['district_info']=$district_info;

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
    function delete()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            //if addition was successful
            $str='';
            if($this->district_m->hard_delete($this->input->post('passed_id')))
            {
                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well done!</h3> ';
                $str.='District was successfully deleted';
                $str.='</div>';

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $district_id=$this->district_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if district exists
            if($district_id)
            {
                //by default
                $data['main_content']       ='admin/confirm_box/confirm_delete_district_f';
                $data['pagetitle']          ='Delete '.ucwords(get_district_by_id($district_id,'title'));
                $data['page_description']   ='delete '.ucwords(get_district_by_id($district_id,'title'));
                $data['passed_id']          =$district_id;

                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }
        }


    }

    //import
    function  import()
    {
        $data['main_content']=$this->uri->segment(1).'/import_districts_v';
        $data['pagetitle']='Import districts';
        $data['page_description']='Import from Excel spreadsheets or CSV file';

        //if form is sent
        if($this->input->post('upload'))
        {

            $file_path=$this->district_m->do_file_upload('csv');

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
                    if(!is_numeric($item))
                    {
                        //prevent duplication

                        if(!$this->district_m->check_by_slug(strtolower(seo_url($item))))
                        {
                            $district_data=array
                            (
                                'title'     =>$item,
                                'slug'      =>strtolower(seo_url($item)),
                                'dateadded' =>mysqldate(),

                            );

                            //save to db
                            $this->district_m->create($district_data);

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
}