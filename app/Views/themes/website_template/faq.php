<div class="faq-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="page-section" id="questions">
                    <div class="faq-section-header">
                        
                    </div>
                    <div class="accordion" id="accordionExample">

                    	<?php $i=1; foreach ($article as $key => $value) { ?>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne<?php echo esc($i); ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo esc($i); ?>" aria-expanded="false" aria-controls="collapseOne">
                                    <?php echo htmlspecialchars_decode($value->headline_en); ?>
                                </button>
                            </h2>
                            <div id="collapseOne<?php echo  esc($i); ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?php echo esc($i); ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php echo htmlspecialchars_decode($value->article1_en); ?>
                                </div>
                            </div>
                        </div>

                        <?php esc($i++); } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>