<?php
/*
#Author: Cengkuru Micheal
9/16/14
3:21 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <form class="form-horizontal" role="form">
            <fieldset>

                <div class="form-group">
                    <label for="projectname" class="col-sm-3 control-label">Platform Name</label>
                    <div class="col-sm-6">
                        <input type="text" required="" class="form-control" id="projectname" placeholder="platform name"><br />
                    </div>
                </div>
                <div class="form-group">
                    <label for="shortcode" class="col-sm-3 control-label">Platform short code</label>
                    <div class="col-sm-6">
                        <input type="text" required="" maxlength="4" class="form-control" id="shortcode" placeholder="short code"><br />
                    </div>
                </div>
                <div class="form-group">
                    <label for="projectdetails" class="col-sm-3 control-label">Platform Details</label>
                    <div class="col-sm-6">
                        <textarea required id="projectdetails" placeholder="platform details" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="create" class="btn-primary btn  edit">Add</button>
                        <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#create').click(function(){


            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

            var project = $('#projectname').val();
            var shortcode = $('#shortcode').val();
            var details = $('#projectdetails').val();

            var form_data =
            {
                project:        project,
                shortcode:      shortcode,
                details:        details,
                ajax:           'add_project_f'
            };

            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/add') ?>",
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