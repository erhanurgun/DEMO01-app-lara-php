<!doctype html>
<html lang="tr_TR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yönetim Paneli | <?= setting('title'); ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= adminPublicUrl('images/favicon.png') ?>">
    <link rel="stylesheet" href="<?= adminPublicUrl('styles/login.css'); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
</head>
<body>

<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form class="login" method="post">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input class="login__input" type="text" name="user_name" placeholder="kullanıcı adınızı giriniz..."
                           value="<?= post('user_name') ?? null; ?>">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input class="login__input" type="password" name="user_password" placeholder="şifrenizi giriniz...">
                </div>
                <div class="mt-div">
                    <input type="hidden" name="recaptcha_php" value="<?= setting('recaptcha_php'); ?>" required>
                    <div class="g-recaptcha" data-sitekey="<?= setting('recaptcha_html'); ?>" data-theme="light"></div>
                </div>
                <button type="submit" class="button login__submit" name="submit" value="1">
                    <span class="button__text">Giriş Yap</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
            <div class="social-login">
                <h3>Takip Et</h3>
                <div class="social-icons">
                    <?php foreach (menu(2) as $menu): ?>
                        <a href="<?= $menu['url']; ?>" class="social-login__icon">
                            <?= $menu['title']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <strong>UYARI:</strong>
                <p><?= $error; ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>