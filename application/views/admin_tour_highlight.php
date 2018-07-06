<div class="section">
    <div class="section-title">Insert</div>
    <form class="form-insert" method="post" action="<?php echo base_url("admin/tour_highlight_insert"); ?>">
        <div class="form-item">
            <div class="form-label">Name <span class="error error-insert-name"></span></div>
            <input type="text" class="form-input input-insert-name" name="thi_nama" />
        </div>
        <div class="btn btn-insert">Insert</div>
    </form>
</div>
<div class="section">
    <div class="section-title">List</div>
    <div class="item-container">
        <?php
        $iLength = sizeof($data);
        for ($i = 0; $i < $iLength; $i++) {
            echo "<div class='item' data-id='" . $data[$i]->thi_kode . "' data-nama='" . $data[$i]->thi_nama . "'>";
            echo "<div class='item-name'>" . $data[$i]->thi_nama . "</div>";
            echo "<div class='btn btn-update'>Edit</div>";
            echo "<div class='btn btn-negative btn-delete'>Delete</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<div class="dialog dialog-update">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <div class="dialog-title">Edit</div>
            <div class="dialog-text">
                <form method="post" class="form-update" action="<?php echo base_url("admin/tour_highlight_update"); ?>">
                    <input type="hidden" class="dialog-update-id" name="thi_kode" value="" />
                    <div class="form-item">
                        <span class="dialog-text-left form-label-inline">Name : </span><input type="text" class="dialog-text-right input-name-update form-input" name="thi_nama" maxlength="50"></span>
                    </div>
                </form>
            </div>
            <div class="dialog-button-container">
                <div class="dialog-button btn btn-dialog-cancel">Cancel</div>
                <div class="dialog-button btn btn-dialog-save">Save</div>
            </div>
        </div>
    </div>
</div>

<div class="dialog dialog-delete">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <div class="dialog-title">Delete</div>
            <form method="post" class="form-delete" action="<?php echo base_url("admin/tour_highlight_delete"); ?>">
                <input type="hidden" class="dialog-delete-id" name="thi_kode" value="" />
            </form>
            <div class="dialog-text">                
            </div>
            <div class="dialog-button-container">
                <div class="dialog-button btn btn-dialog-cancel">Cancel</div>
                <div class="dialog-button btn btn-dialog-delete">Delete</div>
            </div>
        </div>
    </div>
</div>