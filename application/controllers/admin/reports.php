<?php 
/*
#Author: Cengkuru Micheal
8/21/14
2:20 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_admin_controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();

        //load user model
        $this->load->model('user_m');
		$this->load->model('sent_message_m');
		$this->load->model('project_m');

        $this->load->model('user_additional_info_m');
        $this->load->model('project_subscription_m');
        $this->load->model('project_magement_m');

        $this->load->model('district_m');
        $this->load->model('parish_m');
        $this->load->model('sub_county_m');
		
		$this->load->library('cezpdf');
		$this->load->helper('url');
		$this->load->library('excel');

    }

    //admin home page
    function index()
    {
        //redirect to page
        redirect(base_url() .$this->uri->segment(1).'/' . $this->uri->segment(2) . '/page');
    }

    function page()
    {
        $data['main_content']=$this->uri->segment(1).'/report_csv_v';
        $data['pagetitle']='System Reports';
        $data['page_description']='Generate system reports';

        //load the admin dashboard view
        $this->load->view('admin/includes/dashboard_template',$data);

    }
	
		//PDF GENERATION
	function hello_world()
	{
		$this->cezpdf->ezText('ACODE SUBSCRIBED USERS', 12, array('justification' => 'center'));
		$this->cezpdf->ezSetDy(-10);

		$content = 'The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog.
					Junk MTV quiz graced by fox whelps. Bawds jog, flick quartz, vex nymphs.';

		$this->cezpdf->ezText($content, 10);
		$this->cezpdf->ezStream();
	}
	
	function tables()
	{	
		$db_data[] = array('id' => '1','fname' => 'Jon Doe', 'lname' => 'Doe', 'tel' => '111-222-3333', 'email' => 'jdoe@someplace.com');
		$db_data[] = array('id' => '1','fname' => 'Jane Doe', 'lname' => 'Doe','tel' => '222-333-4444', 'email' => 'jane.doe@something.com');
		$db_data[] = array('id' => '1','fname' => 'Jon Smith', 'lname' => 'Doe','tel' => '333-444-5555', 'email' => 'jsmith@someplacepsecial.com');
		
		$col_names = array(
			'id'		=> 'No.',
			'fname' => 'First Name',
			'lname'	=> 'Last Name',
			'tel'	=> 'Contact Number',
			'email' => 'E-mail Address'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE SUBSCRIBED USERS', array('width'=>550));
		$this->cezpdf->ezStream();
	}

	
	function Subscribers_pdf()
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		$where = array
		(
			'trash'=>'n',
		);
		
		foreach($data['all_users'] = $this->user_m->get_where($where) as $user)
        {
			$db_data[] = array('id' => $user['id'], 'fname' => $user['fname'], 'lname' => $user['lname'], 'tel' => '0'.$user['tel'], 'email' => $user['email']);
		}
		
		$col_names = array(
			'id'		=> 'No.',
			'fname' => 'First Name',
			'lname'	=> 'Last Name',
			'tel'	=> 'Contact Number',
			'email' => 'E-mail Address'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE SUBSCRIBED USERS', array('width'=>550));
		$this->cezpdf->ezStream();
	}
	
	function Unsubscribers_pdf()
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		$where = array
		(
			'trash'=>'y',
		);
	
		foreach($data['all_users'] = $this->user_m->get_where($where) as $user)
        {
			$db_data[] = array('id' => $user['id'], 'fname' => $user['fname'], 'lname' => $user['lname'], 'tel' => '0'.$user['tel'], 'email' => $user['email']);
		}
		
		$col_names = array(
			'id'		=> 'No.',
			'fname' => 'First Name',
			'lname'	=> 'Last Name',
			'tel'	=> 'Contact Number',
			'email' => 'E-mail Address'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE UNSUBSCRIBED USERS', array('width'=>550));
		$this->cezpdf->ezStream();
	}
	
	function Outgoing_pdf()
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		foreach($data['all_messages']=$this->sent_message_m->get_all($trashed='n') as $outgoing)
        {
			$db_data[] = array('id' => $outgoing['id'], 'tel' => '0'.$outgoing['tel'], 'message' => $outgoing['message'], 'instructions' => $outgoing['message'], 'datecreated' => $outgoing['datecreated']);
		}
		
		$col_names = array(
			'id'		=> 'No.'	,
			'tel'		=> 'Contact Number',
			'message' => 'SMS Sent',
			'instructions'	=> 'Instructions',
			'datecreated' => 'Date sent'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE SENT SMS', array('width'=>550));
		$this->cezpdf->ezStream();
	}
	
	function Proj_pdf()
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		foreach($data['all_projects']=$this->project_m->get_all($trashed='n') as $project)
        {
			$db_data[] = array('title' => $project['title'], 'shortcode' => $project['shortcode'], 'projectdetails' => $project['projectdetails']);
		}
		
		$col_names = array(
			'title'		=> 'Platform Title',
			'shortcode' => 'Platform Shortcode',
			'projectdetails' => 'Platform Details'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE ACTIVE PLATFORMS', array('width'=>550));
		$this->cezpdf->ezStream();
	}
	
	function Proj_inactive_pdf()
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		$where = array
		(
			'trash'=>'y'
		);
		foreach($data['all_projects']=$this->project_m->get_where($where) as $project)
        {
			$db_data[] = array('title' => $project['title'], 'shortcode' => $project['shortcode'], 'projectdetails' => $project['projectdetails']);
		}
		
		$col_names = array(
			'title'		=> 'Platform Title',
			'shortcode' => 'Platform Shortcode',
			'projectdetails' => 'Platform Details'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'ACODE INACTIVE PLATFORMS', array('width'=>550));
		$this->cezpdf->ezStream();
	}
	
	//END GENERATION
	
	//Export to excel
	public function users_excel()
    {
		// Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Initialise the Excel row number

        // Set document properties
        $objPHPExcel->getProperties()->setCreator(get_user_info_by_id($this->session->userdata('id'),'fullname'))
            ->setLastModifiedBy(get_user_info_by_id($this->session->userdata('user_id'),'fullname'))
            ->setTitle("ACODE SUBSCRIBED NUMBERS")
            ->setSubject("Subscribed numbers")
            ->setDescription("Listing of current subscribed numbers")
            //->setKeywords("Rape, Murder")
            //->setCategory("Murder")
        ;
        $rowCount = 1;
        // Iterate through each result from the SQL query in turn
        //if its super user
        if($this->session->userdata('logged_in_usertype')==1)
        {
            $result=get_active_users();
        }
        else
        {
            $result=get_users_by_jsystem($this->session->userdata('logged_in_user_jsystem'));
        }

        foreach($result as $row)
        {

            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
            // Increment the Excel row counter

            // Set cell A on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['fname'].' '.$row['lname']);

            $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['email']);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['tel']);

            // Set cell B on excel matches column in the db and user type
            #$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, get_usertype($row['usertype'],'title'));


            $rowCount++;


            //$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        }

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        //$objWriter->save('some_excel_file.xlsx');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();


        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ACODE SUBSCRIBED USERS.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
	
	public function users_inactive_excel()
    {
		// Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Initialise the Excel row number

        // Set document properties
        $objPHPExcel->getProperties()->setCreator(get_user_info_by_id($this->session->userdata('id'),'fullname'))
            ->setLastModifiedBy(get_user_info_by_id($this->session->userdata('user_id'),'fullname'))
            ->setTitle("ACODE UNSUBSCRIBED NUMBERS")
            ->setSubject("Subscribed numbers")
            ->setDescription("Listing of current unsubscribed numbers")
            //->setKeywords("Rape, Murder")
            //->setCategory("Murder")
        ;
        $rowCount = 1;
        // Iterate through each result from the SQL query in turn
        //if its super user
        if($this->session->userdata('logged_in_usertype')==1)
        {
            $result=get_inactive_users();
        }
        else
        {
            $result=get_users_by_jsystem($this->session->userdata('logged_in_user_jsystem'));
        }

        foreach($result as $row)
        {

            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
            // Increment the Excel row counter

            // Set cell A on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['fname'].' '.$row['lname']);

            $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['email']);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['tel']);

            // Set cell B on excel matches column in the db and user type
            #$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, get_usertype($row['usertype'],'title'));


            $rowCount++;


            //$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        }

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        //$objWriter->save('some_excel_file.xlsx');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();


        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ACODE UNSUBSCRIBED USERS.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
	
	public function project_excel()
    {
		// Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Initialise the Excel row number

        // Set document properties
        $objPHPExcel->getProperties()->setCreator(get_user_info_by_id($this->session->userdata('id'),'fullname'))
            ->setLastModifiedBy(get_user_info_by_id($this->session->userdata('user_id'),'fullname'))
            ->setTitle("ACODE ACTIVE PLATFORMS")
            ->setSubject("ACODE Platforms")
            ->setDescription("Listing of current active platforms")
            //->setKeywords("Rape, Murder")
            //->setCategory("Murder")
        ;
        $rowCount = 1;
        // Iterate through each result from the SQL query in turn
        //if its super user
        if($this->session->userdata('logged_in_usertype')==1)
        {
            $result=get_active_projects();
        }
        else
        {
            $result=get_users_by_jsystem($this->session->userdata('logged_in_user_jsystem'));
        }

        foreach($result as $row)
        {

            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
            // Increment the Excel row counter

            // Set cell A on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['title']);

            $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['shortcode']);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['projectdetails']);

            // Set cell B on excel matches column in the db and user type
            #$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, get_usertype($row['usertype'],'title'));

            $rowCount++;

            //$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        }

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        //$objWriter->save('some_excel_file.xlsx');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();


        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ACODE INACTIVE PLATFORMS.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
	
	public function project_inactive_excel()
    {
		// Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Initialise the Excel row number

        // Set document properties
        $objPHPExcel->getProperties()->setCreator(get_user_info_by_id($this->session->userdata('id'),'fullname'))
            ->setLastModifiedBy(get_user_info_by_id($this->session->userdata('user_id'),'fullname'))
            ->setTitle("ACODE INACTIVE PLATFORMS")
            ->setSubject("ACODE Platforms")
            ->setDescription("Listing of current inactive platforms")
            //->setKeywords("Rape, Murder")
            //->setCategory("Murder")
        ;
        $rowCount = 1;
        // Iterate through each result from the SQL query in turn
        //if its super user
        if($this->session->userdata('logged_in_usertype')==1)
        {
            $result=get_inactive_projects();
        }
        else
        {
            $result=get_users_by_jsystem($this->session->userdata('logged_in_user_jsystem'));
        }

        foreach($result as $row)
        {

            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
            // Increment the Excel row counter

            // Set cell A on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['title']);

            $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['shortcode']);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
            // Set cell B on excel matches column in the db
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['projectdetails']);

            // Set cell B on excel matches column in the db and user type
            #$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, get_usertype($row['usertype'],'title'));

            $rowCount++;

            //$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        }

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        //$objWriter->save('some_excel_file.xlsx');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();


        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ACODE ACTIVE PLATFORMS.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}

 