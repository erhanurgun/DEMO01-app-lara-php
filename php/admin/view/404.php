<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sayfa Bulunamadı | <?= setting('title'); ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= adminPublicUrl('images/favicon.png') ?>">
    <link rel="stylesheet" href="<?= adminPublicUrl('styles/404.css?v=' . time()); ?>">
</head>
<body>

<?php for ($i = 0; $i < 5; $i++): ?>
    <div class="bubble"></div>
<?php endfor; ?>

<div class="main">
    <h1>404</h1>
    <h2>Üzgünüz :(</h2>
    <p>
        Aradığınız sayfayı bulamadık! <br>
        Aradığınız sayfa taşınmış olabilir, tamamen kaldırılmış olabilir <br>
        veya erişim yetkiniz kısıtlanmış olabilir!
    </p>
    <a class="btn" href="<?= adminUrl(); ?>">Anasayfa'ya Dön</a>
</div>

</body>
</html>