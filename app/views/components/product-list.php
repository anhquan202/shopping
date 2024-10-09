<div class="product-list">
  <?php foreach ($products as $product): ?>
    <div class="product-item">
      <div class="product-image"><img src="/shopping/assets/images/<?= $product['value'] ?>" alt="" srcset=""></div>
      <div class="product-information">
        <b><?php echo ucfirst($product['name']); ?></b>
        <span><?php echo number_format($product['price_out']) . '<b>đ</b>'; ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</div>