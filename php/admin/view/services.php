<?php require adminView('static/header'); ?>
<!-- kullanıcı işlemleri bu alandan yönetilecek -->
<!--content-->
<div class="content">

    <div class="box-">
        <h1>
            Sayfalar
            <?php if (permission('services', 'add')) : ?>
                <a href="<?= adminUrl('add-service'); ?>">
                    <i class="fa fa-plus"></i> Yeni Ekle
                </a>
            <?php endif; ?>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="table">
        <table>
            <thead class="text-bold">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th class="hide">Yayın Tarihi</th>
                    <th>Başlık</th>
                    <th>İçerik</th>
                    <th>İkon</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody class="table-sortable" data-table="services" data-where="service_id" data-column="service_order">
                <?php if ($query) : ?>
                    <?php foreach ($query as $count => $row) : $count++; ?>
                        <tr id="id_<?= $row['service_id']; ?>">
                            <td width="10"><i class="fa fa-list-ul fa-silver"></i></td>
                            <td> <?= countRow($count); ?> </td>
                            <td class="hide" title="<?= $row['service_date']; ?>">
                                <?= timeConvert($row['service_date']); ?>
                            </td>
                            <td><?= $row['service_title']; ?></td>
                            <td><?= cutText($row['service_content'], 90); ?></td>
                            <td><?= $row['service_icon']; ?></td>
                            <td><?= tdStatus($row['service_status']); ?></td>
                            <td width="200">
                                <a class="btn" href="<?= siteUrl('services/' . $row['service_url']); ?>" target="_blank">
                                    <i class="fa fa-external-link"></i>
                                </a>
                                <?php if (permission('services', 'edit')) : ?>
                                    <a class="btn btn-success" href="<?= adminUrl('edit-service?id=' . $row['service_id']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (permission('services', 'delete')) : ?>
                                    <a href="<?= adminUrl('delete?table=services&column=service_id&id=' . $row['service_id']); ?>" class="btn btn-danger" onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" align="center">
                            Bu tablo'ya ait herhangi bir veri kaydı <b>bulunamadı</b>!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalRecord > $pageLimit) : ?>
        <div class="pagination">
            <ul>
                <?= $db->showPagination(adminUrl(route(1)) . '?' . $pageParam . '=[page]'); ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

<?php require adminView('static/footer'); ?>