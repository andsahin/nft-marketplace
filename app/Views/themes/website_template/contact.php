<?php 
    $i=1; 
    foreach ($article as $con_key => $con_value) {
        $con_headline[]     =   $con_value->headline_en;
        $contract_1[]      =   $con_value->article1_en;
        $contract_2[]   =   $con_value->article2_en;

      $i++;
    }
?>
<div class="map-content">

    <div id="map"></div>

</div>
<!-- /.End of map content -->
<section class="border-bottom py-5">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4 text-center border-end">
        <h6 class="text-uppercase mb-2 font-weight-bold fs-13"><?php echo htmlspecialchars_decode($contract_1[1]) ?></h6>
        <!-- /.End of heading -->
        <div class="mb-5 mb-md-0">
          <a href="#!" class="h4"><?php echo htmlspecialchars_decode($contract_2[1]) ?></a>
        </div>
        <!-- /.End of link -->
      </div>
      <div class="col-12 col-md-4 text-center border-end">
        <h6 class="text-uppercase mb-2 font-weight-bold fs-13"><?php echo htmlspecialchars_decode($contract_1[2]) ?></h6>
        <!-- /.End of heading -->
        <div class="mb-5 mb-md-0">
          <a href="#!" class="h4">
            <?php echo htmlspecialchars_decode($contract_2[2]) ?>
          </a>
        </div>
        <!-- /.End of link -->
      </div>
      <div class="col-12 col-md-4 text-center">
        <h6 class="text-uppercase mb-2 font-weight-bold fs-13"><?php echo htmlspecialchars_decode($contract_1[3]) ?></h6>
        <!-- /.End of heading -->
        <a href="#!" class="h4">
          <?php echo htmlspecialchars_decode($contract_2[3]) ?>
        </a>
        <!-- /.End of link -->
      </div>
    </div>
  </div>
</section>
<section class="section-about py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="section-title text-center mb-5">
          <h2 class="block-title fs-25 mb-2"><?php echo htmlspecialchars_decode($contract_1[4]) ?></h2>
          <div class="sub-title fs-18">
            <?php echo htmlspecialchars_decode($contract_2[4]) ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-8">
        <div class="row align-items-center">
          <div class="col-sm-6 col-md-6 mb-5 mb-md-0">
            <div class="contact-info">
              <div class="mb-4">
                <h3 class="info-title link-title fs-18 mb-3 font-weight-600 position-relative"><?php echo htmlspecialchars_decode($contract_1[5]) ?></h3>
                <address class="mb-4">
                  <?php echo htmlspecialchars_decode($contract_2[5]) ?>
                </address>
              </div>
              <!-- /.End of address -->
              <div class="mb-4">
                <h3 class="info-title link-title fs-18 mb-3 font-weight-600 position-relative"><?php echo htmlspecialchars_decode($contract_1[6]) ?></h3>
                <?php echo htmlspecialchars_decode($contract_2[6]) ?>
              </div>
              <!-- /.End of phone -->
              <div class="mb-4">
                <h3 class="info-title link-title fs-18 mb-3 font-weight-600 position-relative"><?php echo htmlspecialchars_decode($contract_1[7]) ?></h3>
                <?php echo htmlspecialchars_decode($contract_2[7]) ?>
              </div>
              <!-- /.End of email -->
            </div>
          </div>
          <div class="col-sm-6 col-md-6">
            <?php if(isset($message)){ ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo display('Success'); ?>!</strong> <?php echo esc($message); ?>
            </div>
            <?php } ?>
            <?php if(isset($exception)){ ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo display('Exception'); ?>!</strong> <?php echo esc($exception); ?>
            </div>
            <?php } ?>
             <?php echo form_open(base_url('contactMsg'),'id="contactForm"  class="contact_form" name="contactForm"'); ?>
              <div class="mb-3">
                <input type="text" class="form-control" id="contactName" name="fullname" placeholder="Full name">
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" id="contactEmail" name="email" placeholder="hello@domain.com">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" id="contactPhonr" name="phone" placeholder="Telephone">
              </div>
              <div class="mb-3">
                <textarea class="form-control" id="contactMessage" name="comment" rows="5" 
                  placeholder="Tell us what we can help you with!"></textarea>
              </div>
              <!-- Submit -->
              <button type="submit" class="btn btn-primary"><?php echo display('Send_message'); ?></button>
            <?php echo form_close() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc($googleapikeydecode['api_key']); ?>" type="text/javascript"></script>
<script src="<?php echo esc($frontendAssets); ?>/js/maps.js"></script>
