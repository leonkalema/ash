<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/21/14
 * Time: 1:27 PM
 * registration form
 */
//print_array($user_info);
foreach($user_info as $row)
{
    $fname      =$row['fname'];
    $lname   =$row['lname'];
    $id         =$row['id'];

    //print_array(get_user_info_by_id($id,'telephone'));
}
?>

<form id="registerform" class="form-horizontal" method="post" name="registerform" action="#">

    <div class="form-group">
        <input required=""  type="text" class="form-control fname" value="<?=ucwords($fname)?>" placeholder="First name">
    </div>
    <div class="form-group">
        <input required=""  type="text" class="form-control lname" value="<?=ucwords($lname)?>"" placeholder="Last name">
    </div>

    <div class="form-group">
        <input required=""  type="text" class="form-control tel" value="<?=get_user_info_by_id($id,'telephone')?>" placeholder="Telephone">
    </div>

    <div class="form-group">
        <input required=""  type="text" class="form-control address" value="<?=get_user_info_by_id($id,'address')?>" placeholder="address">
    </div>

    <div class="form-group">
        <input required=""  type="text" class="form-control city" value="<?=get_user_info_by_id($id,'city')?>" placeholder="city">
    </div>

    <div class="form-group">
        <input required=""  type="text" class="form-control d_o_b datepicker" value="<?=get_user_info_by_id($id,'d_o_b')?>" placeholder="date of birth">
    </div>

    <div class="form-group">

            <textarea name="description"     id="descrip" class="form-control ckeditor message2" >
                <?=html_entity_decode(get_user_info_by_id($id,'bio'))?>
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


    <div class="form-group">
        <input type="submit" class="btn btn-primary register" value="Edit account">
    </div>

    <div class="message">

    </div>


</form>

<script>

    $(document).ready(function()
    {

        $('#selector1').select2();
        $('.populate').select2();
        $('.datepicker').datepicker();


    });

    $('.register').click(function(){

        //loading gif
        $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }



        var fname           =$('.fname').val();
        var lname           =$('.lname').val();
        var address         =$('.address').val();
        var d_o_b           =$('.datepicker').val();
        var city            =$('.city').val();
        var tel             =$('.tel').val();
        var bio             =jQuery("textarea.message2").val();
        var id              ='<?=$id?>';

        var form_data =
        {

            fname :     fname,
            lname:      lname,
            address:    address,
            d_o_b:      d_o_b,
            city:       city,
            tel:       tel,
            bio:        bio,
            id:         id,
            ajax:       'update_additional'
        };

        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
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