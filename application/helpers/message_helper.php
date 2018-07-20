<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/11/2014
 * Time: 7:43 AM
 */
function get_recieved_messages_by_shotcode($shortcode)
{
    $ci=& get_instance();
    $ci->load->model('from_dump_yard_m');

    $data=array
    (
        'shortcode'=>$shortcode,
        'trash'=>'n'
    );

    return $ci->from_dump_yard_m->get_where($data);

}