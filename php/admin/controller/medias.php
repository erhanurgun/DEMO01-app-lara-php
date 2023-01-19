    <?php

if (!permission('medias', 'add')) {
    permissionPage();
}

if (post('submit')) {
    echo '<pre>';
    if (array_filter($_FILES['images']['name'])) {
        $files = [];
        foreach ($_FILES['images'] as $file_key => $values) {
            foreach ($values as $index => $value) {
                $files[$index][$file_key] = $value;
            }
        }

        foreach ($files as $file) {
            $file_path = PATH . '/upload/medias/';
            $handle = new upload($file);
            if ($handle->uploaded) {
                $handle->file_new_name_body = 'img_' . rand(10000000, 99999999);
                $handle->image_resize = true;
                $handle->image_x = 1280;
                $handle->image_ratio_y = true;
                $handle->allowed = ['image/*'];
                $handle->process($file_path);
                if ($handle->processed) {
                    $img = $handle->file_dst_name_body . '.' . $handle->file_dst_name_ext;
                    demoUser('medias');
                    $db->insert('medias')->set(['media_url' => $img]);
                } else {
                    $error = $handle->error;
                }
            }
        }
        $success = "İşlem başarıyla tamamlandı.";
        $_SESSION['log_success'] = $success ?? null;
        header('Location: ' . adminUrl('medias'));
        exit;
    }else {
        $error = 'Lütfen en az 1 resim seçiniz!';
        $_SESSION['log_error'] = $error ?? null;
        header('Location: ' . adminUrl('medias'));
        exit;
    }
}

$query = $db->from('medias')
    ->orderBy('media_id','DESC')
    ->all();

require adminView('medias');