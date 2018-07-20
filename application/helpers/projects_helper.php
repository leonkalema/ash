<?php

function get_project_by_type_id($project_id,$param='')
{
    $ci=& get_instance();
    $ci->load->model('project_m');

    return $ci->project_m->get_project_by_id($project_id,$param);

}

function get_active_projects()
{
    $ci=&get_instance();
    $ci->load->model('project_m');
	$where=
	array
	(
		'trash'=>'n'
	);

    return $ci->project_m->get_where($where);
}

function get_inactive_projects()
{
	$ci=&get_instance();
	$ci->load->model();
	$where=
	array
	(
		'trash'=>'y'
	);
	
	return $ci->project_m->get_where($where);
}

function get_project_id_by_slug($slug)
{
    $ci=& get_instance();
    $ci->load->model('project_m');

    return $ci->project_m->check_by_slug($slug);
}

function get_project_id_by_shortcode($shortcode,$param)
{
    $ci=& get_instance();
    $ci->load->model('project_m');

    return $ci->project_m->get_project_by_shortcode($shortcode,$param);
}
