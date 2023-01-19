<?php
// yönlendirme ve session işlemleri için
session_start();
ob_start();
// sistem saatini istanbul'a göre ayarla
date_default_timezone_set('Europe/Istanbul');

// ayarlar dosyasını dahil etme
require __DIR__ . '/settings.php';
// tüm php hatalarını göster
error_reporting(E_ALL);
ini_set('display_errors', $settings['display_error_mode']);

// yolu düzenle
function editPath($path)
{
    $path = str_replace('\\', '/', $path);
    return $path;
}

// tüm sınıfları yükle
function loadClasses($className)
{
    $path = __DIR__ . '/classes/' . strtolower($className) . '.php';
    require editPath($path);
}

spl_autoload_register('loadClasses');

// konfigürasyon ayarlarını yapılandır
$config = require __DIR__ . '/config.php';
$host = $config['db']['host'];
$dbName = $config['db']['name'];
$user = $config['db']['user'];
$pass = $config['db']['pass'];

// veritabanına bağlantı ayarlarını yap
try {
    $db = new basicdb($host, $dbName, $user, $pass);
} catch (PDOException $e) {
    die($e->getMessage());
}



// helper klasörü içindeki tüm PHP dosyalarını dahil et
foreach (glob(__DIR__ . '/helper/*.php') as $helperFile) {
    require editPath($helperFile);
}
