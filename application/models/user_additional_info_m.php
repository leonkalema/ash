<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/30/14
 * Time: 4:40 AM
 */
class User_additional_info_m extends MY_Model
{

    public $_tablename='users_additional_info';
    public $_primary_key='id';
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        //load the district model
        //$this->load->model('district_m');

        //load the parish model
        //$this->load->model('parish_m');

        //load the sub_county model
        // $this->load->model('sub_county_m');
    }

    public function get_user_additional_info($user_id='', $param='')
    {
        //if an id is pass
        if($user_id=='')
        {
            return FALSE;
        }else
        {
            //get user info
            $query=$this->db->select()->from($this->_tablename)->where('user_id',$user_id)->get();

            if($query->result_array())
            {
                foreach($query->result_array() as $row)
                {
                    //filter results
                    switch($param)
                    {
                        case 'd_o_b':
                            $result=$row['d_o_b'];
                            break;


                        case 'district_id':
                            $result=$row['district'];
                            break;
                        case 'district':
                            $result=get_district_by_id($row['district'],'title');
                            break;

                        case 'parish_id':
                            $result=$row['parish'];
                            break;
                        case 'parish':
                            $result=get_parish_by_id($row['parish'],'title');
                            break;

                        case 'sub_county_id':
                            $result=$row['sub_county'];
                            break;
                        case 'sub_county':
                            $result=get_sub_county_by_id($row['sub_county'],'title');
                            break;

                        //extension to get additional user infp as well
                        default:
                            $result=$query->result_array();
                    }

                }

                return $result;
            }

        }
    }



}

