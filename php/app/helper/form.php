<?php
// POST işlemlerinin güvenliğini sağlama
function post($name)
{
    // POST işlemi yapıldıysa
    if (isset($_POST[$name])) {
        // gelen POST verileri diziyse
        if (is_array($_POST[$name])) {
            // dizi olarak döndür
            return array_map(function ($item) {
                // TODO: permissions gönderme işleminde hata oluşmakta!
                /*return htmlspecialchars(trim($item));*/
                return $item;
            }, $_POST[$name]);
        }
        // boşluk ve HTML elemenlerini temizle
        return htmlspecialchars(trim($_POST[$name]));
    }
}

// GET işlemlerinin güvenliğini sağlama
function get($name)
{
    if (isset($_GET[$name])) {
        if (is_array($_GET[$name])) {
            return array_map(function ($item) {
                return htmlspecialchars(trim($item));
            }, $_GET[$name]);
        }
        return htmlspecialchars(trim($_GET[$name]));
    }
}

// gelen POST değerleri boş mu kontrol et
function formControl(...$exceptThese)
{
    // gelen verilerden submit değerini çıkar
    unset($_POST['submit']);
    $data = [];
    $error = false;
    // gelen değerleri teker teker oku
    foreach ($_POST as $key => $value) {
        // gelen değer yoksa ve dizi değilse
        if (!in_array($key, $exceptThese) && post($key) == "" && post($key) == "message") {
            $error = true;
        } else {
            $data[$key] = post($key);
        }
    }
    // hat durumu aktifse
    if ($error) {
        return false;
    }
    return $data;
}

// forma gelen verilerin türüne göre filtreleme yapma
function formFilter($data, $type = 'text')
{
    $errors = [];
    switch ($type) {
        case 'email':
            if (!filter_var($data, FILTER_VALIDATE_EMAIL))
                $errors['email'] = 'Lütfen geçerli bir email adresi giriniz!';
            break;
        case 'number':
            if (!preg_match('/^[0-9\s]+$/', $data))
                $errors['number'] = 'Lütfen sadece rakamları kullanınız!';
            break;
        case 'textarea':
            if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $data))
                $errors['textarea'] = 'Lütfen (,) dışında özel karakter kullanmadan tekrar deneyiniz!';
            break;
        default:
            if (!preg_match('/^[a-zA-Z\s]+$/', $data))
                $errors['text'] = 'Lütfen sadece büyük veya küçük harfleri kullanınız!';
            break;
    }
    return $errors;
}

// PHPMailer ile mail gönderme işlemi
function sendEmail($email, $name, $subject, $message)
{
    // mailerden nesne türet
    $mail = new PHPMailer(true);

    try {
        //sunucu ayarları
        // $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = setting('smtp_host');
        $mail->SMTPAuth = true;
        $mail->Username = setting('smtp_email');
        $mail->Password = setting('smtp_password');
        $mail->SMTPSecure = setting('smtp_secure');
        $mail->Port = setting('smtp_port');
        $mail->CharSet = 'UTF-8';

        // alıcı
        $mail->setFrom(setting('smtp_send_email'), setting('smtp_send_name'));
        $mail->addAddress($email, $name);

        // içerik
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // mesajı gönder
        $mail->send();
        // echo 'Mesaj başarıyla gönderildi';
        return true;
    } catch (Exception $e) {
        // echo "Mesaj Gönderilemedi. Mail Hatası: {$mail->ErrorInfo}";
        return false;
    }
}
