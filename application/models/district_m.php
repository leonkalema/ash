<?php
class District_m extends MY_Model
{
    public $_tablename='districts';
    public $_primary_key='id';
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');


    }


    function get_district_by_id($id='',$param='')
    {
        if($id=='')
        {
            return NULL;
        }
        else
        {
            $query=$this->db->select()->from($this->_tablename) ->where($this->_primary_key,$id)->get();
        }

        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                switch($param)
                {

                    case 'title':
                        $result=$row['title'];
                        break;
                    case 'dateupdated':
                        $result=$row['dateupdated'];
                        break;
                    case 'dateadded':
                        $result=$row['dateadded'];
                        break;

                    case 'trash':
                        $result=$row['trash'];
                        break;
                    case 'author':
                        $result=$this->user_m->get_user_info($user_id=$row['author'], $param='fullname');
                        break;
                    default:
                        $result=$query->result_array();
                }
            }

            return $result;
        }
        else
        {
            return NULL;
        }




    }



    function do_file_upload($folder_name){



        $config['upload_path']='./uploads/'.$folder_name;//remember to create a folder called uploads in root folder

        $config['allowed_types']='csv|xls|xlsx';

        //to prevent overly gigantic photos
        $config['max_size']='10000';//always in kilobytes
        $config['max_height']='130240';//aways in pixels
        $config['max_width']='10680';//aways in pixels

        //load the library and passin configs
        $this->load->library('upload',$config);

        //to perform the upload
        $upload= $this->upload->do_upload();

        //if upload successfull
        if ($upload)
        { //fetch image data
            $image_data=$this->upload->data();

            //echo $image_data['full_path'];
            return $image_data['full_path'];
        }
        else
        {

            return $this->upload->display_errors();
        }

    }






}
 