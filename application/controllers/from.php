<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/10/2014
 * Time: 12:59 PM
 */

/*
 * reception url format
 * http://academia-app.com/ACODE/from/number&msg/message&to/shortcode
 *
 * recieved message example
 *http://localhost/projects/ci_acode/from/0775896794&msg/hellotest&to/2338
 *verify that extract message does not already exist
 *
 * */
class From extends MY_frontend_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('from_dump_yard_m');
        $this->load->model('user_m');
        $this->load->model('project_subscription_m');

    }



    //admin home page
    function index()
    {

        if($this->input->post('ajax'))
        {

            $data['from']=$this->input->post('from');
            $data['msg']=$this->input->post('msg');
            $data['shortcode']=$this->input->post('shortcode');


            //print_array($url_data);

            //extract number
            $pieces=explode('&',$this->input->post('from'));
            $tel=$pieces[0];

            //extract message
            $pieces=explode('&',$this->input->post('msg'));
            $msg=$pieces[0];


            //extract shortcode
            $pieces=explode('&',$this->input->post('shortcode'));
            $shortcode=$pieces[0];

            //echo $shortcode;

           //validate number
            if(validate_telephone($tel)&&is_numeric($shortcode))
            {
                //filter for subscription or unsubscription
                //substr($msg,0,5); to subscribe
                if(strtolower(substr($msg,0,5))=='start')
                {
                    //get phone number and project short code
                    //if project exists move on to register
                    if(get_project_id_by_shortcode($shortcode,''))
                    {
                        //check if user exists
                        if(get_user_id_by_telephone($tel))
                        {
                            //if user exists
                            //just subscribe
                            $this->subscribe_user(get_user_id_by_telephone($tel,'id'),$shortcode);
                        }
                        else
                        {
                            //register to get id then subscribe
                            //print_array(get_project_id_by_shortcode($shortcode,'id'));
                            //register user first
                            $user_data=array
                            (
                                'tel'       =>$tel
                            );

                            $id = $this->user_m->create($user_data);
                            $this->subscribe_user($id,$shortcode);
                        }
                    }
                }
                elseif(strtolower(substr($msg,0,4))=='stop')
                {
                    if(get_project_id_by_shortcode($shortcode,''))
                    {
                        //check if user exists
                        if(get_user_id_by_telephone($tel))
                        {
                            //if user exists
                            //just subscribe
                            $this->unsubscribe_user(get_user_id_by_telephone($tel,'id'),$shortcode);
                        }

                    }
                }
                else
                {
                    //its a normal message
                    $where=array
                    (
                        'from'=>$tel,
                        'msg'=>$msg,
                        'to'=>$shortcode,
                    );
                    //check for duplicate
                    if(!$this->from_dump_yard_m->get_where($where))
                    {

                        $msg_data=array
                        (
                            'from'      =>$tel,
                            'msg'       =>$msg,
                            'to' =>$shortcode
                        );
                        //ave message
                        if($this->from_dump_yard_m->create($msg_data))
                        {
                            //echo $this->db->last_query();
                            echo success_template('Message was recieved');
                        }
                    }
                    else
                    {
                        echo warning_template('Duplicate message');
                    }

                }

            }
            else
            {
                echo error_template('Message invalid');
            }


        }
        else
        {
            $data['main_content']='public/from_dump_yard_v';
            $data['pagetitle']='SMS RECEPTION';
            $data['page_description']='Incoming sms';


            //load the admin dashboard view
            $this->load->view('admin/includes/dashboard_template',$data);
        }


    }

    function ajax_calls()
    {
        if($_POST)
        {
            echo 'foo';
        }


    }

    function subscribe_user($user_id,$shortcode)
    {
        //then subscribe user
        $subscriber_data=array
        (
            'user_id'=>$user_id,
            'project_id'=>get_project_id_by_shortcode($shortcode,'id')
        );


        //prevent duplicate
        if(!check_subscriber_by_id($user_id,get_project_id_by_shortcode($shortcode,'id')))
        {
            print_array($subscriber_data);
            $this->project_subscription_m->create($subscriber_data);

            //send notification message
            $msg_content='You have subscribed to '.get_project_id_by_shortcode($shortcode,'title').' To stop unsubscribe send STOP_'.$shortcode.' to 8888';
            send_subscription_message(get_user_info_by_id($user_id,'tel'),$msg_content);
        }
        else
        {
            //if user already subscribed
            //send message to the subscriber
            $msg_content='You are already subscribed to '.get_project_id_by_shortcode($shortcode,'title').' To stop unsubscribe send STOP_'.$shortcode.' to 8888';
            send_subscription_message(get_user_info_by_id($user_id,'tel'),$msg_content);
        }
    }


    function unsubscribe_user($user_id,$shortcode)
    {
        //then subscribe user
        $subscriber_data=array
        (
            'user_id'=>$user_id,
            'project_id'=>get_project_id_by_shortcode($shortcode,'id'),
            'trash'=>'n'
        );

        $id='';

        foreach($this->project_subscription_m->get_where($subscriber_data) as $row)
        {
            $id=$row['id'];
        }
        if($id)
        {
            if($this->project_subscription_m->delete($id))
            {
                //if successfully unscubscribed
                //send notification message
                $msg_content='You have successfully subscribed to '.get_project_id_by_shortcode($shortcode,'title').' To subscribe  send START_'.$shortcode.' to 8888';
                send_subscription_message(get_user_info_by_id($user_id,'tel'),$msg_content);
            }
        }



        //prevent duplicate
        if(!check_subscriber_by_id($user_id,get_project_id_by_shortcode($shortcode,'id')))
        {
            print_array($subscriber_data);
            $this->project_subscription_m->create($subscriber_data);

            //send notification message
            $msg_content='You have subscribed to '.get_project_id_by_shortcode($shortcode,'title').' To stop unsubscribe send STOP_'.$shortcode.' to 8888';
            send_subscription_message(get_user_info_by_id($user_id,'tel'),$msg_content);
        }
        else
        {
            //if user already subscribed
            //send message to the subscriber
            $msg_content='You are already subscribed to '.get_project_id_by_shortcode($shortcode,'title').' To stop unsubscribe send STOP_'.$shortcode.' to 8888';
            send_subscription_message(get_user_info_by_id($user_id,'tel'),$msg_content);
        }
    }


}
