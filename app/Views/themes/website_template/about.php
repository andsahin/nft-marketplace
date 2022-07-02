<div class="py-5">
  <i class="bi bi-check-lg"></i>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-7">
        <div class="bd-content">
          <h1 class="bd-title"><?php echo isset($article[0])?htmlspecialchars_decode($article[0]->headline_en):''; ?></h1> 
            <?php echo isset($article[0])?htmlspecialchars_decode($article[0]->article2_en):''; ?>
        </div>
      </div>
    </div>
  </div>
</div>