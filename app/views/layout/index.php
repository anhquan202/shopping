<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/shopping/resources/scss/app.css">
  <title><?php echo $title?></title>
</head>

<body>
  <?php require_once 'header.php'; ?>

  <div id="main-content" class="container">
    <?php echo $content; ?>

  </div>
  <?php require_once 'footer.php'; ?>

  <script src="/shopping/dist/index.js"></script>
</body>

</html>
