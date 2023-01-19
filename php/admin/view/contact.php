<?php require adminView('static/header'); ?>
<!-- kullanıcı işlemleri bu alandan yönetilecek -->
<!--content-->
<div class="content">

    <div class="box-">
        <h1> İletişim Mesajları </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="table">
        <table>
            <thead class="text-bold">
                <tr>
                    <th>#</th>
                    <th class="hide">Tarih</th>
                    <th>Gönderen</th>
                    <th class="hide">Konu</th>
                    <th width="100">Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query) : ?>
                    <?php foreach ($query as $key => $row) :; ?>
                        <tr>
                            <td> <?= countRow($key + 1); ?> </td>
                            <td class="hide">
                                <?= timeConvert($row['contact_date']); ?>
                                <?php if ($row['contact_read_date']) : ?>
                                    <div style="color: #999; font-size: 12px;">
                                        <?= timeConvert($row['contact_read_date']); ?> okundu
                                        <br>
                                        <strong>Okuyan: </strong> <?= $row['user_name']; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <p><?= $row['contact_name']; ?></p>
                                <p>(<?= $row['contact_email']; ?>)</p>
                                <p><?= $row['contact_phone']; ?></p>
                            </td>
                            <td class="hide">
                                <?= $row['contact_subject']; ?>
                            </td>
                            <td width="115"><?= tdStatus($row['contact_read'], 'read'); ?></td>
                            <td width="125">
                                <?php if (permission('contact', 'edit')) : ?>
                                    <a class="btn btn-primary" href="<?= adminUrl('edit-contact?id=' . $row['contact_id']); ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (permission('contact', 'delete')) : ?>
                                    <a href="<?= adminUrl('delete?table=contact&column=contact_id&id=' . $row['contact_id']); ?>" class="btn btn-danger" onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
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