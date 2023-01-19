<?php

if (!permission('others', 'add')) {
    permissionPage();
}

$_SESSION['click_id'] = '#teams';

if (post('submit')) {
    $title = post('team_name');

    if (!$_FILES['team_img']) {
        $error = 'Lütfen bir resim seçiniz!';
    }elseif (!$title) {
        $error = 'Lütfen ad ve soyad giriniz!';
    } else {
        $query = $db->from('teams')
            ->where('team_name', $title)
            ->first();
        if ($query) {
            $error = '<strong>' . $title . '</strong> adında bir kişi zaten mevcut, lütfen başka bir ad giriniz!';
        } else {
            if ($data = formControl(
                'team_img', 'team_job', 'team_face', 'team_insta', 'team_twit', 'img_check'
            )) {
                $file_path = PATH . '/upload/teams/';
                $handle = new upload($_FILES['team_img']);
                if ($handle->uploaded) {
                    $handle->file_new_name_body = 'team_' . rand(10000000, 99999999);
                    $handle->image_resize = true;
                    $handle->image_x = 512;
                    $handle->image_ratio_y = true;
                    $handle->allowed = ['image/*'];
                    $handle->process($file_path);
                    if ($handle->processed) {
                        $img = $handle->file_dst_name_body . '.' . $handle->file_dst_name_ext;
                        demoUser('teams');
                        $insert = $db->insert('teams')->set($data);
                        $lastId = $db->lastId();
                        $update = $db->update('teams')
                            ->where('team_id', $lastId)
                            ->set(['team_img' => $img]);
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

require adminView('add-team');