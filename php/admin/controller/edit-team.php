<?php

if (!permission('others', 'add')) {
    permissionPage();
}

$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl());
    exit;
}

$row = $db->from('teams')
    ->where('team_id', $id)
    ->first();
if (!$row) {
    header('Location' . adminUrl('others'));
    exit;
}

$_SESSION['click_id'] = '#teams';

if (post('submit')) {
    $title = post('team_name');
    $imgStatus = post('img_check') ?? 'is_null';

    if ($imgStatus == 'yes' && !$_FILES['team_img']) {
        $error = 'Lütfen bir resim seçiniz!';
    } elseif (!$title) {
        $error = 'Lütfen ad ve soyad giriniz!';
    } else {
        $query = $db->from('teams')
            ->where('team_name', $title)
            ->where('team_id', $id, '!=')
            ->first();
        if ($query) {
            $error = '<strong>' . $title . '</strong> adında bir kişi zaten mevcut, lütfen başka bir ad giriniz!';
        } else {
            if ($data = formControl(
                'team_img', 'team_job', 'team_face', 'team_insta', 'team_twit', 'img_check'
            )) {
                if ($imgStatus == 'is_null' || !isset($imgStatus)) {
                    unset($data['team_img']);
                    unset($data['img_check']);
                } else {
                    unset($data['img_check']);
                }
                demoUser('teams');
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
                        $update = $db->update('teams')
                            ->where('team_id', $id)
                            ->set(array_merge($data, ['team_img' => $img]));

                    } else {
                        $error = $handle->error;
                    }
                } else {
                    $update = $db->update('teams')
                        ->where('team_id', $id)
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

require adminView('edit-team');