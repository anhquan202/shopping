<div class="pagination">
  <?php if ($pages > 1): ?>
    <a class="prev" href="?page=<?= $pages - 1 ?>&sort=<?= $sort?>">
      <img src="/shopping/assets/icons/arrow-left.svg" alt="Previous">
    </a>
  <?php endif; ?>

  <?php for ($current_page = 1; $current_page <= $totalPages; $current_page++): ?>
    <a href="?page=<?= $current_page ?>&sort=<?= $sort?>" class="<?= ($current_page == $pages) ? 'active' : '' ?>"><?= $current_page; ?></a>
  <?php endfor; ?>
  
  <?php if ($pages < $totalPages): ?>
    <a class="next" href="?page=<?= $pages + 1 ?>&sort=<?= $sort?>">
      <img src="/shopping/assets/icons/arrow-right.svg" alt="Next">
    </a>
  <?php endif; ?>
</div>