<?php require adminView('static/header'); ?>
<!-- menü işlemleri bu alanda gösterilecektir -->

<!--content-->
<div class="content">

    <div class="box-">
        <h1>
            Menü Yönetimi
            <?php if (permission('menus', 'add')): ?>
                <a href="<?= adminUrl('add-menu'); ?>">
                    <i class="fa fa-plus"></i> Yeni Ekle
                </a>
            <?php endif; ?>
            <a class="eu-btn" id="delSelectedData" onclick="$('#frm-del-items').submit();" style="display: none;">
                <i class="fa fa-trash"></i> Seçilenleri Sil
            </a>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <form id="frm-del-items" action="delete" method="get" enctype="multipart/form-data">
        <input type="hidden" name="select_all" value="no">
        <input type="hidden" name="img_colmn" value="no">
        <input type="hidden" name="type" value="multiple">
        <input type="hidden" name="table" value="menus">
        <input type="hidden" name="column" value="menu_id">
        <div class="table">
            <table>
                <thead class="text-bold">
                <tr>
                    <th><input type="checkbox" id="checkAllInput"></th>
                    <th>#</th>
                    <th class="hide">Eklenme Tarihi</th>
                    <th>Menü Başlığı</th>
                    <?php if (permission('menus', 'edit') || permission('menus', 'delete')): ?>
                        <th>İşlemler</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($query): ?>
                    <?php foreach ($rows as $count => $row): $count++; ?>
                        <tr>
                            <td width="5">
                                <input type="checkbox" class="check-data" name="ids[]" value="<?= $row['menu_id']; ?>">
                            </td>
                            <td><?= countRow($count); ?></td>
                            <td title="<?= $row['menu_date']; ?>"><?= timeConvert($row['menu_date']); ?></td>
                            <td><?= $row['menu_title']; ?></td>
                            <td width="115">
                                <?php if (permission('menus', 'edit')): ?>
                                    <a class="btn btn-success"
                                       href="<?= adminUrl('edit-menu?id=' . $row['menu_id']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (permission('menus', 'delete')): ?>
                                    <a href="<?= adminUrl('delete?table=menu&column=menu_id&id=' . $row['menu_id']); ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" align="center">
                            Bu tablo'ya ait herhangi bir veri kaydı <b>bulunamadı</b>!
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>

</div>

<?php require adminView('static/footer'); ?>
