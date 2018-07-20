<?php
class Visitor_counter_m extends MY_Model
{
    public $_tablename = 'visitor_counter';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();

        $this->add_by_one();
    }

    function add_by_one()
    {
        if($this->get_all())
        {
            foreach($this->get_all() as $visitor)
            {
                if($visitor['last_session']!=$this->session->userdata('session_id'))
                {
                    //echo '1';
                    //$this->db->set('_count', 'star_count+'.$rating, FALSE);
                    $this->db->set('visit_count', 'visit_count + 1', FALSE);
                    $this->db->where("id", '1');
                    $this->db->update($this->_tablename);

                    $where=array
                    (
                        'last_session'=>$this->session->userdata('session_id')
                    );
                    $this->update('1',$where);
                }
            }

        }
        else
        {
            $data=array
            (
                'visit_count'=>'1'
            );

            $this->create($data);
        }
    }
}