<?php
/**
 * Created by PhpStorm.
 * User: mover
 * Date: 11/24/14
 * Time: 9:18 AM
 * class is mean
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_manager extends MY_admin_controller
{

    function __construct()
    {
       parent::__construct();
       $this->load->model('reports_m');
	   $this->load->helper(array('form', 'url', 'html'));
    }

    #index page message-counter and analytics
    function index()
    {
        echo  'reached';
    }
	
    ## Reports Sent and Icoming messages        
    function message_inout()
    {
        ## Reports Sent and Icoming messages

       $result = ($this->reports_m->get_sentmessage());   
       if(count($result) > 0)
       {
        $result = array('sm' => '0' );
        echo json_encode($result);

       }else{
          echo json_encode($result);
       }
    }

 	function messagestartout()
    {
        $sctn = $this -> uri ->segment('4');
     if($sctn == 'week')
     {
     	$day = Date('D');
     	switch ($day) 
		{
        	case 'Mon':
            	$interval = 0;
            break;
            case 'Tue':
            	$interval = 1;
            	# code... function messagestart()
    			{
        			$sctn = $this -> uri ->segment('4');
					 if($sctn == 'week')
					 {
						$day = Date('D');
						
                		switch ($day)
						{
                  			case 'Mon':
                  				$interval = 0;
                    		break;
                 			case 'Tue':
                    			$interval = 1;
							break;
                			case 'Wed':
                   				$interval = 2;
                    		break;
                			case 'Thu':
                   				$interval = 3;
                    		break;
                			case 'Fri':
                   				$interval = 4;
                    		break;
                			case 'Sat':
                   				$interval = 5;
                    		break;
                			case 'Sun':
                   				$interval = 6;
                    		break;
               				default:
               					$interval = 7;
                    		break;
                		}
						
                 		$result = ($this->reports_m->messagesstat_out($sctn,$interval));   
           				$qq = ($result);
         				echo json_encode($qq);
      				}
  					else if($sctn == 'month')
     				{
                		$day = Date('d');
             
              			switch ($day)
						{
						  	case '01':
						  		$interval = 0;
							break;
					  		case '02':
								$interval = 1;
							break;
					  		case '03':
						   		$interval = 2;
							break;
					  		case '04':
						   		$interval = 3;
							break;
					  		case '05':
						   		$interval = 4;
							break;
					  		case '06':
						    	$interval = 5;
							break;
						  	case '07':
							   $interval = 6;
							break;
						  	case '08':
							   $interval = 7;
							break;
						  	case '09':
							   $interval = 8;
							break;
						  	case '10':
							   $interval = 9;
							break;
						  	case '11':
							   $interval = 10;
								# code...
							break;
						  	case '12':
							   $interval = 11;
								# code...
							break;
						  	case '13':
							   $interval = 12;
								# code...
							break;
						  	case '14':
							   $interval = 13;
								# code...
							break;
						  	case '15':
							   $interval = 14;
								# code...
							break;
						  	case '16':
							   $interval = 15;
								# code...
							break;
						  	case '17':
							   $interval = 16;
								# code...
							break;
						  	case '18':
							   $interval = 17;
								# code...
							break;
						  	case '19':
							   $interval = 18;
								# code...
							break;
						  	case '20':
							   $interval = 19;
								# code...
							break;
						  	case '21':
							   $interval = 20;
								# code...
							break;
						  	case '22':
							   $interval = 21;
								# code...
							break;
						  	case '23':
							   $interval = 22;
								# code...
							break;
						   	case '24':
						   		$interval = 23;
							# code...
							break;
							case '25':
						   		$interval = 24;
							# code...
							break;
							case '26':
						   		$interval = 25;
							# code...
							break;
							case '27':
						   		$interval = 26;
							# code...
							break;
							case '28':
						   		$interval = 27;
							# code...
							break;
							case '29':
						   $interval = 28;
							# code...         
							break;
							case '30':
						   		$interval = 29;
							# code...
							break;
							case '31':
						   		$interval = 30;
							# code...
							break;
					   		default:
					   			$interval = 31                                                                               ;
							# code...
							break;
                		}
                
           				$result = ($this->reports_m->messagesstat_out($sctn,$interval));   
           				$qq = ($result);
         				echo json_encode($qq);
      				}
    				else  if($sctn == 'year')
                	{
						$interval = 4;
        				$result = ($this->reports_m->messagesstat_out($sctn,$interval));   
           				$qq = ($result);
         				echo json_encode($qq);
       				}
       				else if($sctn == 'seconds')
       				{
						$interval = 45;         
						$result = ($this->reports_m->messagesstat_out($sctn,$interval));  
						echo $result;
       				}
   				}
                break;
                case 'Wed':
                   $interval = 2;
                break;
                case 'Thu':
                   $interval = 3;
                    # code...
                break;
                case 'Fri':
                   $interval = 4;
                    # code...
                break;
                case 'Sat':
                   $interval = 5;
                    # code...
                break;
                case 'Sun':
                   $interval = 6;
                    # code...
                break;
               	default:
               		$interval = 7;
                    # code...
                break;
            }
            	$result = ($this->reports_m->messagesstat_out($sctn,$interval));   
           		$qq = ($result);
         		echo json_encode($qq);
      }
	  else if($sctn == 'month')
      {
          $day = Date('d');
             
		  switch ($day)
		  {
          		case '01':
                  $interval = 0;
                break;
              	case '02':
                	$interval = 1;
                    # code...
                break;
              case '03':
                   $interval = 2;

                    # code...
                    break;
              case '04':
                   $interval = 3;
                    # code...
                    break;
              case '05':
                   $interval = 4;
                    # code...
                    break;
              case '06':
                   $interval = 5;
                    # code...
                    break;
              case '07':
                   $interval = 6;
                    # code...
                    break;
              case '08':
                   $interval = 7;
                    # code...
                    break;
              case '09':
                   $interval = 8;
                    # code...
                    break;
              case '10':
                   $interval = 9;
                    # code...
                    break;
              case '11':
                   $interval = 10;
                    # code...
                    break;
              case '12':
                   $interval = 11;
                    # code...
                    break;
              case '13':
                   $interval = 12;
                    # code...
                    break;
              case '14':
                   $interval = 13;
                    # code...
                    break;
              case '15':
                   $interval = 14;
                    # code...
                    break;
              case '16':
                   $interval = 15;
                    # code...
                    break;
              case '17':
                   $interval = 16;
                    # code...
                    break;
              case '18':
                   $interval = 17;
                    # code...
                    break;
              case '19':
                   $interval = 18;
                    # code...
                    break;
              case '20':
                   $interval = 19;
                    # code...
                    break;
              case '21':
                   $interval = 20;
                    # code...
                    break;
              case '22':
                   $interval = 21;
                    # code...
                    break;
              case '23':
                   $interval = 22;
                    # code...
                    break;

                   case '24':
                   $interval = 23;
                    # code...
                    break;
                     case '25':
                   $interval = 24;
                    # code...
                    break;
                     case '26':
                   $interval = 25;
                    # code...
                    break;
                     case '27':
                   $interval = 26;
                    # code...
                    break;
                     case '28':
                   $interval = 27;
                    # code...
                    break;
                     case '29':
                   $interval = 28;
                    # code...         
                    break;
                     case '30':
                   $interval = 29;
                    # code...
                    break;
                     case '31':
                   $interval = 30;
                    # code...
                    break;


               default:
               $interval = 31                                                                                                               ;
                    # code...
                    break;
                }
                
           $result = ($this->reports_m->messagesstat_out($sctn,$interval));   
           $qq = ($result);
         echo json_encode($qq);

      }
    else  if($sctn == 'year')
                {
$interval = 4;
                
              
      
        $result = ($this->reports_m->messagesstat_out($sctn,$interval));   
           $qq = ($result);
         echo json_encode($qq);
       }
       else if($sctn == 'seconds')
       {
        $interval = 45;         
        $result = ($this->reports_m->messagesstat_out($sctn,$interval));  
        echo $result;
       }
       
          
    
   }
    // daily
    function messagestart_in()
    {
        $sctn = $this -> uri ->segment('4');
     if($sctn == 'week')
     {


                $day = Date('D');
               
                switch ($day) {
                  case 'Mon':
                  $interval = 0;
                    break;
                 case 'Tue':
                    $interval = 1;
                    # code...
                    break;
                case 'Wed':
                   $interval = 2;

                    # code...
                    break;
                case 'Thu':
                   $interval = 3;
                    # code...
                    break;
                case 'Fri':
                   $interval = 4;
                    # code...
                    break;
                case 'Sat':
                   $interval = 5;
                    # code...
                    break;
                case 'Sun':
                   $interval = 6;
                    # code...
                    break;
              
               default:
               $interval = 7;
                    # code...
                    break;
                }
                 $result = ($this->reports_m->messagesstat_in($sctn,$interval));   
           $qq = ($result);
         echo json_encode($qq);
      }
else if($sctn == 'month')
     {


                $day = Date('d');
             
              switch ($day) {
                  case '01':
                  $interval = 0;
                    break;
              case '02':
                    $interval = 1;
                    # code...
                    break;
              case '03':
                   $interval = 2;

                    # code...
                    break;
              case '04':
                   $interval = 3;
                    # code...
                    break;
              case '05':
                   $interval = 4;
                    # code...
                    break;
              case '06':
                   $interval = 5;
                    # code...
                    break;
              case '07':
                   $interval = 6;
                    # code...
                    break;
              case '08':
                   $interval = 7;
                    # code...
                    break;
              case '09':
                   $interval = 8;
                    # code...
                    break;
              case '10':
                   $interval = 9;
                    # code...
                    break;
              case '11':
                   $interval = 10;
                    # code...
                    break;
              case '12':
                   $interval = 11;
                    # code...
                    break;
              case '13':
                   $interval = 12;
                    # code...
                    break;
              case '14':
                   $interval = 13;
                    # code...
                    break;
              case '15':
                   $interval = 14;
                    # code...
                    break;
              case '16':
                   $interval = 15;
                    # code...
                    break;
              case '17':
                   $interval = 16;
                    # code...
                    break;
              case '18':
                   $interval = 17;
                    # code...
                    break;
              case '19':
                   $interval = 18;
                    # code...
                    break;
              case '20':
                   $interval = 19;
                    # code...
                    break;
              case '21':
                   $interval = 20;
                    # code...
                    break;
              case '22':
                   $interval = 21;
                    # code...
                    break;
              case '23':
                   $interval = 22;
                    # code...
                    break;

                   case '24':
                   $interval = 23;
                    # code...
                    break;
                     case '25':
                   $interval = 24;
                    # code...
                    break;
                     case '26':
                   $interval = 25;
                    # code...
                    break;
                     case '27':
                   $interval = 26;
                    # code...
                    break;
                     case '28':
                   $interval = 27;
                    # code...
                    break;
                     case '29':
                   $interval = 28;
                    # code...         
                    break;
                     case '30':
                   $interval = 29;
                    # code...
                    break;
                     case '31':
                   $interval = 30;
                    # code...
                    break;


               default:
               $interval = 31                                                                                                               ;
                    # code...
                    break;
                }
                
           $result = ($this->reports_m->messagesstat_in($sctn,$interval));   
           $qq = ($result);
         echo json_encode($qq);

      }
    else  if($sctn == 'year')
                {
$interval = 2;
                
              
      
        $result = ($this->reports_m->messagesstat_in($sctn,$interval));   
           $qq = ($result);
         echo json_encode($qq);
       }
       else if($sctn == 'seconds')
       {
        $interval = 45;         
        $result = ($this->reports_m->messagesstat_in($sctn,$interval));  
        echo $result;
       }
   }
} 