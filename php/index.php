<?php

require __DIR__ . '/app/init.php';

// $_SERVER['REQUEST_URI'] den gelen değerleri parçala ve istenilen formata dönüştür
$routeExplode = explode('?', $_SERVER['REQUEST_URI']);
$route = array_filter(explode('/', $routeExplode[0]));

// eğer ana dizinde çalışılmıyorsa
if (SUBFOLDER_NAME != null) {
    // ilk değeri sil
    array_shift($route);
}

// GET 'ten gönderilen dizinin ilk değeri yoksa
if (!route(0)) {
    $route[0] = 'index';
}

// GET 'ten gönderilen ilk değere erişilemiyorsa
if (!file_exists(controller($route[0]))) {
    $route[0] = '404';
}

// bakım modu durumu aktif mi
if (setting('maintenance_mode') == 1 && route(0) != 'admin') {
    $route[0] = 'maintenance-mode';
}

// controller'ları sayfaya dahil et
require controller(route(0));