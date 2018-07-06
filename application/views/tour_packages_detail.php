<div class="section">
    <div class="dark-subheader" data-src="<?php echo base_url("assets/images/home_5.jpg"); ?>">
        <div class="dark-subheader-text">
            <div class="dark-subheader-title" data-anim="show-up"><?php echo strtoupper($tour_package->tg_nama); ?></div>
            <div class="dark-subheader-detail" data-anim="show-up"><?php echo $tour_package->tg_description; ?></div>
        </div>
    </div>
    <div class="tour-detail">
        <div class="tour-detail-inner-container">
            <div class="tour-detail-col">
                <div class="tour-detail-main" data-anim="show-up">
                    <div class="tour-detail-title"><?php echo $tour_package->tg_nama; ?></div>
                    <div class="tour-detail-location"><?php echo strtoupper($tour_package->tg_rute) . " (" . $tour_package->tg_durasi . " days)"; ?></div>
                    <div class="tour-detail-price"><?php echo strtoupper($tour_package->tgha_kurs) . " " . number_format($tour_package->tgha_harga, 0, ".", ","); ?></div>
                </div>
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
            if (trim($tour_package->tg_cicilan) != "") {
                echo "<div class='cicilan' data-anim='show-up'><pre><span class='cicilan-title'>INFORMASI CICILAN</span> : <br />" . $tour_package->tg_cicilan . "</pre></div>";
            }

            if (trim($tour_package->tg_contactPersonHP1) != "") {
                $phone = $tour_package->tg_contactPersonHP1;
                if (substr($phone, 0, 1) == "0") {
                    $phone = "62" . substr($phone, 1);
                }
                echo "<div class='contact-person contact-person-1' data-anim='show-up'>" . $tour_package->tg_contactPersonNama1 . " - <a target='_blank' href='https://api.whatsapp.com/send?phone=" . $phone . "'>" . $tour_package->tg_contactPersonHP1 . "</a></div>";
            }

            if (trim($tour_package->tg_contactPersonHP2) != "") {
                $phone = $tour_package->tg_contactPersonHP2;
                if (substr($phone, 0, 1) == "0") {
                    $phone = "62" . substr($phone, 1);
                }
                echo "<div class='contact-person' data-anim='show-up'>" . $tour_package->tg_contactPersonNama2 . " - <a target='_blank' href='https://api.whatsapp.com/send?phone=" . $phone . "'>" . $tour_package->tg_contactPersonHP2 . "</a></div>";
            }
            ?>
            <a href="<?php echo base_url("register-tour/form/" . $tour_package->tg_kode . $tpd_kode_get); ?>" class="button-invers btn-register-tour" data-anim="show-up">
                <div class="button-left"></div>
                <div class="button-right"></div>
                <div class="button-text">Register</div>
            </a>
        </div>
    </div>
    <div class="tour-detail-dates">
        <div class="tour-detail-dates-title" data-anim="show-up" data-anim-threshold="self">Date Options</div>
        <?php
        $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        if ($tour_package->tg_tglStarts != "") {
            $tg_tglStart = explode(",", $tour_package->tg_tglStarts);
            $tg_tglEnd = explode(",", $tour_package->tg_tglEnds);
            $iLength = sizeof($tg_tglStart);
            for ($i = 0; $i < $iLength; $i++) {
                $date_item = explode("-", $tg_tglStart[$i]);
                $month = intval($date_item[1]);
                $tg_tglStart[$i] = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

                $date_item = explode("-", $tg_tglEnd[$i]);
                $month = intval($date_item[1]);
                $tg_tglEnd[$i] = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

                echo "<div class='tour-detail-date' data-anim='show-up' data-anim-threshold='self'>" . $tg_tglStart[$i] . " - " . $tg_tglEnd[$i] . "</div>";
            }
        }
        ?>
    </div>
    <div class="itinerary-container">
        <?php
            $iLength = sizeof($tgi);
            for ($i = 0; $i < $iLength; $i++) {                
                echo "<div class='itinerary'>";
                echo "<div class='itinerary-text' data-anim='show-up' data-anim-threshold='self'>";
                echo "<div class='itinerary-time-place'>HARI " . $tgi[$i]->tgi_hari . "</div>";
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
    <div class="join-container">
        <div class="join-text" data-anim="show-up" data-anim-threshold="self">WOULD YOU <strong>JOIN THE TOUR?</strong></div>
        <a href="<?php echo base_url("register-tour/form/" . $tour_package->tg_kode . $tpd_kode_get); ?>" class="button btn-register" data-anim="show-up" data-anim-threshold="self">
            <div class="button-left"></div>
            <div class="button-right"></div>
            <div class="button-text">Register</div>
        </a>
    </div>
</div>