<?php require adminView('static/header'); ?>

<div class="box-">
    <h1>Diğer Ayarlar</h1>
</div>

<div class="clear" style="height: 10px;"></div>

<div class="eu-mx-1">
    <div class="message warning eu-mb-1">
        <strong>UYARI:</strong>
        Eğer <b>ne yaptığınızı bilmiyorsanız</b> lütfen ayarları değiştirmeyiniz. Kalıcı sorunlara yol açabilir!
    </div>
    <div class="message info eu-mb-2">
        <strong>NOT:</strong>
        Tablo da ki veriler arasıda sıralama yapabilmek için
        &nbsp;<i class="fa fa-list-ul fa-silver"></i>&nbsp; ikonunu tutup sürükleyiniz.
    </div>
</div>

<div class="box-" tab>

    <div class="admin-tab">
        <ul tab-list>
            <li><a>Slider</a></li>
            <li id="counter"><a>Sayaç</a></li>
            <li id="teams"><a>Ekip</a></li>
            <li id="features"><a>Özellikler</a></li>
            <li id="about"><a>Hakkında</a></li>
        </ul>
    </div>

    <div class="tab-container">
        <div tab-content>
            <div class="box- eu-ml--4px">
                <a class="btn-other" href="<?= adminUrl('add-slider') ?>">
                    <i class="fa fa-plus"></i> Yeni Ekle
                </a>
            </div>

            <div class="table">
                <table class="table-dark table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Slider Resmi</th>
                            <th>Slider Başlığı</th>
                            <th class="hide">Slider Açıklaması</th>
                            <th class="hide">Buton Adı</th>
                            <th class="hide">Buton Linki</th>
                            <th class="hide">Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="table-sortable" data-table="sliders" data-where="slid_id" data-column="slid_order">
                        <?php if ($sliders) : ?>
                            <?php foreach ($sliders as $count => $row) : $count++; ?>
                                <tr id="id_<?= $row['slid_id']; ?>">
                                    <td width="10"><i class="fa fa-list-ul fa-silver"></i></td>
                                    <td width="45"><?= countRow($count); ?></td>
                                    <td width="120">
                                        <img class="td-img-square" alt="<?= $row['slid_title'] ?>" src="<?= uploadUrl('sliders/' . $row['slid_image']); ?>">
                                    </td>
                                    <td><?= $row['slid_title'] ?></td>
                                    <td class="hide"><?= $row['slid_description'] ? cutText($row['slid_description'], 100) : '<i class="txt-silver">Veri Yok!</i>'; ?></td>
                                    <td class="hide"><?= haveData($row['slid_btn_name']); ?></td>
                                    <td class="hide">
                                        <?php if (isset($row['slid_btn_url'])) : ?>
                                            <a href="<?= siteUrl($row['slid_btn_url']); ?>" target="_blank"><?= $row['slid_btn_url']; ?></a>
                                        <?php else : ?>
                                            <i class="txt-silver">Veri Yok!</i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="hide" width="100"><?= tdStatus($row['slid_status']); ?></td>
                                    <td width="115">
                                        <?php if (permission('others', 'edit')) : ?>
                                            <a class="btn btn-success" href="<?= adminUrl('edit-slider?id=' . $row['slid_id']); ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (permission('others', 'delete')) : ?>
                                            <a href="<?= adminUrl('delete?table=sliders&column=slid_id&id=' . $row['slid_id']); ?>" class="btn btn-danger" onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" align="center">
                                    Bu tablo'ya ait herhangi bir veri kaydı <b>bulunamadı</b>!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div tab-content>
            <form class="form label" action="<?= adminUrl('edit-counter'); ?>" method="post">
                <ul>
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <li>
                            <label>Sayaç - <?= $i; ?></label>
                            <div class="form-content">
                                <input type="text" class="w-50" name="name_<?= $i; ?>" value="<?= post('name_' . $i) ?? $counters['name_' . $i]; ?>">
                                <input type="number" class="w-50" name="count_<?= $i; ?>" value="<?= post('count_' . $i) ?? $counters['count_' . $i]; ?>">
                            </div>
                        </li>
                    <?php endfor; ?>
                    <li>
                        <label>Buton</label>
                        <div class="form-content">
                            <input type="text" class="w-50" name="btn_name" value="<?= post('btn_name') ?? $counters['btn_name']; ?>">
                            <input type="text" class="w-50" name="btn_url" value="<?= post('btn_url') ?? $counters['btn_url']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Başlık</label>
                        <div class="form-content">
                            <input type="text" name="title" value="<?= post('title') ?? $counters['title']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>Açıklama</label>
                        <div class="form-content">
                            <textarea name="description" cols="30" rows="5"><?= post('description') ?? $counters['description']; ?></textarea>
                        </div>
                    </li>
                    <li class="submit">
                        <button type="submit" name="submit" value="1">Kaydet</button>
                    </li>
                </ul>
            </form>
        </div>

        <div tab-content>
            <div class="box- eu-ml--4px">
                <a class="btn-other" href="<?= adminUrl('add-team') ?>">
                    <i class="fa fa-plus"></i> Yeni Ekle
                </a>
            </div>

            <div class="table">
                <table class="table-dark table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Fotoğraf</th>
                            <th>Ad ve Soyad</th>
                            <th class="hide">Meslek</th>
                            <th class="hide">Facebook</th>
                            <th class="hide">İnstagram</th>
                            <th class="hide">Twitter</th>
                            <th class="hide">Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="table-sortable" data-table="teams" data-where="team_id" data-column="team_order">
                        <?php if ($teams) : ?>
                            <?php foreach ($teams as $count => $row) : $count++; ?>
                                <tr id="id_<?= $row['team_id']; ?>">
                                    <td width="10"><i class="fa fa-list-ul fa-silver"></i></td>
                                    <td width="45"><?= countRow($count); ?></td>
                                    <td width="120">
                                        <img class="td-img-rounded" alt="<?= $row['team_name'] ?>" src="<?= $row['team_img'] ? uploadUrl('teams/' . $row['team_img']) : getGravatar(setting('email')); ?>">
                                    </td>
                                    <td><?= textType($row['team_name'], 'user'); ?></td>
                                    <td class="hide"><?= haveData($row['team_job']); ?></td>
                                    <td class="hide"><?= haveData($row['team_face']); ?></td>
                                    <td class="hide"><?= haveData($row['team_insta']); ?></td>
                                    <td class="hide"><?= haveData($row['team_twit']); ?></td>
                                    <td class="hide" width="100"><?= tdStatus($row['team_status']); ?></td>
                                    <td width="115">
                                        <?php if (permission('others', 'edit')) : ?>
                                            <a class="btn btn-success" href="<?= adminUrl('edit-team?id=' . $row['team_id']); ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (permission('others', 'delete')) : ?>
                                            <a href="<?= adminUrl('delete?table=teams&column=team_id&id=' . $row['team_id']); ?>" class="btn btn-danger" onclick="return confirm('Silme işlemini onaylıyor musunuz?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" align="center">
                                    Bu tablo'ya ait herhangi bir veri kaydı <b>bulunamadı</b>!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div tab-content>
            <form class="form label" action="<?= adminUrl('edit-feature'); ?>" method="post">
                <ul>
                    <?php foreach ($features as $key => $val) : ?>
                        <li>
                            <label>Başlık - <?= $key + 1; ?></label>
                            <div class="form-content">
                                <input type="text" name="item_<?= $key + 1; ?>[title]" value="<?= post('title') ?? $val['title']; ?>">
                            </div>
                        </li>
                        <li>
                            <label>İkon - <?= $key + 1; ?></label>
                            <div class="form-content">
                                <input type="text" name="item_<?= $key + 1; ?>[icon]" value="<?= post('icon') ?? $val['icon']; ?>">
                            </div>
                        </li>
                        <li>
                            <label>Açıklama - <?= $key + 1; ?></label>
                            <div class="form-content">
                                <textarea name="item_<?= $key + 1; ?>[description]" cols="30" rows="4"><?= post('description') ?? $val['description']; ?></textarea>
                            </div>
                        </li>
                    <?php endforeach; ?>

                    <li class="submit">
                        <button type="submit" name="submit" value="1">Kaydet</button>
                    </li>
                </ul>
            </form>
        </div>

        <div tab-content>
            <form class="form label" action="<?= adminUrl('edit-about'); ?>" method="post">
                <ul>
                    <li>
                        <label>Özellikler</label>
                        <input type="hidden" id="itemCount" name="item_count" value="<?= count($properties); ?>">
                        <div id="allItems">
                            <?php foreach ($properties as $key => $val) : ?>
                                <div class="form-content eu-mb-2">
                                    <input type="text" name="item_<?= $key + 1; ?>[item]" value="<?= post('item') ?? $val['item']; ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-content">
                            <button type="button" class="btn btn-success" id="addNewItem">
                                <i class="fa fa-plus"></i> Yeni Ekle
                            </button>
                            <button type="button" class="btn btn-danger" id="removeOldItem">
                                <i class="fa fa-trash"></i> Sil
                            </button>
                        </div>
                    </li>
                    <li>
                        <label>Yetkili Kişi</label>
                        <div class="form-content">
                            <input type="text" class="w-50" name="user_name" value="<?= post('user_name') ?? $about['user_name']; ?>">
                            <input type="text" class="w-50" name="user_job" value="<?= post('user_job') ?? $about['user_job']; ?>">
                        </div>
                    </li>
                    <li>
                        <label>İçerik</label>
                        <div class="form-content">
                            <textarea class="editor-short" name="content" cols="30" rows="4"><?= post('content') ?? $about['content']; ?></textarea>
                        </div>
                    </li>
                    <li class="submit">
                        <button type="submit" name="submit" value="1">Kaydet</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>

</div>

<?php require adminView('static/footer'); ?>