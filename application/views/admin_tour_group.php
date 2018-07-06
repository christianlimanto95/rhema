<div class="section section-insert">
    <div class="section-title">Insert</div>
    <form class="form-insert" enctype="multipart/form-data" method="post" action="<?php echo base_url("admin/tour_group_insert"); ?>">
        <div class="form-item form-item-jenis-tour">
            <div class="form-label-inline">Jenis Tour</div>
            <div class="select select-jenis-tour" data-type="jenis-tour" data-value="1">
                <input type="hidden" class="input-jenis-tour" name="tg_jenis_tour" value="1" />
                <div class="select-text">Pilgrimage</div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-jenis-tour" data-type="jenis-tour">
                    <div class="dropdown-item" data-value="1">Pilgrimage</div>
                    <div class="dropdown-item" data-value="2">Leisure</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Judul</div>
            <input type="text" name="tour_group_nama" class="form-input input-judul" maxlength="200" />
        </div>
        <div class="form-item-inline">
            <div class="form-label-inline">Mulai Tanggal</div>
            <input type="text" name="date_start" data-type="date" class="form-input input-date-start" maxlength="10" />
        </div>
        <div class="form-item-inline">
            <div class="form-label-inline">Sampai Tanggal</div>
            <input type="text" name="date_end" data-type="date" class="form-input input-date-end" maxlength="10" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Rute</div>
            <input type="text" name="rute" class="form-input input-rute" maxlength="250" />
        </div>
        <div class="form-item form-item-harga">
            <div class="form-label-inline">Harga</div>
            <div class="form-right">
                <input type="hidden" name="harga_count" value="1" />
                <div class="harga-container">
                    <div class="harga-item">
                        <input type="text" name="harga_1" class="form-input input-harga" data-type="number" data-thousand-separator="true" maxlength="15" value="0" />
                        <div class="select select-kurs" data-type="kurs" data-value="usd">
                            <input type="hidden" class="kurs-value" name="kurs_1" value="usd" />
                            <div class="select-text">USD</div>
                            <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                            <div class="dropdown-container dropdown-container-kurs" data-type="kurs">
                                <div class="dropdown-item" data-value="usd">USD</div>
                                <div class="dropdown-item" data-value="idr">IDR</div>
                            </div>
                        </div>
                        <input type="text" name="harga_remarks_1" class="form-input input-harga-remarks" maxlength="25" />
                    </div>
                </div>
                <div class="btn btn-add-harga">Add Harga</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Informasi Cicilan</div>
            <textarea name="tg_cicilan" class="form-input input-cicilan" ></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Pembimbing</div>
            <input type="text" name="pembimbing" class="form-input input-pembimbing" maxlength="120" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Gambar</div>
            <div class="form-right">
                <input type="hidden" name="tour_group_image" class="tour-group-image-input" value="" />
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
        <div class="form-item form-item-tour-highlight">
            <div class="form-label-inline">Tour Highlight</div>
            <div class="form-input-right">
                <input type="hidden" name="tour_highlight" value="" />
                <div class="checkbox-outer-container">
                    <?php
                    $iLength = sizeof($tour_highlight);
                    for ($i = 0; $i < $iLength; $i++) {
                        echo "<div class='checkbox-container highlight-checkbox-container' data-name='highlight' data-value='" . $tour_highlight[$i]->thi_kode . "'>";
                        echo "<div class='checkbox'></div>";
                        echo "<div class='checkbox-text'>" . $tour_highlight[$i]->thi_nama . "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <div class="btn btn-add-tour-highlight">Add Tour Highlight</div>
            </div>
        </div>
        <div class="form-item form-item-tour-bonus">
            <div class="form-label-inline">Tour Bonus</div>
            <div class="form-input-right">
                <input type="hidden" name="tour_bonus" value="" />
                <div class="checkbox-outer-container">
                    <?php
                    $iLength = sizeof($tour_bonus);
                    for ($i = 0; $i < $iLength; $i++) {
                        echo "<div class='checkbox-container bonus-checkbox-container' data-name='bonus' data-value='" . $tour_bonus[$i]->tb_kode . "'>";
                        echo "<div class='checkbox'></div>";
                        echo "<div class='checkbox-text'>" . $tour_bonus[$i]->tb_nama . "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <div class="btn btn-add-tour-bonus">Add Tour Bonus</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Include Pax</div>
            <textarea name="include_pax" class="form-input input-include-pax" ></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Exclude Pax</div>
            <textarea name="exclude_pax" class="form-input input-exclude-pax" ></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Responsibility</div>
            <textarea name="responsibility" class="form-input input-responsibility" ></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Terms &amp; Conditions</div>
            <textarea name="tnc" class="form-input input-tnc"></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Nama CP 1</div>
            <input type="text" name="cp_name_1" class="form-input input-cp-name-1" maxlength="120" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">No. Handphone CP 1</div>
            <input type="text" name="cp_hp_1" class="form-input input-cp-hp-1" data-type="number" maxlength="20" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Email CP 1</div>
            <input type="text" name="cp_email_1" class="form-input input-cp-email-1" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Nama CP 2</div>
            <input type="text" name="cp_name_2" class="form-input input-cp-name-2" maxlength="120" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">No. Handphone CP 2</div>
            <input type="text" name="cp_hp_2" class="form-input input-cp-hp-2" data-type="number" maxlength="20" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Email CP 2</div>
            <input type="text" name="cp_email_2" class="form-input input-cp-email-2" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Itineraries</div>
            <div class="itinerary-container">
                <input type="hidden" class="itinerary-count" name="itinerary_count" value="0" />
                <div class="btn btn-add-itinerary">Add Itinerary</div>
            </div>
        </div>
        <div class="btn btn-insert-tour-group">Insert Tour Group</div>
    </form>
</div>
<div class="section section-update">
    <div class="section-title">List</div>
    <div class="tour-group-container">
        <?php
        $iLength = sizeof($tour_group);
        for ($i = 0; $i < $iLength; $i++) {
            echo "<div class='tour-group-item' data-id='" . $tour_group[$i]->tg_kode . "'>";
            echo "<div class='tour-group-item-image' style='background-image: url(" . base_url("assets/images/tour_groups/tour_groups_" . $tour_group[$i]->tg_kode) . "." . $tour_group[$i]->tg_image_extension . "?d=" . strtotime($tour_group[$i]->modified_date) . ");'></div>";
            echo "<div class='tour-group-item-nama'>" . $tour_group[$i]->tg_nama . "</div>";
            echo "<div class='tour-group-item-tgl'>" . $tour_group[$i]->tg_tglStart . " to " . $tour_group[$i]->tg_tglEnd . "</div>";
            echo "<div class='tour-group-item-rute'>" . $tour_group[$i]->tg_rute . "</div>";
            echo "<a class='btn btn-edit-tour-group-item' href='" . base_url("admin/tour_group_detail/" . $tour_group[$i]->tg_kode) . "'>Edit Tour Group</a>";
            echo "<form class='form-delete-tour-group' method='post' action='" . base_url("admin/tour_group_delete") . "'>";
            echo "<input type='hidden' name='tg_kode' value='" . $tour_group[$i]->tg_kode . "' />";
            echo "<div class='btn btn-negative btn-delete-tour-group'>Delete</div>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<div class="dialog dialog-add-tour-highlight">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <div class="dialog-title">Add Tour Highlight</div>
            <div class="dialog-text">
                <div class="form-item">
                    <span class="dialog-text-left form-label-inline">Name : </span><input type="text" class="dialog-text-right input-add-tour-highlight form-input" maxlength="50"></span>
                </div>
            </div>
            <div class="dialog-button-container">
                <div class="dialog-button btn btn-dialog-cancel">Cancel</div>
                <div class="dialog-button btn btn-dialog-add-tour-highlight">Save</div>
            </div>
        </div>
    </div>
</div>

<div class="dialog dialog-add-tour-bonus">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <div class="dialog-title">Add Tour Bonus</div>
            <div class="dialog-text">
                <div class="form-item">
                    <span class="dialog-text-left form-label-inline">Name : </span><input type="text" class="dialog-text-right input-add-tour-bonus form-input" maxlength="50"></span>
                </div>
            </div>
            <div class="dialog-button-container">
                <div class="dialog-button btn btn-dialog-cancel">Cancel</div>
                <div class="dialog-button btn btn-dialog-add-tour-bonus">Save</div>
            </div>
        </div>
    </div>
</div>

<div class="dialog dialog-add-itinerary" data-type="add" data-source="insert">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <div class="dialog-title">Add Itinerary</div>
            <div class="dialog-text">
                <div class="form-item">
                    <div class="form-label-inline">Date</div>
                    <input type="text" class="form-input input-add-itinerary-date" />
                </div>
                <div class="form-item">
                    <div class="form-label-inline">Place</div>
                    <input type="text" class="form-input input-add-itinerary-place" maxlength="100" />
                </div>
                <div class="form-item">
                    <div class="form-label-inline">Remarks</div>
                    <textarea class="form-input input-add-itinerary-remarks" ></textarea>  
                </div>
                <div class="form-item form-item-image-position">
                    <div class="form-label-inline">Image Position</div>
                    <div class="select select-position" data-type="position" data-value="1">
                        <div class="select-text">Left</div>
                        <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                        <div class="dropdown-container dropdown-container-sort" data-type="position">
                            <div class="dropdown-item" data-value="1">Left</div>
                            <div class="dropdown-item" data-value="2">Right</div>
                            <div class="dropdown-item" data-value="3">Inline Center</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="add-itinerary-image-count" value="0" />
                <div class="form-item">
                    <div class="form-label-inline">Image 1</div>
                    <div class="form-right">
                        <div class="upload-container">
                            <div class="upload-button">
                                <div class="upload-text">Choose Image</div>
                            </div>
                            <input type="file" class="input-upload itinerary-input-upload" name="input-image" accept="image/*" />
                        </div>
                        <img class="dialog-add-itinerary-image-preview image-preview image-preview-1" />
                        <div class="btn btn-negative btn-delete-itinerary-image">Delete Image</div>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-label-inline">Image 2</div>
                    <div class="form-right">
                        <div class="upload-container">
                            <div class="upload-button">
                                <div class="upload-text">Choose Image</div>
                            </div>
                            <input type="file" class="input-upload itinerary-input-upload" name="input-image" accept="image/*" />
                        </div>
                        <img class="dialog-add-itinerary-image-preview image-preview image-preview-2" />
                        <div class="btn btn-negative btn-delete-itinerary-image">Delete Image</div>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-label-inline">Image 3</div>
                    <div class="form-right">
                        <div class="upload-container">
                            <div class="upload-button">
                                <div class="upload-text">Choose Image</div>
                            </div>
                            <input type="file" class="input-upload itinerary-input-upload" name="input-image" accept="image/*" />
                        </div>
                        <img class="dialog-add-itinerary-image-preview image-preview image-preview-3" />
                        <div class="btn btn-negative btn-delete-itinerary-image">Delete Image</div>
                    </div>
                </div>
            </div>
            <div class="dialog-button-container">
                <div class="dialog-button btn btn-dialog-cancel">Cancel</div>
                <div class="dialog-button btn btn-dialog-save-itinerary">Add</div>
            </div>
        </div>
    </div>
</div>

<script>
var add_tour_highlight_url = "<?php echo base_url("admin/add_tour_highlight"); ?>";
var add_tour_bonus_url = "<?php echo base_url("admin/add_tour_bonus"); ?>";
</script>