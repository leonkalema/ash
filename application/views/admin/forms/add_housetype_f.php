<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 10/17/14
 * Time: 12:15 PM
 */
?>

<form  class="form-horizontal" method="post"  action="#">

    <div class="form-group">
        <label for="housetype" class="col-sm-3 control-label">House type</label>
        <div class="col-sm-6">
            <input type="text"  class="form-control" id="housetype" placeholder="type here...">
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-3 control-label">Description</label>
        <div class="col-sm-9">
            <textarea   name="editor0" id="editor0" class="form-control ckeditor message1" ></textarea>

            <script>
                $(document).ready(function(){
                    CKEDITOR.replace( 'editor0',
                        {
                            filebrowserBrowseUrl : '<?=base_url()?>js/ckfinder/ckfinder.html',
                            filebrowserImageBrowseUrl : '<?=base_url()?>js/ckfinder/ckfinder.html?type=Images',
                            filebrowserFlashBrowseUrl : '<?=base_url()?>js/ckfinder/ckfinder.html?type=Flash',
                            filebrowserUploadUrl : '<?=base_url()?>js/ckfinder/core/connector/java/connector.java?command=QuickUpload&type=Files',
                            filebrowserImageUploadUrl : '<?=base_url()?>js/ckfinder/core/connector/java/connector.java?command=QuickUpload&type=Images',
                            filebrowserFlashUploadUrl : '<?=base_url()?>js/ckfinder/core/connector/java/connector.java?command=QuickUpload&type=Flash'
                        });
                });

            </script>

        </div>

        <div class="row">
            <div  class="form-group">
                <div style="margin-top: 20px;"  class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                        <button id="create" class="btn-primary btn ">Submit</button>
                        <a href="<?=base_url()?>admin/<?=$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="message">

        </div>


</form>

<script>



    $('#create').click(function(){

        //loading gif
        $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');


        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var housetype           =$('#housetype').val();
        var description         =jQuery("textarea.message1").val();

        //alert(category);

        var form_data =
        {
            housetype :         housetype,
            description :     description,
            ajax:        'add_housetype'
        };

        $.ajax({
            url: "<?php echo site_url('admin/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
            type: 'POST',
            data: form_data,
            success: function(msg)
            {

                $('.message').html(msg);

            }
        });

        return false;

    });
</script>