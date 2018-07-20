<?php 
/*
#Author: Cengkuru Micheal
9/19/14
3:25 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form class="form-inline" action="#">
    <div class="input-group">
        <input type="text" id="src_field" placeholder="Find users..." class="form-control">
        <div class="input-group-btn">
            <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $('#src_field').keyup(function(){
            //alert($('#src_field').val());
            var src_val=$('#src_field').val();
            $(".user_area").html('<img src="<?=base_url()?>images/loading.gif" />');

                    //alert(src_val);
                    var src_data=
                    {
                        ajax:'src_users',
                        src_term:src_val
                    }

                    $.ajax({
                        url: "<?php echo site_url('admin/users/ajax_calls') ?>",
                        type: 'POST',
                        data: src_data,
                        success: function(msg)
                        {

                            //alert(src_val);
                            $('.user_area').html(msg);

                        }
                    });


        });

    });
</script>
 