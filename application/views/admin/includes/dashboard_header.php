<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <title><?=$pagetitle?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="ACODE SMS platform developed by New Wave Technologies">
    <meta name="author" content="<?=$this->config->item('site_name')?>">

    <!-- CSS -->
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/multiple-select.css" rel="stylesheet" type="text/css">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?=base_url()?>assets/ico/favicon.png">
    <script src="<?=base_url()?>assets/js/jquery-2.1.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.multiple.select.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

        var dd = $('.vticker').easyTicker({
            direction: 'up',
            easing: 'easeInOutBack',
            speed: 'slow',
            interval: 3000,
            height: 'auto',
            visible: 3,
            mousePause: 0,
            controls: {
                up: '.up',
                down: '.down',
                toggle: '.toggle',
                stopText: 'Stop !!!'
            }
        }).data('easyTicker');
        
        cc = 1;
        $('.aa').click(function(){
            $('.vticker ul').append('<li>' + cc + ' Triangles can be made easily using CSS also without any images. This trick requires only div tags and some</li>');
            cc++;
        });
        
        $('.vis').click(function(){
            dd.options['visible'] = 3;
        });
        
        $('.visall').click(function(){
            dd.stop();
            dd.options['visible'] = 0 ;
            dd.start();
        });
        
    });
    </script>
    <script src="<?=base_url()?>assets/js/jquery.bxSlider.js"></script>
    <style type="text/css">
    .vticker{
        width: 350px;
    }
    .vticker ul{
        padding: 0;
    }
    .vticker li{
        list-style: none;
        border-bottom: 1px solid #fff;
        padding: 10px;
    }
    .et-run{
        background: red;
    }
	#slider {
		list-style:none;
		padding:0px
	}
	.slider-container {  
		width:100px; 
		height:150px; 
		padding:20px; 
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px; 
	}
	#slider img { 
		width:150px; 
		margin:0px; 
		display:inline-block  
	}
	#slider li {
		width:210px
	}
    </style>
</head>
<body class="dashboard">

<!-- Social integration-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=533946333377303&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!--End-->

<!-- WRAPPER -->
<div class="wrapper">
    <!--load top bar-->
    <?=$this->load->view('admin/parts/topbar')?>

    <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
    <div class="bottom">
        <div class="container">
            <div class="row">
                <!-- left sidebar -->
                <?=$this->load->view('admin/parts/left_sidebar')?>
                <!-- end left sidebar -->

                <!-- content-wrapper -->

                <div class="col-md-10 content-wrapper">
                    <div class="row">
                        <!-- breadcrumb -->
                        <?=$this->load->view('admin/parts/breadcrumb')?>


                        <!-- statistics -->
                        <?php

                        //show to only admins(super users and champions)
                        if(in_array(get_user_info_by_id($this->session->userdata('user_id'),'usertype_id'),$this->config->item('admins')))
                        {
                            echo $this->load->view('admin/parts/topright_statistics');
                        }
                        ?>
                    </div>

                    <!-- main -->
                    <div class="content">
                        <div class="main-header">
                            <h2><?=strtoupper($pagetitle)?></h2>
                            <em><?=$page_description?></em>
                        </div>

                        <div class="main-content">
<!--                            check if profile is completed-->
                            <?=$this->load->view('admin/alerts/profile_complete_check')?>

