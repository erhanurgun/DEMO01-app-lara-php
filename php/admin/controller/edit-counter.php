<?php
if (!permission('others', 'edit')) {
    permissionPage();
}

$_SESSION['click_id'] = '#counter';

if (post('submit')) {
    if ($data = formControl()) {
        demoUser('others');
        $query = $db->update('counters')->set($data);
        if ($query) {
            $success = "İşlem başarıyla tamamlandı.";
            $_SESSION['log_success'] = $success ?? null;
            header('Location: ' . adminUrl('others'));
            exit;
        } else {
            $error = 'Bir sorun oluştu!';
        }
    } else {
        $error = 'Eksik alanlar var, lütfen kontrol ediniz!';
    }
}
$_SESSION['log_error'] = $error ?? null;
header('Location: ' . adminUrl('others'));
exit;
