<?php require adminView('static/header'); ?>
    <!--content-->
    <div class="content">

        <div class="box-"><h1>Takım Ekleme</h1></div>

        <div class="clear" style="height: 10px;"></div>

        <div class="box-">
            <form class="form label" action="" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label>Resim</label>
                        <div class="form-content">
                            <input class="inp-img" type="file" name="team_img" accept="image/*" required>
                        </div>
                    </li>
                    <li>
                        <label>Ad ve Soyad</label>
                        <div class="form-content">
                            <input type="text" name="team_name" value="<?= post('team_name'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Meslek (isteğe bağlı)</label>
                        <div class="form-content">
                            <input type="text" name="team_job" value="<?= post('team_job'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Facebook</label>
                        <div class="form-content">
                            <input type="text" name="team_face" value="<?= post('team_face'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>İnstagram</label>
                        <div class="form-content">
                            <input type="text" name="team_insta" value="<?= post('team_insta'); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Twitter</label>
                        <div class="form-content">
                            <input type="text" name="team_twit" value="<?= post('team_twit'); ?>">
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