<?php
class Project_magement_m extends MY_Model
{
    public $_tablename = 'project_management';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();

        //$this->update_slugs();

    }

  
    function get_manager_by_id($userid,$projectid)
    {
        if($userid == '')
        {
            $where = array('trash'=>'n');
            $query = $this->db->select()->from($this->_tablename)->where($where)->get();
        }
        else
        {
			$where = array('userid'=>$userid,'projectid'=>$projectid,'trash'=>'n');
            $query = $this->db->select()->from($this->_tablename) ->where($where)->get();
        }

        $result = $query->result_array();
		return $result;


    }




}