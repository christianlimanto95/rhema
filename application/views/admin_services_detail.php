<div class="section">
    <form class="form-update" method="post" action="<?php echo base_url("admin/service_update"); ?>">
        <input type="hidden" name="ts_kode" value="<?php echo $data->ts_kode; ?>" />
        <div class="form-item">
            <div class="form-label-inline">Nama Service</div>
            <input type="text" name="ts_nama" class="form-input input-nama" maxlength="100" value="<?php echo $data->ts_nama; ?>" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Deskripsi</div>
            <textarea name="ts_keterangan" class="form-input input-deskripsi"><?php echo $data->ts_keterangan; ?></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Gambar</div>
            <?php
            $imageAdded = "";
            $src = "";
            if ($data->ts_image_extension != "") {
                $imageAdded = " image-added";
                $src = "src='" . base_url("assets/images/services/service_" . $data->ts_kode . "." . $data->ts_image_extension . "?d=" . strtotime($data->modified_date)) . "'";
            }
            ?>
            <div class="form-right<?php echo $imageAdded; ?>">
                <input type="hidden" name="ts_image" class="tour-group-image-input" value="" />
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
        <div class="btn btn-update">Simpan Perubahan</div>
    </form>
</div>