<?php
//load header
$this->load->view('admin/includes/dashboard_header');

//load dynamic content
$this->load->view($main_content);

//load the footer
$this->load->view('admin/includes/dashboard_footer');

 