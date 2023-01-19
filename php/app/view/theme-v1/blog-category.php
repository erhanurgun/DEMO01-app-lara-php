<?php require view('static/header'); ?>

    <!-- blog-page-area start -->
    <div class="blog-page-area section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-12 col-12">
                    <?php if ($posts): ?>
                        <div class="find-post-mssg">
                            <strong>ETİKET SONUÇU: <?= $category['category_name']; ?></strong>
                            etiketi ile ilgili <strong><?= $totalRecord; ?></strong> adet paylaşım bulundu :)
                        </div>
                        <div class="blog-left-bar">
                            <!-- loop area start -->
                            <?php foreach ($posts as $count => $row): ?>
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <div class="blog-s2">
                                            <a href="<?= siteUrl('blog/' . $row['post_url']); ?>">
                                                <img class="post-img-big" src="<?= uploadUrl($row['post_img'] ? 'posts/' . $row['post_img'] : 'no-img.png'); ?>"
                                                     alt="<?= $row['post_title']; ?>">
                                            </a>
                                        </div>
                                        <ul class="post-meta">
                                            <li><?= $row['category_name']; ?></li>
                                            <li><?= timeConvert($row['post_date']); ?></li>
                                        </ul>
                                    </div>
                                    <div class="blog-content-2">
                                        <a href="<?= siteUrl('blog/' . $row['post_url']); ?>">
                                            <h2><?= cutText($row['post_title'], 72); ?></h2>
                                        </a>
                                        <p><?= cutText($row['post_content']); ?></p>
                                        <a href="<?= siteUrl('blog/' . $row['post_url']); ?>">Devamını Oku...</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- loop area end -->

                            <?php if ($totalRecord > $pageLimit) : ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="pagination-wrapper pagination-wrapper-2">
                                            <ul>
                                                <li class="float-left">
                                                    <a class="next"
                                                       href="<?= siteUrl('blog/category/' . $category['category_url'] . '?' . $pageParam . '=' . $db->prevPage()); ?>">
                                                        <i class="fa fa-long-arrow-left"></i>
                                                        <b class="for-desktop">Önceki</b>
                                                    </a>
                                                </li>
                                                <!-- loop area start -->
                                                <?= $db->showPagination(siteUrl('blog/category/' . $category['category_url'] . '?' . $pageParam . '=[page]')); ?>
                                                <!-- loop area end -->
                                                <li class="float-right">
                                                    <a class="next"
                                                       href="<?= siteUrl('blog/category/' . $category['category_url'] . '?' . $pageParam . '=' . $db->nextPage()); ?>">
                                                        <b class="for-desktop">Sonraki</b>
                                                        <i class="fa fa-long-arrow-right"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <strong>UYARI: <?= $category['category_name']; ?></strong>
                            etiketi ile ilgili herhangi bir paylaşım bulunamadı!
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="blog-right-bar">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="widget search-widget">
                                    <form action="<?= siteUrl('blog/search'); ?>" method="get">
                                        <div>
                                            <input type="text" class="form-control" name="q" value="<?= get('q'); ?>"
                                                   placeholder="Blog'ta Ara..">
                                            <button type="submit"><i class="fa fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="catagory-item">
                                    <div class="widget-title">
                                        <h3 class="text-left eu-blog-text">Kategoriler</h3>
                                    </div>
                                    <div class="category-section">
                                        <ul>
                                            <!-- loop area start -->
                                            <?php foreach (Blog::categories() as $row): ?>
                                                <li>
                                                    <a href="<?= siteUrl('blog/category/' . $row['category_url']); ?>">
                                                        <?= $row['category_name']; ?>
                                                        <span class="float-right badge badge-primary badge-pill"><?= $row['total']; ?></span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                            <!-- loop area end -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-12 col-g">
                                <div class="widget tag-widget">
                                    <h3 class="eu-blog-text eu p-3">Etiketler</h3>
                                    <ul>
                                        <!-- loop area start -->
                                        <?php foreach (Blog::getRandomTags(6) as $row): ?>
                                            <li>
                                                <a href="<?= siteUrl('blog/tag/' . $row['tag_url']); ?>"><?= $row['tag_name']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                        <!-- loop area end -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="catagory-item">
                                    <div class="widget-title">
                                        <h3 class="text-left eu-blog-text">Son Yazılar</h3>
                                    </div>
                                </div>
                                <div class="category-section catagory-item mt-0">
                                    <ul>
                                        <!-- loop area start -->
                                        <?php foreach ($lastPosts as $row): ?>
                                            <li>
                                                <a href="<?= siteUrl('blog/' . $row['post_url']); ?>">
                                                    <div class="posts mini-post">
                                                        <div class="post post2">
                                                            <div class="img-holder">
                                                                <img class="post-img-small"
                                                                     src="<?= uploadUrl($row['post_img'] ? 'posts/' . $row['post_img'] : 'no-img.png'); ?>"
                                                                     alt="<?= $row['post_title']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="details">
                                                            <span class="a-title"><?= cutText($row['post_title'], 30); ?></span>
                                                            <p><?= trDateConvert($row['post_date']); ?></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                        <!-- loop area end -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- blog-page-area end -->

<?php require view('static/footer'); ?>