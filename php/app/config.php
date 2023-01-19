<?php
define('PATH', editPath(realpath('.')));
define('SUBFOLDER_NAME', '/tr');
define('URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . SUBFOLDER_NAME);

define('DB_HOST', 'localhost');
define('DB_NAME', 'site_hizirhamalcom');
define('DB_USER', 'root');
define('DB_PASS', '');

return [
    'db' => [
        'host' => DB_HOST,
        'name' => DB_NAME,
        'user' => DB_USER,
        'pass' => DB_PASS
    ]
];
