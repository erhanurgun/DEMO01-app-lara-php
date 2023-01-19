<?php if (session('user_rank') && session('user_rank') <= session('max_user_rank')) : ?>
    </div>
<?php endif; ?>

<!--scripts-->
<script src="<?= adminPublicUrl('scripts/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?= adminPublicUrl('scripts/jquery-ui.min.js'); ?>"></script>
<script src="<?= adminPublicUrl('vendor/jquery.tagsinput/jquery.tagsinput-revisited.min.js'); ?>"></script>
<script src="<?= adminPublicUrl('scripts/tinymce.min.js'); ?>"></script>
<script>
    let apiUrl = '<?= adminUrl('api'); ?>',
        appUrl = '<?= siteUrl('app/'); ?>';
</script>
<script src="<?= adminPublicUrl('scripts/admin.js'); ?>"></script>
<script src="<?= adminPublicUrl('scripts/api.js'); ?>"></script>
<script src="<?= adminPublicUrl('scripts/custom.js'); ?>"></script>

<script>
    $(window).on("load", function() {
        pageLoader();
    });

    function pageLoader() {
        if ($(".page-loader").length) {
            $(".page-loader").delay(100).fadeOut(500, function() {
                heroSlider();
            });
        }
    }
</script>

<script>
    // sayfa hazırsa
    $(function() {
        // menü ekle butonuna tıklandığında
        $('#add-menu').on('click', function(e) {
            $('#menu').append(
                '<li>\n' +
                '<div class="handle"></div>\n' +
                '<div class="menu-item">\n' +
                '<a href="#" class="delete-menu"><i class="fa fa-times"></i></a>\n' +
                '<input type="text" name="title[]" placeholder="Menü Adı">\n' +
                '<input type="text" name="url[]" placeholder="Menü Linki">\n' +
                '</div>\n' +
                '<div class="sub-menu"><ul></ul></div>' +
                '<a href="#" class="btn add-submenu">Alt Menü Ekle</a>\n' +
                '</li>\n'
            );
            e.preventDefault();
        });
        // alt menü ekle butonuna tıklandığında
        $(document.body).on('click', '.add-submenu', function(e) {
            let index = $(this).closest('li').index();
            $(this).prev('.sub-menu').find('ul').append(
                '<li>\n' +
                '<div class="handle"></div>\n' +
                '<div class="menu-item">\n' +
                '<a href="#" class="delete-menu"><i class="fa fa-times"></i></a>\n' +
                '<input type="text" name="sub_title_' + index + '[]" placeholder="Menü Adı" />\n' +
                '<input type="text" name="sub_url_' + index + '[]" placeholder="Menü Linki" />\n' +
                '</div>\n' +
                '</li>\n'
            );
            e.preventDefault();
        });

        // menü sil butonun tıklandığında
        $(document.body).on('click', '.delete-menu', function(e) {
            if ($('#menu li').length === 1) {
                alert('En az 1 menü içeriği kalmak zorunda!');
            } else {
                $(this).closest('li').remove(); // closest() -> en yakın olanı seç
            }
            e.preventDefault();
        });
    });
</script>

<script>
    $(function() {
        setTimeout(function() {
            $('.message.error.box-').hide();
            $('.message.success.box-').hide();
            <?php
            unset($_SESSION['log_error']);
            unset($_SESSION['log_success']);
            ?>
        }, 5000);
    });
</script>

<script>
    let itemCount = '<?= setting('phone_count') == 1 ? '0' : setting('phone_count'); ?>';
    const addMenu = (value) => {
        itemCount++;
        $('#phoneCount').val(itemCount);
        $('#allPhones').append(
            '<div class="form-content eu-mt-1">' +
            '<input type="text" name="settings[phone_' + itemCount + ']"' +
            (itemCount == 1 ? 'value="' + value + '"' : '') +
            ' placeholder="telefon numarası giriniz...">' +
            '</div>\n'
        );
    }
    $(document).ready(function() {
        <?php for ($i = 1; $i <= setting('phone_count'); $i++) : ?>
            <?php if (setting('phone_' . $i)) : ?>
                $('#allPhones').append(
                    '<div class="form-content eu-mt-1">' +
                    '<input type="text" name="settings[phone_<?= $i; ?>]" value="<?= setting('phone_' . $i) ?>"' +
                    ' placeholder="telefon numarası giriniz...">' +
                    '</div>\n'
                );
            <?php endif; ?>
        <?php endfor; ?>
    });
    $('#addNewPhone').on('click', addMenu);
</script>

<script>
    $(document).ready(function() {
        let rank = '<?= session('how_user_rank'); ?>';
        if (rank === '1') {
            $("#checkAllPerm").click();
        }

        let counter = '<?= session('click_id'); ?>';
        if (counter) {
            $(counter).click();
        }
        <?php unset($_SESSION['click_id']); ?>
    });
</script>

</body>

</html>