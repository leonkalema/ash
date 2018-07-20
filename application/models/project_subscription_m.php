<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 10/17/14
 * Time: 8:58 AM
 */
class Project_subscription_m extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');

    }
    public  $_tablename='project_subscription';
    public  $_primary_key='id';
    public $_order_by = 'id';

    public function get_project_subscription_info($passed_id='', $param='')
    {

        //if NO ID
        if($passed_id=='')
        {
            return NULL;
        }
        else
        {
            //get user info
            $query=$this->db->select()->from($this->_tablename)->where($this->_primary_key,$passed_id)->get();

            if($query->result_array())
            {
                foreach($query->result_array() as $row)
                {
                    //filter results
                    switch($param)
                    {
                        case 'user_id':
                            //$result=$row['user_id'];
                            $result=$row['user_id'];
                            break;

                        case 'user':
                            //$result=$row['user_id'];
                            $result=$this->user_m->get_user_info_by_telephone($row['user_id'],'fullname');
                            break;
                        case 'subscriber_id':
                            //$result=$row['user_id'];
                            $result=$row['user_id'];
                            break;

                        case 'subscriber':
                            $result=$this->user_m->get_user_info_by_telephone($row['user_id'],'fullname');
                            break;
                        case 'dateadded':
                            $result=$row['dataadded'];
                            break;
                        case 'dateupdated':
                            $result=$row['dateupdated'];
                            break;

                        case 'trash':
                            $result=$row['trash'];
                            break;


                        case 'slug':
                            $result=$row['slug'];
                            break;
                        default:
                            $result=$query->result_array();
                    }

                }

                return $result;
            }

        }
    }
}