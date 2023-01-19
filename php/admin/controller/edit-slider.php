<?php

// izin kontrol işlemi
if (!permission('others', 'edit')) {
    permissionPage();
}

// id değeri var mı kontrol et
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl());
    exit;
}

// değer  var mı kontrol et
$row = $db->from('sliders')
    ->where('slid_id', $id)
    ->first();
if (!$row) {
    header('Location' . adminUrl('others'));
    exit;
}

// form gönderildiyse
if (post('submit')) {
    // kategoriye ait verileri al
    $title = post('slid_title');
    $btnUrl = post('slid_btn_url');
    $btnName = post('slid_btn_name');
    $btnStatus = post('slid_btn_status') ?? 'is_null';
    $imgStatus = post('slid_img_status') ?? 'is_null';

    // kategori adı veya kategori url'si boşsa hata ver
    if (!$title) {
        $error = 'Lütfen başlık giriniz!';
    } elseif ($imgStatus == 'yes' && !$_FILES['slid_image']) {
        $error = 'Lütfen bir resim seçiniz!';
    } elseif ($btnStatus == '1' && (!$btnName || !$btnUrl)) {
        $error = 'Lütfen buton bilgilerini giriniz!';
    } else {
        // veri var mı komtrol et
        $query = $db->from('sliders')
            ->where('slid_title', $title)
            ->where('slid_id', $id, '!=')
            ->first();
        // sorgulanan kategori varsa
        if ($query) {
            $error = '<strong>' . $title . '</strong> adında bir slider zaten mevcut, lütfen başka bir başlık deneyiniz!';
        } else {
            // yoksa kategoriyi ekleme işlemini yap
            if ($data = formControl(
                'slid_description', 'slid_img_status', 'slid_btn_status', 'slid_image', 'slid_btn_name', 'slid_btn_url'
            )) {
                if ($imgStatus == 'is_null' || !isset($imgStatus)) {
                    unset($data['slid_img_status']);
                    unset($data['slid_image']);
                } else {
                    unset($data['slid_img_status']);
                }
                if ($btnStatus == 'is_null') {
                    unset($data['slid_btn_url']);
                    unset($data['slid_btn_name']);
                }
                // verileri ekle
                demoUser('sliders');
                $update = '';
                $file_path = PATH . '/upload/sliders/';
                $handle = new upload($_FILES['slid_image']);
                if ($handle->uploaded) {
                    $handle->file_new_name_body = 'slid_' . rand(10000000, 99999999);
                    $handle->image_resize = true;
                    $handle->image_x = 1280;
                    $handle->image_ratio_y = true;
                    $handle->allowed = ['image/*'];
                    $handle->process($file_path);
                    if ($handle->processed) {
                        $img = $handle->file_dst_name_body . '.' . $handle->file_dst_name_ext;
                        $update = $db->update('sliders')
                            ->where('slid_id', $id)
                            ->set(array_merge($data, ['slid_image' => $img]));
                    } else {
                        $error = $handle->error;
                    }
                } else {
                    $update = $db->update('sliders')
                        ->where('slid_id', $id)
                        ->set($data);
                }
                if ($update) {
                    $success = "İşlem başarıyla tamamlandı.";
                    $_SESSION['log_success'] = $success ?? null;
                    header('Location: ' . adminUrl('others'));
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

// menü ekleme html alanının gösterilmesi
require adminView('edit-slider');