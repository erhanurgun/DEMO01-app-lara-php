<?php require adminView('static/header'); ?>
    <!--content-->
    <div class="content">

        <div class="box-"><h1>Takım Düzenleme (#<?= $id; ?>)</h1></div>

        <div class="clear" style="height: 10px;"></div>

        <div class="box-">
            <form class="form label" action="" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label>Yüklü Resim ( 250 x 250 )</label>
                        <div class="form-content">
                            <img class="edit-slid-img" src="<?= uploadUrl('teams/' . $row['team_img']); ?>">
                        </div>
                    </li>
                    <li>
                        <label>Resim Durumu</label>
                        <label class="font-normal">
                            <input type="checkbox" id="checkImage" name="img_check" value="yes"
                                <?= (post('img_check') ? 'checked' : null); ?>> Resim de güncellensin mi?
                        </label>
                    </li>
                    <li id="showImage" style="display: none;">
                        <label>Resim</label>
                        <div class="form-content">
                            <input type="file" class="inp-img" id="selectImg" name="team_img" accept="image/*">
                        </div>
                    </li>
                    <li>
                        <label>Ad ve Soyad</label>
                        <div class="form-content">
                            <input type="text" name="team_name" value="<?= post('team_name') ?? $row['team_name']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Meslek (isteğe bağlı)</label>
                        <div class="form-content">
                            <input type="text" name="team_job" value="<?= post('team_job') ?? $row['team_job']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Facebook</label>
                        <div class="form-content">
                            <input type="text" name="team_face" value="<?= post('team_face') ?? $row['team_face']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>İnstagram</label>
                        <div class="form-content">
                            <input type="text" name="team_insta" value="<?= post('team_insta') ?? $row['team_insta']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Twitter</label>
                        <div class="form-content">
                            <input type="text" name="team_twit" value="<?= post('team_twit') ?? $row['team_twit']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Durum</label>
                        <div class="form-content">
                            <select name="team_status">
                                <option value="" disabled>--- Durum Seç ---</option>
                                <option value="1" <?= selected($row['team_status'], 1); ?>>Aktif</option>
                                <option value="0" <?= selected($row['team_status'], 0); ?>>Pasif</option>
                            </select>
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