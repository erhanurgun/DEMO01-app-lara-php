<!-- start track-section -->
<?php if (setting('other_newsletter_section') == "1") : ?>
    <section class="newsletter-section newsletter-section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h2>Bültenimize Abone Olun</h2>
                    <p>Gelişmelerden anında haberdar olmak için bültenimize <u>ücretsiz</u> kaydolabilirsiniz.</p>
                </div>
                <div class="col-lg-8">
                    <div class="newsletter">
                        <div class="newsletter-form">
                            <form method="post" class="contact-validation-active" id="newsletter-form">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <input type="text" name="news_name" id="news_name" class="form-control" placeholder="Adınız ve Soyadınız">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <input type="email" name="news_email" id="news_email" class="form-control" placeholder="E-Posta Adresiniz">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <button type="submit" onclick="addNewsletter('#newsletter-form');">
                                            Ücretsiz Kaydol
                                        </button>
                                        <div id="loader">
                                            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix error-handling-messages">
                                    <div id="newsSuccess">
                                        Teşekkürler mesajınız başarılı bir şekilde iletildi. <br>
                                        En kısa zamanda sizinle iletişime geçilecektir!
                                    </div>
                                    <div id="newsError">
                                        E-posta gönderilirken hata oluştu. Lütfen daha sonra tekrar deneyiniz.
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
<?php endif; ?>
<!-- end track-section -->

<!-- .footer-area start -->
<div class="footer-area">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 footer-t">
                    <div class="footer-logo">
                        <a href="<?= siteUrl(); ?>">
                            <img class="img-logo" src="<?= publicUrl('upload/logo.svg') ?>" alt="Logo, <?= setting('keywords'); ?>">
                        </a>
                    </div>
                    <div class="social">
                        <ul class="d-flex">
                            <!-- loop area start -->
                            <?php foreach (menu(2) as $item) : ?>
                                <li>
                                    <a target="_blank" href="<?= $item['url']; ?>">
                                        <?= $item['title']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <!-- loop area end -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 footer-t">
                    <div class="footer-link">
                        <h3>Hızlı Erişim</h3>
                        <ul>
                            <!-- loop area start -->
                            <?php foreach (menu(1) as $menu) :
                                if (!isset($menu['submenu'])) : ?>
                                    <li><a href="<?= siteUrl($menu['url']); ?>"><?= $menu['title']; ?></a></li>
                            <?php endif;
                            endforeach; ?>
                            <!-- loop area end -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="footer-widget instagram">
                        <h3>Mini Galerimiz</h3>
                        <ul class="d-flex">
                            <!-- loop area start -->
                            <?php foreach ($medias as $key => $val) :
                                if ($key == 9) break; ?>
                                <li>
                                    <a href="<?= uploadUrl('medias/' . $val['media_url']); ?>" target="_blank">
                                        <img class="mini-media" src="<?= uploadUrl('medias/' . $val['media_url']); ?>" alt="<?= setting('keywords'); ?>">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <!-- loop area end -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="row">
                    <div class="col-12">
                        <span>
                            ©™ <?= date('Y'); ?> Tüm hakları saklıdır.
                            <?php if (setting('other_footer_dev') == "1") : ?>
                                ❤️ ile tasarlayan
                                <a target="_blank" href="https://erhanurgun.com.tr/" title="Back-End Developer">erhanurgun.com.tr</a>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (setting('other_whatsapp') == "1") : ?>
        <div data-toggle="tooltip" data-placement="right" title="Bizi arayıp, teklif alabilirsiniz!">
            <a href="tel:<?= setting('phone_1'); ?>">
                <img class="eu-telefon" src="<?= publicUrl('images/icon/phone.svg'); ?>" alt="<?= setting('title'); ?> Telefon Hattımız">
            </a>
        </div>

        <div data-toggle="tooltip" data-placement="right" title="Buyrun, size nasıl yardımcı olabiliriz?">
            <a href="https://api.whatsapp.com/send/?phone=<?= wpFormat(setting('phone_1')); ?>&text=Bilgi%20almak%20istiyorum..." target="_blank">
                <img class="eu-whatsapp" src="<?= publicUrl('images/icon/wp.svg'); ?>" alt="<?= setting('title'); ?> WhatsApp Hattımız">
            </a>
        </div>
    <?php endif; ?>
</div>
<!-- .footer-area end -->

<!-- alert start -->
<div class="res-mssg">
    <div class="success" style="display: none;">
        Teşekkürler mesajınız başarılı bir şekilde iletildi. <br>
        En kısa zamanda sizinle iletişime geçilecektir!
    </div>
    <div class="error" style="display: none;">
        Mesajınız gönderilirken hata oluştu. Lütfen daha sonra tekrar deneyiniz.
    </div>
</div>
<!-- alert end -->

<!-- All JavaScript files
================================================== -->
<script src="<?= publicUrl('js/jquery.min.js'); ?>"></script>
<script src="<?= publicUrl('js/bootstrap.min.js'); ?>"></script>
<!-- Plugins for this template -->
<script src="<?= publicUrl('js/jquery-plugin-collection.js'); ?>"></script>
<script src="<?= publicUrl('js/jquery.slicknav.min.js'); ?>"></script>
<!-- Custom script for this template -->
<script src="<?= publicUrl('js/script.js'); ?>"></script>
<script src="<?= publicUrl('js/custom.js'); ?>"></script>

<script>
    let apiUrl = '<?= siteUrl('api'); ?>',
        appUrl = '<?= siteUrl('app/'); ?>';
</script>

<script src="<?= publicUrl('js/ajax.js'); ?>"></script>

<script>
    <?php for ($i = 1; $i <= setting('phone_count'); $i++) : ?>
        <?php if (setting('phone_' . $i)) : ?>
            $('#allPhones').append(
                '<span class="d-block"><?= setting('phone_' . $i) ?></span>'
            );
        <?php endif; ?>
    <?php endfor; ?>
</script>

</body>

</html>