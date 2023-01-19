<?php

// izin kontrol işlemi
if (!permission('customers', 'edit')) {
    permissionPage();
}

// id parametresi yoksa yönlendir
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl('customers'));
    exit();
}
// kullanıcıyı çekme
$row = $db->from('customers')
    ->where('customer_id', $id)
    ->first();

// kullanıcı bulunamadıysa yönlendir
if (!$row) {
    header('Location: ' . adminUrl('customers'));
    exit();
}

// düzenleme isteği yapıldı mı
if (post('submit')) {
    // izinler dışındaki verileri al
    if ($data = formControl('customer_status')) {
        $data['customer_status'] = post('customer_status');
        // verileri güncelle
        demoUser('customers');
        $query = $db->update('customers')
            ->where('customer_id', $id)
            ->set($data);
        // veriler güncellendiyse yönlendir
        if ($query) {
            $success = "İşlem başarıyla tamamlandı.";
            $_SESSION['log_success'] = $success ?? null;
            header('Location: ' . adminUrl('customers'));
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
require adminView('edit-customer');