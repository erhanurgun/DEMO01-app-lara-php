<?php

isLogin('user_id');

$maxRank = 3;
$_SESSION['max_user_rank'] = $maxRank;

// post işlemi yapıldıysa
if (post('submit')) {
    if ($data = formControl()) {
        // veri var mı kontrol et
        $row = $db->from('users')
            ->where('user_url', sefLink($data['user_name']))
            ->where('user_rank', $maxRank, '<=')
            ->first();
        // eğer eşleşen veri yoksa
        if (!$row) {
            $error = "Girdiğiniz bilgiler hatalı, lütfen bilgilerinizi kontrol edip tekrar deneyiniz!";
        } else {
            // eğer eşleşen veri varsa
            $passVerify = password_verify($data['user_password'], $row['user_password']);
            $response = $data["g-recaptcha-response"];
            $secret = $data["recaptcha_php"];
            $remoteip = $_SERVER["REMOTE_ADDR"];
            $captcha = file_get_contents(
                "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip"
            );
            $result = json_decode($captcha);
            // şifre doğruysa
            if (/* $result->success == 1 && */ $passVerify) {
                // kullanıcının yetkisi yönetici değilse
                if ($row['user_rank'] > $maxRank) {
                    $error = 'Bu bölüme girmek için yetkiniz bulunmuyor!';
                } else {
                    // eğer kullanıcı yöneticiyse giriş işlemini yap ve yönlendir
                    User::login($row);
                    $success = "İşlem başarıyla tamamlandı.";
                    $_SESSION['log_success'] = $success ?? null;
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            } else if ($result->success != 1) {
                $error = 'Robot olmadığınızı doğrulayınız!';
            } else {
                $error = 'Kullanıcı adınız veya şifreniz hatalı lütfen kontrol ediniz!';
            }
        }
    } else {
        $error = 'Lütfen tüm alanları doldurunuz!';
    }
}
$_SESSION['log_error'] = $error ?? null;

// sayfaya dahil et
require adminView('login');
