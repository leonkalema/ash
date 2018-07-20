<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/12/2014
 * Time: 7:33 PM
 */

//get user type y id
function get_count_visitiors()
{
    $ci=& get_instance();
    $ci->load->model('visitor_counter_m');
    //print_array($ci->visitor_counter_m->get_by_id('1'));

    foreach($ci->visitor_counter_m->get_by_id('1') as $visitor)
    {
        return $visitor['visit_count'];
    }



}