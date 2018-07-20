<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 10:21 PM
 */
?>
<div class="col-lg-9">
    <?php
    if(count($all_projects))
    {
        ?>
        <div class="widget widget-table">
            <div class="widget-header"><h3><i class="fa fa-table"></i> Total (<?=count(get_active_projects())?>)</h3></div>
            <div class="widget-content">
                <table class="table table-condensed table-dark-header">
                    <thead>
                    <tr>
                        <th>Platform name</th>
                        <th>Subscription code</th>
                        <th>Subscribe</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($all_projects_paginated as $project)
                    {
                        ?>
                        <tr>
                            <td><a href="<?=base_url()?>current_projects/details/<?=$project['slug']?>"><?=ucwords($project['title'])?></a> </td>
                            <td><?=$project['shortcode']?></td>
                            <td><a href="<?=base_url()?>current_projects/details/<?=$project['slug']?>">Subscribe now</a> </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    else
    {
        ?>
        <div class="alert alert-info alert-dismissable">
            <a href="" class="close">×</a>
            <strong>Notice !</strong> No information to display
        </div>
    <?php
    }
    ?>

</div>
