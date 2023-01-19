<?php

// izin kontrol işlemi
if (!permission('menus', 'show')){
    permissionPage();
}

// menü verilerini çek
$query = $db->prepare('SELECT * FROM menus ORDER BY menu_title DESC');
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

// menü bu alanda listensin
require adminView('menus');