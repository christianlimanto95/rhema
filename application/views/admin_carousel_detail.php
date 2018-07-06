<div class="section section-update">
    <form class="form-update-carousel" method="post" action="<?php echo base_url("admin/carousel_update"); ?>">
        <input type="hidden" name="carousel_id" value="<?php echo $data->carousel_id; ?>" />
        <div class="form-item">
            <div class="form-label">Image (Desktop)</div>
            <?php
            $imageAdded = "";
            $src = "";
            if ($data->carousel_image_extension != "") {
                $imageAdded = " image-added";
                $src = "src='" . base_url("assets/images/home_1_" . $data->carousel_id . "." . $data->carousel_image_extension . "?d=" . strtotime($data->modified_date)) . "'";
            }
            ?>
            <div class="form-right form-image<?php echo $imageAdded; ?>">
                <input type="hidden" name="carousel_image" class="image-input tour-group-image-input" value="" />
                <div class="upload-container">
                    <div class="upload-button">
                        <div class="upload-text">Choose Image</div>
                    </div>
                    <input type="file" class="input-upload tour-group-image-input-upload" name="input-image" accept="image/*" />
                </div>
                <img class="tour-group-image-preview image-preview" <?php echo $src; ?> />
                <div class="btn btn-negative btn-delete-tour-group-image">Delete Image</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Image (Mobile)</div>
            <?php
            $imageAdded = "";
            $src = "";
            if ($data->carousel_image_mobile_extension != "") {
                $imageAdded = " image-added";
                $src = "src='" . base_url("assets/images/home_1_" . $data->carousel_id . "_mobile." . $data->carousel_image_mobile_extension . "?d=" . strtotime($data->modified_date)) . "'";
            }
            ?>
            <div class="form-right form-image-mobile<?php echo $imageAdded; ?>">
                <input type="hidden" name="carousel_image_mobile" class="image-input tour-group-image-input-mobile" value="" />
                <div class="upload-container">
                    <div class="upload-button">
                        <div class="upload-text">Choose Image</div>
                    </div>
                    <input type="file" class="input-upload tour-group-image-input-upload" name="input-image" accept="image/*" />
                </div>
                <img class="tour-group-image-preview image-preview" <?php echo $src; ?> />
                <div class="btn btn-negative btn-delete-tour-group-image">Delete Image</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Zoom Out Effect</div>
            <div class="radio-outer-container">
                <input type="hidden" class="radio-input" name="carousel_zoom_out" data-name="zoom-out" value="<?php echo $data->carousel_zoom_out; ?>" />
                <?php
                $ya_active = " active";
                $tidak_active = "";
                if ($data->carousel_zoom_out == 0) {
                    $ya_active = "";
                    $tidak_active = " active";
                }
                ?>
                <div class="radio-container zoom-out-radio-container<?php echo $ya_active; ?>" data-name="zoom-out" data-value="1">
                    <div class="radio"></div>
                    <div class="radio-text">Ya</div>
                </div>
                <div class="radio-container zoom-out-radio-container<?php echo $tidak_active; ?>" data-name="zoom-out" data-value="0">
                    <div class="radio"></div>
                    <div class="radio-text">Tidak</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Text Position</div>
            <div class="select select-text-position" data-type="text-position" data-value="<?php echo $data->carousel_text_position; ?>">
                <input type="hidden" class="input-text-position" name="carousel_text_position" value="<?php echo $data->carousel_text_position; ?>" />
                <?php
                if ($data->carousel_text_position == 1) {
                    echo "<div class='select-text'>Center</div>";
                } else if ($data->carousel_text_position == 3) {
                    echo "<div class='select-text'>Right</div>";
                }
                ?>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-text-position" data-type="text-position">
                    <div class="dropdown-item" data-value="1">Center</div>
                    <div class="dropdown-item" data-value="3">Right</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Title <span class="error error-title"></span></div>
            <textarea class="form-input input-title" name="carousel_title" maxlength="100" ><?php echo $data->carousel_title; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label">Title Color</div>
            <div class="select select-title-color" data-type="title-color" data-value="<?php echo $data->carousel_title_color; ?>">
                <input type="hidden" class="input-title-color" name="carousel_title_color" value="<?php echo $data->carousel_title_color; ?>" />
                <?php
                if ($data->carousel_title_color == "dark_blue") {
                    echo "<div class='select-text'>Dark Blue</div>";
                } else if ($data->carousel_title_color == "white") {
                    echo "<div class='select-text'>White</div>";
                }
                ?>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-title-color" data-type="title-color">
                    <div class="dropdown-item" data-value="dark_blue">Dark Blue</div>
                    <div class="dropdown-item" data-value="white">White</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Description</div>
            <textarea class="form-input input-description" name="carousel_description" ><?php echo $data->carousel_description; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label">Description Color</div>
            <div class="select select-description-color" data-type="description-color" data-value="<?php echo $data->carousel_description_color; ?>">
                <input type="hidden" class="input-description-color" name="carousel_description_color" value="<?php echo $data->carousel_description_color; ?>" />
                <?php
                if ($data->carousel_description_color == "dark_blue") {
                    echo "<div class='select-text'>Dark Blue</div>";
                } else if ($data->carousel_description_color == "white") {
                    echo "<div class='select-text'>White</div>";
                }
                ?>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-description-color" data-type="description-color">
                    <div class="dropdown-item" data-value="dark_blue">Dark Blue</div>
                    <div class="dropdown-item" data-value="white">White</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Button Text</div>
            <input type="text" class="form-input input-button-text" name="carousel_button_text" maxlength="100" value="<?php echo $data->carousel_button_text; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label">Button Link</div>
            <div>
                <?php echo base_url(); ?> <input type="text" name="carousel_button_link" class="form-input input-button-link" maxlength="100" value="<?php echo $data->carousel_button_link; ?>" />
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Button Color</div>
            <div class="select select-button-color" data-type="button-color" data-value="<?php echo $data->carousel_button_color; ?>">
                <input type="hidden" class="input-button-color" name="carousel_button_color" value="<?php echo $data->carousel_button_color; ?>" />
                <?php
                if ($data->carousel_button_color == "dark_blue") {
                    echo "<div class='select-text'>Dark Blue</div>";
                } else if ($data->carousel_button_color == "white_skeleton") {
                    echo "<div class='select-text'>White Skeleton</div>";
                }
                ?>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-button-color" data-type="description-color">
                    <div class="dropdown-item" data-value="dark_blue">Dark Blue</div>
                    <div class="dropdown-item" data-value="white_skeleton">White Skeleton</div>
                </div>
            </div>
        </div>
        <div class="btn btn-update-carousel">Simpan Perubahan</div>
    </form>
</div>