<?php require controller('header'); ?>

<!DOCTYPE html>

<html lang="tr_TR">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="<?= setting('author'); ?>">
    <meta name="description" content="<?= setting('description'); ?>">
    <meta name="google-site-verification" content="<?= setting('search_console'); ?>" />
    <!-- Page Title -->
    <title> <?= setting('title') . ' | ' . setting('domain'); ?></title>
    <!-- Icon fonts -->
    <link rel="shortcut icon" type="image/png" href="<?= publicUrl('images/icon.png'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/flaticon.css'); ?>">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= publicUrl('css/bootstrap.min.css'); ?>">
    <!-- Plugins for this template -->
    <link rel="stylesheet" href="<?= publicUrl('css/animate.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/odometer-theme-default.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/slick.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/slick-theme.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/slicknav.min.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/jquery.fancybox.css'); ?>">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?= publicUrl('css/style.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/responsive.css'); ?>">
    <link rel="stylesheet" href="<?= publicUrl('css/custom.css'); ?>">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= setting('analitic'); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '<?= setting('analitic'); ?>');
    </script>
</head>

<body>

    <!-- start page-loader -->
    <!-- TODO: bu alan kapatılırsa slider kısmı çalışmaz! -->
    <?php if (setting('other_page_loader') == "1") : ?>
        <div class="page-loader">
            <div class="page-loader-inner">
                <div class="inner"></div>
            </div>
        </div>
    <?php endif; ?>
    <!-- end page-loader -->

    <!-- header-area start -->
    <header>

        <?php if (setting('other_header_top') == "1") : ?>
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-12 col-lg-6">
                            <ul class="d-flex account_login-area">
                                <li>
                                    <i class="fa fa-clock-o" aria-hidden="true"></i></i>
                                    <strong>Hafta İçi:</strong>
                                    <span><?= setting('mid_week_1'); ?> &minus;</span>
                                    <span><?= setting('mid_week_2'); ?>&nbsp;</span>
                                    <strong>Hafta Sonu:</strong>
                                    <span><?= setting('weekend_1'); ?> &minus;</span>
                                    <span><?= setting('weekend_2'); ?></span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 col-lg-6">
                            <div class="row">
                                <div class="col-lg-7 col-md-6">
                                    <ul class="d-flex header-social">
                                        <!-- loop area start -->
                                        <?php foreach (menu(2) as $item) : ?>
                                            <li>
                                                <a href="<?= siteUrl($item['url']); ?>" target="_blank">
                                                    <?= html_entity_decode($item['title']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                        <!-- loop area end -->
                                    </ul>
                                </div>
                                <div class="col-lg-5 col-md-6">
                                    <ul class="login-r">
                                        <li>
                                            <a href="<?= siteUrl('admin'); ?>" target="_blank">
                                                <i class="fa fa-user"></i>
                                                <?= session('user_id') ? session('user_name') : 'Giriş Yap'; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="header-top header-top-2 for-desktop">
            <div class="container">
                <ul class="d-flex account_login-area">
                    <li class="account-item">
                        <img src="<?= publicUrl('images/icon/call.svg'); ?>">
                        <h5><span>Hemen Arayın</span></h5>
                        <a href="tel:<?= setting('phone_1'); ?>"><?= setting('phone_1'); ?></a>
                    </li>
                    <li class="account-item account-item-2">
                        <img src="<?= publicUrl('images/icon/message.svg'); ?>">
                        <h5><span>E-Posta</span></h5>
                        <a href="mailto:<?= setting('email'); ?>"><?= setting('email'); ?></a>
                    </li>
                    <li class="account-item">
                        <img src="<?= publicUrl('images/icon/map.svg'); ?>">
                        <h5><span>Adres</span> <?= setting('address'); ?></h5>
                    </li>
                </ul>
            </div>
        </div>

        <div class="header-area" id="sticky-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-9 col-sm-9 col-9">
                        <div class="logo">
                            <a href="<?= siteUrl(); ?>">
                                <img class="img-logo" src="<?= publicUrl('upload/logo.svg'); ?>" alt="<?= setting('title'); ?> Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 d-none d-lg-block">
                        <div class="main-menu">
                            <nav class="nav_mobile_menu">
                                <ul>
                                    <!-- loop area start -->
                                    <?php foreach (menu(1) as $menu) : ?>
                                        <li <?= ((!$isEmptyRoute && $menu['url'] == 'index') || howRoute() == $menu['url'] || howRoute(2) == $menu['url']) ? 'class="active"' : null; ?>>
                                            <a href="<?= (!isset($menu['submenu']) && $menu['url'] ? siteUrl($menu['url']) : 'javascript:void(0)'); ?>">
                                                <?= $menu['title']; ?>
                                            </a>
                                            <?php if ($menu['url'] != 'services') : ?>
                                                <?php if (isset($menu['submenu'])) : ?>
                                                    <ul class="submenu">
                                                        <?php foreach ($menu['submenu'] as $submenu) : ?>
                                                            <li <?= howRoute() == $submenu['url'] ? 'class="active"' : null; ?>>
                                                                <a href="<?= siteUrl($menu['url'] . '/' . $submenu['url']); ?>"><?= $submenu['title']; ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <ul class="submenu">
                                                    <?php foreach ($services as $service) : ?>
                                                        <li <?= howRoute() == $service['service_url'] ? 'class="active"' : null; ?>>
                                                            <a href="<?= siteUrl($menu['url'] . '/' . $service['service_url']); ?>"><?= $service['service_title']; ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                    <!-- loop area end -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-12 d-block d-lg-none">
                        <div class="mobile_menu"></div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <!-- header-area end -->

    <?php if ($isEmptyRoute && !empty($breadcumb)) : ?>
        <!-- .breadcumb-area start -->
        <div class="breadcumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcumb-wrap text-center">
                            <ul>
                                <?php foreach ($breadcumb as $item) :
                                    if (isset($item['href'])) : ?>
                                        <li><a href="<?= $item['href']; ?>"><?= $item['title']; ?></a></li>
                                    <?php else : ?>
                                        <li><span><?= $item['title']; ?></span></li>
                                <?php endif;
                                endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .breadcumb-area end -->
    <?php endif; ?>