<?php require adminView('static/header'); ?>
    <!--content-->
    <div class="content">

        <div class="box-"><h1>Slider Ekleme</h1></div>

        <div class="clear" style="height: 10px;"></div>

        <div class="box-">
            <form class="form label" action="" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label>Resim</label>
                        <div class="form-content">
                            <input class="inp-img" type="file" name="slid_image" accept="image/*" required>
                        </div>
                    </li>
                    <li>
                        <label>Başlık</label>
                        <div class="form-content">
                            <input type="text" name="slid_title" value="<?= post('slid_title'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Buton Durumu</label>
                        <label class="font-normal">
                            <input type="checkbox" id="checkPass" name="slid_btn_status" value="1"
                                <?= post('slid_btn_status') ? 'checked' : null; ?>> Buton gösterilsin mi?
                        </label>
                    </li>
                    <li id="showAllPass" style="display: none;">
                        <label>Buton Adı</label>
                        <div class="form-content eu-mb-4">
                            <input type="text" name="slid_btn_name" value="<?= post('slid_btn_name'); ?>">
                        </div>

                        <label>Buton Linki</label>
                        <div class="form-content">
                            <input type="text" name="slid_btn_url" value="<?= post('slid_btn_url'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Açıklama</label>
                        <div class="form-content">
                            <textarea name="slid_description" cols="30" rows="10"><?= post('slid_description'); ?></textarea>
                        </div>
                    </li>
                    <li class="submit">
                        <button type="submit" name="submit" value="1">Kaydet</button>
                    </li>
                </ul>
            </form>
        </div>

    </div>

<?php require adminView('static/footer'); ?>