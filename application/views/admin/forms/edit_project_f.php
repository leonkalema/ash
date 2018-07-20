<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 11/5/14
 * Time: 00:10
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

foreach($project_info as $row)
{
    $edit_id = $row['id'];
    $project_name = $row['title'];
    $proj_details = $row['projectdetails'];
    $short = $row['shortcode'];
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
                    <label for="project" class="col-sm-3 control-label">Project Name</label>
                    <div class="col-sm-6">
                        <input type="text" required="" value="<?=$project_name?>" class="form-control" id="project"><br />
                    </div>
                </div>

                <div class="form-group">
                    <label for="project" class="col-sm-3 control-label">Project short code</label>
                    <div class="col-sm-6">
                        <input type="text" required="" value="<?=$short?>" class="form-control" id="shortcode"><br />
                    </div>
                </div>
                <div class="form-group">
                    <label for="project" class="col-sm-3 control-label">Project Details</label>
                    <div class="col-sm-6">
                        <textarea required="" id="details" class="form-control"><?=$proj_details?></textarea>
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

            var project_name    = $('#project').val();
            var project_details =  $('#details').val();
            var project_code =  $('#shortcode').val();

            var form_data =
            {
                project :       project_name,
                pdetails:       project_details,
                pcode:          project_code,
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