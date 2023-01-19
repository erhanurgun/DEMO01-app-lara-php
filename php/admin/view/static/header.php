<!doctype html>
<html lang="tr_TR">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>Yönetim Paneli | <?= setting('title'); ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= adminPublicUrl('images/favicon.png') ?>">

    <!--styles-->
    <link rel="stylesheet" href="<?= adminPublicUrl('styles/main.css?v=' . time()); ?>">
    <link rel="stylesheet" href="<?= adminPublicUrl('styles/custom.css?v=' . time()); ?>">
    <link rel="stylesheet" href="<?= adminPublicUrl('vendor/jquery.tagsinput/jquery.tagsinput-revisited.min.css'); ?>">
    <link rel="stylesheet" href="<?= adminPublicUrl('styles/jquery-ui.css?v=' . time()); ?>">
</head>

<body>

<div class="page-loader">
    <div class="page-loader-inner">
        <div class="inner"></div>
    </div>
</div>

<div class="sortable-mssg success">
    <a href="#" class="sortable-mssg-close"><i class="fa fa-times"></i></a>
    <div></div>
</div>

<div class="sortable-mssg error">
    <a href="#" class="sortable-mssg-close"><i class="fa fa-times"></i></a>
    <div></div>
</div>

<?php if (session('user_rank') && session('user_rank') <= session('max_user_rank')) : ?>
<!--navbar-->
<div class="navbar">
    <ul dropdown>
        <li>
            <a href="<?= siteUrl(); ?>" target="_blank">
                <span class="fa fa-home"></span>
                <span class="title"><?= setting('title'); ?></span>
            </a>
        </li>
        <li>
            <a href="<?= adminUrl('logout'); ?>">
                <span class="fa fa-sign-out"></span>
                Çıkış Yap
            </a>
        </li>
    </ul>
</div>

<!--sidebar-->
<div class="sidebar">
    <div id="user-info">
        <a href="<?= adminUrl('edit-user?id=' . session('user_id')); ?>">
            <img class="image" src="<?= getGravatar(session('user_email')); ?>" alt="<?= session('user_name'); ?>">
            <p class="name"><?= session('user_name'); ?></p>
        </a>
        <p class="rank t1"><b>YETKİ:</b> <span><?= userRanks(session('user_rank')); ?></span></p>
    </div>
    <div class="hr eu-my-2"></div>
    <!-- menüler bu alanda listelenir -->
    <ul>
        <?php foreach ($menus as $mainUrl => $menu) :
            if (!permission($menu['url'], 'show')) continue; ?>
            <li class="<?= (route(1) == $menu['url']) || (isset($menu['sub-menu']) && (array_search(route(1), array_column($menu['sub-menu'], 'url')))) ? 'active' : null; ?>">
                <a href="<?= adminUrl($menu['url']); ?>">
                    <span class="fa fa-<?= $menu['icon']; ?>"></span>
                    <span class="title"><?= $menu['title']; ?></span>
                </a>
                <?php if (isset($menu['sub-menu'])) : ?>
                    <ul class="sub-menu">
                        <?php foreach ($menu['sub-menu'] as $k => $subMenu) :
                            if (!permission($subMenu['url'], 'show')) continue; ?>
                            <li class="<?= route(1) == $subMenu['url'] ? 'active' : null; ?>">
                                <a href="<?= adminUrl($subMenu['url']); ?>"><?= $subMenu['title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <!-- yan panelin genişletilip daraltılma durumu  -->
    <a href="#" class="collapse-menu">
        <span class="fa fa-arrow-circle-left"></span>
        <span class="title">Alanı Daralt</span>
    </a>

</div>

<!--content-->
<div class="content">

    <?php if (isset($success) || session('log_success')) : ?>
        <div class="message success box-">
            <?= $success ?? session('log_success'); ?>
        </div>
    <?php elseif (isset($error) || session('log_error')) : ?>
        <div class="message error box-">
            <?= $error ?? session('log_error'); ?>
        </div>
    <?php endif; ?>

<?php endif; ?>