<?php
foreach($user_info as $info)
{
    $id         =$info['id'];


}

?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <div class="form-horizontal">

            <div class="form-group">
                <label class="col-md-2 control-label">Districts</label>
                <div class="col-md-10">
                    <select id="usr_district" class="form-control">
                        <option class="text-info" selected="<?=get_user_info_by_id($id,'district')?>" value=""><?=ucwords(get_district_by_id(get_user_info_by_id($id,'district'),'title'))?></option>
                        <?php
                        $districts=get_active_districts();
                        foreach($districts as $district)
                        {

                            ?>
                            <option  value="<?=$district['id']?>"><?=ucwords($district['title'])?></option>

                        <?php


                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="sub_county">

            </div>



            <div class="parish">

            </div>




            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input type="submit" class="btn btn-primary register" value="Edit">
                    <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                </div>
            </div>
        </div>

    </div>
</div>




<script>
    $(document).ready(function()
    {
        //dynamically load the sub counties
        $(".sub_county").hide();//by default hide sub counties
        $(".parish").hide();//by default hide parishes
        $("#usr_district").change(function(){
            //alert($("#usertype").val());
            $(".sub_county").show('slow');
            $(".sub_county").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
            var district           =$('#usr_district').val();
            var form_data =
            {

                district:         district,
                ajax:        'get_counties'
            };

            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                type: 'POST',
                data: form_data,
                success: function(msg)
                {

                    $('.sub_county').html(msg);

                }
            });
        });

        $('.register').click(function(){

            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');


            var district           =$('#usr_district').val();
            var counties           =$('#usr_counties').val();
            var parishes           =$('#usr_parishes').val();
            var id                  ='<?=$id?>';

            //alert(counties);


            var form_data =
            {
                district :      district,
                county :      counties,
                parish :      parishes,
                id:          '<?=$id?>',
                ajax:        'edit_location'
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

    });

</script>




