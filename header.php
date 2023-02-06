<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <title><?= titulo_site("Pagina inicial") ?></title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/css/uikit.min.css" />
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- master.css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/master.css?v='.time()) ?>">
    <script>
      $base_url = "<?= base_url() ?>";
    </script>
  </head>
  <body class="body-load">
  <div class="loadspinner"><div uk-spinner="ratio: 3"></div></div>
