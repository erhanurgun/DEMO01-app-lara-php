<li class="comment even thread-even depth-1" id="comment-<?= $comment['comment_id']; ?>">
    <div id="div-comment-<?= $comment['comment_id']; ?>">
        <div class="comment-theme">
            <div class="comment-image">
                <img src="<?= getGravatar($comment['comment_email']); ?>" alt="<?= setting('keywords'); ?>">
            </div>
        </div>
        <div class="comment-main-area">
            <div class="comment-wrapper">
                <div class="comments-meta">
                    <h4><?= textType($comment['comment_name'], 'user') ?></h4>
                    <span class="comments-date">
                        <?= faDatetime($comment['comment_date']); ?>
                    </span>
                </div>
                <div class="comment-area-sub">
                    <p style="overflow-wrap: break-word;"><?= $comment['comment_content']; ?></p>
                </div>
            </div>
        </div>
    </div>
</li>