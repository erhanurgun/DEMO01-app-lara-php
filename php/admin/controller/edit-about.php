<?php
if (!permission('others', 'edit')) {
    permissionPage();
}

$_SESSION['click_id'] = '#about';

if (post('submit')) {
    if ($data = formControl()) {
        demoUser('others');
        $properties = [];
        for ($i = 0; $i < $data['item_count']; $i++) {
            $properties[$i] = $data['item_' . $i + 1];
        }
        $properties = json_encode($properties);
        $query = $db->update('about')
            ->set([
                'properties' => $properties,
                'user_name' => $data['user_name'],
                'user_job' => $data['user_job'],
                'content' => $data['content']
            ]);
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
