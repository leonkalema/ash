<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 6:49 AM
 */
function get_pages_by_category($category_id)
{
    $ci=& get_instance();
    $ci->load->model('page_m');
    $where=array
    (
        'category_id'=>$category_id
    );

    return $ci->page_m->get_where($where);

}

function get_pages_info_by_id($id,$param)
{
    $ci=& get_instance();
    $ci->load->model('page_m');


    return $ci->page_m->get_page_by_id($id,$param);

}