<div class="section">
    <div class="dark-subheader" data-src="<?php echo base_url("assets/images/home_5.jpg"); ?>">
        <div class="dark-subheader-text">
            <div class="dark-subheader-title" data-anim="show-up">TOUR <strong>PACKAGES</strong></div>
            <div class="dark-subheader-detail" data-anim="show-up">Mari menikmati perjalanan dengan series perjalanan tour kami.</div>
        </div>
    </div>
    <div class="tour-package-container">
        <?php
        $iLength = sizeof($data);
        for ($i = 0; $i < $iLength; $i++) {
            $url_name = strtolower(str_replace(" ", "-", str_replace("-", "", str_replace("+", "", $data[$i]->tg_nama))));
            $href = base_url("tour-packages/detail/" . $url_name . "-" . $data[$i]->tg_kode);
            
            echo "<a href='" . $href . "' class='tour-package-item' data-src='" . base_url("assets/images/tour_groups/tour_groups_" . $data[$i]->tg_kode . "." . $data[$i]->tg_image_extension . "?d=" . strtotime($data[$i]->modified_date)) . "' data-anim='show-up' data-anim-threshold='self'>";
            echo "<div class='tour-package-item-text'>";
            echo "<div class='tour-package-item-name'>" . $data[$i]->tg_nama . "</div>";
            echo "<div class='tour-package-item-view'>View Group</div>";
            echo "</div>";
            echo "</a>";
        }
        ?>
    </div>
</div>