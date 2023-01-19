<?php require adminView('static/header'); ?>
    <!-- üye işlemleri bu alanda gösterilecektir -->
    <!--content-->
    <div class="content">

        <div class="box-"><h1>Kullanıcı Düzenleme (#<?= $id; ?>)</h1></div>

        <div class="clear" style="height: 10px;"></div>

        <div class="box-">
            <form action="" method="post" class="form label">
                <ul>
                    <li>
                        <label>Kullanıcı Adı</label>
                        <div class="form-content">
                            <input type="text" name="user_name" value="<?= post('user_name') ?? $row['user_name']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>E-Posta</label>
                        <div class="form-content">
                            <input type="text" name="user_email"
                                   value="<?= post('user_email') ?? $row['user_email']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Şifre Durumu</label>
                        <label class="font-normal">
                            <input type="checkbox" id="checkPass" name="user_pass_check" value="yes"
                                <?= post('user_pass_check') ? 'checked' : null; ?>> Şifreyi'de güncelle
                        </label>
                    </li>
                    <li id="showAllPass" style="display: none;">
                        <label>Şifre</label>
                        <div class="form-content eu-mb-4">
                            <input type="password" name="user_password">
                        </div>

                        <label>Şifre ( tekrar )</label>
                        <div class="form-content">
                            <input type="password" name="user_pass_again">
                        </div>
                    </li>
                    <li>
                        <label>Rütbe</label>
                        <div class="form-content">
                            <select name="user_rank">
                                <option value="" disabled>--- Rütbe Seçiniz ---</option>
                                <?php foreach (userRanks(null, 'list') as $id => $rank) : ?>
                                    <option <?= (post('user_rank') ?? $row['user_rank']) == $id ? 'selected' : null; ?>
                                            value="<?= $id; ?>"><?= $rank; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <label>İzinler</label>
                        <label class="not"><input type="checkbox" id="checkAllPerm"> Tümünü İşaretle</label>
                        <div class="form-content eu-mt-2">
                            <div class="permissions">
                                <?php foreach ($menus as $url => $menu) : ?>
                                    <div class="permi">
                                        <h3><?= $menu['title']; ?></h3>
                                        <div class="list">
                                            <?php foreach ($menu['permissions'] as $key => $val) :
                                                if ($key == 'sub') continue; ?>
                                                <label>
                                                    <input class="check" <?= isset($permissions[$menu['url']][$key]) && $permissions[$menu['url']][$key] == 1 ? 'checked' : null; ?>
                                                           name="user_permissions[<?= $menu['url']; ?>][<?= $key; ?>]"
                                                           value="1" type="checkbox"> <?= $val; ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <?php if (settingPermArr($menu['url'])) : ?>
                                        <div class="sub-menu-container eu-mb-5">
                                            <div class="list">
                                                <?php foreach (settingPermArr($menu['url']) as $key => $val) : ?>
                                                    <label>
                                                        <input <?= isset($permissions[$menu['url']]['sub'][$key]) && $permissions[$menu['url']]['sub'][$key] == 1 ? 'checked' : null; ?>
                                                                name="user_permissions[<?= $menu['url']; ?>][sub][<?= $key; ?>]"
                                                                type="checkbox" class="check" value="1"
                                                            <?= session('user_rank') > 2 ? 'disabled' : null; ?>> <?= $val; ?>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (isset($menu['sub-menu'])) : ?>
                                        <div class="sub-menu-container eu-mb-5">
                                            <?php foreach ($menu['sub-menu'] as $k => $subMenu) :
                                                if (!isset($subMenu['permissions'])) continue; ?>
                                                <div>
                                                    <h3><?= $subMenu['title']; ?></h3>
                                                    <div class="list">
                                                        <?php foreach ($subMenu['permissions'] as $key => $val) : ?>
                                                            <label>
                                                                <input class="check" <?= isset($permissions[$subMenu['url']][$key]) && $permissions[$subMenu['url']][$key] == 1 ? 'checked' : null; ?>
                                                                       name="user_permissions[<?= $subMenu['url']; ?>][<?= $key; ?>]"
                                                                       value="1" type="checkbox"> <?= $val; ?>
                                                            </label>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>

                    <li class="submit">
                        <button name="submit" value="1" type="submit">Kaydet</button>
                    </li>
                </ul>
            </form>
        </div>

    </div>

<?php require adminView('static/footer'); ?>