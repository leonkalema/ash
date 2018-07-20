<?php
class Category_m extends MY_Model
{
    public $_tablename = 'content_categories';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');


    }

    function get_category_by_id($id='',$param='')
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


    function get_category_by_slug($slug='',$param='')
    {
        if($slug=='')
        {
            return NULL;
        }
        else
        {
            $query=$this->db->select()->from($this->_tablename) ->where('slug',$slug)->get();
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

                    case 'id':
                        $result=$row['id'];
                        break;

                    case 'trash':
                        $result=$row['trash'];
                        break;
                    case 'author':
                        $result=$this->user_m->get_user_info($user_id=$row['author'], $param='fullname');
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