<?php

class MY_Model extends CI_Model
{

    public $_tablename;
    public $_primary_key;

    function __construct()
    {
        //load ci model
        parent::__construct();
    }

    //visible and trashed
    public function get_all()//visible is either y or n
    {
        $query=$this->db->select()->from($this->_tablename)->where('trash','n')->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    //get by id
    public function get_by_id($id='')
    {
        //if its empty get all visible
        if($id=='')
        {
            $query=$this->db->select()->from($this->_tablename)->where('trash','n')->order_by($this->_primary_key,'DESC')->get();
        }
        else
        {
            $data=array
            (
                'id'        =>$id,
                'trash'   =>'n'
            );
            $query=$this->db->select()->from($this->_tablename)->where($data)->order_by($this->_primary_key,'DESC')->get();

        }
        //echo $this->db->last_query();

        return $query->result_array();
    }

    //get paginated
    public function get_paginated($num=20,$start)
    {
        //echo $this->$_primary_key.'foo';
        //build query
        $q=$this->db->select()->from($this->_tablename)->limit($num,$start)->where('trash','n')->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();

        //return result
        return $q->result_array();

    }

    //create
    public function create($data)
    {
        $this->db->insert($this->_tablename,$data);
        //echo $this->db->last_query();
        return $this->db->insert_id();

    }

    function check_by_slug($slug='')
    {
        if($slug=='')
        {
            return NULL;
        }
        else
        {
            $data=array
            (
                'trash' =>'n',
                'slug'      =>$slug
            );
            //$this->output->cache(60); // Will expire in 60 minutes
            $query=$this->db->select()->from($this->_tablename)->where($data)->order_by($this->_primary_key,'DESC')->get();

            if($query->num_rows()>0)
            {
                foreach ($query->result() as $row)
                {
                    return $row->id;

                }

            }
            else
            {
                return FALSE;
            }
        }
    }

    public function get_by_slug($slug)
    {
        if(!$slug)
        {
            return NULL;
        }
        else
        {
            $query=$this->db->select()->from($this->_tablename)->where('slug',$slug)->order_by($this->_primary_key,'DESC')->get();

            return $query->result_array();
        }



    }

    //when multiple parameters are given
    public function get_where($where)
    {
        $query=$this->db->select()->from($this->_tablename)->where($where)->order_by($this->_primary_key,'DESC')->get();

        //echo $this->db->last_query();

        return $query->result_array();
    }

    //delete
    public function delete($id)
    {
        //security purposes
        if(!$id)
        {
            //if an id has not been passed
            return FALSE;
        }
        else
        {
            $this->db->where('id',$id);
            $data=array
            (
                'trash'=>'y'
            );
            $this->db->update($this->_tablename, $data);
            //echo $this->db->last_query();

            return $this->db->affected_rows();
        }
    }

    //update
    public function update($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_tablename, $data);

        //echo $this->db->last_query();

        return $this->db->affected_rows();

    }

    //update by
    public function update_by($key,$key_value,$data)
    {
        $this->db->where($key, $key_value);
        $this->db->update($this->_tablename, $data);

        //echo $this->db->last_query();

        return $this->db->affected_rows();

    }



    //prevent duplicate editing
    function verify_item($id,$item,$field)
    {
        $query=$this->db->select()->from($this->_tablename)->where($field,$item)->order_by($this->_primary_key,'DESC')->get();

        //echo $this->db->last_query();
        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                //echo $row['id'];
                if($row['id']==$id)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
        }
        else
        {
            return TRUE;
        }


        }



    //get paginated
    public function get_paginated_by_criteria($num=20,$start,$criteria)
    {
        //build query
        $q=$this->db->select()->from($this->_tablename)->limit($num,$start)->where($criteria)->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();

        //return result
        return $q->result_array();

    }


    //search
    public function search($data)
    {
        $query=$this->db->select()->from($this->_tablename)->like($data)->order_by($this->_primary_key,'DESC')->get();
        return $query->result_array();
    }

    //get latest
    function get_latest($limit=20)
    {
        $query=$this->db->select()->from($this->_tablename)->where('trash','n')->order_by($this->_primary_key,'DESC')->limit($limit)->get();
        return $query->result_array();
    }

    //update empty slugs
    public function update_slugs()
    {
        foreach($this->get_all()as $row)
        {
            if($row['slug']=='')
            {
                $data['slug']=strtolower(seo_url($row['title']));
                $this->update($row['id'],$data);
            }
        }
    }


    //to upload csv files
    function insert_csv($data)
    {
        $this->db->insert($this->_tablename, $data);
    }


    //to hard delete
    function hard_delete($id)
    {
        $where=array
        (
            $this->_primary_key=>$id
        );
        $this->db->delete($this->_tablename,$where);
		//echo $this->db->last_query();

        return $this->db->affected_rows();

    }



}
