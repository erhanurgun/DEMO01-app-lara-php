<?php require adminView('auth/header'); ?>

    <form action="" method="post" class="h-forgot">
        <h3>Şifre Sıfırlama</h3>

        <label for="email">E-Posta</label>
        <input type="email" id="email" name="user_email" value="<?= post('user_email') ?? null; ?>"
               placeholder="e-posta adresinizi giriniz...">

        <button type="submit" name="submit" value="1">Talep Oluştur</button>

        <div class="social">
            <a href="<?= adminUrl('login'); ?>">Giriş ekranına dön</a>
        </div>
    </form>

<?php require adminView('auth/footer'); ?>