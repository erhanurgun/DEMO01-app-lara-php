<?php

// izin kontrol işlemi
if (!permission('contact', 'edit')) {
    permissionPage();
}

// id parametresi yoksa yönlendir
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl('contact'));
    exit();
}
// kullanıcıyı çekme
$row = $db->from('contact')
    ->join('users', '%s.user_id = %s.contact_read_user', 'left')
    ->where('contact_id', $id)
    ->first();

// kullanıcı bulunamadıysa yönlendir
if (!$row) {
    header('Location: ' . adminUrl('contact'));
    exit();
}

// kullanıcı iletişim verisini okuduğunda okuındu olarak güncelle
if ($row['contact_read'] == 0) {
    if (!demoUser('contact', 'view')) {
        $db->update('contact')
            ->where('contact_id', $id)
            ->set([
                'contact_read' => 1,
                'contact_read_date' => date('Y-m-d H:i:s'),
                'contact_read_user' => session('user_id')
            ]);
    }
}

// düzenleme isteği yapıldı mı
if (post('submit')) {
    // izinler dışındaki verileri al
    if ($data = formControl('user_permissions')) {
        // verileri değişkenlere aktar
        $data['user_url'] = sefLink($data['user_name']);
        $data['user_permissions'] = json_encode($data['user_permissions']);
        // verileri güncelle
        demoUser('contact', 'ajax');
        $query = $db->update('users')
            ->where('user_id', $id)
            ->set($data);
        // veriler güncellendiyse yönlendir
        if ($query) {
            $success = "İşlem başarıyla tamamlandı.";
            $_SESSION['log_success'] = $success ?? null;
            header('Location: ' . adminUrl('users'));
            exit();
        } else {
            $error = 'Beklenmedik bir sorun oluştu!';
        }
    } else {
        $error = 'Eksik alanlar var, lütfen kontrol ediniz!';
    }
}
$_SESSION['log_error'] = $error ?? null;

// sayfaya dahil et
require adminView('edit-contact');