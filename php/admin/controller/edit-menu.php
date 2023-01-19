<?php

// izin kontrol işlemi
if (!permission('menus', 'edit')) {
    permissionPage();
}

$id = get('id');
// eğer id değeri yolsa menüler sayfasına yönlendir
if (!$id) {
    header('Location: ' . adminUrl('menus'));
    exit();
}

// menü verilerini çekme
$query = $db->prepare('SELECT * FROM menus WHERE menu_id = :id');
$query->execute(['id' => $id]);
$row = $query->fetch(PDO::FETCH_ASSOC);
// istenen veri bulunamadıysa yönlendir
if (!$row) {
    header('Location: ' . adminUrl('menus'));
    exit();
}

// eğer post işlemi yapıldıysa
if (post('submit')) {
    $menu = [];
    $menuTitle = post('menu_title');
    // eğer menü başlığı boşsa
    if (!$menuTitle) {
        $error = 'Menü başlığını belirtin';
    } // eğer hiç menü yoksa
    elseif (count(array_filter(post('title'))) == 0) {
        $error = 'En az bir menü içeriği girmeniz gerekiyor';
    } else {
        // menü mimarisini kurma
        $urls = post('url');
        // menü başlığına göre döngüye al
        foreach (post('title') as $key => $title) {
            $arr = [
                'title' => $title,
                'url' => $urls[$key]
            ];
            // menüye ait alt başlık var mı
            if (post('sub_title_' . $key)) {
                $subMenu = [];
                $subUrls = post('sub_url_' . $key);
                // alt başlık varsa döngüye al
                foreach (post('sub_title_' . $key) as $k => $subTitle) {
                    if (!empty($subTitle)) {
                        $subMenu[] = [
                            'title' => $subTitle,
                            'url' => $subUrls[$k]
                        ];
                    }
                }

                $arr['submenu'] = $subMenu;
            }
            if (!empty($arr['title'])) {
                $menu[] = $arr;
            }
        }

        demoUser('menus');
        // menüyü veritabanını güncelle
        $query = $db->prepare('UPDATE menus SET menu_title = :title, menu_content = :content WHERE menu_id = :id');
        $result = $query->execute([
            'id' => $id,
            'title' => $menuTitle,
            'content' => json_encode($menu)
        ]);
        // güncelleme işlemi başarılıysa yönlendir
        if ($result) {
            $success = "İşlem başarıyla tamamlandı.";
            $_SESSION['log_success'] = $success ?? null;
            header('Location: ' . adminUrl('menus'));
            exit;
        } else {
            $error = 'Bir sorun oluştu ve menü güncellenemedi!';
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// JSON formatında gelen verileri diziye dönüştür
$menuData = json_decode($row['menu_content'], true);

// menü ekleme html alanının gösterilmesi
require adminView('edit-menu');