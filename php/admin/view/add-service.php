<?php require adminView('static/header'); ?>

<div class="box-"><h1>Hizmet Ekleme</h1></div>

<div class="clear" style="height: 10px;"></div>

<div class="box-" tab>

    <div class="admin-tab">
        <ul tab-list>
            <li><a href="">Genel</a></li>
            <li><a href="">SEO</a></li>
        </ul>
    </div>

    <form action="" method="post" class="form label">
        <div class="tab-container">

            <div tab-content>
                <ul>
                    <li>
                        <label>Sayfa Başlığı</label>
                        <div class="form-content">
                            <input type="text" name="service_title" value="<?= post('service_title'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Sayfa İkonu</label>
                        <div class="form-content">
                            <input type="text" name="service_icon" value="<?= post('service_icon'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Sayfa İçeriği</label>
                        <div class="form-content">
                            <textarea class="editor" name="service_content" cols="30" rows="10"><?= post('service_content'); ?></textarea>
                        </div>
                    </li>
                </ul>
            </div>

            <div tab-content>
                <ul>
                    <li>
                        <label>SEO Url</label>
                        <div class="form-content">
                            <input type="text" name="service_url" value="<?= post('service_url'); ?>">
                            <p class="p-small">
                                <b>NOT:</b> Eğer boş bırakırsanız, otomatik olarak sayfa başlığını baz alır!
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>SEO Başlık</label>
                        <div class="form-content">
                            <input type="text" name="service_seo[title]">
                        </div>
                    </li>
                    <li>
                        <label>SEO Açıklaması</label>
                        <div class="form-content">
                            <textarea name="service_seo[description]" cols="30" rows="5"></textarea>
                        </div>
                    </li>
                </ul>
            </div>

            <ul>
                <li class="submit">
                    <input type="hidden" name="submit" value="1">
                    <button type="submit">Kaydet</button>
                </li>
            </ul>
        </div>
    </form>

</div>

<?php require adminView('static/footer'); ?>
