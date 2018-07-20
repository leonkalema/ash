<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/10/2014
 * Time: 2:13 PM
 */
class From_dump_yard_m extends MY_Model
{
    public $_tablename = 'from_dump_yard';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');

        $this->load->model('project_m');

        //aways validate messages
        $this->validate_msgs();

        $this->load->model('received_msg_m');

    }

    function validate_msgs()
    {
        //get all messages that are unseen
        $where=array
        (
            'trash'=>'n',
            'status'=>'u'
        );

        $all_msg=$this->get_where($where);

        //loop through
        foreach($all_msg as $msg)
        {
            //extract short code
            $short_code=substr($msg['msg'],0,4);

            //verify short codes
            $where=array
            (
                'shortcode'=>$short_code,
                'trash'=>'n'
            );

            //if project does not exists update msg as invalid
            if(!$this->project_m->get_where($where))
            {
                //do update
                $where=array
                (
                    'invalid'=>'y'
                );

                $this->update($msg['id'],$where);

                //attempt to to guess shortcode
                $where=array
                (
                    'title'=>$msg['msg']
                );

                //search for project titles based on terms in the message limit result to one
                $src_result=array_slice($this->project_m->search($where),0,1);
                //echo $this->db->last_query();
                if($src_result)
                {
                    //loop through results
                    foreach($src_result as $result)
                    {
                        //update the form dump yard table
                        $where=array
                        (
                            'guessed'=>$result['shortcode']
                        );

                        $this->update($msg['id'],$where);
                    }

                }

            }
            else
            {
                //move message
                $msg_data=array
                (
                    'msg_id'=>$msg['id'],
                    'project_id'=>$this->project_m->get_project_by_shortcode($shortcode = $short_code, $param = 'id')
                );
                //prevent duplicates
                $where=array
                (
                    'msg_id'=>$msg['id']
                );
                $query=$this->db->select()->from('received_msgs')->where('msg_id',$msg['id'])->get();

                if(!$query->num_rows())
                {
                    $this->db->insert('received_msgs',$msg_data);
                }
            }

            //populate the shortcode field automatically
            $where=array
            (
                'shortcode'=>$short_code,
            );
            $this->update($msg['id'],$where);
            //$this->output->enable_profiler(TRUE);

        }

    }
}

