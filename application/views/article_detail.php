<div class="section">
    <div class="section-title"><strong><?php echo $article->ta_title; ?></strong></div>
    <div class="image-container">
        <img class="main-image" src="<?php echo base_url("assets/images/article/article_" . $article->ta_kode . "." . $article->ta_image_extension . "?d=" . strtotime($article->modified_date)); ?>" data-src="<?php echo base_url("assets/images/article/article_1.jpg"); ?>" />
    </div>
    <div class="blog-container">
        <pre><?php
        $iLength = sizeof($detail);
        for ($i = 0; $i < $iLength; $i++) {
            if ($detail[$i]->tac_type == 1) {
                echo $detail[$i]->tac_value;
            } else {
                echo "<div class='image-container'>";
                echo "<img class='image' src='" . base_url("assets/images/article/article_content_" . $detail[$i]->tac_kode . "." . $detail[$i]->tac_image_extension . "?d=" . strtotime($detail[$i]->modified_date)) . "' data-src='" . base_url("assets/images/article/article_content_" . $detail[$i]->tac_kode . "." . $detail[$i]->tac_image_extension . "?d=" . strtotime($detail[$i]->modified_date)) . "' />";
                echo "</div>";
            }
            echo "\n\n";
        }
        ?></pre>
    </div>
    <!--<div class="article-container">
        <a href="<?php //echo base_url("article/detail/1"); ?>" class="article" data-anim="show-up" data-anim-threshold="self">
            <div class="article-image-container">
                <div class="article-image" data-src="<?php //echo base_url("assets/images/article/article_1.jpg"); ?>"></div>
            </div>
            <div class="article-title">
                <div class="article-line"></div><div class="article-title-text">This Is The Title</div>
            </div>
            <div class="article-description">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
            </div>
        </a>
        <a href="<?php //echo base_url("article/detail/1"); ?>" class="article" data-anim="show-up" data-anim-threshold="self">
            <div class="article-image-container">
                <div class="article-image" data-src="<?php //echo base_url("assets/images/article/article_1.jpg"); ?>"></div>
            </div>
            <div class="article-title">
                <div class="article-line"></div><div class="article-title-text">This Is The Title</div>
            </div>
            <div class="article-description">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
            </div>
        </a>
    </div>-->
</div>