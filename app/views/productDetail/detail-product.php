<div class="detail-product">
  <h3>Detail Product Information</h3>
  <table class="full-info">
    <thead>
      <tr>
        <th>Attribute</th>
        <th>Product Specifications</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detailProduct as $info): ?>
        <tr>
          <td><?= $info['attribute_name'] ?></td>
          <td><?= $info['value'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>