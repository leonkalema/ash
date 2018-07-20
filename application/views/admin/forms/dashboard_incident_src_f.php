<?php 
/*
#Author: Cengkuru Micheal
9/30/14
9:33 AM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form class="form-inline" action="#">
    <div class="input-group">
        <input type="text" id="src_incident" placeholder="Find incidents..." class="form-control">
        <div class="input-group-btn">
            <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $('#src_incident').keyup(function(){
            //alert($('#src_field').val());
            var src_val=$('#src_field').val();
            $(".incident_area").html('<img src="<?=base_url()?>images/loading.gif" />');

            //alert(src_val);
            var src_data=
            {
                ajax:'src_incidents',
                src_term:src_val
            }

            $.ajax({
                url: "<?php echo site_url('admin/incidents/ajax_calls') ?>",
                type: 'POST',
                data: src_data,
                success: function(msg)
                {

                    //alert(src_val);
                    $('.incident_area').html(msg);

                }
            });


        });

    });
</script>
 