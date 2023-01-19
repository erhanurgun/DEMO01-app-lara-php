<?php
require view('static/header');
$postURL = siteUrl('blog/' . $row['post_url']);
?>

<!-- blog-page-area start -->
<div class="blog-page-area section-padding">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-12 col-12">
                <div class="blog-left-bar">
                    <div class="blog-item">
                        <div class="blog-img">
                            <div class="blog-s2">
                                <img src="<?= uploadUrl($row['post_img'] ? 'posts/' . $row['post_img'] : 'no-img.png'); ?>" alt="<?= setting('keywords'); ?>">
                            </div>
                            <ul class="post-meta">
                                <li><?= timeConvert($row['post_date']); ?></li>
                            </ul>
                        </div>
                        <div class="blog-content-2">
                            <h2><?= $row['post_title']; ?></h2>
                            <p><?= htmlspecialchars_decode($row['post_content']); ?></p>
                        </div>
                    </div>
                    <div class="tag-share">
                        <div class="tag">
                            <ul>
                                <!-- loop area start -->
                                <?php foreach ($tags as $key => $tag) : ?>
                                    <li><a href="<?= siteUrl('blog/tag/' . $key) ?>"><?= $tag; ?></a></li>
                                <?php endforeach; ?>
                                <!-- loop area end -->
                            </ul>
                        </div>
                        <div class="share">
                            <ul>
                                <li>Paylaş:</li>
                                <!-- loop area start -->
                                <?php foreach (menu(3) as $menu) : ?>
                                    <li>
                                        <a href="<?= $menu['url']; ?><?= $postURL; ?>" target="_blank">
                                            <?= $menu['title']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <!-- loop area end -->
                            </ul>
                        </div>
                    </div>
                    <div class="more-posts">
                        <div class="previous-post">
                            <a href="<?= getPrevPost($row['post_id']); ?>">
                                <span class="post-control-link">
                                    <i class="fa fa-long-arrow-left"></i> Önceki
                                </span>
                            </a>
                        </div>
                        <div class="next-post">
                            <a href="<?= getNextPost($row['post_id']); ?>">
                                <span class="post-control-link">Sonraki
                                    <i class="fa fa-long-arrow-right"></i>
                                </span>
                            </a>
                        </div>
                    </div> <!-- end more-posts -->
                    <div class="comments-area">
                        <div class="comments-section">
                            <?php if ($comments) : ?>
                                <h3 class="comments-title">Yorumlar (<?= countRow($totalComment); ?>)</h3>
                                <ol id="comments">
                                    <!-- loop area start -->
                                    <?php foreach ($comments as $comment) require view('static/comment'); ?>
                                    <!-- loop area end -->
                                </ol>
                            <?php else : ?>
                                <blockquote>
                                    <h5>İlk yorumu siz yazın!</h5>
                                    <p>
                                        Bu konu için hiç yorum yazılmamış! İlk yorumu siz yapmaya ne dersiniz?
                                    </p>
                                </blockquote>
                                <ol id="comments"></ol>
                            <?php endif; ?>
                        </div> <!-- end comments-section -->
                        <div class="comment-respond" id="post-write-content">
                            <h3 class="comment-reply-title">Yorum Yaz</h3>
                            <form class="comment-form" id="post-comment-form" onsubmit="return false;" data-id="<?= $row['post_id']; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="name" placeholder="Adınız ve Soyadınız">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" placeholder="E-Posta Adresiniz">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="url" name="website" placeholder="Website Adresiniz (varsa)">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="comment" placeholder="Yorumunuz..."></textarea>
                                    </div>
                                </div>
                                <div class="form-submit">
                                    <input type="submit" value="Yorum Yap" onclick="addPostComment('#post-comment-form')">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="blog-right-bar">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="widget search-widget">
                                <form action="<?= siteUrl('blog/search'); ?>" method="get">
                                    <div>
                                        <input type="text" class="form-control" name="q" value="<?= get('q'); ?>" placeholder="Blog'ta Ara..">
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
                                        <?php foreach (Blog::categories() as $row) : ?>
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
                                    <?php foreach (Blog::getRandomTags(6) as $row) : ?>
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
                                    <?php foreach ($lastPosts as $row) : ?>
                                        <li>
                                            <a href="<?= siteUrl('blog/' . $row['post_url']); ?>">
                                                <div class="posts mini-post">
                                                    <div class="post post2">
                                                        <div class="img-holder">
                                                            <img class="post-img-small" src="<?= uploadUrl($row['post_img'] ? 'posts/' . $row['post_img'] : 'no-img.png'); ?>" alt="<?= setting('keywords'); ?>">
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