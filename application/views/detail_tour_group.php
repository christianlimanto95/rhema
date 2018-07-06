<div class="section">
    <div class="section-title" data-anim="show-up"><strong>DETAIL</strong> TOUR GROUP</div>
    <div class="tour-detail">
        <div class="tour-detail-image" data-anim="show-up" data-src="<?php echo base_url("assets/images/tour_groups/tour_groups_" . $tour_group->tg_kode . "." . $tour_group->tg_image_extension . "?d=" . strtotime($tour_group->modified_date)); ?>"></div>
        <div class="tour-detail-text">
            <div class="tour-detail-main">
                <div class="tour-detail-title" data-anim="show-up"><?php echo $tour_group->tg_nama; ?></div>
                <div class="tour-detail-date" data-anim="show-up"><?php echo $tour_group->tg_tglStart . " - " . $tour_group->tg_tglEnd; ?></div>
                <div class="tour-detail-location" data-anim="show-up"><?php echo $tour_group->tg_rute; ?></div>
                <div class="tour-detail-price" data-anim="show-up"><?php echo strtoupper($tour_group->tgha_kurs) . " " . number_format($tour_group->tgha_harga, 0, ".", ","); ?></div>
            </div>
            <div class="tour-detail-col">
                <div class="hightlight-description" data-anim="show-up">
                    <pre>HIGHLIGHT :
<?php
$iLength = sizeof($tghi);
for ($i = 0; $i < $iLength; $i++) {
    echo "- " . $tghi[$i]->thi_nama . "\n";
}
?></pre>
                </div>
            </div>
            <div class="tour-detail-col">
                <div class="bonus-description" data-anim="show-up">
                    <pre>BONUS :
<?php
$iLength = sizeof($tgb);
for ($i = 0; $i < $iLength; $i++) {
    echo "- " . $tgb[$i]->tb_nama . "\n";
}
?></pre>
                </div>
            </div>
            <?php
            if (trim($tour_group->tg_cicilan) != "") {
                echo "<div class='cicilan' data-anim='show-up'><pre><span class='cicilan-title'>INFORMASI CICILAN</span> : <br />" . $tour_group->tg_cicilan . "</pre></div>";
            }

            if (trim($tour_group->tg_contactPersonHP1) != "") {
                $phone = $tour_group->tg_contactPersonHP1;
                if (substr($phone, 0, 1) == "0") {
                    $phone = "62" . substr($phone, 1);
                }
                echo "<div class='contact-person' data-anim='show-up'>" . $tour_group->tg_contactPersonNama1 . " - <a target='_blank' href='https://api.whatsapp.com/send?phone=" . $phone . "'>" . $tour_group->tg_contactPersonHP1 . "</a></div>";
            }

            if (trim($tour_group->tg_contactPersonHP2) != "") {
                $phone = $tour_group->tg_contactPersonHP2;
                if (substr($phone, 0, 1) == "0") {
                    $phone = "62" . substr($phone, 1);
                }
                echo "<div class='contact-person' data-anim='show-up'>" . $tour_group->tg_contactPersonNama2 . " - <a target='_blank' href='https://api.whatsapp.com/send?phone=" . $phone . "'>" . $tour_group->tg_contactPersonHP2 . "</a></div>";
            }
            ?>
            <a href="<?php echo base_url("register-tour/form/" . $tour_group->tg_kode); ?>" class="button-invers btn-register-head" data-anim="show-up">
                <div class="button-left"></div>
                <div class="button-right"></div>
                <div class="button-text">Register</div>
            </a>
        </div>
    </div>
    <div class="itinerary-container">
        <div class="itinerary-container-title" data-anim="show-up" data-anim-threshold="self">ITINERARY</div>
        <?php
            $iLength = sizeof($tgi);
            for ($i = 0; $i < $iLength; $i++) {                
                echo "<div class='itinerary'>";
                echo "<div class='itinerary-text' data-anim='show-up' data-anim-threshold='self'>";
                echo "<div class='itinerary-time-place'>HARI " . ($i + 1) . ", " . strtoupper($tgi[$i]->day) . " " . strtoupper($tgi[$i]->tgi_tanggal) . "</div>";
                echo "<div class='itinerary-description'><pre>" . $tgi[$i]->tgi_remarks . "</pre></div>";
                echo "</div>";
                if ($tgi[$i]->tgi_image_position == 3) {
                    echo "<div class='itinerary-image-container-inline'>";
                    if ($tgi[$i]->tgi_image_1_extension != "" && $tgi[$i]->tgi_image_count >= 1) {
                        echo "<div class='image-container'>";
                        echo "<img class='itinerary-image' data-anim='show-up' data-anim-threshold='self' src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_1." . $tgi[$i]->tgi_image_1_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' data-src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_1." . $tgi[$i]->tgi_image_1_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' />";
                        echo "</div>";
                    }
                    if ($tgi[$i]->tgi_image_2_extension != "" && $tgi[$i]->tgi_image_count >= 2) {
                        echo "<div class='image-container'>";
                        echo "<img class='itinerary-image' data-anim='show-up' data-anim-threshold='self' src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_2." . $tgi[$i]->tgi_image_2_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' data-src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_2." . $tgi[$i]->tgi_image_2_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' />";
                        echo "</div>";
                    }
                    if ($tgi[$i]->tgi_image_3_extension != "" && $tgi[$i]->tgi_image_count >= 3) {
                        echo "<div class='image-container'>";
                        echo "<img class='itinerary-image' data-anim='show-up' data-anim-threshold='self' src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_3." . $tgi[$i]->tgi_image_3_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' data-src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_3." . $tgi[$i]->tgi_image_3_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' />";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    $data_side = "";
                    if ($tgi[$i]->tgi_image_position == 2) {
                        $data_side = " data-side='right'";
                    }
                    echo "<div class='itinerary-image-container-block'" . $data_side . ">";
                    if ($tgi[$i]->tgi_image_1_extension != "" && $tgi[$i]->tgi_image_count >= 1) {
                        echo "<div class='image-container-outer'>";
                        echo "<div class='image-container'>";
                        echo "<img class='itinerary-image' data-anim='show-up' data-anim-threshold='self' src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_1." . $tgi[$i]->tgi_image_1_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' data-src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_1." . $tgi[$i]->tgi_image_1_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' />";
                        echo "</div>";
                        echo "</div>";
                    }
                    if ($tgi[$i]->tgi_image_2_extension != "" && $tgi[$i]->tgi_image_count >= 2) {
                        echo "<div class='image-container-outer'>";
                        echo "<div class='image-container'>";
                        echo "<img class='itinerary-image' data-anim='show-up' data-anim-threshold='self' src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_2." . $tgi[$i]->tgi_image_2_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' data-src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_2." . $tgi[$i]->tgi_image_2_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' />";
                        echo "</div>";
                        echo "</div>";
                    }
                    if ($tgi[$i]->tgi_image_3_extension != "" && $tgi[$i]->tgi_image_count >= 3) {
                        echo "<div class='image-container-outer'>";
                        echo "<div class='image-container'>";
                        echo "<img class='itinerary-image' data-anim='show-up' data-anim-threshold='self' src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_3." . $tgi[$i]->tgi_image_3_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' data-src='" . base_url("assets/images/tour_groups/itinerary_image_" . $tgi[$i]->tgi_kode . "_3." . $tgi[$i]->tgi_image_3_extension . "?d=" . strtotime($tgi[$i]->modified_date)) . "' />";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
                echo "</div>";
            }
        ?>
    </div>
    <div class="tour-information">
        <div class="tour-information-title" data-anim="show-up" data-anim-threshold="self">TOUR <strong>INFORMATION</strong></div>
        <div class="tour-information-detail-container" data-anim="show-up" data-anim-threshold="self">
            <div class="tour-information-subtitle"><strong>INCLUDE PAX</strong></div>
            <pre><?php
            echo $tour_group->tg_include_pax;
            ?></pre>
        </div>
        <div class="tour-information-detail-container" data-anim="show-up" data-anim-threshold="self">
            <div class="tour-information-subtitle"><strong>EXCLUDE PAX</strong></div>
            <pre><?php
            echo $tour_group->tg_exclude_pax;
            ?></pre>
        </div>
        <div class="tour-information-detail-container" data-anim="show-up" data-anim-threshold="self">
            <div class="tour-information-subtitle"><strong>RESPONSIBILITY</strong></div>
            <pre><?php
            echo $tour_group->tg_responsibility;
            ?></pre>
        </div>
        <div class="tour-information-detail-container" data-anim="show-up" data-anim-threshold="self">
            <div class="tour-information-subtitle"><strong>TERMS & CONDITIONS</strong></div>
            <pre><?php
            echo $tour_group->tg_tnc;
            ?></pre>
        </div>
    </div>
    <div class="join-container">
        <div class="join-text" data-anim="show-up" data-anim-threshold="self">WOULD YOU <strong>JOIN THE TOUR?</strong></div>
        <a href="<?php echo base_url("register-tour/form/" . $tour_group->tg_kode); ?>" class="button btn-register" data-anim="show-up" data-anim-threshold="self">
            <div class="button-left"></div>
            <div class="button-right"></div>
            <div class="button-text">Register</div>
        </a>
    </div>
</div>