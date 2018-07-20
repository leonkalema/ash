<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/9/2014
 * Time: 1:36 PM
 */
function get_subscribers_by_project($slug)
{

    $ci=& get_instance();
    $ci->load->model('project_subscription_m');
    $ci->load->model('project_m');

    $where=array
    (
        'project_id'=>get_project_id_by_slug($slug),
    );
    //$ci->project_subscription_m->get_where($where);
    //echo $ci->db->last_query();

    return $ci->project_subscription_m->get_where($where);

}

function get_project_subscribers($slug)
{
	$ci=& get_instance();
    $ci->load->model('project_subscription_m');
    $ci->load->model('project_m');
	$ci->load->model('user_m');
	
	$where=array
    (
        'project_id'=>get_project_id_by_slug($slug),
		'user_id'=>get_by_id($id),
    );
	echo $ci->db->last_query();
}

function check_subscriber_by_id($subscriber_id,$project)
{
    $ci=& get_instance();
    $ci->load->model('project_subscription_m');
    $where=array
    (
        'user_id'=>$subscriber_id,
        'project_id'=>$project,
    );
    return $ci->project_subscription_m->get_where($where);
}

