<?php require adminView('static/header'); ?>

<div class="box-"><h1>Etiket Düzenleme (#<?= $id; ?>)</h1></div>

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
                        <label>Etiket Adı</label>
                        <div class="form-content">
                            <input type="text" name="tag_name" value="<?= post('tag_name') ?? $row['tag_name']; ?>">
                        </div>
                    </li>
                </ul>
            </div>

            <div tab-content>
                <ul>
                    <li>
                        <label>SEO Url</label>
                        <div class="form-content">
                            <input type="text" name="tag_url" value="<?= post('tag_url') ?? $row['tag_url']; ?>">
                            <p class="p-small">
                                <b>NOT:</b> Eğer boş bırakırsanız, otomatik olarak etiket adını baz alır!
                            </p>
                        </div>
                    </li>
                    <li>
                        <label>SEO Başlık</label>
                        <div class="form-content">
                            <input type="text" name="tag_seo[title]" value="<?= $seo['title'] ?? null; ?>">
                        </div>
                    </li>
                    <li>
                        <label>SEO Açıklaması</label>
                        <div class="form-content">
                            <textarea name="tag_seo[description]" cols="30"
                                      rows="5"><?= $seo['description'] ?? null; ?></textarea>
                        </div>
                    </li>
                </ul>
            </div>

            <ul>
                <li class="submit">
                    <input type="hidden" name="submit" value="1">
                    <button type="submit">Güncelle</button>
                </li>
            </ul>
        </div>
    </form>

</div>

<?php require adminView('static/footer'); ?>
