<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/5/2014
 * Time: 11:45 PM
 */

class Parishes extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();


        $this->load->model('district_m');


        $this->load->model('sub_county_m');

        $this->load->model('parish_m');

    }

    //admin home page
    function index()
    {
        //redirect to page
        redirect(base_url() .$this->uri->segment(1).'/sub_counties');
    }

    function listing()
    {

        $sub_county_id=$this->sub_county_m->check_by_slug($this->uri->segment(4));

        //if it exists
        if($sub_county_id)
        {
            $data['main_content'] = $this->uri->segment(1).'/parish_listing_v';
            $data['pagetitle'] = ucwords(get_sub_county_by_id($sub_county_id,'district') .'|'.remove_dashes($this->uri->segment(4))).'| Parish listing';
            $data['page_description'] = 'All Parishes in '.ucwords(remove_dashes($this->uri->segment(4))).' sub county';


            $where=array
            (
                'sub_county_id'=>$sub_county_id,
                'trash'=>'n'
            );

            $data['all_parishes'] = $this->parish_m->get_where($where);
            $data['sub_county']=$sub_county_id;

            $limit = 25;
            $data['all_parishes_paginated'] = $this->parish_m->get_paginated_by_criteria($num = $limit, $this->uri->segment(4),$where);
            //pagination configs
            $config = array
            (
                'base_url' => base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4),//contigure page base_url
                'total_rows' => count($data['all_parishes']),
                'per_page' => $limit,
                'num_links' => $limit,
                'use_page_numbers' => TRUE,
                'full_tag_open' => '<div class="btn-group">',
                'full_tag_close' => '</div>',
                'anchor_class' => 'class="btn" ',
                'cur_tag_open' => '<div class="btn">',
                'cur_tag_close' => '</div>',
                'uri_segment' => '5'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages'] = $this->pagination->create_links();
            //load view

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template', $data);
        }
        else
        {
            show_404();
        }





    }

    //add new
    function add_to()
    {
        //if there is an ajax post
        if($this->input->post('ajax'))
        {
            $str='';
            $config = array
            (

                array
                (
                    'field'   => 'parish',
                    'label'   => 'Parish name',
                    'rules'   => 'required|is_unique[parishes.title]'
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
                //gather data
                $parish_data=array
                (
                    'title'     =>$this->input->post('parish'),
                    'sub_county_id'     =>$this->input->post('sub_county'),
                    'slug'      =>strtolower(seo_url($this->input->post('parish'))),
                    'dateadded' =>mysqldate(),
                    'author'    =>$this->session->userdata('user_id')

                );
                if($this->parish_m->create($parish_data))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3> ';
                    $str.='Parish was successfully added';
                    $str.=jquery_clear_fields();
                }
                else
                {
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Warning!</h3> ';
                    $str.='Parish was not added. Please try one more time';
                    $str.='</div>';
                }

            }
            echo $str;
        }
        else
        {
            $sub_county_id=$this->sub_county_m->check_by_slug($this->uri->segment(4));

            //if sub county exists exists
            if($sub_county_id)
            {
                $data['main_content']       ='admin/new_parish_v';
                $data['pagetitle']          ='New '.remove_dashes(ucwords($this->uri->segment(4))).' parish';
                $data['page_description']   ='Add a new parish to '.remove_dashes(ucwords($this->uri->segment(4)));
                $data['sub_county']         =$sub_county_id;


                //load the admin dashboard view
                $this->load->view('admin/includes/dashboard_template',$data);
            }
            else
            {
                show_404();
            }

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

                array
                (
                    'field'   => 'parish',
                    'rules'   => 'trim|required',
                    'label'   =>  'Parish'
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
                    'title'         =>$this->input->post('parish'),
                    'slug'          =>strtolower(seo_url($this->input->post('parish'))),
                    'dateupdated'   =>mysqldate(),
                    'author'        =>$this->session->userdata('user_id')
                );

                if($this->parish_m->update($this->input->post('id'),$dbdata))
                {
                    //echo $this->db->last_query();
                    //if there were errors add them to the errors array
                    $str.='<div class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well Done!</h3>';
                    $str.=$this->input->post('parish').' was successfully Edited';
                    $str.='</div>';
                }
                else
                {
                    //print_array($_POST);
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
            //verify if  exists
            $where=array
            (
                'slug'=>$this->uri->segment(4)
            );

            $parish_info=$this->parish_m->get_where($where);

            $parish_id=$this->parish_m->check_by_slug($this->uri->segment(4));

            //echo $parish_id;

            //print_array(get_parish_by_id($parish_id,'sub_county_id'));



            if($parish_info)
            {
                $data['main_content']='admin/edit_parish_v';
                $data['pagetitle']=ucwords(remove_dashes($this->uri->segment(4)));
                $data['page_description']='Edit '.remove_underscore($this->uri->segment(4));

                $data['parish_info']=$parish_info;

                $data['sub_county']=get_parish_by_id($parish_id,'sub_county_id');

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
            if($this->parish_m->delete($this->input->post('passed_id')))
            {
                $str.='<div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h3>Well done!</h3> ';
                $str.='Parish was successfully deleted';
                $str.='</div>';

            }

            echo $str;
        }
        else
        {
            //check slug availability
            $parish_id=$this->parish_m->check_by_slug($this->uri->segment(4));//check_by_slug spits out the user id

            //if district exists
            if($parish_id)
            {
                //by default
                $data['main_content']       ='admin/confirm_box/confirm_delete_parish_f';
                $data['pagetitle']          ='Delete '.ucwords(get_parish_by_id($parish_id,'title'));
                $data['page_description']   ='delete '.ucwords(get_parish_by_id($parish_id,'title'));
                $data['passed_id']          =$parish_id;

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
        $data['main_content']='admin/import_districts_v';
        $data['pagetitle']='Import districts';
        $data['page_description']='Import from Excesll spreadsheets or CSV file';

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
                                'dateadded' =>mysqldate()
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

    //district
    function district()
    {
        //verify slug
        $district_id=$this->district_m->check_by_slug($this->uri->segment(4));

        if($district_id)
        {

            $criteria=array
            (
                'district_id'=>$district_id
            );

            $data['main_content'] = $this->uri->segment(1).'/district_counties_v';
            $data['pagetitle'] = ucwords(remove_dashes($this->uri->segment(4))).' Sub counties';
            $data['page_description'] = 'All sub counties in '.ucwords(remove_dashes($this->uri->segment(4)));

            $data['all_sub_counties'] = get_sub_country_by_district($district_id);

            $limit = 25;
            $data['all_sub_counties_paginated'] = $this->sub_county_m->get_paginated_by_criteria($num = $limit, $this->uri->segment(4),$criteria);
            //pagination configs
            $config = array
            (
                'base_url' => base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4),//contigure page base_url
                'total_rows' => count($data['all_sub_counties']),
                'per_page' => $limit,
                'num_links' => $limit,
                'use_page_numbers' => TRUE,
                'full_tag_open' => '<div class="btn-group">',
                'full_tag_close' => '</div>',
                'anchor_class' => 'class="btn" ',
                'cur_tag_open' => '<div class="btn">',
                'cur_tag_close' => '</div>',
                'uri_segment' => '5'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages'] = $this->pagination->create_links();
            //load view

            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template', $data);
        }
        else
        {
            //show 404
            show_404();
        }
    }
}