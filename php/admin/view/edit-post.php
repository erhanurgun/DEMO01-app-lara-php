<?php require adminView('static/header'); ?>

<div class="box-"><h1>Konu Düzenleme (#<?= $id; ?>)</h1></div>

<div class="clear" style="height: 10px;"></div>

<div class="box-" tab>

    <div class="admin-tab">
        <ul tab-list>
            <li><a href="">Genel</a></li>
            <li><a href="">SEO</a></li>
        </ul>
    </div>

    <form action="" method="post" class="form label" enctype="multipart/form-data">
        <div class="tab-container">

            <div tab-content>
                <ul>
                    <li>
                        <label>Yüklü Resim</label>
                        <div class="form-content">
                            <img class="post-img" src="<?= uploadUrl('posts/' . $row['post_img']); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Paylaşım Görseli</label>
                        <div class="form-content">
                            <input type="file" name="post_img">
                        </div>
                    </li>
                    <li>
                        <label>Konu Başlığı</label>
                        <div class="form-content">
                            <input type="text" name="post_title"
                                   value="<?= post('post_title') ?? $row['post_title']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Konu Kategorisi</label>
                        <div class="form-content">
                            <select name="post_categories[]" multiple size="6">
                                <option value="" disabled>--- Kategori Seçiniz ---</option>
                                <?php foreach ($categories as $category): ?>
                                    <option <?= in_array($category['category_id'], explode(',', $row['post_categories'])) ? 'selected' : ''; ?>
                                            value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="eu-mt-1 f-size-sm">
                                <b>NOT:</b> Birden fazla seçim yapabilmek için <b>CTRL</b> tuşuna basılı tutunuz!
                            </div>
                        </div>
                    </li>
                    <li>
                        <label>Konu Durumu</label>
                        <div class="form-content">
                            <select name="post_status">
                                <option value="">--- Durum Seçiniz ---</option>
                                <option value="1" <?= (post('post_status') ?? $row['post_status']) == 1 ? 'selected' : null; ?>>
                                    Yayında
                                </option>
                                <option value="2" <?= (post('post_status') ?? $row['post_status']) == 2 ? 'selected' : null; ?>>
                                    Taslak
                                </option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <label>Konu Etiketleri</label>
                        <div class="form-content">
                            <input class="tagsinput" type="text" name="post_tags"
                                   value="<?= post('post_tags') ?? implode(',', $postTags); ?>">
                            <div class="eu-mt-1 f-size-sm">
                                <b>NOT:</b> Etiketi yazdıktan sonra eklemek için <b>ENTER</b> tuşuna basınız!
                            </div>
                        </div>
                    </li>
                    <li>
                        <label>Konu İçeriği</label>
                        <div class="form-content">
                            <textarea class="editor" name="post_content" cols="30"
                                      rows="10"><?= post('post_content') ?? $row['post_content']; ?></textarea>
                        </div>
                    </li>
                </ul>
            </div>

            <div tab-content>
                <ul>
                    <li>
                        <label>SEO Url</label>
                        <div class="form-content">
                            <input type="text" name="post_url" value="<?= post('post_url') ?? $row['post_url']; ?>">
                            <p class="p-small">
                                <b>NOT:</b> Eğer boş bırakırsanız, otomatik olarak konu adını baz alır!
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>SEO Başlık</label>
                        <div class="form-content">
                            <input type="text" name="post_seo[title]" value="<?= $seo['title']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>SEO Açıklaması</label>
                        <div class="form-content">
                            <textarea name="post_seo[description]" cols="30"
                                      rows="5"><?= $seo['description']; ?></textarea>
                        </div>
                    </li>
                </ul>
            </div>

            <ul>
                <li class="submit">
                    <input type="hidden" name="submit" value="1">
                    <button type="submit">Gönder</button>
                </li>
            </ul>
        </div>
    </form>

</div>

<script>
    let tags = ['<?= implode("','", $tagsArr); ?>'];
</script>

<?php require adminView('static/footer'); ?>
