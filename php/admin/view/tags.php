<?php require adminView('static/header'); ?>
<!-- kullanıcı işlemleri bu alandan yönetilecek -->
<!--content-->
<div class="content">

    <div class="box-">
        <h1>
            Etiketler
            <?php if (permission('tags', 'add')): ?>
                <a href="<?= adminUrl('add-tag'); ?>">
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
        <input type="hidden" name="table" value="tags">
        <input type="hidden" name="column" value="tag_id">
        <div class="table">
            <table>
                <thead class="text-bold">
                <tr>
                    <th><input type="checkbox" id="checkAllInput"></th>
                    <th>#</th>
                    <th>Etiket Adı</th>
                    <th>Kullanım Sayısı</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($query): ?>
                    <?php foreach ($query as $count => $row): $count++; ?>
                        <tr>
                            <td width="5">
                                <input type="checkbox" class="check-data" name="ids[]" value="<?= $row['tag_id']; ?>">
                            </td>
                            <td> <?= countRow($count); ?> </td>
                            <td><?= $row['tag_name']; ?></td>
                            <td><?= $row['total']; ?></td>
                            <td width="115">
                                <?php if (permission('tags', 'edit')): ?>
                                    <a class="btn btn-success" href="<?= adminUrl('edit-tag?id=' . $row['tag_id']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (permission('tags', 'delete')): ?>
                                    <a href="<?= adminUrl('delete?table=tags&column=tag_id&id=' . $row['tag_id']); ?>"
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

    <?php if ($totalRecord > $pageLimit): ?>
        <div class="pagination">
            <ul>
                <?= $db->showPagination(adminUrl(route(1)) . '?' . $pageParam . '=[page]'); ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

<?php require adminView('static/footer'); ?>
