<?php
// iletişime gönderilem mail adreslerine yanıt oluşturma
if ($data = formControl()) {
    demoUser('edit-contact', 'ajax');
    $isEditor = $data['is_editor'];
    if ($isEditor == 'yes') {
        $data['message'] = '<pre>' . $_POST['message'] . '</pre>';
    }
    // verileri al
    $send = sendEmail($data['email'], $data['name'], $data['subject'], $data['message']);
    // sonuç true ise
    if ($send) {
        $json['success'] = 'Mesajınız başarıyla gönderildi.';
    } else {
        $json['error'] = 'Mesaj gonderilirken bir sorun oluştu!';
    }
} else {
    $json['error'] = 'Lütfen tüm bilgileri doldurunuz!';
}
