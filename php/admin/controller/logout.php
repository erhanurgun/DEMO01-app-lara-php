<?php
// tüm session'ları sil
session_destroy();
// giriş ekranına yönlendir
header('Location: ' . adminUrl('login'));
exit;