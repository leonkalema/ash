<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/20/14
 * Time: 3:04 PM
 *
 * controls notifications CRUD
 */

class Notification_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public $_tablename='notifications';
    public $_primary_key='id';

    //mark as seen
    public function mark_as_seen($user_id,$msg_id)
    {
        $data=array
        (
            'seen'=>'y'
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);

    }

    //prevent duplications
    public function prevent_duplicate($notification_data){
        //the query
        $query=$this->db->select()->from('notifications')->where($notification_data)->get()  ;

        return $query->num_rows();
    }

    public function get_unseen_messages($userid,$param)
    {
        $data = array
        (
            'user_id'   =>$userid,
            'seen'      =>'n',
            'trash'     =>'n'
        );
        $query=$this->db->select()->from($this->_tablename)->where($data)->get();

        foreach($query->result_array() as $row)
        {
            switch($param)
            {
                //case of notifications
                case 'message':
                    $result=$row['notification'];
                    break;
                case 'alert_type':
                    $result=$row['alert_type'];
                    break;
                case 'dateadded':
                    $result=$row['dateadded'];
                    break;
                default:
                    $result=$query->result_array();
            }

            return $result;
        }
    }

}