<?php
class Project_m extends MY_Model
{
    public $_tablename = 'projects';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();

        $this->update_slugs();

    }

    //list available projects
    function get_project_by_id($id = '', $param = '')
    {
        if($id == '')
        {
            return NULL;
        }
        else
        {
            $query = $this->db->select()->from($this->_tablename) ->where($this->_primary_key,$id)->get();
        }

        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                switch($param)
                {
                    case 'title':
                        $result = $row['title'];
                        break;
                    case 'projectdetails':
                        $result = $row['projectdetails'];
                        break;
                    case 'description':
                        $result = $row['projectdetails'];
                        break;
                    case 'shortcode':
                        $result = $row['shortcode'];
                        break;
                    case 'dateadded':
                        $result = $row['dateadded'];
                        break;
                    case 'dateupdated':
                        $result = $row['dateupdated'];
                        break;
                    case 'author':
                        $result = $this->user_m->get_user_info($user_id = $row['author'], $param = 'fullname');
                        break;
                    case 'trash':
                        $result = $row['trash'];
                        break;
                    case 'slug':
                        $result = $row['slug'];
                        break;
                    default:
                        $result = $query->result_array();
                }
            }

            return $result;
        }
        else
        {
            return NULL;
        }


    }

    //list available projects
    function get_project_by_shortcode($shortcode = '', $param = '')
    {
        if($shortcode == '')
        {
            return NULL;
        }
        else
        {
            $query = $this->db->select()->from($this->_tablename) ->where('shortcode',$shortcode)->get();
        }

        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                switch($param)
                {
                    case 'title':
                        $result = $row['title'];
                        break;
                    case 'id':
                        $result = $row['id'];
                        break;
                    case 'projectdetails':
                        $result = $row['projectdetails'];
                        break;
                    case 'dateadded':
                        $result = $row['dateadded'];
                        break;
                    case 'dateupdated':
                        $result = $row['dateupdated'];
                        break;
                    case 'author':
                        $result = $this->user_m->get_user_info($user_id = $row['author'], $param = 'fullname');
                        break;
                    case 'trash':
                        $result = $row['trash'];
                        break;
                    case 'slug':
                        $result = $row['slug'];
                        break;
                    default:
                        $result = $query->result_array();
                }
            }

            return $result;
        }
        else
        {
            return NULL;
        }


    }

    public function update_slugs()
    {
        foreach($this->get_all()as $row)
        {
            if($row['slug'] == '')
            {
                $data['slug'] = strtolower(seo_url($row['usertype']));
                $this->update($row['id'],$data);
            }
        }
    }

    public  function  project_assigned_to_user($userid,$trash)
    {
        $array = array("project_management.userid"=>$userid,"project_management.trash"=>$trash);

        $this->db->select()->from("projects");
        $this -> db->join("project_management","projects.id=project_management.projectid");
        $this ->db-> where($array);
        $query = $this->db->get();
        return $query->result_array();

    }

}