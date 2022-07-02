<link rel="stylesheet" href="<?php echo base_url('app/Modules/CMS/Assets/Admin/css/cms.css') ?>">

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4><?php echo display('Content_Manager_System'); ?></h4>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 col-sm-3 col-md-12 col-lg-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-Home-tab" data-toggle="pill" href="#v-pills-Home" role="tab" aria-controls="v-pills-Home" aria-selected="false"><?php echo display('home_section'); ?></a>
                            <a class="nav-link" id="v-pills-About-tab" data-toggle="pill" href="#v-pills-About" role="tab" aria-controls="v-pills-About" aria-selected="false"><?php echo display('About'); ?></a>
                            <a class="nav-link" id="v-pills-Contact-tab" data-toggle="pill" href="#v-pills-Contact" role="tab" aria-controls="v-pills-Contact" aria-selected="false"><?php echo display('Contact'); ?></a>
                            <a class="nav-link" id="v-pills-Terms-tab" data-toggle="pill" href="#v-pills-Terms" role="tab" aria-controls="v-pills-Terms" aria-selected="false"><?php echo display('Terms'); ?></a>
                            <a class="nav-link" id="v-pills-Privacy-tab" data-toggle="pill" href="#v-pills-Privacy" role="tab" aria-controls="v-pills-Privacy" aria-selected="false"><?php echo display('Privacy_Policy'); ?></a>
                            <a class="nav-link" id="v-pills-FAQ-tab" data-toggle="pill" href="#v-pills-FAQ" role="tab" aria-controls="v-pills-FAQ" aria-selected="false"><?php echo display('faq'); ?></a>
                            <a class="nav-link" id="v-pills-Social-tab" data-toggle="pill" href="#v-pills-Social" role="tab" aria-controls="v-pills-Social" aria-selected="false"><?php echo display('Social_Link'); ?></a>
                        </div>
                    </div>

               		<div class="col-12 col-sm-9 col-md-12 col-lg-9">
                        <div class="tab-content" id="v-pills-tabContent">
	                        <div class="tab-pane fade show active" id="v-pills-Home" role="tabpanel" aria-labelledby="v-pills-Home-tab">
								<?php echo display('Home'); ?>
	                        </div>
                            <div class="tab-pane fade" id="v-pills-About" role="tabpanel" aria-labelledby="v-pills-About-tab">
                                <?php echo display('About'); ?>
                            </div>
	                        <div class="tab-pane fade" id="v-pills-Contact" role="tabpanel" aria-labelledby="v-pills-Contact-tab">
								<?php echo display('Contact'); ?>
	                        </div>
	                        <div class="tab-pane fade" id="v-pills-Terms" role="tabpanel" aria-labelledby="v-pills-Terms-tab">
								<?php echo display('Terms'); ?>
	                        </div>
	                        <div class="tab-pane fade" id="v-pills-Privacy" role="tabpanel" aria-labelledby="v-pills-Privacy-tab">
								<?php echo display('Policy'); ?>
	                        </div>
	                        <div class="tab-pane fade" id="v-pills-FAQ" role="tabpanel" aria-labelledby="v-pills-FAQ-tab">
								<?php echo display('faq'); ?>
	                        </div>
	                        <div class="tab-pane fade" id="v-pills-Social" role="tabpanel" aria-labelledby="v-pills-Social-tab">
								<?php echo display('Social'); ?>
	                        </div>

                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Inline form -->
</div>
<script src="<?php echo base_url('app/Modules/CMS/Assets/Admin/js/cms.js') ?>"></script>


<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    	<div class="modal-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="modal_content">
                    
                </div>
            </div>
        </div>
        </div>
    </div>
</div>