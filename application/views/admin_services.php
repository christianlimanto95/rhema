<div class="section section-insert">
    <div class="section-title">Insert</div>
    <form class="form-insert-service" enctype="multipart/form-data" method="post" action="<?php echo base_url("admin/service_insert"); ?>">
        <div class="form-item">
            <div class="form-label-inline">Nama Service</div>
            <input type="text" name="ts_nama" class="form-input input-nama" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label-inline">Deskripsi</div>
            <textarea name="ts_keterangan" class="form-input input-deskripsi"></textarea>
        </div>
        <div class="form-item">
            <div class="form-label-inline">Gambar</div>
            <div class="form-right">
                <input type="hidden" name="ts_image" class="tour-group-image-input" value="" />
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
        <div class="btn btn-insert-service">Add Service</div>
    </form>
</div>
<div class="section section-update">
    <div class="section-title">List</div>
    <div class="tour-group-container">
        <?php
        $iLength = sizeof($data);
        for ($i = 0; $i < $iLength; $i++) {
            echo "<div class='tour-group-item' data-id='" . $data[$i]->ts_kode . "'>";
            echo "<div class='tour-group-item-image' style='background-image: url(" . base_url("assets/images/services/service_" . $data[$i]->ts_kode) . "." . $data[$i]->ts_image_extension . "?d=" . strtotime($data[$i]->modified_date) . ");'></div>";
            echo "<div class='tour-group-item-nama'>" . $data[$i]->ts_nama . "</div>";
            echo "<a class='btn btn-edit-tour-group-item' href='" . base_url("admin/service_detail/" . $data[$i]->ts_kode) . "'>Edit Service</a>";
            echo "<form class='form-delete-tour-group' method='post' action='" . base_url("admin/service_delete") . "'>";
            echo "<input type='hidden' name='ts_kode' value='" . $data[$i]->ts_kode . "' />";
            echo "<div class='btn btn-negative btn-delete-tour-group'>Delete</div>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
</div>