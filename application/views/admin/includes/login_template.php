<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 30/05/14
 * Time: 10:03
 *
 * this puts together the login page
 */

//load login header
$this->load->view('admin/includes/login_header');

//load dynamic content
$this->load->view($main_content);

//load the login footer
$this->load->view('admin/includes/login_footer');
