<?php
if (!permission('others', 'edit')) {
    permissionPage();
}

$_SESSION['click_id'] = '#features';

if (post('submit')) {
    if ($data = formControl()) {
        demoUser('others');
        $content = [];
        for ($i = 0; $i < 4; $i++) {
            $content[$i] = $data['item_' . $i + 1];
        }
        $content = json_encode($content);
        $query = $db->update('features')->set(['content' => $content]);
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
