<?php
class Feedback_m extends MY_Model
{
    public $_tablename = 'feedback';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');

        $this->load->model('sub_county_m');

    }


    function get_feedback_by_id($id = '', $param = '')
    {
        if ($id == '') {
            return NULL;
        } else {
            $query = $this->db->select()->from($this->_tablename)->where($this->_primary_key, $id)->get();
        }

        if ($query->result_array()) {
            foreach ($query->result_array() as $row) {
                switch ($param) {

                    case 'title':
                        $result = $row['title'];
                        break;
                    case 'dateupdated':
                        $result = $row['dateupdated'];
                        break;
                    case 'dateadded':
                        $result = $row['dateadded'];
                        break;
                    case 'sub_county':
                        $result =$this->sub_county_m->get_sub_county_by_id($id=$row['sub_county_id'],$param='title') ;
                        break;
                    case 'trash':
                        $result = $row['trash'];
                        break;
                    case 'sub_county_id':
                        $result = $row['sub_county_id'];
                        break;
                    case 'author':
                        $result = $this->user_m->get_user_info($user_id = $row['author'], $param = 'fullname');
                        break;
                    default:
                        $result = $query->result_array();
                }
            }

            return $result;
        } else {
            return NULL;
        }
    }
	
	function get_feedback($isactive = 'Y', $param = array())
    {
		$where_str = '';
        if (!empty($param)){
			foreach($param as $key=>$val)
				$where_str .= (!empty($where_str)? ' AND ' : ' ') . $key . '="' . $val . '"';
				
			$where_str = ' AND ' . $where_str;
        }
		
		$feedback_sql = 'SELECT feedback.message, feedback.phone, feedback.dateadded, parishes.title AS parish, districts.title AS district,'.
						'sub_counties.title AS subcounty, feedback.id AS feedbackid, users.fname, users.lname FROM '.
						'users LEFT OUTER JOIN districts ON users.district = districts.id '.
						'LEFT OUTER JOIN sub_counties ON users.subcounty = sub_counties.id '.
						'LEFT OUTER JOIN parishes ON users.parish = parishes.id '.
						'INNER JOIN feedback ON feedback.phone = users.tel '.
						'WHERE feedback.isactive = "'.$isactive.'" ' . $where_str;
						
		exit($feedback_sql);
		return $this->db->query($feedback_sql)
				->result_array();
    }
}