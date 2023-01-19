<?php
// boş JSON dizi değişkeni oluştur
$json = [];
// urlden gelen kısmı 2 olarak al
$type = route(2);
// routed değeri boşsa durudur
if (!$type) {
    exit();
}
// gelen route / dosya admin'in altında controller altında varsa
if (file_exists(adminController('api/' . $type))){
    // sayfaya dahil et
    require adminController('api/' . $type);
}
// JSON formatında geriye değerleri döndür
echo json_encode($json);