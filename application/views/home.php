<div class="header">
    <a href="<?php echo base_url(); ?>" class="logo" style="background-image: url(<?php echo base_url("assets/icons/logo_white.png"); ?>);"></a>
    <div class="header-menu-container">
        <a href="<?php echo base_url(""); ?>" class="header-menu active" >HOME</a>
        <a href="<?php echo base_url("register-tour"); ?>" class="header-menu" >REGISTER TOUR</a>
        <a href="<?php echo base_url("services"); ?>" class="header-menu" >SERVICES</a>
        <a href="<?php echo base_url("tour_packages"); ?>" class="header-menu" >TOUR PACKAGES</a>
        <a href="<?php echo base_url("article"); ?>" class="header-menu" >ARTICLE</a>
        <a href="<?php echo base_url("about"); ?>" class="header-menu" >ABOUT</a>
        <a href="<?php echo base_url("contact"); ?>" class="header-menu" >CONTACT US</a>
    </div>
</div>
<div class="section section-1">
    <?php
    $iLength = sizeof($carousel);
    for ($i = 0; $i < $iLength; $i++) {
        $zoom_out = "";
        if ($carousel[$i]->carousel_zoom_out == 1) {
            $zoom_out = " zoom-out";
        }
        echo "<div class='section-1-item active' data-index='" . ($i + 1) . "'>";
        echo "<div class='section-1-image-container image-container'>";
        echo "<img class='section-1-image" . $zoom_out . "' src='" . base_url("assets/images/home_1_" . $carousel[$i]->carousel_id . "." . $carousel[$i]->carousel_image_extension . "?d=" . strtotime($carousel[$i]->modified_date)) . "'data-src='" . base_url("assets/images/home_1_" . $carousel[$i]->carousel_id . "." . $carousel[$i]->carousel_image_extension . "?d=" . strtotime($carousel[$i]->modified_date)) . "' />";
        if ($carousel[$i]->carousel_image_mobile_extension != "") {
            echo "<img class='section-1-image-mobile" . $zoom_out . "' src='" . base_url("assets/images/home_1_" . $carousel[$i]->carousel_id . "_mobile." . $carousel[$i]->carousel_image_mobile_extension . "?d=" . strtotime($carousel[$i]->modified_date)) . "'data-src='" . base_url("assets/images/home_1_" . $carousel[$i]->carousel_id . "." . $carousel[$i]->carousel_image_mobile_extension . "?d=" . strtotime($carousel[$i]->modified_date)) . "' />";
        } else {
            echo "<img class='section-1-image-mobile" . $zoom_out . "' src='" . base_url("assets/images/home_1_" . $carousel[$i]->carousel_id . "." . $carousel[$i]->carousel_image_extension . "?d=" . strtotime($carousel[$i]->modified_date)) . "'data-src='" . base_url("assets/images/home_1_" . $carousel[$i]->carousel_id . "." . $carousel[$i]->carousel_image_extension . "?d=" . strtotime($carousel[$i]->modified_date)) . "' />";
        }
        echo "</div>";
        echo "<div class='section-1-center'>";
        $title_class = "section-1-title";
        $description_class = "section-1-description";
        $button_class = "";
        if ($carousel[$i]->carousel_text_position == 3) {
            $title_class = "section-1-title-right";
            $description_class = "section-1-description-right";
            $button_class = " section-1-button-right";
        }

        if (trim($carousel[$i]->carousel_title) != "") {
            $title_color = "#002157";
            if ($carousel[$i]->carousel_title_color == "white") {
                $title_color = "white";
            }

            echo "<div class='" . $title_class . "'>";
            echo "<div class='data-anim='show-up' data-anim-index='" . ($i + 1) . "' style='color: " . $title_color . ";'>" . nl2br($carousel[$i]->carousel_title) . "</div>";
            echo "</div>";
        }

        if (trim($carousel[$i]->carousel_description) != "") {
            $description_color = "#002157";
            if ($carousel[$i]->carousel_description_color == "white") {
                $description_color = "white";
            }

            echo "<div class='" . $description_class . "' data-anim='show-up' data-anim-index='" . ($i + 1) . "' style='color: " . $description_color . ";'>" . $carousel[$i]->carousel_description . "</div>";
        }

        if ($carousel[$i]->carousel_button_text != "") {
            $button_invers = "";
            if ($carousel[$i]->carousel_button_color == "dark_blue" || $carousel[$i]->carousel_button_color == "white") {
                $button_invers = " button-invers";
            }
            echo "<a href='" . base_url($carousel[$i]->carousel_button_link) . "' class='section-1-button" . $button_class . $button_invers . " button' data-color='" . $carousel[$i]->carousel_button_color . "' data-anim='show-up' data-anim-index='" . ($i + 1) . "'>";
            echo "<div class='button-left'></div>";
            echo "<div class='button-right'></div>";
            echo "<div class='section-1-button-text button-text'>" . $carousel[$i]->carousel_button_text . "</div>";
            echo "</a>";
        }

        echo "</div>";
        echo "</div>";
    }
    ?>
    <div class="carousel-circle-container">
        <?php
        $iLength = sizeof($carousel);
        if ($iLength > 1) {
            for ($i = 0; $i < $iLength; $i++) {
                echo "<svg class='carousel-circle' data-index='" . ($i + 1) . "' width='100' height='100' viewBox='0 0 100 100'>";
                echo "<circle cx='50' cy='50' r='44' fill='#002157' stroke='white' stroke-width='8' />";
                echo "</svg> ";
            }
        }
        ?>
    </div>
    <div class="section-1-scroll-down-container">
        <div class="section-1-scroll-down" style="background-image: url(<?php echo base_url("assets/icons/scroll.png"); ?>);"></div>
    </div>
    <?php
    if (sizeof($carousel) > 1) { ?>
    <div class="section-1-item-left">
        <div class="section-1-item-left-image" style="background-image: url(<?php echo base_url("assets/icons/ic_keyboard_arrow_left_white_48px.svg"); ?>);"></div>
    </div>
    <div class="section-1-item-right">
        <div class="section-1-item-right-image" style="background-image: url(<?php echo base_url("assets/icons/ic_keyboard_arrow_right_white_48px.svg"); ?>);"></div>
    </div>
    <?php } ?>
</div>
<div class="section section-2">
    <div class="section-2-background" style="background-image: url(<?php echo base_url("assets/images/home_2.png"); ?>);"></div>
    <div class="section-2-triangle-right"></div>
    <div class="section-2-triangle-left"></div>
    <div class="section-2-triangle-left-2" data-desktop-top="21"></div>
    <div class="section-2-triangle-right-2" data-desktop-top="35"></div>
    <svg class="svg-triangle svg-triangle-border svg-triangle-border-1" data-real-width="100" data-real-height="110" data-desktop-top="34" width="100" height="110" viewBox="0 0 200 200">
        <polygon points="4,4 176,100 4,196" stroke-width="8" stroke="#002157" fill="transparent" />
    </svg>
    <svg class="svg-triangle svg-triangle-border svg-triangle-border-2" data-desktop-top="16" data-real-width="180" data-real-height="200" width="180" height="200" viewBox="0 0 200 200">
        <polygon points="4,4 176,100 4,196" stroke-width="4" stroke="#002157" fill="transparent" />
    </svg>
    <svg class="svg-triangle svg-triangle-border svg-triangle-border-3" data-desktop-top="13" data-real-width="100" data-real-height="110" width="100" height="110" viewBox="0 0 200 200">
        <polygon points="176,4 4,100 176,196" stroke-width="8" stroke="#002157" fill="transparent" />
    </svg>
    <svg class="svg-triangle svg-triangle-border svg-triangle-border-4" data-desktop-top="28" data-real-width="180" data-real-height="200" width="180" height="200" viewBox="0 0 200 200">
        <polygon points="176,4 4,100 176,196" stroke-width="4" stroke="#002157" fill="transparent" />
    </svg>
    <svg class="svg-triangle svg-triangle-1" data-desktop-top="10" data-real-width="270" data-real-height="300" width="270" height="300" viewBox="0 0 200 200">
        <defs>
            <pattern id="img1" patternUnits="userSpaceOnUse" width="200" height="200">
                <image xlink:href="<?php echo base_url("assets/images/home_3.jpg"); ?>" x="-50" y="-70" width="400" height="400" />
            </pattern>
        </defs>
        <polygon points="0,0 180,100 0,200" fill="url(#img1)" />
    </svg>
    <svg class="svg-triangle svg-triangle-2" data-desktop-top="21" data-real-width="270" data-real-height="300" width="270" height="300" viewBox="0 0 200 200">
        <defs>
            <pattern id="img2" patternUnits="userSpaceOnUse" width="200" height="200">
                <image xlink:href="<?php echo base_url("assets/images/home_4.jpg"); ?>" x="-140" y="-110" width="420" height="420" />
            </pattern>
        </defs>
        <polygon points="0,100 180,0 180,200" fill="url(#img2)" />
    </svg>
    <div class="section-2-text">
        <div class="section-2-title" data-anim="show-up" data-anim-threshold="self"><div><strong>LIFE CHANGING</strong> TRIP <br />TO <strong>THE HOLYLAND</strong></div></div>
        <div class="section-2-line"></div>
        <div class="section-2-description" data-anim="show-up" data-anim-threshold="self">Selagi kesempatan kita terbuka untuk mengunjungi Israel kenapa tidak menyaksikan dan mengalami sendiri pengalaman rohani yang akan mengubahkan kehidupan Anda. Banyak pengalaman rohani yang akan Anda alami di Tanah yang dijanjikan Tuhan kepada bangsa Israel. Mendengar kisah perjalanan dari orang lain itu memang sangat memberkati diri kita, namun jangan berhenti sampai disana. Mari kita sendiri yang melakukan perjalanan itu dan kita mengalami pengalaman yang luar biasa tersebut.</div>
        <div class="button-invers btn-view-group" data-anim="show-up" data-anim-threshold="self">
            <div class="button-left"></div>
            <div class="button-right"></div>
            <div class="button-text">View Group</div>
        </div>
    </div>
</div>
<div class="section section-3">
    <div class="choose-experience" data-src="<?php echo base_url("assets/images/home_5.jpg"); ?>">
        <div class="choose-experience-text">
            <div class="choose-experience-title">CHOOSE <strong>YOUR EXPERIENCE</strong></div>
            <div class="choose-experience-detail">Mari menikmati perjalanan seru bersama kami ke berbagai belahan dunia!</div>
        </div>
    </div>
    <div class="tour-package-container">
        <?php
        $iLength = sizeof($tour_packages);
        for ($i = 0; $i < $iLength; $i++) {
            $url_name = strtolower(str_replace(" ", "-", str_replace("-", "", str_replace("+", "", $tour_packages[$i]->tg_nama))));
            $href = base_url("tour-packages/detail/" . $url_name . "-" . $tour_packages[$i]->tg_kode);
            
            echo "<a href='" . $href . "' class='tour-package-item' data-src='" . base_url("assets/images/tour_groups/tour_groups_" . $tour_packages[$i]->tg_kode . "." . $tour_packages[$i]->tg_image_extension . "?d=" . strtotime($tour_packages[$i]->modified_date)) . "' data-anim='show-up' data-anim-threshold='self'>";
            echo "<div class='tour-package-item-text'>";
            echo "<div class='tour-package-item-name'>" . $tour_packages[$i]->tg_nama . "</div>";
            echo "<div class='tour-package-item-view'>View Group</div>";
            echo "</div>";
            echo "</a>";
        }
        ?>
    </div>
</div>
<div class="section section-4">
    <div class="section-4-title" data-anim="show-up" data-anim-threshold="self">Nearest Tour Group</div>
    <div class="tour-group-container">
        <?php
        $iLength = sizeof($tour_groups);
        for ($i = 0; $i < $iLength; $i++) {
            $url_name = strtolower(str_replace(" ", "-", str_replace("-", "", str_replace("+", "", $tour_groups[$i]->tg_nama))));
            $href = "";
            if ($tour_groups[$i]->tg_jenis == 1) {
                $href = base_url("tour-group/detail/" . $url_name . "-" . $tour_groups[$i]->tg_kode);
            } else {
                $href = base_url("tour-packages/detail/" . $url_name . "-" . $tour_groups[$i]->tg_kode . "?tpd=" . $tour_groups[$i]->tpd_kode);
            }
            
            echo "<a href='" . $href . "' class='tour-group' data-anim='show-up' data-anim-threshold='self'>";
            echo "<div class='tour-group-image' data-src='" . base_url("assets/images/tour_groups/tour_groups_" . $tour_groups[$i]->tg_kode . "." . $tour_groups[$i]->tg_image_extension . "?d=" . strtotime($tour_groups[$i]->modified_date)) . "'></div>";
            echo "<div class='tour-group-date'>" . $tour_groups[$i]->tg_tglStart . " - " . $tour_groups[$i]->tg_tglEnd . "</div>";
            echo "<div class='tour-group-location'>" . $tour_groups[$i]->tg_rute . "</div>";
            $pembimbing = trim($tour_groups[$i]->tg_pembimbing);
            if ($pembimbing != "") {
                echo "<div class='tour-group-with'>with " . $pembimbing . "</div>";
            }
            echo "<div class='tour-group-price'>" . strtoupper($tour_groups[$i]->tgha_kurs) . " " . number_format($tour_groups[$i]->tgha_harga, 0, ".", ",") . "</div>";
            echo "</a>";
        }
        ?>
    </div>
</div>