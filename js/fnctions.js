

	
function save_projectm()
{
	var form  = document.forms['pmanage'];
	var user = form.usrt.value;
	
	var pid = form.pid.value;
	var url = $('.pmanage').attr('action');
	url = url+'/1/'+pid+'/'+user;
	
	var hd = "&nbsp;Proccessing ...";
	$('.modal-title').html(hd);
	 $.ajax({
        url: url,
        success: function(data)
        {

          switch(data)
		  {
			  case '0':
			  $('.modal-title').html("User is ALready Subscribed to this Project");
			  break;
			  case '1':
			   $('.modal-title').html("User Assigned Succesful");
			  break;
			  default:
			  break;
		  }
           
        },
        error: function(){
          
            alert('Ajax Eror');
        }
    });
	
}
function p_addusers(url)
{

  $('#modal-container-228144').modal('toggle');
    $('.modal-title').html('ADD PROJECT MANGER');
    fetchurl(url,".modal-body");
	/* $("#e23").select2({
                      tags:["red", "green", "blue"],
                      maximumInputLength: 10
                  }); */
				  $( ".select2, .select2-multiple, .select2-allow-clear, .select2-remote" ).on( select2OpenEventName, function() {
				if ( $( this ).parents( "[class*='has-']" ).length ) {
					var classNames = $( this ).parents( "[class*='has-']" )[ 0 ].className.split( /\s+/ );

					for ( var i = 0; i < classNames.length; ++i ) {
						if ( classNames[ i ].match( "has-" ) ) {
							$( "#select2-drop" ).addClass( classNames[ i ] );
						}
					}
				}
			});
				
}
function fetchurl($url,$display)
{
   
    $($display).html('Proccessing ... ');
   
  $.ajax({
        url: $url,
        success: function(data)
        {
          
            $($display).html(data);
        },
        error: function(){
          
            alert('Ajax Eror');
        }
    });
}
function prntArea($div)
{
    $('non-print').hide('quick');
    $("#prnt").printArea();
    $('non-print').fadeIn('slow');
}