<?php require adminView('static/header'); ?>

<div class="box-"><h1>Yorum Düzenleme (#<?= $id; ?>)</h1></div>

<div class="clear" style="height: 10px;"></div>

<div class="box-">
    <div class="info-edit-item">
        <strong>
            <a class="a-link" target="_blank"
               href="<?= siteUrl('blog/' . $row['post_url']); ?>">
                <?= cutText($row['post_title'], 22); ?>
            </a>
        </strong>
        paylaşımı için <?= timeConvert($row['comment_date']); ?>
        <strong><?= $row['user_name'] ?? $row['comment_name']; ?></strong> tarafından yazıldı.
    </div>
    <form action="" method="post" class="form label">
        <ul>
            <li>
                <label>Yorum Yazan</label>
                <div class="form-content">
                    <input type="text" name="comment_name" value="<?= post('comment_name') ?? $row['comment_name']; ?>">
                </div>
            </li>
            <li>
                <label>Yorum E-Posta</label>
                <div class="form-content">
                    <input type="text" name="comment_email"
                           value="<?= post('comment_email') ?? $row['comment_email']; ?>">
                </div>
            </li>
            <li>
                <label>Yorum</label>
                <div class="form-content">
                    <textarea name="comment_content" cols="30"
                              rows="10"><?= post('comment_content') ?? $row['comment_content']; ?></textarea>
                </div>
            </li>
            <li>
                <label>Yorum Durumu</label>
                <div class="form-content">
                    <select name="comment_status">
                        <option value="1" <?= $row['comment_status'] == 1 ? 'selected' : null; ?>>Onaylı</option>
                        <option value="0" <?= $row['comment_status'] == 0 ? 'selected' : null; ?>>Onay Bekliyor</option>
                    </select>
                </div>
            </li>
            <li class="submit">
                <input type="hidden" name="submit" value="1">
                <button type="submit">Güncelle</button>
            </li>
        </ul>
    </form>
</div>

<?php require adminView('static/footer'); ?>
