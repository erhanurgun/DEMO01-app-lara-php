<?php require adminView('static/header'); ?>

<!-- genel anasayfa görünümü bu alanda gösterilecek -->
<div class="box-container">
    <div class="box" id="div-0">
        <h3>Bilgilendirme!</h3>
        <div class="box-content">
            <h1>
                Yönetim paneline hoşgeldiniz...
            </h1>
            <ul class="fa-not">
                <li>
                    <i class="fa f10px fa-dot-circle-o"></i>
                    Bu yönetim paneli her zaman <b>güncellenecektir</b>!
                </li>
                <li>
                    <i class="fa f10px fa-dot-circle-o"></i>
                    Bu panelden <b>maksimum verim</b> alabilmek için lütfen <b>bilgisayar</b> kullanınız!
                </li>
                <li>
                    <i class="fa f10px fa-dot-circle-o"></i>
                    Eğer panele erişim sağlayamazsanız lütfen <b>teknik destek</b> ekibiyle irtibata geçiniz!
                </li>
                <li>
                    <i class="fa f10px fa-dot-circle-o"></i>
                    Revize edilmesini istediğiniz alanlar varsa teknik destek ekibimizle iletişime geçmekten çekinmeyiniz :)
                </li>
                <li>
                    <i class="fa f10px fa-dot-circle-o"></i>
                    <span class="text-red">
                        Panelin bazı eksikleri bulunmaktadır.
                        Bu eksikler halen giderilmektedir.
                        Ama bu durum sizi yanıltmasın.
                        <b>Paneli gönül rahatlığıyla kullanmaya devam edebilirsiniz.</b>
                        İşlemlerinizde herhangi bir aksaklık olmayacağını garanti ederiz...
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="box-container">
    <div class="box">
        <h3>Müşteriler'e E-Posta Gönderme</h3>
        <div class="box-content">
            <div class="message success box-" style="display: none;" id="success"></div>
            <div class="message error box-" style="display: none;" id="error"></div>

            <form action="" class="form" id="offer-form" onsubmit="return false;">
                <input type="hidden" name="name" value="yes">
                <ul>
                    <li>
                        <input type="text" name="name" value="<?= setting('title'); ?>" placeholder="Gönderen">
                    </li>
                    <li>
                        <input type="text" name="subject" placeholder="Mesaj Konusu">
                    </li>
                    <li>
                        <input type="email" name="email" placeholder="E-Posta Adresi">
                    </li>
                    <li>
                        <textarea name="message" cols="30" rows="10" placeholder="Mesajınız..."></textarea>
                    </li>
                    <li>
                        <button onclick="sendEmail('#offer-form');" type="submit">Gönder</button>
                    </li>
                </ul>
            </form>

            <div class="message info eu-mt-2">
                <strong>NOT:</strong>
                Alternatif e-posta gönderme paneli'ne gitmek için bu
                <a class="a-link" href="<?= siteURL('https://hizirhamal.com:2096/cpsess2424422796/3rdparty/roundcube/?_task=mail&_action=compose&_id=19296487416355910061d96'); ?>" target="_blank">
                    <b>linke</b>
                </a>
                tıklayınız.
                <ul class="fa-not">
                    <li>
                        <i class="fa f10px fa-dot-circle-o"></i>
                        Bu paneli kullanabilmeniz için giriş yapmanız gerekmektedir.
                    </li>
                    <li>
                        <i class="fa f10px fa-dot-circle-o"></i>
                        Giriş için bu <b>e-posta</b> ve <b>şifre</b>'yi kullanınız. <br><br>
<pre>
    <b>E-Posta:</b> no-relpy@hizirhamal.com
    <b>Şifre......:</b> 5478Reply*?!
</pre>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require adminView('static/footer'); ?>