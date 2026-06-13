<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= e($title ?? 'PortalLulus') ?></title>
  <style>
    html, body { height: 100%; overflow: auto; background: #f8fafc; }
    body { font-family: 'Times New Roman', serif; margin: 0; padding: 20px; color: #000; }
    @media print {
      html, body { height: auto; overflow: visible !important; background: white; padding: 0; margin: 0; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>
  <?php require $view_file; ?>
</body>
</html>
