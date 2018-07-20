<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 12:23 AM
 */
function get_active_categories()
{
    $ci=& get_instance();
    $ci->load->model('category_m');
    $where=

        array
        (
            'trash' =>'n'
        );

    return $ci->category_m->get_where($where);
}

function get_category_by_id($id,$param='')
{
    $ci=& get_instance();
    $ci->load->model('category_m');

    return $ci->category_m->get_category_by_id($id,$param);

}


function get_category_by_slug($slug,$param='')
{
    $ci=& get_instance();
    $ci->load->model('category_m');

    return $ci->category_m->get_category_by_id($slug,$param);

}

