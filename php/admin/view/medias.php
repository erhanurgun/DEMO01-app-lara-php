<?php require adminView('static/header'); ?>

<div class="box-"><h1>Media Galeri</h1></div>

<div class="clear" style="height: 10px;"></div>

<div class="box-" tab>

    <div class="admin-tab">
        <ul tab-list>
            <li><a id="addNewImage">Yeni Resim Ekle</a></li>
            <li><a id="otherProces">Diğer İşlemler</a></li>
        </ul>
    </div>

    <form action="" method="post" class="form label" enctype="multipart/form-data">
        <div class="tab-container">

            <div tab-content>
                <ul>
                    <li>
                        <label>Resim Yükle</label>
                        <div class="form-content">
                            <input type="file" name="images[]" multiple>
                        </div>
                    </li>
                    <li class="submit">
                        <input type="hidden" name="submit" value="1">
                        <button type="submit">Yükle</button>
                    </li>
                </ul>
            </div>
    </form>

    <form action="delete" method="get" enctype="multipart/form-data">
        <div tab-content class="other-tab">
            <label class="item d-block"><input type="checkbox" id="checkAllImg"> Tüm resimleri Seç </label>
            <button type="submit" class="btn-danger"
                    onclick="return confirm('Seçilen resimleri silmek istediğinize emin misiniz?')">
                Seçili Resimleri Sil
            </button>
        </div>

        <div class="hr eu-mb-5"></div>

        <div class="medias">
            <input type="hidden" name="table" value="medias">
            <input type="hidden" name="column" value="media_id">
            <?php foreach ($query as $media): ?>
                <label class="item">
                    <img src="<?= uploadUrl('medias/' . $media['media_url']) ?>" alt="<?= $media['media_url']; ?>">
                    <span class="hr eu-m-1"></span>
                    <input type="checkbox" class="check" name="ids[]" value="<?= $media['media_id']; ?>">
                    <span>Resmi Seç</span>
                </label>
            <?php endforeach; ?>
        </div>
    </form>

</div>

<?php require adminView('static/footer'); ?>
