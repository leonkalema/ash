<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 24/05/14
 * Time: 14:01
 */

//get current full name
function get_user_basic_info($id, $parameter)
{
    $ci=& get_instance();
    $ci->load->model('user_m');

    $basic_info=$ci->user_m->get_by_id($id);

    if(is_array($basic_info))
    {
        foreach ($basic_info as $info)
        {
            switch($parameter)
            {
                //firstname
                case 'firstname':
                    $result=$info['fname'];
                    break;
                //lastname
                case 'lastname':
                    $result=$info['lname'];
                    break;
                //email
                case 'email':
                    $result=$info['email'];
                    break;
                //avatar
                case 'avatar':
                    $result=$info['avatar'];
                    break;
                //firstname
                case 'usertype':
                    $result=
                        $info['usertype'];

                    break;
                default:
                    $result='<div class="panel panel-primary">';
                    $result.='<div class="panel-heading">Basic information</div>';
                    $result.='<div class="panel-body">';

                    $result.='<b>Firstname</b>' .$info['firstname'];
                    $result.='<b>Lastname</b>' .$info['lastname'];
                    $result.='<b>Email</b>' .$info['email'];
                    $result.='<b>Avatar</b>' .$info['avatar'];
                    $result.='<b>Usertype</b>' .$info['usertype'];

                    $result.='</div>';
                    $result.='<div class="panel-footer"><a class="btn" href="">Edit</a> </div>';
                    $result.='</div>';
            }
        }



        return $result;
    }
    else
    {
        return NULL;
    }



function get_user_info_by_slug($slug,$param)
{
    $ci=& get_instance();
    $ci->load->model('user_m');

    return $ci->user_m->get_info_by_slug($slug,$param);
}



}

function get_user_additional_info($id, $parameter)
{
    $ci=& get_instance();
    $ci->load->model('user_additional_info_m');

    $additional_info=$ci->user_additional_info_m->get_user_additional_info($id,$parameter);





    return $additional_info;



}

function display_avatar($user_id,$type)
{
    $ci=& get_instance();
    $ci->load->model('user_m');

    $user_info=$ci->user_m->get_by_id($user_id);

    //extract the profile image
    foreach($user_info as $info)
    {
        $avatar=$info['avatar'];
        $pieces = explode(".", $avatar);
        switch ($type)
        {
            //when thumbnail is requested
            case 'thumbnail':
                //if profile pic is not the default
                if($pieces[0]!='avatar')
                {
                    $str='uploads/profile_pics/thumbs/'.$pieces[0].'_thumb.'.$pieces[1];
                }
                else
                {
                    //if user has never changed the pic
                    $str='uploads/thumbs/'.$pieces[0].'_thumb.'.$pieces[1];
                }

                break;
            default:
                //if profile pic is not the default
                if($pieces[0]!='avatar')
                {
                    $str='uploads/profile_pics/'.$pieces[0].'_thumb.'.$pieces[1];
                }
                else
                {
                    $str='uploads/'.$avatar;
                }


        }

        //return the result
        return $str;

    }
}

function get_user_avatar($user_id)
{
    $ci=& get_instance();
    //load model
    $ci->load->model('user_m');

    $image_name=$ci->user_m->get_user_info($user_id, 'avatar');

    //if user has no avatar
    if(!$image_name)
    {
        return '<img width="24px" height="24px" src="'.base_url().'uploads/thumbs/avatar_thumb.jpg"/>';

    }
    else
    {
        //get user image
        $pieces=explode('.',$image_name);
        $thumbnail=$pieces[0].'_thumb'.$pieces[1];
        $str='<img width="24px" height="24px" src="'.base_url().'uploads/profile_pics/thumbs/"'.$thumbnail.'/>';
        return $str;
    }
}

function get_user_info_by_id($id='',$param='')
{
    $ci=& get_instance();
    $ci->load->model('user_m');

    return $ci->user_m->get_user_info($id, $param);
}

function get_user_info_by_telephone($telephone)
{
    $ci=& get_instance();
    $ci->load->model('user_m');

    $where=array
    (
        'tel'=>$telephone
    );

    return $ci->user_m->get_where($where);
}

function get_user_id_by_telephone($telephone)
{
    $ci=& get_instance();
    $ci->load->model('user_m');
    $info=get_user_info_by_telephone($telephone)  ;

    foreach($info as $row)
    {
        return $row['id'];
    }
}

function logged_in_user($param)
{
    $ci=& get_instance();
    switch($param)
    {
        //get id
        case 'id':
            $result=$ci->session->userdata('logged_in_user_id');
            break;

        //get firstname
        case 'firstname':
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'firstname');
            break;

        //get lastname
        case 'lastname':
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'lastname');
            break;

        //get fullname
        case 'fullname':
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'firstname').' '.get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'lastname');
            break;

        //get email
        case 'email':
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'email');
            break;

        //get usertype
        case 'usertype':
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'user_type');
            break;

        //get avatar
        case 'avatar':
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'avatar');
            break;

        default:
            $result=get_user_info_by_id($ci->session->userdata('logged_in_user_id'),'');
    }

    return $result;
}

function get_active_users()
{
    $ci=& get_instance();
    $ci->load->model('user_m');
    $where=

        array
        (
            'trash' =>'n'
        );

    return $ci->user_m->get_where($where);
}

function get_inactive_users()
{
	$ci=&get_instance();
	$ci->load->model();
	$where=
	array
	(
		'trash'=>'y'
	);
	
	return $ci->user_m->get_where($where);
}

function get_users_by_district($district_id)
{
    $ci=& get_instance();
    $ci->load->model('user_additional_info_m');
    $where=

        array
        (
            'district'=>$district_id,
            'trash' =>'n'
        );

    return $ci->user_additional_info_m->get_where($where);
}

function get_users_by_project($project_id)
{
    $ci=& get_instance();
    $ci->load->model('project_subscription_m');
    $where=

        array
        (
            'project_id'=>$project_id,
            'trash' =>'n'
        );

    return $ci->project_subscription_m->get_where($where);
}

function get_deactivated_users()
{
    $ci=& get_instance();
    $ci->load->model('user_m');
    $where=

        array
        (
            'trash' =>'y'
        );

    return $ci->user_m->get_where($where);
}


function get_users_by_usertype($usertype_id)
{
    $ci=& get_instance();
    $ci->load->model('user_m');
    $where=

        array
        (
            'usertype'      =>$usertype_id,
            'trash'         =>'n'
        );

    return $ci->user_m->get_where($where);
}



