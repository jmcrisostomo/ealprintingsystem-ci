<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="E.A.L Printing Services">
    <meta name="application-name" content="E.A.L Printing Services">
    <meta name="msapplication-TileColor" content="#e91e63">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <title><?= $meta_page ? 'E.A.L Printing Services - ' .$meta_page : 'E.A.L Printing Services' ?></title>

    <link href="<?= base_url('assets/admin/css/app.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/css/admin.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/css/toast.css') ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome.min.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        let base_url = '<?= base_url(); ?>';
    </script>
</head>

<body>
    <!-- image background -->
    <div class="loginbg"></div>

    <!-- toast -->
    <div id="popNotifications" class="pop-notifications">
        <div class="toast-notif"><p>Sample Message</p></div>
    </div>