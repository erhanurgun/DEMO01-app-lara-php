<?php

// izin kontrol işlemi
if (!permission('users', 'add')) {
    permissionPage();
}

// düzenleme isteği yapıldı mı
if (post('submit')) {
    // kayıt verilerini değişenlere aktar
    $userName = post('user_name');
    $email = post('user_email');
    $pass = post('user_password');
    $passAgain = post('user_pass_again');

    // gelen verilerin boş olup olmadığını kontrol et
    if (!$userName) {
        $error = 'Lütfen kullanıcı adınızı yazın!';
    } elseif (!$email) {
        $error = 'Lütfen e-posta adresinizi giriniz!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Lütfen geçerli bir e-posta adresi giriniz!';
    } elseif (!$pass || !$passAgain) {
        $error = 'Lütfen şifrenizi giriniz!';
    } elseif ($pass != $passAgain) {
        $error = 'Giridiğiniz şifreler birbiriyle uyuşmuyor!';
    } else {

        // kullanıcı kaydı hali hazırda mevcut mu
        $row = User::userExist($userName, $email);

        // kullanıcı mevcutsa
        if ($row) {
            $error = 'Bu kullanıcı adı ya da e-posta zaten kullanılıyor. Lütfen başka bir tane deneyiniz!';
        } else {
            // izinler dışınndaki verileri kontrol et
            if ($data = formControl('user_permissions')) {
                unset($data['user_pass_again']);
                $data['user_password'] = password_hash($pass, PASSWORD_DEFAULT);
                $data['user_name'] = $userName;
                $data['user_email'] = $email;
                $data['user_url'] = sefLink($data['user_name']);
                $data['user_permissions'] = json_encode($data['user_permissions']);
                demoUser('users');
                // verileri güncelle
                $query = $db->insert('users')->set($data);
                // güncelleme işlemi başarılıysa yönlendir
                if ($query) {
                    $success = "İşlem başarıyla tamamlandı.";
                    $_SESSION['log_success'] = $success ?? null;
                    header('Location: ' . adminUrl('users'));
                    exit;
                } else {
                    $error = 'Beklenmedik bir sorun oluştu!';
                }
            } else {
                $error = 'Eksik alanlar var, lütfen kontrol ediniz!';
            }
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// sayfaya dahil et
require adminView('add-user');
