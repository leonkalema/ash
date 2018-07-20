<?php
/*
#Author: Cengkuru Micheal
9/16/14
3:21 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//echo $slug_id;

?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <form class="form-horizontal" role="form">
            <fieldset>

                <div class="form-group">

                    <div class="col-sm-9">
                        <input type="text" required="" class="form-control" id="title" placeholder="title here">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-12">
                        <textarea id="descrip" name="descrip" class="form-control ckeditor message2" >

                        </textarea>

                        <script>
                            CKEDITOR.replace( 'descrip',
                                {
                                    filebrowserBrowseUrl : '<?=base_url()?>js/ckfinder/ckfinder.html',
                                    filebrowserImageBrowseUrl : '<?=base_url()?>js/ckfinder/ckfinder.html?type=Images',
                                    filebrowserFlashBrowseUrl : '<?=base_url()?>js/ckfinder/ckfinder.html?type=Flash',
                                    filebrowserUploadUrl : '<?=base_url()?>js/ckfinder/core/connector/java/connector.java?command=QuickUpload&type=Files',
                                    filebrowserImageUploadUrl : '<?=base_url()?>js/ckfinder/core/connector/java/connector.java?command=QuickUpload&type=Images',
                                    filebrowserFlashUploadUrl : '<?=base_url()?>js/ckfinder/core/connector/java/connector.java?command=QuickUpload&type=Flash'
                                });
                        </script>

                    </div>
                </div>




                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="create" class="btn-primary btn  edit">Create</button>

                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
    $(document).ready(function(){

        $('#create').click(function(){


            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            var title    =$('#title').val();
            var content    =jQuery("textarea.message2").val();
            var category='<?=$slug_id?>';

           //alert(category);


            var form_data =
            {
                title :       title,
                content :       content,
                category :       category,
                ajax:           'add_category_f'
            };

            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
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