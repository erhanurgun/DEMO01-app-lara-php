<?php require adminView('static/header'); ?>

    <div class="box-"><h1>Menü Düzenleme (#<?= $id; ?>)</h1></div>

    <div class="box- menu-container">
        <form action="" method="post">
            <label>Menü Adı</label>
            <div style="padding-bottom: 10px; max-width: 400px">
                <input type="text" name="menu_title" value="<?= post('menu_title') ?? $row['menu_title']; ?>"
                       placeholder="Menü Başlığı">
            </div>
            <label>Menüler</label>
            <ul id="menu" class="menu">
                <?php foreach ($menuData as $key => $menu) : ?>
                    <li>
                        <div class="handle"></div>
                        <div class="menu-item">
                            <a href="#" class="delete-menu">
                                <i class="fa fa-times"></i>
                            </a>
                            <input type="text" name="title[]" value="<?= htmlspecialchars($menu['title']); ?>"
                                   placeholder="Menü Adı">
                            <input type="text" name="url[]" value="<?= $menu['url']; ?>" placeholder="Menü Linki">
                        </div>
                        <div class="sub-menu">
                            <ul class="menu">
                                <?php if (isset($menu['submenu'])) : ?>
                                    <?php foreach ($menu['submenu'] as $k => $subMenu) : ?>
                                        <li>
                                            <div class="handle"></div>
                                            <div class="menu-item">
                                                <a href="#" class="delete-menu">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                                <input type="text" name="sub_title_<?= $key; ?>[]"
                                                       value="<?= htmlspecialchars($subMenu['title']); ?>"
                                                       placeholder="Menü Adı">
                                                <input type="text" name="sub_url_<?= $key; ?>[]"
                                                       value="<?= $subMenu['url']; ?>" placeholder="Menü Linki">
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <a href="#" class="btn add-submenu">Alt Menü Ekle</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="menu-btn">
                <a href="#" id="add-menu" class="btn">Menü Ekle</a>
                <button type="submit" value="1" name="submit">Kaydet</button>
            </div>
        </form>
    </div>

<?php require adminView('static/footer'); ?>