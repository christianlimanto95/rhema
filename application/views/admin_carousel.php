<div class="section section-insert">
    <div class="section-title">Insert</div>
    <form class="form-add-carousel" method="post" action="<?php echo base_url("admin/carousel_insert"); ?>">
        <div class="form-item">
            <div class="form-label">Image (Desktop) <span class="error error-image"></span></div>
            <div class="form-right">
                <input type="hidden" name="carousel_image" class="image-input tour-group-image-input" value="" />
                <div class="upload-container">
                    <div class="upload-button">
                        <div class="upload-text">Choose Image</div>
                    </div>
                    <input type="file" class="input-upload tour-group-image-input-upload" name="input-image" accept="image/*" />
                </div>
                <img class="tour-group-image-preview image-preview" />
                <div class="btn btn-negative btn-delete-tour-group-image">Delete Image</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Image (Mobile)</div>
            <div class="form-right">
                <input type="hidden" name="carousel_image_mobile" class="image-input" value="" />
                <div class="upload-container">
                    <div class="upload-button">
                        <div class="upload-text">Choose Image</div>
                    </div>
                    <input type="file" class="input-upload tour-group-image-input-upload" name="input-image" accept="image/*" />
                </div>
                <img class="tour-group-image-preview image-preview" />
                <div class="btn btn-negative btn-delete-tour-group-image">Delete Image</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Zoom Out Effect</div>
            <div class="radio-outer-container">
                <input type="hidden" class="radio-input" name="carousel_zoom_out" data-name="zoom-out" value="1" />
                <div class="radio-container zoom-out-radio-container active" data-name="zoom-out" data-value="1">
                    <div class="radio"></div>
                    <div class="radio-text">Ya</div>
                </div>
                <div class="radio-container zoom-out-radio-container" data-name="zoom-out" data-value="0">
                    <div class="radio"></div>
                    <div class="radio-text">Tidak</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Text Position</div>
            <div class="select select-text-position" data-type="text-position" data-value="1">
                <input type="hidden" class="input-text-position" name="carousel_text_position" value="1" />
                <div class="select-text">Center</div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-text-position" data-type="text-position">
                    <div class="dropdown-item" data-value="1">Center</div>
                    <div class="dropdown-item" data-value="3">Right</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Title <span class="error error-title"></span></div>
            <textarea class="form-input input-title" name="carousel_title" maxlength="100" ></textarea>
        </div>
        <div class="form-item">
            <div class="form-label">Title Color</div>
            <div class="select select-title-color" data-type="title-color" data-value="dark_blue">
                <input type="hidden" class="input-title-color" name="carousel_title_color" value="dark_blue" />
                <div class="select-text">Dark Blue</div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-title-color" data-type="title-color">
                    <div class="dropdown-item" data-value="dark_blue">Dark Blue</div>
                    <div class="dropdown-item" data-value="white">White</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Description</div>
            <textarea class="form-input input-description" name="carousel_description" ></textarea>
        </div>
        <div class="form-item">
            <div class="form-label">Description Color</div>
            <div class="select select-description-color" data-type="description-color" data-value="dark_blue">
                <input type="hidden" class="input-description-color" name="carousel_description_color" value="dark_blue" />
                <div class="select-text">Dark Blue</div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-description-color" data-type="description-color">
                    <div class="dropdown-item" data-value="dark_blue">Dark Blue</div>
                    <div class="dropdown-item" data-value="white">White</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Button Text</div>
            <input type="text" class="form-input input-button-text" name="carousel_button_text" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label">Button Link</div>
            <div>
                <?php echo base_url(); ?> <input type="text" name="carousel_button_link" class="form-input input-button-link" maxlength="100" />
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">Button Color</div>
            <div class="select select-button-color" data-type="button-color" data-value="dark_blue">
                <input type="hidden" class="input-button-color" name="carousel_button_color" value="dark_blue" />
                <div class="select-text">Dark Blue</div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-button-color" data-type="description-color">
                    <div class="dropdown-item" data-value="dark_blue">Dark Blue</div>
                    <div class="dropdown-item" data-value="white_skeleton">White Skeleton</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label">At Index</div>
            <div class="select select-index" data-type="index" data-value="first">
                <input type="hidden" class="input-index" name="carousel_index" value="first" />
                <div class="select-text">First</div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-index" data-type="index">
                    <div class="dropdown-item" data-value="first">First</div>
                    <?php
                    $iLength = sizeof($data);
                    for ($i = 1; $i < $iLength; $i++) {
                        echo "<div class='dropdown-item' data-value='" . $data[$i]->carousel_index . "'>" . $data[$i]->carousel_index . "</div>";
                    }
                    ?>
                    <div class="dropdown-item" data-value="last">Last</div>
                </div>
            </div>
        </div>
        <div class="btn btn-add-carousel">Add Carousel</div>
    </form>
</div>
<div class="section section-update">
    <div class="section-title">List</div>
    <div class="item-container">
    <?php
    $iLength = sizeof($data);
    for ($i = 0; $i < $iLength; $i++) {
        echo "<div class='item' data-id='" . $data[$i]->carousel_id . "' data-index='" . $data[$i]->carousel_index . "'>";
        echo "<div class='item-image' style='background-image: url(" . base_url("assets/images/home_1_" . $data[$i]->carousel_id . "." . $data[$i]->carousel_image_extension . "?d=" . strtotime($data[$i]->modified_date)) . ");'></div>";
        echo "<div class='item-index'>" . $data[$i]->carousel_index . "</div>";
        echo "<a href='" . base_url("admin/carousel_detail/" . $data[$i]->carousel_id) . "' class='btn btn-edit-carousel'>Edit</a>";
        if ($iLength > 1) {
            echo "<div class='btn btn-edit-index'>Edit Index</div>";
            echo "<form class='form-delete-carousel' method='post' action='" . base_url("admin/carousel_delete") . "'>";
            echo "<input type='hidden' name='carousel_id' value='" . $data[$i]->carousel_id . "' />";
            echo "<div class='btn btn-negative btn-delete-carousel'>Delete</div>";
            echo "</form>";
        }
        echo "</div>";
    }
    ?>
    </div>
</div>

<div class="dialog dialog-edit-index">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <form class="form-update-index" method="post" action="<?php echo base_url("admin/carousel_update_index"); ?>">
                <input type="hidden" name="carousel_id" value="" />
                <div class="dialog-title">Edit Index</div>
                <div class="dialog-text">
                    <div class="form-item">
                        <div class="form-label-inline label-from-index">From Index : 1</div>
                    </div>
                    <div class="form-item">
                        <div class="form-label-inline">To : </div>
                        <div class="select select-update-index" data-type="index" data-value="first">
                            <input type="hidden" class="input-update-index" name="carousel_index" value="first" />
                            <div class="select-text">First</div>
                            <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                            <div class="dropdown-container dropdown-container-update-index" data-type="index">
                                <div class="dropdown-item" data-value="first">First</div>
                                <?php
                                $iLength = sizeof($data);
                                for ($i = 1; $i < $iLength; $i++) {
                                    echo "<div class='dropdown-item' data-value='" . $data[$i]->carousel_index . "'>" . $data[$i]->carousel_index . "</div>";
                                }
                                ?>
                                <div class="dropdown-item" data-value="last">Last</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dialog-button-container">
                    <div class="dialog-button btn btn-dialog-cancel">Cancel</div>
                    <div class="dialog-button btn btn-dialog-update-index">Update</div>
                </div>
            </form>
        </div>
    </div>
</div>