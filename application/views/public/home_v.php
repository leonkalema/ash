<div class="col-md-10 content-wrapper">
<!-- main -->
	<div class="content">
		<div class="main-content">
        <!-- WIDGET MAIN CHART WITH TABBED CONTENT -->
			<div class="widget">
				<div class="widget-content">
					<p>
                    ACODE is an independent public policy research and advocacy think tank registered in Uganda with operations in the Eastern and Southern Africa sub-region. ACODE was first registered in 1999 as a Non-governmental organization (NGO). In 2004, the organization was incorporated as a company limited by guarantee and without having a share capital.
                    </p>
                    <p> Thirteen years now, ACODE is one of the most dynamic and robust regional leaders in cutting-edge public policy research and analysis in a range of areas including governance, trade, environment, and science and technology. ACODE is non-partisan and independent. As a non-partisan organisation, ACODE does not align with any political party or political organisation. 
                    <p>However, given the direct relationship between development policy and politics, ACODE believes that its work is political and it must stand for certain political causes of a bi-partisan nature. Such causes are legitimate issues of research interest so long as they are defined on the basis of constitutionalism, the rule of law as well as national and regional interests as expressed in the relevant treaties, strategy documents and declarations.
                    </p>
					<hr class="separator">
				</div>
			</div>
		<!-- END WIDGET MAIN CHART WITH TABBED CONTENT -->
								
		  <div class="row">
				<div class="col-md-6">	
					<!-- WIDGET DONUT AND PIE CHART -->
					<div class="widget">
						<div class="widget-header">
								<h3><i class="fa fa-comments"></i> Incoming Messages</h3>
								<div class="btn-group widget-header-toolbar">
									<a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
									<a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
									<a href="#" title="Remove" class="btn-borderless btn-remove"><i class="fa fa-times"></i></a>
								</div>
						</div>
					  <div class="widget-content">
						<div class="vticker">
                                <ul>
                                    <?php
                                      if(!empty($all_messages))
                                     {
                                        foreach ($all_messages as $messages) {
                                            echo '<li>'.$messages['msg'].'<br /><span style="font-size:10px">SMS BY: '.str_replace('256','0',$messages['from']).'</span></li>';
                                        }
                                        
                                     }
                                    ?>
                                </ul>
                            </div>
					  </div>
				  </div>
					<!-- END WIDGET DONUT AND PIE CHART -->
			</div>
			<div class="col-md-6">
				<!-- WIDGET INLINE SPARKLINE -->
				<div class="widget widget-sparkline">
					<div class="widget-content" style="background: #fff">
						<div class="fb-like-box" data-href="https://www.facebook.com/pages/Advocates-Coalition-for-Development-and-Environment-ACODE/220046328033059" data-width="340" data-height="400" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="false"></div>
					</div>
				  </div>
				<!-- END WIDGET INLINE SPARKLINE -->
			</div>
		</div>
        
        <div class="row">
			<div class="col-md-4">
				<!-- WIDGET TASKS -->
				<div class="widget">
					<div class="widget-header">
						<h3><i class="fa fa-calendar"></i> Events</h3>
					</div>
					<div class="widget-content" style="width:400px">
						<ul class="task-list">
							<li><i class="fa fa-file-text-o pull-left pull-left"></i><a href="#">ACODE Event 1.</a></li>
                        	<li><i class="fa fa-file-text-o pull-left pull-left"></i><a href="#">ACODE Event 2.</a></li>
                        	<li><i class="fa fa-file-text-o pull-left pull-left"></i><a href="#">ACODE Event 3.</a></li>
						</ul>
					</div>
				</div>
				<!-- END WIDGET TASKS -->
			</div>
			<div class="col-md-8">
				<!-- WIDGET REAL-TIME CHART -->
				<div class="widget real-time-chart">
					<div class="widget-header">
						<h3><i class="fa fa-cogs"></i> Sponsors</h3>
					</div>
					<div class="widget-content" style="background: #fff">
						<div class="slider-container">
                        	<ul id="slider">
                            	<li><a href="#"><img src="<?=base_url()?>/images/logos/1.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/2.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/3.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/4.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/5.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/6.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/7.jpg"></a></li>
                                <li><a href="#"><img src="<?=base_url()?>/images/logos/8.jpg"></a></li>
                             </ul><br />
                        </div><!-- /slider -->
					</div>
				</div>
				<!-- END WIDGET REAL-TIME CHART -->
			</div>
		</div>
	</div><!-- /main-content -->
  </div><!-- /main -->
</div>

	<script type="text/javascript">
  		$(document).ready(function(){
     		$('#slider').bxSlider({
    		ticker: true,
    		tickerSpeed: 5000,
			tickerHover: true
  			});
  		});
	</script>