<div class="section">
    <div class="section-title" data-anim="show-up" data-anim-threshold="self"><strong>ARTICLE</strong></div>
    <div class="article-container">
        <?php
        $iLength = sizeof($data);
        for ($i = 0; $i < $iLength; $i++) {
            echo "<a href='" . base_url("article/detail/" . $data[$i]->ta_kode) . "' class='article' data-anim='show-up' data-anim-threshold='self'>";
            echo "<div class='article-image-container'>";
            echo "<div class='article-image' data-src='" . base_url("assets/images/article/article_" . $data[$i]->ta_kode . "." . $data[$i]->ta_image_extension . "?d=" . strtotime($data[$i]->modified_date)) . "'></div>";
            echo "</div>";
            echo "<div class='article-title'>";
            echo "<div class='article-line'></div><div class='article-title-text'>" . $data[$i]->ta_title . "</div>";
            echo "</div>";
            $text = $data[$i]->tac_value;
            if (strlen($text) > 160) {
                $text = substr($text, 0, 160);
            }
            echo "<div class='article-description'>" . $text . "</div>";
            echo "</a>";
        }
        ?>
    </div>
</div>