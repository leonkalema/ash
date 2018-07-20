<?php
//load header
$this->load->view('public/includes/frontend_header');

//load dynamic content
$this->load->view($main_content);

//load the footer
$this->load->view('public/includes/frontend_footer');

 