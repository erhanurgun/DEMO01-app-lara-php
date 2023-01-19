<?php

isLogin('user_id');

// post işlemi yapıldıysa
if (post('submit')) {
    if ($data = formControl()) {
        // veri var mı kontrol et
        $row = $db->from('users')
            ->where('user_email', post('user_email'))
            ->first();
        // eğer eşleşen veri yoksa
        if (!$row) {
            $error = "Girdiğiniz e-posta adresi hatalı, lütfen kontrol edip tekrar deneyiniz!";
        } else {
            // kullanıcının yetkisi yönetici değilse
            $ranks = [];
            for ($i = 0; $i < session('max_user_rank'); $i++) {
                $ranks[$i] = $i + 1;
            }
            if (!in_array($row['user_rank'], $ranks)) {
                $error = 'Bu bölüme girmek için yetkiniz bulunmuyor!';
            } else {
                // eğer kullanıcı yöneticiyse giriş işlemini yap ve yönlendir
                demoUser('forgot-pass');
                // TODO: şifre sıfırlama işlemleri daha sonradan eklenecektir!
                die('şifreyi sıfırlama işlemi');
            }
        }

    } else {
        $error = 'Lütfen bilgilerinizi giriniz!';
    }
}
$_SESSION['log_error'] = $error ?? null;

// sayfaya dahil et
require adminView('forgot-pass');