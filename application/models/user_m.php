<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 24/05/14
 * Time: 11:16
 */
class User_m extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        //auto create avatars for emprty profiles
        $this->autocreate_avatar();
        $this->autocreate_superuser();

        //update empty user slugs
        $this->update_slugs();
        //echo $this->db->last_query();


        //user type model
        $this->load->model('usertype_m');
        $this->load->model('user_additional_info_m');
        

        $this->flag_unfinished_profiles();

        $this->generate_pwd_for_flagged_users();


    }
    public  $_table_name='users';
    public  $_tablename='users';
    public  $_primary_key='id';
    protected $_order_by = 'id';
    protected $_email = '';
    protected $_password = '';
    protected $_firstname = '';
    protected $_lastname = '';
    protected $_avatar = '';
    protected $_timestamps=FALSE;

    //check if user is in system
    function authenticate_user($data)
    {
        $query=$this->db->select()->from($this->_table_name)->where($data)->get();
        //get the user id
        return $query->result_array();
    }

    //create default pic for empty profiles
    public function autocreate_avatar()
    {
        $users=$this->get_by_id($id='');//get all untrashed users
        foreach($users as $user)
        {
            //if there is no slug create one
            if($user['avatar']=='')
            {
                $data=array
                (
                    'avatar'=>'avatar.jpg'
                );
                $this->db->where('user_id', $user['user_id']);
                $this->db->update($this->_table_name, $data);
            }
        }
    }

    public function autocreate_superuser()
    {
        $users=$this->get_all();//get all active users
        //if there are no users create a superuser
        if(count($users)==0)
        {
            $user_data=array
            (
                'fname'     =>'super',
                'lname'     =>'user',
                'email'     =>'admin@gmail.com',
                'usertype'  =>'1',
                'password'  =>'e10adc3949ba59abbe56e057f20f883e',
                'avatar'    =>'avatar.jpg',
                'dateadded' =>mysqldate()
            );

            $this->create($user_data);
        }
    }

    public function get_user_info($user_id='', $param='')
{

    //if NO ID
    if($user_id=='')
    {
        return NULL;
    }
    else
    {
        //get user info
        $query=$this->db->select()->from($this->_tablename)->where('id',$user_id)->get();

        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                //filter results
                switch($param)
                {
                    case 'firstname':
                        $result=$row['fname'];
                        break;
                    case 'lastname':
                        $result=$row['lname'];
                        break;
                    case 'fullname':
                        $result=$row['fname'].' '.$row['lname'];
                        break;
                    case 'email':
                    $result=$row['email'];
                    break;
                    case 'usertype':
                        $result=$this->usertype_m->get_usertypes_by_id($row['usertype'],'usertype');
                        break;
                    case 'usertype_id':
                        $result=$row['usertype'];
                        break;

                    case 'dateadded':
                        $result=$row['dateadded'];
                        break;

                    case 'lastlogin':
                        $result=$row['lastlogin'];
                        break;

                    case 'avatar':
                        $result=$row['avatar'];
                        break;
                    case 'slug':
                        $result=$row['slug'];
                        break;

                    case 'tel':
                        $result=$row['tel'];
                        break;

                    case 'telephone':
                        $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'telephone');
                        break;

                    case 'avatar':
                        $result=$row['avatar'];
                        break;


                    case 'sub_county':
                        $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'sub_county');
                        break;

                    case 'parish':
                        $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'parish');
                        break;

                    case 'district':
                        $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'district');
                        break;

                    case 'd_o_b':
                        $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'d_o_b');
                        break;
                    default:
                        $result=$query->result_array();
                }

            }

            return $result;
        }

    }
}



    public function get_user_info_by_slug($slug='', $param='')
    {

        //if NO ID
        if($slug=='')
        {
            return NULL;
        }
        else
        {
            //get user info
            $query=$this->db->select()->from($this->_tablename)->where('slug',$slug)->get();

            if($query->result_array())
            {
                foreach($query->result_array() as $row)
                {
                    //filter results
                    switch($param)
                    {
                        case 'firstname':
                            $result=$row['fname'];
                            break;
                        case 'lastname':
                            $result=$row['lname'];
                            break;
                        case 'fullname':
                            $result=$row['fname'].' '.$row['lname'];
                            break;
                        case 'email':
                            $result=$row['email'];
                            break;
                        case 'usertype':
                            $result=$this->usertype_m->get_usertypes_by_id($row['usertype'],'usertype');
                            break;
                        case 'usertype_id':
                            $result=$row['usertype'];
                            break;

                        case 'avatar':
                            $result=$row['avatar'];
                            break;
                        case 'tel':
                            $result=$row['tel'];
                            break;

                        case 'telephone':
                            $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'telephone');
                            break;


                        case 'sub_county':
                            $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'sub_county');
                            break;

                        case 'parish':
                            $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'parish');
                            break;

                        case 'district':
                            $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'district');
                            break;

                        case 'd_o_b':
                            $result=$this->user_additional_info_m->get_user_additional_info($row['id'],'d_o_b');
                            break;


                        default:
                            $result=$query->result_array();
                    }

                }

                return $result;
            }

        }
    }




    public function update_slugs()
    {

        foreach($this->get_all()as $row)
        {
            if(!$row['slug'])
            {
                $data['slug']=now().random_string('numeric',8);
                $this->update($row['id'],$data);
                //echo $this->db->last_query();

            }
        }
    }


    function do_upload_update($folder_name){



        $config['upload_path']='./uploads/'.$folder_name;//remember to create a folder called uploads in root folder

        $config['allowed_types']='gif|png|jpg|jpeg';

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
        {


            //fetch image data
            $image_data=$this->upload->data();

            //resize the image
            //configs to resize image
            $config['image_library']='gd2';
            $config['source_image']=$image_data['full_path'];
            $config['create_thumb']=TRUE;
            $config['maintain_ratio']=TRUE;
            $config['width']=150;//in px always
            $config['height']=150;


            $config['new_image']='./uploads/'.$folder_name;

            //load image library and attach configs to it
            $this->load->library('image_lib',$config);

            //tell the library ti resize
            $this->image_lib->resize();

            //do the photo insert
            $photo_data['imageurl']=$image_data['file_name'];

            $image_data=array
            (
                'avatar'      =>$image_data['file_name']
            );

            $this->update($this->input->post('user_id'),$image_data);
            //echo $this->db->last_query();
            //print_array($_POST);


        }
        else
        {

            return $this->upload->display_errors();
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

    function flag_unfinished_profiles()
    {
        $where=array
        (
            'fname'=>'',
            'lname'=>'',
            'email'=>'',
            'password'=>''
        );

        $profiles=$this->get_where($where);

        foreach($profiles as $profile)
        {
            //update the flags
            if($profile['send_flag']=='off')
            {
                $where=array
                (
                    'send_flag'=>'on'
                );

                $this->update($profile['id'],$where);

            }
        }

    }

    function generate_pwd_for_flagged_users()
    {
        $where=array
        (
            'send_flag'=>'on'
        );

        $profiles=$this->get_where($where);

        foreach($profiles as $profile)
        {
            //generate random password
            $pwd=random_string('alnum', 8);
            //echo $profile['tel'];

            //$url = 'http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to=' . $profile['tel'] . "&from=newwave&text=" . $msg;
            //echo $url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to=2560775957998'.'&from=newwave&text=test'.'<br>';
            $url='http://sms.smsone.co.ug:8866/cgi-bin/sendsms?username=newave&password=eZog@8&to=256'.$profile['tel'].'&from=newwave&text='.$pwd.'';
            $ch = curl_init($url);
            //$response = curl_exec($ch);

            //turn off flag
            $where=array
            (
                'send_flag'=>'off'
            );

            $this->update($profile['id'],$where);

        }
    }
	
	//Search function
	function get_search() {
	  $match = $this->input->post(‘search’);
	  $this->db->like(‘bookname’,$match);
	  $this->db->or_like(‘author’,$match);
	  $this->db->or_like(‘characters’,$match);
	  $this->db->or_like(‘synopsis’,$match);
	  $query = $this->db->get(‘books’);
	  return $query->result();
	}
	


}