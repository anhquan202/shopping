<!-- Categories -->
<section class="sections">
  <div class="header">
    <div class="label">
      <span class="label-title">Categories</span>
      <b class="label-content">Browse By Category</b>
    </div>
    <nav class="navigation">
      <div class="arrow arrow-left">
        <img src="/shopping/assets/icons/arrow-left.svg" alt="">
      </div>
      <div class="arrow arrow-right">
        <img src="/shopping/assets/icons/arrow-right.svg" alt="">
      </div>
    </nav>
  </div>

  <div class="category-list">
    <?php foreach ($categories as $category): ?>
      <div class="category-item">
        <div class="icon">
          <img src="/shopping/assets/images/Categories/<?= $category['category_image'] ?>" alt="" srcset="">
        </div>
        <span><?php echo ucfirst($category['category_name']); ?></span>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Random Products -->
<section class="sections">
  <div class="header">
    <div class="label">
      <span class="label-title">Our Products</span>
      <b class="label-content">Explore Our Products</b>
    </div>
    <nav class="navigation">
      <a href="" class="btn-nav">View All Products</a>
    </nav>
  </div>

  <?php require_once __DIR__ . '/../components/product-list.php'?>
</section>