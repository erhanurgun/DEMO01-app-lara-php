<?php require adminView('static/header'); ?>
    <!-- kullanıcı işlemleri bu alandan yönetilecek -->
    <!--content-->
    <div class="content">

        <div class="box-">
            <h1>
                Kullanıcılar
                <?php if (permission('users', 'add')) : ?>
                    <a href="<?= adminUrl('add-user'); ?>">
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
            <input type="hidden" name="table" value="users">
            <input type="hidden" name="column" value="user_id">
            <div class="table">
                <table>
                    <thead class="text-bold">
                    <tr>
                        <th><input type="checkbox" id="checkAllInput"></th>
                        <th>#</th>
                        <th class="hide">Kayıt Tarihi</th>
                        <th>Kullanıcı Adı</th>
                        <th class="hide">E-Posta</th>
                        <th class="hide">Rütbe</th>
                        <?php if (permission('users', 'edit') || permission('users', 'delete')) : ?>
                            <th>İşlemler</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($query): ?>
                        <?php foreach ($query as $count => $row) : $count++; ?>
                            <tr>
                                <td width="5">
                                    <input type="checkbox" class="check-data" name="ids[]"
                                           value="<?= $row['user_id']; ?>">
                                </td>
                                <td><?= countRow($count); ?></td>
                                <td class="hide" title="<?= $row['user_date']; ?>">
                                    <?= timeConvert($row['user_date']); ?>
                                </td>
                                <td>
                                    <img class="td-img-rounded" src="<?= getGravatar($row['user_email']); ?>"
                                         alt="<?= $row['user_name'] ?>">
                                    <span class="title username"><?= $row['user_name'] ?></span>
                                </td>
                                <td class="hide"><?= $row['user_email']; ?></td>
                                <td class="hide"><?= userRanks($row['user_rank']); ?></td>
                                <?php if ($row['user_rank'] >= session('user_rank')): ?>
                                    <td width="115">
                                        <?php if (permission('users', 'edit')): ?>
                                            <a class="btn btn-success"
                                               href="<?= adminUrl('edit-user?id=' . $row['user_id']); ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (permission('users', 'delete')): ?>
                                            <a href="<?= adminUrl('delete?table=users&column=user_id&id=' . $row['user_id']); ?>"
                                               class="btn btn-danger"
                                               onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                <?php else: ?>
                                    <td><i class="p-small text-gray">Yetkiniz Yok!</i></td>
                                <?php endif; ?>
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

        <?php if ($totalRecord > $pageLimit) : ?>
            <div class="pagination">
                <ul>
                    <?= $db->showPagination(adminUrl(route(1)) . '?' . $pageParam . '=[page]'); ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>

<?php require adminView('static/footer'); ?>