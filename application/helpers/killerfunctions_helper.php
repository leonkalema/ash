<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/2/14
 * Time: 4:57 PM
 *
 * i cant begin to stress how important these functions are
 */

//generate seo friendly funtions
function seo_url($string)
{
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return strtolower($string);
}

//limit strings to only the first 100

function limit_words($string,$word_count)
{
    if (strlen($string) > $word_count) {

        // truncate string
        $stringCut = substr($string, 0, $word_count);

        // make sure it ends in a word so assassinate doesn't become ass...
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'';
    }
    return $string;
}

//check if an image exists
function check_image_existance($path,$image_name)
{
    //buld the url
    $image_url=$path.$image_name;
    if (file_exists($image_url) !== false) {
        return true;
    }
}

//check if file exists
function check_file_existance($path)
{
    //buld the url
    $image_url=$path;
    if (file_exists($image_url) !== false) {
        return true;
    }
}

//date to seconds
function date_to_seconds($date)
{
    return strtotime($date);
}

//remove dashes between words
function remove_dashes($string)
{
   return str_replace('-', ' ', $string);

}

//validate emails
function validate_mail($email)
{

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        return FALSE;
    }
    else
    {
       return TRUE;
    }
}

//get all files in a directory randomly
function get_all_directory_files($directory_path)
{

    $scanned_directory = array_diff(scandir($directory_path), array('..', '.'));



    return custom_shuffle($scanned_directory);
}

//to shuffle the elements
function custom_shuffle($my_array = array()) {
    $copy = array();
    while (count($my_array)) {
        // takes a rand array elements by its key
        $element = array_rand($my_array);
        // assign the array and its value to an another array
        $copy[$element] = $my_array[$element];
        //delete the element from source array
        unset($my_array[$element]);
    }
    return $copy;
}

//to formate date for mysql
function mysqldate()
{
    $mysqldate = date("m/d/y g:i A", now());
    $phpdate = strtotime( $mysqldate );
    return date( 'Y-m-d H:i:s', $phpdate );
}

//to clear forrm fields
function clear_form_fields()
{
    $str='';
    $str.='<script>
							  $(".form-horizontal")[0].reset();
							  </script>';
    return $str;
}



//hu,am friendly date now
function human_date_today()
{
    /*
     * other options
     *
$today = date("F j, Y, g:i a");                   // March 10, 2001, 5:16 pm
$today = date("m.d.y");                           // 03.10.01
$today = date("j, n, Y");                         // 10, 3, 2001
$today = date("Ymd");                             // 20010310
$today = date('h-i-s, j-m-y, it is w Day');       // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
$today = date('\i\t \i\s \t\h\e jS \d\a\y.');     // It is the 10th day (10ème jour du mois).
$today = date("D M j G:i:s T Y");                 // Sat Mar 10 17:16:18 MST 2001
$today = date('H:m:s \m \e\s\t\ \l\e\ \m\o\i\s'); // 17:03:18 m est le mois
$today = date("H:i:s");                           // 17:16:18
$today = date("Y-m-d H:i:s");                     // 2001-03-
     */

    return date('l jS F Y');
}


//check if ur on localhost
function check_localhost()
{
    if ( $_SERVER["SERVER_ADDR"] == '127.0.0.1' )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

//get real ip address
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//seconds to time
function Sec2Time($time){
    if(is_numeric($time)){
        $value = array(
            "years" => 0, "days" => 0, "hours" => 0,
            "minutes" => 0, "seconds" => 0,
        );
        if($time >= 31556926){
            $value["years"] = floor($time/31556926);
            $time = ($time%31556926);
        }
        if($time >= 86400){
            $value["days"] = floor($time/86400);
            $time = ($time%86400);
        }
        if($time >= 3600){
            $value["hours"] = floor($time/3600);
            $time = ($time%3600);
        }
        if($time >= 60){
            $value["minutes"] = floor($time/60);
            $time = ($time%60);
        }
        $value["seconds"] = floor($time);
        return (array) $value;
    }else{
        return (bool) FALSE;
    }
}

//remove underscors from a string
function remove_underscore($string)
{
    return str_replace('_', ' ', $string);
}

function custom_date_format($format='d.F.Y',$date='')
{
   $date=strtotime($date);
    return date($format,$date);
}

function replace_pipes($string)
{
    return str_replace('|',',',$string);
}

function last_segment()
{

    $ci=& get_instance();
    //load the profile model
    //to get last segment
    $last = $ci->uri->total_segments();
    $record_num = $ci->uri->segment($last);

    //if its pg
    if($record_num=='pg')
    {
        //to get last segment
        $last = $ci->uri->total_segments()-1;
        return remove_dashes($ci->uri->segment($last));
    }
    else
    {
        return remove_dashes($record_num);
    }
}

//ensure tht jquery is installed even without internet
function load_jquery()
{
    ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript">
        // Ensure that jQuery is installed even if the Google CDN is down.
        if (typeof jQuery === "undefined") {
            var script = document.createElement('script');
            var attr = document.createAttribute('type');
            attr.nodeValue = 'text/javascript';
            script.setAttributeNode(attr);
            attr = document.createAttribute('src');
            attr.nodeValue = '/scripts/jquery-1.3.2.min.js';
            script.setAttributeNode(attr);
            document.getElementsByTagName('head')[0].appendChild(script);
        }
    </script>
<?php
}

//print an array
function print_array($array) {
    print '<pre>';
    print_r($array);
    print '</pre>';
}

// Trim function - cuts text to a certain length
// $string = string to trim; $max_length = longest allowed string before trimming; $append = characters to add on after the trim (typically "...")
function neat_trim($string, $max_length, $append = '')
{
    if (strlen($string) > $max_length) {
        $string = substr($string, 0, $max_length);
        $pos = strrpos($string, ' ');
        if ($pos === false) {
            return substr($string, 0, $max_length) . $append;
        }
        return substr($string, 0, $pos) . $append;
    }
    else {
        return $string;
    }
}

// Confirm valid integer
function int_check($string) {
    $pattern = "/^([0-9])+$/";
    if (preg_match($pattern,$string)) {
        return true;
    }
    else {
        return false;
    }
}

// Confirm valid numeric
function numeric_check($string) {
    $regex = '/^\s*[+\-]?(?:\d+(?:\.\d*)?|\.\d+)\s*$/';
    return preg_match($regex, $string);
}

function jquery_clear_fields()
{
    ?>
    <script>
        $(".form-horizontal")[0].reset();
        $('textarea').val('');
    </script>
<?php
}

function jquery_redirect($url)
{
    ?>
    <script>
        // similar behavior as an HTTP redirect
        window.location.replace("<?=$url?>");
    </script>
<?php
}

function jquery_countdown_redirect($url)
{
    ?>
    <script>
       var count = 1;
        var countdown = setInterval(function(){
            $("countdown").html(count + " seconds remaining!");
            if (count == 0) {
                clearInterval(countdown);
                window.open("<?=$url?>", "_self");

            }
            count--;
        }, 1000);
    </script>
<?php
}

function check_live_server()
{
    $whitelist = array(
        '127.0.0.1',
        '::1'
    );

    if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function time_ago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = round( $difference );

    if( $difference != 1 )
    {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";

}


//function to get thumbnail from photo_name
function get_thumbnail($image_name)
{
    $pieces=explode('.',$image_name);

    return $pieces[0].'_thumb.'.$pieces[1];
}


function get_current_class()
{
    $ci=& get_instance();
    return $ci->router->fetch_class();
}


function fullescape($in)
{
    $out = '';
    for ($i=0;$i<strlen($in);$i++)
    {
        $hex = dechex(ord($in[$i]));
        if ($hex=='')
            $out = $out.urlencode($in[$i]);
        else
            $out = $out .'%'.((strlen($hex)==1) ? ('0'.strtoupper($hex)):(strtoupper($hex)));
    }
    $out = str_replace('+','%20',$out);
    $out = str_replace('_','%5F',$out);
    $out = str_replace('.','%2E',$out);
    $out = str_replace('-','%2D',$out);
    return $out;
}

function remove_zeros($tel)
{
    if(substr($tel,0,1)==0)
    {
        return substr($tel,1);
    }
    else
    {
        return $tel;
    }
}

# Returns the select options based on the passed data, id and value fields, and selected value
function get_select_options($select_data_array, $value_field, $display_field, $selected, $show_instr='Y', $instr_txt='Select One')
{
    $drop_HTML = "";
    #Determine whether to show the instruction option
    if($show_instr == 'Y'){
        $drop_HTML = "<option value='' ";
        # Select by default if there is no selected option
        if($selected == '')
        {
            $drop_HTML .= " selected";
        }

        $drop_HTML .= ">- ".$instr_txt." -</option>";
    }

    foreach($select_data_array AS $data_row)
    {
        $drop_HTML .= " <option  value='".addslashes($data_row[$value_field])."' ";

        # Show as selected if value matches the passed value
        #check if passed value is an array
        if(is_array($selected)){
            if(in_array($data_row[$value_field], $selected)) $drop_HTML .= " selected";

        }elseif(!is_array($selected)){
            if($selected == $data_row[$value_field]) $drop_HTML .= " selected";
        }

        $display_array = array();
        # Display all data given based on whether what is passed is an array
        if(is_array($display_field))
        {
            $drop_HTML .= ">";

            foreach($display_field AS $display)
            {
                array_push($display_array, $data_row[$display]);
            }

            $drop_HTML .= implode(' - ', $display_array)."</option>";
        }
        else
        {
            $drop_HTML .= ">".$data_row[$display_field]."</option>";
        }
    }

    return $drop_HTML;
}

function default_timestamp()
{
    return '0000-00-00 00:00:00';
}







