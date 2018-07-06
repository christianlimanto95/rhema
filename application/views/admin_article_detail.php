<?php
$first_content = "";
if (sizeof($detail) > 0) {
    $first_content = $detail[0]->tac_value;
}
?>
<div class="section">
    <form class="form-insert" method="post" action="<?php echo base_url("admin/article_update"); ?>">
        <input type="hidden" class="ta-kode" name="ta_kode" value="<?php echo $data->ta_kode; ?>" />
        <input type="hidden" class="content-type" name="content_type" />
        <div class="form-item">
            <div class="form-label">Judul <span class="error error-judul"></span></div>
            <input type="text" class="form-input input-judul" name="title" maxlength="100" value="<?php echo $data->ta_title; ?>" />
        </div>
        <?php
        $imageAdded = "";
        $src = "";
        if ($data->ta_image_extension != "") {
            $imageAdded = " image-added";
            $src = "src='" . base_url("assets/images/article/article_" . $data->ta_kode . "." . $data->ta_image_extension . "?d=" . strtotime($data->modified_date)) . "'";
            
        }
        ?>
        <div class="main-image form-right<?php echo $imageAdded; ?>">
            <input type="hidden" name="title_image" class="main-image-input" value="" />
            <div class="upload-container btn btn-insert-image">
                <div class="upload-button">
                    <div class="upload-text">Insert Image</div>
                </div>
                <input type="file" class="input-upload-main" name="input-image" accept="image/*" />
            </div>
            <img class="main-image-preview image-preview" <?php echo $src; ?> />
            <div class="btn btn-negative btn-delete-image">Delete Image</div>
        </div>
        <div class="insert-content">
            <div class="content-group content-group-text">
                <textarea class="insert-content-text"><?php echo $first_content; ?></textarea>
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
            <?php
            $iLength = sizeof($detail);
            for ($i = 1; $i < $iLength; $i++) {
                $type = $detail[$i]->tac_type;
                $content = "";
                if ($type == 2) {
                    $content = " <div class='content-group content-group-image'><input type='hidden' name='article-image' class='article-image' value='" . base_url("assets/images/article/article_content_" . $detail[$i]->tac_kode . "." . $detail[$i]->tac_image_extension . "?d=" . strtotime($detail[$i]->modified_date)) . "' /><div class='image-container'><img class='image' src='" . base_url("assets/images/article/article_content_" . $detail[$i]->tac_kode . "." . $detail[$i]->tac_image_extension . "?d=" . strtotime($detail[$i]->modified_date)) . "' /></div><input type='text' class='form-input input-image-description' name='article_image_description' /><div><div class='btn btn-negative btn-delete-article-image'>Delete Image</div><div class='upload-container btn btn-insert-image'><div class='upload-button'><div class='upload-text'>Insert Image</div></div><input type='file' class='input-upload' name='input-image' accept='image/*' /></div><div class='btn btn-insert-text'>Insert Text</div></div></div>";
                } else {
                    $content = " <div class='content-group content-group-text'><textarea class='insert-content-text'>" . $detail[$i]->tac_value . "</textarea><div><div class='btn btn-negative btn-delete-text'>Delete Text</div><div class='upload-container btn btn-insert-image'><div class='upload-button'><div class='upload-text'>Insert Image</div></div><input type='file' class='input-upload' name='input-image' accept='image/*' /></div><div class='btn btn-insert-text'>Insert Text</div></div></div>";
                }
                echo $content;
            }
            ?>
        </div>
        <div class="btn btn-submit">Simpan Perubahan</div>
    </form>
</div>