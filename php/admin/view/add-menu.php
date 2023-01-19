<?php require adminView('static/header'); ?>

<div class="box- menu-container">
    <h2>Menü Ekleme</h2>
    <form action="" method="post">
        <div style="padding-bottom: 10px; max-width: 400px">
            <input type="text" name="menu_title" value="<?= post('menu_title'); ?>" placeholder="Menü Başlığı">
        </div>
        <ul id="menu" class="menu">
            <li>
                <div class="handle"></div>
                <div class="menu-item">
                    <a href="#" class="delete-menu">
                        <i class="fa fa-times"></i>
                    </a>
                    <input type="text" name="title[]" placeholder="Menü Adı">
                    <input type="text" name="url[]" placeholder="Menü Linki">
                </div>
                <div class="sub-menu">
                    <ul class="menu"></ul>
                </div>
                <a href="#" class="btn add-submenu">Alt Menü Ekle</a>
            </li>
        </ul>
        <div class="menu-btn">
            <a href="#" id="add-menu" class="btn">Menü Ekle</a>
            <button type="submit" value="1" name="submit">Kaydet</button>
        </div>
    </form>
</div>

<?php require adminView('static/footer'); ?>

