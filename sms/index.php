<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>index</title>
	<meta name="generator" content="BBEdit 11.0" />
</head>
<body>
<?php

$sender = isset($_POST['from']) ? $_POST['from'] : (isset($_GET['from']) ? $_GET['from'] : "");
$recipient = isset($_POST['to']) ? $_POST['to'] : (isset($_GET['to']) ? $_GET['to'] : "");
$msg = isset($_POST['msg']) ? $_POST['msg'] : (isset($_GET['msg']) ? $_GET['msg'] : "");

       $conn = mysql_connect('localhost','root','William') or die ('Error!');
       mysql_select_db('acode', $conn);

       $r = mysql_query("INSERT INTO from_dump_yard (`from`, `msg`, `to`, `trash`, `dateupdated`, `status`, `ip_address`, `invalid`, `shortcode`, `guessed`) VALUES ('$sender', '$msg', '', 'n', '', '', '$recipient','','','')");
       if($r)
       {
       echo "Ok";
       }
       exit;
     	
     	
?>
</body>
</html>