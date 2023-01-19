<?php require adminView('static/header'); ?>
<!-- kullanıcı işlemleri bu alandan yönetilecek -->
<!--content-->
<div class="content">

    <div class="box-">
        <h1>
            Müşteri Yorumları
            <a class="eu-btn" id="delSelectedData" onclick="$('#frm-del-items').submit();" style="display: none;">
                <i class="fa fa-trash"></i> Seçilenleri Sil
            </a>
        </h1>
    </div>

    <div class="filter">
        <ul>
            <li class="<?= !get('status') ? 'active' : null; ?>">
                <a href="<?= adminUrl('customers'); ?>">Tümü</a>
            </li>
            <li class="<?= get('status') == 1 ? 'active' : null; ?>">
                <a href="<?= adminUrl('customers?status=1'); ?>">Onaylanalar</a>
            </li>
            <li class="<?= get('status') == 2 ? 'active' : null; ?>">
                <a href="<?= adminUrl('customers?status=2'); ?>">Onay Bekleyenler</a>
            </li>
        </ul>
    </div>

    <form id="frm-del-items" action="delete" method="get" enctype="multipart/form-data">
        <input type="hidden" name="select_all" value="no">
        <input type="hidden" name="img_colmn" value="no">
        <input type="hidden" name="type" value="multiple">
        <input type="hidden" name="table" value="customers">
        <input type="hidden" name="column" value="customer_id">
        <input type="hidden" name="status" value="<?= get('status') ?? 'no'; ?>">
        <input type="hidden" name="st_column" value="customer_status">
        <div class="table">
            <table>
                <thead class="text-bold">
                <tr>
                    <th><input type="checkbox" id="checkAllInput"></th>
                    <th width="10">#</th>
                    <th class="hide">Tarih</th>
                    <th>Gönderen</th>
                    <th class="hide">Mesaj</th>
                    <th class="hide">Durum</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($query): ?>
                    <?php foreach ($query as $count => $row): $count++; ?>
                        <tr>
                            <td width="5">
                                <input type="checkbox" class="check-data" name="ids[]"
                                       value="<?= $row['customer_id']; ?>">
                            </td>
                            <td><?= countRow($count); ?></td>
                            <td class="hide" title="<?= $row['customer_date']; ?>">
                                <?= timeConvert($row['customer_date']); ?>
                            </td>
                            <td>
                                <img class="td-img-rounded" src="<?= getGravatar($row['customer_email']); ?>">
                                <p class="title username" style="margin-top: -49px">
                                    <?= $row['customer_name']; ?> <br>
                                    (<?= $row['customer_email']; ?>)
                                </p>
                            </td>
                            <td class="hide">
                                <p><?= cutText($row['customer_mssg'], 100); ?></p>
                            </td>
                            <td class="hide" width="200"><?= tdStatus($row['customer_status'], 'confirm'); ?></td>
                            <td width="115">
                                <?php if (permission('customers', 'edit')): ?>
                                    <a class="btn btn-success"
                                       href="<?= adminUrl('edit-customer?id=' . $row['customer_id']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (permission('customers', 'delete')): ?>
                                    <a href="<?= adminUrl('delete?table=customers&column=customer_id&id=' . $row['customer_id']); ?>"
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
                        <td colspan="7" align="center">
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
                <?= $db->showPagination(adminUrl(route(1)) . '?' . $pageParam . '=[page]' . (get('status') ? '&status=' . get('status') : null)); ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

<?php require adminView('static/footer'); ?>
