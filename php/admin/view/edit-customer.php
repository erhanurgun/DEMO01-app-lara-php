<?php require adminView('static/header'); ?>

<div class="box-"><h1>Müşteri Yorumunu Düzenleme (#<?= $id; ?>)</h1></div>

<div class="clear" style="height: 10px;"></div>

<div class="box-">
    <div class="info-edit-item">
        <strong><?= $row['customer_name']; ?></strong> tarafından
        <strong><?= $row['customer_date']; ?></strong> tarihinde ( <?= timeAgo($row['customer_date']); ?> ) yazıldı.
    </div>
    <form action="" method="post" class="form label">
        <ul>
            <li>
                <label>Yazan</label>
                <div class="form-content">
                    <input type="text" name="customer_name"
                           value="<?= post('customer_name') ?? $row['customer_name']; ?>">
                </div>
            </li>
            <li>
                <label>E-Posta</label>
                <div class="form-content">
                    <input type="text" name="customer_email"
                           value="<?= post('customer_email') ?? $row['customer_email']; ?>">
                </div>
            </li>
            <li>
                <label>Yorum</label>
                <div class="form-content">
                    <textarea name="customer_mssg" cols="30"
                              rows="12"><?= post('customer_mssg') ?? $row['customer_mssg']; ?></textarea>
                </div>
            </li>
            <li>
                <label>Durum</label>
                <div class="form-content">
                    <select name="customer_status">
                        <option value="" disabled>--- Durum Seç ---</option>
                        <option value="1" <?= selected($row['customer_status'], 1); ?>>Onaylı</option>
                        <option value="0" <?= selected($row['customer_status'], 0); ?>>Onaylı Değil</option>
                    </select>
                </div>
            </li>
            <li class="submit">
                <button type="submit" name="submit" value="1">Güncelle</button>
            </li>
        </ul>
    </form>
</div>

<?php require adminView('static/footer'); ?>
