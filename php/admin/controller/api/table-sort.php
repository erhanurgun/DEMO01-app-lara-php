<?php
// veritabaından gelen verileri al
$tableName = post('table');
$whereColumnName = post('where');
$columnName = post('column');

demoUser($tableName, 'ajax');

if (empty($json['error']) || !isset($json['error']))
{
    // tabloların id'lerine göre döngüye sok
    foreach (post('id') as $index => $id) {
        // döndürülen id'lere göre sıralama işlemini yap
        $db->update($tableName)
            ->where($whereColumnName, $id)
            ->set([
                $columnName => $index
            ]);
    }

    $json['success'] = 'Sıralama işlemi gerçekleşti.';
}
