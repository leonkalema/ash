<?php 
/*
#Author: Cengkuru Micheal
9/16/14
3:21 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

foreach($usertype_info as $row)
{
    $edit_id=$row['id'];
    $usertype=$row['usertype'];
}
?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <form class="form-horizontal" role="form">
            <fieldset>

                <div class="form-group">
                    <label for="usertype" class="col-sm-3 control-label">User Group</label>
                    <div class="col-sm-6">
                        <input type="text" required="" value="<?=$usertype?>" class="form-control" id="usertype" placeholder="user group...">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="edit" class="btn-primary btn  edit">Edit</button>
                        <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#edit').click(function(){


            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Please wait...');

            var usertype    =$('#usertype').val();
            var form_data =
            {
                usertype :       usertype,
                'id'    :       '<?=$edit_id?>',
                ajax:           'form_edit'
            };

            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/edit') ?>",
                type: 'POST',
                data: form_data,
                success: function(msg) {

                    $('.message').html(msg);

                }
            });
            return false;

        });
    });

</script>