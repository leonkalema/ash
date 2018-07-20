<?php
$table_HTML = "";
														
#*********************************************************************************
# Displays forms used in AJAX when processing data on other forms without 
# reloading the whole form.
#*********************************************************************************


#===============================================================================================
# Display for simple message results
#===============================================================================================
if(!empty($area) && in_array($area, array('save_recover_settings_results', 'add_delivery_data')))
{
	$table_HTML .= format_notice($msg);	
}

#===============================================================================================
# Show search results in combo-box
#===============================================================================================
else if(!empty($area) && $area == 'combo_list')
{	
	if(!empty($page_list))
	{		
		if(empty($select_text))
		{
			$select_text = 'Select';
		}
		
		$table_HTML .= get_select_options($page_list, $value_field, $text_field, '', 'Y', $select_text);	
			
	} else {
		$table_HTML .= "<option value=''>No items to show!</option>";	
	}
}
else if(!empty($area) && $area == 'feedback_list')
{
	if(!empty($page_list))
	{		
		$table_HTML .= '<table class="table-condensed message-table table-striped" width="100%" cellpadding="0" cellspacing="0">'.
                       '<thead>'.
					   '<th class="col-check" width="3%"></th>'.
					   '<th class="col-check">Author</th>'.
					   '<th class="col-star">Location</th>'.
					   '<th class="col-from">Message</th>'.
					   '<th class="col-title">Date</th>'.
					   '<th class="col-timestamp"></th>'.
                       '</thead>'.
                       '<tbody>';		
					   						
                       foreach($page_list as $row)
                       {
						   $location_str = $row['district'];
						   $location_str .= (!empty($location_str) && !empty($row['subcounty'])? ', ' : '') . $row['subcounty'];
										    $location_str .= (!empty($location_str) && !empty($row['parish'])? ', ' : '') . $row['parish'];
						   
						   $table_HTML .= '<tr>'.
                                          '<td>'.
                                          '<div class="simple-checkbox">'.
                                          '<input type="checkbox" id="checkbox10"><label for="checkbox10">&nbsp;</label>'.
                                          '</div>'.
                                          '</td>'.
                                          '<td><span class="from">'.ucwords($row['fname'].' '.$row['lname']). '</span></td>'.
                                          '<td>'.
                                          '<span>'.$location_str.'</span>'.
                                          '</td>'.
                                          '<td><span class="feedback_msg">'.ucwords($row['message']).'</span></td>'.
                                          '<td><span>'.custom_date_format('d M, Y',$row['dateadded']).'</span></td>'.
                                          '<td class="text-right">'.
                                          '<a href="'.base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/delete/'.$row['feedbackid'].
										  '"><i class="fa fa-trash-o"></i></a>'.
                                          '</td>'.
                                          '</tr>';
                       }

                       $table_HTML .= '</tbody></table>';	
			
	} else {
		$table_HTML .= "No messages to show!";	
	}
}
if(!empty($table_HTML))
{	
	#echo htmlentities($table_HTML);
	echo $table_HTML;
}
?>
