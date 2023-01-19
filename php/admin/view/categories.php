<?php require adminView('static/header'); ?>
<!-- kullanıcı işlemleri bu alandan yönetilecek -->
<!--content-->
<div class="content">

    <div class="box-">
        <h1>
            Kategoriler
            <?php if (permission('categories', 'add')) : ?>
                <a href="<?= adminUrl('add-category') ?>">
                    <i class="fa fa-plus"></i> Yeni Ekle
                </a>
            <?php endif; ?>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="message info eu-mb-2">
        <strong>NOT:</strong>
        Kategoriler arasıda sıralama yapabilmek için &nbsp;<i class="fa fa-list-ul fa-silver"></i>&nbsp; ikonunu tutup
        sürükleyiniz.
    </div>

    <div class="table">
        <table>
            <thead class="text-bold">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th class="hide">Eklenme Tarihi</th>
                    <th>Kategori Adı</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody class="table-sortable" data-table="categories" data-where="category_id" data-column="category_order">
                <?php if ($query) : ?>
                    <?php foreach ($query as $count => $row) : $count++; ?>
                        <tr id="id_<?= $row['category_id']; ?>">
                            <td width="10"><i class="fa fa-list-ul fa-silver"></i></td>
                            <td width="25"> <?= countRow($count); ?> </td>
                            <td class="hide"><?= timeConvert($row['category_date']); ?></td>
                            <td><?= $row['category_name'] ?> </td>
                            <td width="115">
                                <?php if (permission('categories', 'edit')) : ?>
                                    <a class="btn btn-success" href="<?= adminUrl('edit-category?id=' . $row['category_id']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (permission('categories', 'delete')) : ?>
                                    <a href="<?= adminUrl('delete?table=categories&column=category_id&id=' . $row['category_id']); ?>" class="btn btn-danger" onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" align="center">
                            Bu tablo'ya ait herhangi bir veri kaydı <b>bulunamadı</b>!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($totalRecord > $pageLimit) : ?>
            <div class="pagination">
                <ul>
                    <?= $db->showPagination(adminUrl(route(1)) . '?' . $pageParam . '=[page]'); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php require adminView('static/footer'); ?>