<?php
$selected_tour_highlight_kode = explode(",", $data->thi_kode);
$selected_tour_bonus_kode = explode(",", $data->tb_kode);

$tour_highlight_value = "";
$iLength = sizeof($selected_tour_highlight_kode);
for ($i = 0; $i < $iLength; $i++) {
    if ($tour_highlight_value != "") {
        $tour_highlight_value .= ";";
    }
    $tour_highlight_value .= $selected_tour_highlight_kode[$i];
}

$tour_bonus_value = "";
$iLength = sizeof($selected_tour_bonus_kode);
for ($i = 0; $i < $iLength; $i++) {
    if ($tour_bonus_value != "") {
        $tour_bonus_value .= ";";
    }
    $tour_bonus_value .= $selected_tour_bonus_kode[$i];
}
?>
<div class="section">
    <form class="form-update" enctype="multipart/form-data" method="post" action="<?php echo base_url("admin/tour_group_update"); ?>">
        <input type="hidden" name="tg_kode" value="<?php echo $data->tg_kode; ?>" />
        <div class="form-item form-item-jenis-tour">
            <div class="form-label-inline">Jenis Tour</div>
            <div class="select select-jenis-tour" data-type="jenis-tour" data-value="<?php echo $data->tg_jenis_tour; ?>">
                <input type="hidden" class="input-jenis-tour" name="tg_jenis_tour" value="<?php echo $data->tg_jenis_tour; ?>" />
                <div class="select-text"><?php echo ($data->tg_jenis_tour == 1) ? "Pilgrimage" : "Leisure"; ?></div>
                <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                <div class="dropdown-container dropdown-container-jenis-tour" data-type="jenis-tour">
                    <div class="dropdown-item" data-value="1">Pilgrimage</div>
                    <div class="dropdown-item" data-value="2">Leisure</div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Judul</div>
            <input type="text" name="tour_group_nama" class="form-input input-judul" maxlength="200" value="<?php echo $data->tg_nama; ?>" />
        </div>
        <div class="form-item-inline">
            <div class="form-label-inline">Mulai Tanggal</div>
            <input type="text" name="date_start" data-type="date" class="form-input input-date-start" maxlength="10" value="<?php echo $data->tg_tglStart; ?>" />
        </div>
        <div class="form-item-inline">
            <div class="form-label-inline">Sampai Tanggal</div>
            <input type="text" name="date_end" data-type="date" class="form-input input-date-end" maxlength="10" value="<?php echo $data->tg_tglEnd; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Rute</div>
            <input type="text" name="rute" class="form-input input-rute" maxlength="250" value="<?php echo $data->tg_rute; ?>" />
        </div>
        <div class="form-item form-item-harga">
            <div class="form-label-inline">Harga</div>
            <div class="form-right">
                <input type="hidden" name="harga_count" value="<?php echo sizeof($harga); ?>" />
                <div class="harga-container">
                    <?php
                    $iLength = sizeof($harga);
                    for ($i = 1; $i <= $iLength; $i++) {
                        echo "<div class='harga-item'>";
                        echo "<input type='text' name='harga_" . $i . "' class='form-input input-harga' data-type='number' data-thousand-separator='true' maxlength='15' value='" . $harga[$i - 1]->tgha_harga . "' />";
                        echo " <div class='select select-kurs' data-type='kurs' data-value='usd'>";
                        $kurs = $harga[$i - 1]->tgha_kurs;
                        echo "<input type='hidden' class='kurs-value' name='kurs_" . $i . "' value='" . $kurs . "' />";
                        echo "<div class='select-text'>" . strtoupper($kurs) . "</div>";
                        echo "<div class='dropdown-container dropdown-container-kurs' data-type='kurs'>";
                        echo "<div class='dropdown-item' data-value='usd'>USD</div>";
                        echo "<div class='dropdown-item' data-value='idr'>IDR</div>";
                        echo "</div>";
                        echo "</div>";
                        echo " <input type='text' name='harga_remarks_" . $i . "' class='form-input input-harga-remarks' maxlength='25' value='" .  $harga[$i - 1]->tgha_remarks. "' />";
                        if ($i > 1) {
                            echo " <div class='btn btn-negative btn-delete-harga'>Delete</div>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
                <div class="btn btn-add-harga">Add Harga</div>
            </div>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Informasi Cicilan</div>
            <textarea name="tg_cicilan" class="form-input input-cicilan" ><?php echo $data->tg_cicilan; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Pembimbing</div>
            <input type="text" name="pembimbing" class="form-input input-pembimbing" maxlength="120" value="<?php echo $data->tg_pembimbing; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Gambar</div>
            <?php
            $imageAdded = "";
            $src = "";
            if ($data->tg_image_extension != "") {
                $imageAdded = " image-added";
                $src = "src='" . base_url("assets/images/tour_groups/tour_groups_" . $data->tg_kode . "." . $data->tg_image_extension . "?d=" . strtotime($data->modified_date)) . "'";
            }
            ?>
            <div class="form-right<?php echo $imageAdded; ?>">
                <input type="hidden" name="tour_group_image" class="tour-group-image-input" value="" />
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
        <div class="form-item form-item-tour-highlight">
            <div class="form-label-inline">Tour Highlight</div>
            <div class="form-input-right">
                <input type="hidden" name="tour_highlight" value="<?php echo $tour_highlight_value; ?>" />
                <div class="checkbox-outer-container">
                    <?php
                    $iLength = sizeof($tour_highlight);
                    for ($i = 0; $i < $iLength; $i++) {
                        $active = "";
                        $index = array_search($tour_highlight[$i]->thi_kode, $selected_tour_highlight_kode);
                        if ($index !== false) {
                            $active = " active";
                        }
                        echo "<div class='checkbox-container highlight-checkbox-container" . $active . "' data-name='highlight' data-value='" . $tour_highlight[$i]->thi_kode . "'>";
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
                <input type="hidden" name="tour_bonus" value="<?php echo $tour_bonus_value; ?>" />
                <div class="checkbox-outer-container">
                    <?php
                    $iLength = sizeof($tour_bonus);
                    for ($i = 0; $i < $iLength; $i++) {
                        $active = "";
                        $index = array_search($tour_bonus[$i]->tb_kode, $selected_tour_bonus_kode);
                        if ($index !== false) {
                            $active = " active";
                        }
                        echo "<div class='checkbox-container bonus-checkbox-container" . $active . "' data-name='bonus' data-value='" . $tour_bonus[$i]->tb_kode . "'>";
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
            <textarea name="include_pax" class="form-input input-include-pax" ><?php echo $data->tg_include_pax; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Exclude Pax</div>
            <textarea name="exclude_pax" class="form-input input-exclude-pax" ><?php echo $data->tg_exclude_pax; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Responsibility</div>
            <textarea name="responsibility" class="form-input input-responsibility" ><?php echo $data->tg_responsibility; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Terms &amp; Conditions</div>
            <textarea name="tnc" class="form-input input-tnc"><?php echo $data->tg_tnc; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Nama CP 1</div>
            <input type="text" name="cp_name_1" class="form-input input-cp-name-1" maxlength="120" value="<?php echo $data->tg_contactPersonNama1; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">No. Handphone CP 1</div>
            <input type="text" name="cp_hp_1" class="form-input input-cp-hp-1" data-type="number" maxlength="20" value="<?php echo $data->tg_contactPersonHP1; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Email CP 1</div>
            <input type="text" name="cp_email_1" class="form-input input-cp-email-1" maxlength="100" value="<?php echo $data->tg_contactPersonEmail1; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Nama CP 2</div>
            <input type="text" name="cp_name_2" class="form-input input-cp-name-2" maxlength="120" value="<?php echo $data->tg_contactPersonNama2; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">No. Handphone CP 2</div>
            <input type="text" name="cp_hp_2" class="form-input input-cp-hp-2" data-type="number" maxlength="20" value="<?php echo $data->tg_contactPersonHP2; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Email CP 2</div>
            <input type="text" name="cp_email_2" class="form-input input-cp-email-2" maxlength="100" value="<?php echo $data->tg_contactPersonEmail2; ?>" />
        </div>
        <div class="btn btn-update-tour-group">Simpan Perubahan</div>
    </form>
    <div class="form-item form-item-itinerary">
        <div class="form-label-inline">Itinerary</div>
        <div class="form-right">
            <div class="itinerary-container">
                <?php
                $iLength = sizeof($itinerary);
                for ($i = 0; $i < $iLength; $i++) {
                    echo "<div class='itinerary-item' data-id='" . $itinerary[$i]->tgi_kode . "'>";
                    echo "<div class='itinerary-item-text'>" . $itinerary[$i]->day . ", " . $itinerary[$i]->tgi_tanggal . "</div>";
                    echo "<div class='btn btn-edit-itinerary'>View / Edit Itinerary</div>";
                    echo "<form class='form-delete-itinerary' method='post' action='" . base_url("admin/itinerary_delete") . "'>";
                    echo "<input type='hidden' name='source' value='tour_group' />";
                    echo "<input type='hidden' name='tg_kode' value='" . $data->tg_kode . "' />";
                    echo "<input type='hidden' name='tgi_kode' value='" . $itinerary[$i]->tgi_kode . "' />";
                    echo "<div class='btn btn-negative btn-delete-itinerary'>Delete Itinerary</div>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="btn btn-add-itinerary">Add New Itinerary</div>
        </div>
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
                <form class="form-insert-itinerary" method="post" action="<?php echo base_url("admin/itinerary_insert"); ?>">
                    <input type="hidden" name="source" value="tour_group" />
                    <input type="hidden" name="tg_kode" value="<?php echo $data->tg_kode; ?>" />
                    <input type="hidden" name="tgi_kode" value="" />
                    <div class="form-item">
                        <div class="form-label-inline">Date</div>
                        <input type="text" name='itinerary_date' class="form-input input-add-itinerary-date" />
                    </div>
                    <div class="form-item">
                        <div class="form-label-inline">Place</div>
                        <input type="text" name="itinerary_place" class="form-input input-add-itinerary-place" maxlength="100" />
                    </div>
                    <div class="form-item">
                        <div class="form-label-inline">Remarks</div>
                        <textarea name="itinerary_remarks" class="form-input input-add-itinerary-remarks" ></textarea>  
                    </div>
                    <div class="form-item form-item-image-position">
                        <div class="form-label-inline">Image Position</div>
                        <div class="select select-position" data-type="position" data-value="1">
                            <input type="hidden" class="input-image-position" name="itinerary_image_position" value="1" />
                            <div class="select-text">Left</div>
                            <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                            <div class="dropdown-container dropdown-container-sort" data-type="position">
                                <div class="dropdown-item" data-value="1">Left</div>
                                <div class="dropdown-item" data-value="2">Right</div>
                                <div class="dropdown-item" data-value="3">Inline Center</div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="itinerary_image_count" class="add-itinerary-image-count" value="0" />
                    <div class="form-item">
                        <div class="form-label-inline">Image 1</div>
                        <div class="form-right">
                            <input type="hidden" name="itinerary_image_1" class="itinerary-image" />
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
                            <input type="hidden" name="itinerary_image_2" class="itinerary-image" />
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
                            <input type="hidden" name="itinerary_image_3" class="itinerary-image" />
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
                </form>
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
<?php
echo "var insert_itinerary_url = '" . base_url("admin/itinerary_insert") . "'; ";
echo "var update_itinerary_url = '" . base_url("admin/itinerary_update") . "'; ";
echo "var itinerary_image_src = '" . base_url("assets/images/tour_groups/") . "'; ";
$iLength = sizeof($itinerary);
echo "var itinerary_arr = [";
for ($i = 0; $i < $iLength; $i++) {
    if ($i > 0) {
        echo ", ";
    }
    echo "{
        id: '" . $itinerary[$i]->tgi_kode . "',
        date: '" . $itinerary[$i]->tgi_tanggal . "',
        place: '" . $itinerary[$i]->tgi_place . "',
        remarks: " . '"' . str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br />", $itinerary[$i]->tgi_remarks) . '"' . ".replace(/<br\s*\/?>/mg, " . '"\n"' . "),
        image_1_extension: '" . $itinerary[$i]->tgi_image_1_extension . "',
        image_2_extension: '" . $itinerary[$i]->tgi_image_2_extension . "',
        image_3_extension: '" . $itinerary[$i]->tgi_image_3_extension . "',
        image_count: '" . $itinerary[$i]->tgi_image_count . "',
        image_position: '" . $itinerary[$i]->tgi_image_position . "',
        modified_date: '" . strtotime($itinerary[$i]->modified_date) . "'
    }";
}
echo "];";
?>
</script>