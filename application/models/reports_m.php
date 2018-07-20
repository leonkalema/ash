<?php
class Reports_m extends MY_Model
{
    public $_tablename = 'projects';
    public $_primary_key = 'id';

    function __construct()
    {
        parent::__construct();
    }           
    
    function inmessage()
    {
         $query = $this->db->select()->from('') ->where($this->_primary_key,$id)->get();
    }
    function get_sentmessage()
    {
        $array = array('datecreated > '=> 'date_sub(now(),interval 5 minute)');
       // $query = mysql_query("select * from sent_message where datecreated > date_sub('.now().' interval 5 minute)") or die(mysql_error());
        $query = mysql_query('select  *,count(*) as sm from sent_message where datecreated > date_sub(now(),interval 5 minute) ') or die(''.mysql_error());
     // print_array(mysql_fetch_array($query));
        //$this->db->select()->from('sent_message')->where($array) ->get()->result_array();
       
       return mysql_fetch_array($query);
    }
    function messagesstat_out($period,$interval)
    {
        switch($period)
        {
            case 'week':
           
              $query = mysql_query('select   YEAR(datecreated) as yer ,MONTH(datecreated) as month,DAY(datecreated) as day, DAYNAME(datecreated) as weekday , COUNT(*)  as msgcount from sent_message where datecreated > date_sub(CURDATE(),interval  '.$interval.' DAY) GROUP BY DAYNAME(datecreated) ORDER BY  datecreated')   or die(''.mysql_error());
          
         $results = array();
              while($row = mysql_fetch_array($query))
              {
                  $results[]=$row;
                  
        
              } 
             //  print_array($results);
             return($results);
        //$this->db->select()->from('sent_message')->where($array) ->get()->result_array();
       
         // return mysql_fetch_array($query);
            break;
            case 'month':
           
              $query = mysql_query('select   YEAR(datecreated) as yer ,MONTH(datecreated) as month,DAY(datecreated) as day, DAYNAME(datecreated) as weekday , COUNT(*)  as msgcount from sent_message where datecreated > date_sub(CURDATE(),interval  '.$interval.' DAY) GROUP BY DAYNAME(datecreated) ORDER BY  datecreated')   or die(''.mysql_error());
          
         $results = array();
              while($row = mysql_fetch_array($query))
              {
                  $results[]=$row;
                  
        
              } 
             //  print_array($results);
             return($results);
        //$this->db->select()->from('sent_message')->where($array) ->get()->result_array();
       
         // return mysql_fetch_array($query);
            break;
             case 'year':
           
              $query = mysql_query('select   YEAR(datecreated) as yer ,MONTH(datecreated) as month,DAY(datecreated) as day, DAYNAME(datecreated) as weekday , COUNT(*)  as msgcount from sent_message where datecreated > date_sub(CURDATE()-1,interval  '.$interval.' DAY) GROUP BY DAYNAME(datecreated) ORDER BY  datecreated')   or die(''.mysql_error());
          
         $results = array();
              while($row = mysql_fetch_array($query))
              {
                  $results[]=$row;
                  
        
              } 
             //  print_array($results);
             return($results);
             break;
       #FETCH MESSAGE IN SECONDS INTERVAL
           case 'seconds':

               $query = mysql_query('select    COUNT(*)  as msgcount from sent_message where date_sub(CURDATE(),interval   5 SECOND ) <= NOW() GROUP BY DAYNAME(datecreated) ORDER BY  datecreated')   or die(''.mysql_error());
          
         
              $rr = mysql_fetch_assoc($query);
             // print_r($rr);

           
             // $msgcount = $rr['msgcount'] > 0 ? $msgcount : 0;
               $msgcount  = $rr['msgcount'];
//print_r($msgcount);
               //percentage counter;
               $target = 1000;
               $parcent = $msgcount / $target * 100;
              return  $parcent;
           
            break;
            default:
            break;
        }
    }
     function messagesstat_in($period,$interval)
    {
        switch($period)
        {
            case 'week':
           
              $query = mysql_query('select   YEAR(dateadded) as yer ,MONTH(dateadded) as month,DAY(dateadded) as day, DAYNAME(dateadded) as weekday , COUNT(*)  as msgcount from from_dump_yard where dateadded > date_sub(CURDATE(),interval  '.$interval.' DAY) GROUP BY DAYNAME(dateadded) ORDER BY  dateadded')   or die(''.mysql_error());
          
         $results = array();
              while($row = mysql_fetch_array($query))
              {
                  $results[]=$row;
                  
        
              } 
            
             return($results);
        //$this->db->select()->from('sent_message')->where($array) ->get()->result_array();
       
         // return mysql_fetch_array($query);
            break;
            case 'month':
           
           $sql = 'select   YEAR(dateadded) as yer ,MONTH(dateadded) as month,DAY(dateadded) as day, DAYNAME(dateadded) as weekday , COUNT(*)  as msgcount from from_dump_yard where dateadded > date_sub(CURDATE(),interval  '.$interval.' DAY) GROUP BY DAYNAME(dateadded) ORDER BY  dateadded';
           // print_r($sql);
           // exit();
              $query = mysql_query($sql)   or die(''.mysql_error());
          
         $results = array();
              while($row = mysql_fetch_array($query))
              {
                  $results[]=$row;
                  
        
              } 
             //  print_array($results);
             return($results);
        //$this->db->select()->from('sent_message')->where($array) ->get()->result_array();
       
         // return mysql_fetch_array($query);
            break;
             case 'year':
           
              $query = mysql_query('select   YEAR(dateadded) as yer ,MONTH(dateadded) as month,DAY(dateadded) as day, DAYNAME(dateadded) as weekday , COUNT(*)  as msgcount from from_dump_yard where dateadded > date_sub(CURDATE()-1,interval  '.$interval.' DAY) GROUP BY DAYNAME(dateadded) ORDER BY  dateadded')   or die(''.mysql_error());
          
         $results = array();
              while($row = mysql_fetch_array($query))
              {
                  $results[]=$row;
                  
        
              } 
             //  print_array($results);
             return($results);
             break;
       #FETCH MESSAGE IN SECONDS INTERVAL
           case 'seconds':

               $query = mysql_query('select    COUNT(*)  as msgcount from from_dump_yard where date_sub(CURDATE(),interval   5 SECOND ) <= NOW() GROUP BY DAYNAME(dateadded) ORDER BY  dateadded')   or die(''.mysql_error());
          
         
              $rr = mysql_fetch_assoc($query);
             // print_r($rr);

           
             // $msgcount = $rr['msgcount'] > 0 ? $msgcount : 0;
               $msgcount  = $rr['msgcount'];
//print_r($msgcount);
               //percentage counter;
               $target = 1000;
               $parcent = $msgcount / $target * 100;
              return  $parcent;
           
            break;
            default:
            break;
        }
    }

}