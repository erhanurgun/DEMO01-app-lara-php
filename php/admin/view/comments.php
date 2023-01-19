<?php require adminView('static/header'); ?>
<!-- kullanıcı işlemleri bu alandan yönetilecek -->
<!--content-->
<div class="content">

    <div class="box-"><h1>Yorumlar</h1></div>

    <div class="filter">
        <ul>
            <li class="<?= !get('status') ? 'active' : null; ?>">
                <a href="<?= adminUrl('comments'); ?>">Tümü</a>
            </li>
            <li class="<?= get('status') == 1 ? 'active' : null; ?>">
                <a href="<?= adminUrl('comments?status=1'); ?>">Onaylanalar</a>
            </li>
            <li class="<?= get('status') == 2 ? 'active' : null; ?>">
                <a href="<?= adminUrl('comments?status=2'); ?>">Onay Bekleyenler</a>
            </li>
        </ul>
    </div>

    <div class="table">
        <table>
            <thead class="text-bold">
            <tr>
                <th width="10">#</th>
                <th width="10"></th>
                <th>Yorum</th>
                <th class="hide">Konu</th>
                <th class="hide">Tarih</th>
                <th class="hide" width="120">Durum</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = 0;
            foreach ($query as $row): $count++; ?>
                <tr>
                    <td><?= countRow($count); ?></td>
                    <td>
                        <img class="td-img-rounded" src="<?= getGravatar($row['comment_email']); ?>">
                    </td>
                    <td>
                        <p style="font-size: 12px; color: #666;">
                            <?= $row['comment_name']; ?> (<?= $row['comment_email'] ?>)
                        </p>
                        <p><?= cutText($row['comment_content'], 36); ?></p>
                    </td>
                    <td class="hide">
                        <a target="_blank" href="<?= siteUrl('blog/' . $row['post_url']); ?>">
                            <?= cutText($row['post_title'], 90); ?>
                        </a>
                    </td>
                    <td class="hide" title="<?= $row['comment_date']; ?>">
                        <?= timeConvert($row['comment_date']); ?>
                    </td>
                    <td class="hide" width="200"><?= tdStatus($row['comment_status'], 'confirm'); ?></td>
                    <td width="115">
                        <?php if (permission('comments', 'edit')): ?>
                            <a class="btn btn-success" href="<?= adminUrl('edit-comment?id=' . $row['comment_id']); ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (permission('comments', 'delete')): ?>
                            <a href="<?= adminUrl('delete?table=comments&column=comment_id&id=' . $row['comment_id']); ?>"
                               class="btn btn-danger" onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalRecord > $pageLimit): ?>
        <div class="pagination">
            <ul>
                <?= $db->showPagination(adminUrl(route(1)) . '?' . $pageParam . '=[page]' . (get('status') ? '&status=' . get('status') : null)); ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

<?php require adminView('static/footer'); ?>
