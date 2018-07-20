<?php
class Parish_m extends MY_Model
{
    public $_tablename = 'parishes';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');

        $this->load->model('sub_county_m');

    }


    function get_parish_by_id($id = '', $param = '')
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
}