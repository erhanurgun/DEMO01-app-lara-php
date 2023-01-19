<?php

// izin kontrol işlemi
if (!permission('others', 'add')) {
    permissionPage();
}

// form gönderildiyse
if (post('submit')) {
    // kategoriye ait verileri al
    $title = post('slid_title');
    $btnUrl = post('slid_btn_url');
    $btnName = post('slid_btn_name');
    $btnStatus = post('slid_btn_status') ?? 'is_null';

    // kategori adı veya kategori url'si boşsa hata ver
    if (!$title) {
        $error = 'Lütfen başlık giriniz!';
    } elseif (!$_FILES['slid_image']) {
        $error = 'Lütfen bir resim seçiniz!';
    } elseif ($btnStatus == '1' && (!$btnName || !$btnUrl)) {
        $error = 'Lütfen buton bilgilerini giriniz!';
    } else {
        // kategori var mı komtrol et
        $query = $db->from('sliders')
            ->where('slid_title', $title)
            ->first();
        // sorgulanan kategori varsa
        if ($query) {
            $error = '<strong>' . $title . '</strong> adında bir slider zaten mevcut, lütfen başka bir başlık deneyiniz!';
        } else {
            // yoksa kategoriyi ekleme işlemini yap
            if ($data = formControl(
                'slid_description', 'slid_btn_status', 'slid_btn_name', 'slid_btn_url',
            )) {
                if ($btnStatus == 'is_null') {
                    unset($data['slid_btn_url']);
                    unset($data['slid_btn_name']);
                }
                // verileri ekle
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
                        demoUser('sliders');
                        $insert = $db->insert('sliders')->set($data);
                        $lastId = $db->lastId();
                        $update = $db->update('sliders')
                            ->where('slid_id', $lastId)
                            ->set(['slid_image' => $img]);
                        if ($insert && $update) {
                            $success = "İşlem başarıyla tamamlandı.";
                            $_SESSION['log_success'] = $success ?? null;
                            header('Location: ' . adminUrl('others'));
                            exit;
                        } else {
                            $error = 'Beklenmedik bir sorun oluştu!';
                        }
                    } else {
                        $error = $handle->error;
                    }
                }
            } else {
                $error = 'Eksik alanlar var, lütfen kontrol ediniz!';
            }
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// menü ekleme html alanının gösterilmesi
require adminView('add-slider');