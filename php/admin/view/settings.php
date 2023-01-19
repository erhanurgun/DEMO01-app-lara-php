<?php require adminView('static/header'); ?>

<div class="box-"><h1>Genel Ayarlar</h1></div>

<div class="clear" style="height: 10px;"></div>


<div class="box-" tab>

    <div class="message warning eu-mb-2">
        <strong>UYARI:</strong>
        Eğer <b>ne yaptığınızı bilmiyorsanız</b> lütfen ayarları değiştirmeyiniz. Kalıcı sorunlara yol açabilir!
    </div>

    <div class="admin-tab">
        <ul tab-list>
            <?php foreach (settingPermArr() as $key => $item) : ?>
                <?php if (permission('settings', $key)): ?>
                    <li><a><?= $item; ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <form action="" method="post" class="form label">
        <div class="tab-container">

            <?php if (settingPermission('general')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>Domain Adı</label>
                            <div class="form-content">
                                <input type="text" name="settings[domain]" value="<?= setting('domain'); ?>"
                                       placeholder="domain adresini giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Hata Ayıklama</label>
                            <div class="form-content">
                                <select name="settings[display_error_mode]">
                                    <option value="" disabled>--- Mod Seç ---</option>
                                    <?php foreach ($mods as $key => $mode): ?>
                                        <option <?= setting('display_error_mode') == $key ? 'selected' : null; ?>
                                                value="<?= $key; ?>"><?= $mode; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Site Başlık</label>
                            <div class="form-content">
                                <input type="text" name="settings[title]" value="<?= setting('title'); ?>"
                                       placeholder="site başlığını giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Site Teması</label>
                            <div class="form-content">
                                <select name="settings[theme]">
                                    <option value="" disabled>--- Tema Seç ---</option>
                                    <?php foreach ($themes as $theme): ?>
                                        <option <?= setting('theme') == $theme ? 'selected' : null; ?>
                                                value="<?= $theme; ?>"><?= $theme; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Site Anahtar Kelime</label>
                            <div class="form-content">
                            <textarea name="settings[keywords]" cols="30"
                                      rows="3"><?= setting('keywords'); ?></textarea>
                            </div>
                        </li>
                        <li>
                            <label>Site Açıklama</label>
                            <div class="form-content">
                            <textarea name="settings[description]" cols="30"
                                      rows="5"
                                      placeholder="site açıklamasını giriniz..."><?= setting('description'); ?></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (settingPermission('contact')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>Telefon</label>
                            <div id="allPhones"></div>
                            <div class="form-content eu-mt-1 eu-mb-1">
                                <input type="hidden" id="phoneCount" name="settings[phone_count]"
                                       value="<?= setting('phone_count'); ?>">
                                <button type="button" class="btn btn-success" id="addNewPhone"><i
                                            class="fa fa-plus"></i>
                                    Yeni Telefon Ekle
                                </button>
                            </div>
                        </li>
                        <li>
                            <label>E-Posta</label>
                            <div class="form-content">
                                <input type="text" name="settings[email]" value="<?= setting('email'); ?>"
                                       placeholder="e-posta adresi giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Hafta İçi</label>
                            <div class="form-content">
                                <input type="time" class="w-50" name="settings[mid_week_1]"
                                       value="<?= setting('mid_week_1'); ?>">
                                <input type="time" class="w-50" name="settings[mid_week_2]"
                                       value="<?= setting('mid_week_2'); ?>">
                            </div>
                        </li>
                        <li>
                            <label>Hafta Sonu</label>
                            <div class="form-content">
                                <input type="time" class="w-50" name="settings[weekend_1]"
                                       value="<?= setting('weekend_1'); ?>">
                                <input type="time" class="w-50" name="settings[weekend_2]"
                                       value="<?= setting('weekend_2'); ?>">
                            </div>
                        </li>
                        <li>
                            <label>Adres</label>
                            <div class="form-content">
                            <textarea name="settings[address]" cols="30" rows="5"
                                      placeholder="adres giriniz..."><?= setting('address'); ?></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (settingPermission('smtp')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>SMTP Host</label>
                            <div class="form-content">
                                <input type="text" name="settings[smtp_host]" value="<?= setting('smtp_host'); ?>"
                                       placeholder="smtp host adresini giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>SMTP E-Posta</label>
                            <div class="form-content">
                                <input type="text" name="settings[smtp_email]" value="<?= setting('smtp_email'); ?>"
                                       placeholder="smtp e-posta adresini giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>SMTP Şifre</label>
                            <div class="form-content">
                                <input type="text" name="settings[smtp_password]"
                                       value="<?= setting('smtp_password'); ?>"
                                       placeholder="smtp şifresini giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>SMTP Port</label>
                            <div class="form-content">
                                <input type="text" name="settings[smtp_port]" value="<?= setting('smtp_port'); ?>"
                                       placeholder="smtp portunu giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>SMTP Gönderen <br> E-Posta</label>
                            <div class="form-content">
                                <input type="text" name="settings[smtp_send_email]"
                                       value="<?= setting('smtp_send_email'); ?>"
                                       placeholder="smtp gönderen e-posta adresini giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>SMTP Gönderen <br> Ad Soyad</label>
                            <div class="form-content">
                                <input type="text" name="settings[smtp_send_name]"
                                       value="<?= setting('smtp_send_name'); ?>"
                                       placeholder="smtp gönderen adını giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>SMTP Güvenliği</label>
                            <div class="form-content">
                                <select name="settings[smtp_secure]">
                                    <option value="" disabled>--- Tip Seç ---</option>
                                    <option <?= setting('smtp_secure') == 'ssl' ? 'selected' : null; ?> value="ssl">SSL
                                    </option>
                                    <option <?= setting('smtp_secure') == 'tls' ? 'selected' : null; ?> value="tls">TLS
                                    </option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (settingPermission('pagination')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>Blog Sayfalama</label>
                            <div class="form-content">
                                <input type="number" name="settings[blog_pagination]"
                                       value="<?= setting('blog_pagination'); ?>" placeholder="bir sayı giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Blog Kategori Sayfalama</label>
                            <div class="form-content">
                                <input type="number" name="settings[blog_category_pagination]"
                                       value="<?= setting('blog_category_pagination'); ?>"
                                       placeholder="bir sayı giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Blog Arama Sayfalama</label>
                            <div class="form-content">
                                <input type="number" name="settings[blog_search_pagination]"
                                       value="<?= setting('blog_search_pagination'); ?>"
                                       placeholder="bir sayı giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Blog Etiket Sayfalama</label>
                            <div class="form-content">
                                <input type="number" name="settings[blog_tag_pagination]"
                                       value="<?= setting('blog_tag_pagination'); ?>" placeholder="bir sayı giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Tablo Sayfalama</label>
                            <div class="form-content">
                                <input type="number" name="settings[admin_table_pagination]"
                                       value="<?= setting('admin_table_pagination'); ?>"
                                       placeholder="bir sayı giriniz...">
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (settingPermission('ajax')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>Google Maps API</label>
                            <div class="form-content">
                                <input type="text" name="settings[maps]" value="<?= setting('maps'); ?>"
                                       placeholder="api adresi giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>reCAPTCHA_v2 HTML API</label>
                            <div class="form-content">
                                <input type="text" name="settings[recaptcha_html]"
                                       value="<?= setting('recaptcha_html'); ?>" placeholder="api adresi giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>reCAPTCHA_v2 PHP API</label>
                            <div class="form-content">
                                <input type="text" name="settings[recaptcha_php]"
                                       value="<?= setting('recaptcha_php'); ?>" placeholder="api adresi giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Search Console Token</label>
                            <div class="form-content">
                                <input type="text" name="settings[search_console]"
                                       value="<?= setting('search_console'); ?>" placeholder="token giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Google Analitik ID</label>
                            <div class="form-content">
                                <input type="text" name="settings[analitic]" value="<?= setting('analitic'); ?>"
                                       placeholder="id giriniz...">
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (settingPermission('maintenance')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>Bakım Modu Açık Mı?</label>
                            <div class="form-content">
                                <select name="settings[maintenance_mode]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option <?= setting('maintenance_mode') == 1 ? 'selected' : null; ?> value="1">Evet
                                    </option>
                                    <option <?= setting('maintenance_mode') == 2 ? 'selected' : null; ?> value="2">Hayır
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Bakım Modu Başlık</label>
                            <div class="form-content">
                                <input type="text" name="settings[maintenance_mode_title]"
                                       value="<?= setting('maintenance_mode_title'); ?>"
                                       placeholder="başlığı giriniz...">
                            </div>
                        </li>
                        <li>
                            <label>Bakım Modu Açıklama</label>
                            <div class="form-content">
                    <textarea name="settings[maintenance_mode_description]" cols="30"
                              rows="5"
                              placeholder="bilgilendirme açıklamasını giriniz..."><?= setting('maintenance_mode_description'); ?></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (settingPermission('field_status')): ?>
                <div tab-content>
                    <ul>
                        <li>
                            <label>Anasayfa - Özellikler</label>
                            <div class="form-content">
                                <select name="settings[index_area_section]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('index_area_section') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('index_area_section') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Anasayfa - Biz Kimiz?</label>
                            <div class="form-content">
                                <select name="settings[index_area_about]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('index_area_about') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('index_area_about') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Anasayfa - Hizmetlerimiz</label>
                            <div class="form-content">
                                <select name="settings[index_area_service]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('index_area_service') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('index_area_service') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Anasayfa - Sizler İçin En İyisi</label>
                            <div class="form-content">
                                <select name="settings[index_area_counter]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('index_area_counter') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('index_area_counter') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Anasayfa - Müşteri Yorumları</label>
                            <div class="form-content">
                                <select name="settings[index_area_testimonial]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('index_area_testimonial') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('index_area_testimonial') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Anasayfa - Blog Yazılarımız</label>
                            <div class="form-content">
                                <select name="settings[index_area_blog]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('index_area_blog') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('index_area_blog') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Hakkımızda - Özellikler</label>
                            <div class="form-content">
                                <select name="settings[about_area_section]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('about_area_section') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('about_area_section') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Hakkımızda - Biz Kimiz?</label>
                            <div class="form-content">
                                <select name="settings[about_area_about]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('about_area_about') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('about_area_about') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Hakkımızda - Ekibimiz</label>
                            <div class="form-content">
                                <select name="settings[about_area_team]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('about_area_team') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('about_area_team') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>İletişim - Bilgilerimiz</label>
                            <div class="form-content">
                                <select name="settings[contact_row_1]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('contact_row_1') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('contact_row_1') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>İletişim - Harita</label>
                            <div class="form-content">
                                <select name="settings[contact_row_2]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('contact_row_2') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('contact_row_2') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Ekibimiz</label>
                            <div class="form-content">
                                <select name="settings[other_area_team]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_area_team') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_area_team') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Müthiş Özelliklerimiz</label>
                            <div class="form-content">
                                <select name="settings[other_area_features]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_area_features') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_area_features') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Yükleme Animasyonu</label>
                            <div class="form-content">
                                <select name="settings[other_page_loader]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_page_loader') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_page_loader') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                                <div class="eu-mt-1 f-size-sm">
                                    <b>NOT:</b> Eğer bu alan pasif edilirse <b>slider</b> alanı çalışmaz!
                                </div>
                            </div>
                        </li>
                        <li>
                            <label>Üst Bilgi İletişimi</label>
                            <div class="form-content">
                                <select name="settings[other_header_top]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_header_top') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_header_top') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Bülten Aboneliği</label>
                            <div class="form-content">
                                <select name="settings[other_newsletter_section]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_newsletter_section') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_newsletter_section') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>Geliştirici Adı</label>
                            <div class="form-content">
                                <select name="settings[other_footer_dev]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_footer_dev') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_footer_dev') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>WhatsApp Butonu</label>
                            <div class="form-content">
                                <select name="settings[other_whatsapp]">
                                    <option value="" disabled>--- İşlem Seç ---</option>
                                    <option value="1" <?= setting('other_whatsapp') == 1 ? 'selected' : null; ?>>
                                        Aktif
                                    </option>
                                    <option value="2" <?= setting('other_whatsapp') == 2 ? 'selected' : null; ?>>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <ul>
                <li class="submit">
                    <input type="hidden" name="submit" value="1">
                    <button type="submit"><i class="fa fa-save"></i> Ayarları Güncelle</button>
                </li>
            </ul>
        </div>
    </form>

</div>

<?php require adminView('static/footer'); ?>
