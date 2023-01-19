<?php

if (!permission('users', 'edit')) {
    permissionPage();
}

// id parametresi yoksa yönlendir
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl('users'));
    exit();
}
// kullanıcıyı çekme
$row = $db->from('users')
    ->where('user_id', $id)
    ->first();

$_SESSION['how_user_rank'] = $row['user_rank'];

// kullanıcı bulunamadıysa
if (!$row) {
    header('Location: ' . adminUrl('users'));
    exit();
}

// düzenleme isteği yapıldı mı
if (post('submit')) {
    // kayıt verilerini değişenlere aktar
    $userName = post('user_name');
    $email = post('user_email');
    $pass = post('user_password');
    $passAgain = post('user_pass_again');
    $passCheck = post('user_pass_check') ?? 'is_null';

    // gelen verilerin boş olup olmadığını kontrol et
    if (!$userName) {
        $error = 'Lütfen kullanıcı adınızı yazın!';
    } elseif (!$email) {
        $error = 'Lütfen e-posta adresinizi giriniz!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Lütfen geçerli bir e-posta adresi giriniz!';
    } elseif ($passCheck == 'yes' && (!$pass || !$passAgain)) {
        $error = 'Lütfen şifrenizi giriniz!';
    } elseif ($passCheck == 'yes' && $pass != $passAgain) {
        $error = 'Giridiğiniz şifreler birbiriyle uyuşmuyor!';
    } elseif (session('user_rank') == 2 && post('user_rank') == 1) {
        $error = "Bu kullanıcı'yı bir üst rütbe'ye taşıma <b>yetkiniz yok</b>!";

    } else {
        // izinler dışınndaki verileri kontrol et
        if ($data = formControl('user_permissions', 'user_password', 'user_pass_again')) {
            unset($data['user_pass_check']);
            unset($data['user_pass_again']);
            if ($passCheck == 'is_null') {
                unset($data['user_password']);
            } else {
                $data['user_password'] = password_hash($pass, PASSWORD_DEFAULT);
            }
            $data['user_name'] = $userName;
            $data['user_email'] = $email;
            $data['user_url'] = sefLink($data['user_name']);
            $data['user_permissions'] = json_encode($data['user_permissions']);

            // verileri güncelle
            demoUser('users');
            $query = $db->update('users')
                ->where('user_id', $id)
                ->set($data);
            // güncelleme işlemi başarılıysa yönlendir
            if ($query) {
                $success = "İşlem başarıyla tamamlandı.";
                $_SESSION['log_success'] = $success ?? null;
                $_SESSION['user_permissions'] = $data['user_permissions'];
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
$_SESSION['log_error'] = $error ?? null;

// JSON formatında gelen verileri diziye dönüştür
$permissions = json_decode($row['user_permissions'], true);

// sayfaya dahil et
require adminView('edit-user');
