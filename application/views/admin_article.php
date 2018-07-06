<div class="section">
    <div class="section-title">Insert</div>
    <form class="form-insert" method="post" action="<?php echo base_url("admin/article_insert"); ?>">
        <input type="hidden" class="content-type" name="content_type" />
        <div class="form-item">
            <div class="form-label">Judul <span class="error error-judul"></span></div>
            <input type="text" class="form-input input-judul" name="title" maxlength="100" />
        </div>
        <div class="main-image form-right">
            <input type="hidden" name="title_image" class="main-image-input" value="" />
            <div class="upload-container btn btn-insert-image">
                <div class="upload-button">
                    <div class="upload-text">Insert Image</div>
                </div>
                <input type="file" class="input-upload-main" name="input-image" accept="image/*" />
            </div>
            <img class="main-image-preview image-preview" />
            <div class="btn btn-negative btn-delete-image">Delete Image</div>
        </div>
        <div class="insert-content">
            <div class="content-group content-group-text">
                <textarea class="insert-content-text"></textarea>
                <div>
                    <div class="upload-container btn btn-insert-image">
                        <div class="upload-button">
                            <div class="upload-text">Insert Image</div>
                        </div>
                        <input type="file" class="input-upload" name="input-image" accept="image/*" />
                    </div>
                    <div class="btn btn-insert-text">Insert Text</div>
                </div>
            </div>
        </div>
        <div class="btn btn-submit">Submit Article</div>
    </form>
</div>
<div class="section">
    <div class="section-title">List</div>
    <?php
    $iLength = sizeof($data);
    for ($i = 0; $i < $iLength; $i++) {
        echo "<div class='article-item'>";
        echo "<img class='article-item-image' src='" . base_url("assets/images/article/article_" . $data[$i]->ta_kode . "." . $data[$i]->ta_image_extension . "?d=" . strtotime($data[$i]->modified_date)) . "' />";
        echo "<div class='article-item-title'>" . $data[$i]->ta_title . "</div>";
        echo "<a href='" . base_url("admin/article_detail/" . $data[$i]->ta_kode) . "' class='btn btn-edit-article'>Edit Article</a>";
        echo "<form class='form-delete' method='post' action='" . base_url("admin/article_delete") . "'>";
        echo "<input type='hidden' name='ta_kode' value='" . $data[$i]->ta_kode . "' />";
        echo "<div class='btn btn-negative btn-delete-article'>Delete Article</div>";
        echo "</form>";
        echo "</div>";
    }
    ?>
</div>