<?php
class Page_m extends MY_Model
{
    public $_tablename = 'content_pages';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('category_m');


    }

    function get_page_by_id($id='',$param='')
    {
        if($id=='')
        {
            return NULL;
        }
        else
        {
            $query=$this->db->select()->from($this->_tablename) ->where($this->_primary_key,$id)->get();
        }

        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                switch($param)
                {

                    case 'title':
                        $result=$row['title'];
                        break;
                    case 'dateupdated':
                        $result=$row['dateupdated'];
                        break;
                    case 'dateadded':
                        $result=$row['dateadded'];
                        break;

                    case 'slug':
                        $result=$row['slug'];
                        break;

                    case 'trash':
                        $result=$row['trash'];
                        break;
                    case 'author':
                        $result=$this->user_m->get_user_info($user_id=$row['author'], $param='fullname');
                        break;
                    case 'category':
                        $result=$this->category_m->get_category_by_id($row['category_id'], $param='title');
                        break;
                    default:
                        $result=$query->result_array();
                }
            }

            return $result;
        }
        else
        {
            return NULL;
        }




    }

}