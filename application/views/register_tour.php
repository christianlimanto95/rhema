<div class="section">
    <div class="section-center">
        <div class="section-title"><strong>FIND</strong> TOUR GROUP</div>
        <form class="form-search filter-container" method="get" action="<?php echo base_url("register-tour"); ?>">
            <div class="form-item-inline">
                <div class="form-label-inline">TOUR</div>
                <input type="text" name="tour" class="form-input input-tour" value="<?php echo $tour; ?>" />
            </div>
            <div class="form-item-inline">
                <div class="form-label-inline">MONTH</div>
                <?php
                $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                ?>
                <input type="hidden" class="input-month" name="month" value="<?php echo $month; ?>" />
                
                <div class="select select-month" data-type="month" data-value="<?php echo $month; ?>">
                    <div class="select-text"><?php echo $month_text; ?></div>
                    <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                    <div class="dropdown-container dropdown-container-month" data-type="month">
                        <div class="dropdown-item" data-value="all">All</div>
                        <div class="dropdown-item" data-value="1">Januari</div>
                        <div class="dropdown-item" data-value="2">Februari</div>
                        <div class="dropdown-item" data-value="3">Maret</div>
                        <div class="dropdown-item" data-value="4">April</div>
                        <div class="dropdown-item" data-value="5">Mei</div>
                        <div class="dropdown-item" data-value="6">Juni</div>
                        <div class="dropdown-item" data-value="7">Juli</div>
                        <div class="dropdown-item" data-value="8">Agustus</div>
                        <div class="dropdown-item" data-value="9">September</div>
                        <div class="dropdown-item" data-value="10">Oktober</div>
                        <div class="dropdown-item" data-value="11">November</div>
                        <div class="dropdown-item" data-value="12">Desember</div>
                    </div>
                </div>
            </div>
            <div class="form-item-inline">
                <div class="form-label-inline">YEAR</div>
                <input type="hidden" class="input-year" name="year" value="<?php echo $year; ?>" />
                <div class="select select-year" data-type="year" data-value="<?php echo $year; ?>">
                    <div class="select-text"><?php echo $year_text; ?></div>
                    <span class="dropdown-icon" style="background-image: url(<?php echo base_url("assets/icons/down.png"); ?>);"></span>
                    <div class="dropdown-container dropdown-container-year" data-type="year">
                        <div class="dropdown-item" data-value="all">All</div>
                        <div class="dropdown-item" data-value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></div>
                        <div class="dropdown-item" data-value="<?php echo date('Y', strtotime('+1 year')); ?>"><?php echo date('Y', strtotime('+1 year')); ?></div>
                    </div>
                </div>
            </div>
            <div class="button-invers btn-search">
                <div class="button-left"></div>
                <div class="button-right"></div>
                <div class="button-text">Search</div>
            </div>
        </form>
        <div class="tour-group-container">
        <?php
        $iLength = sizeof($data);
        for ($i = 0; $i < $iLength; $i++) {
            $url_name = strtolower(str_replace(" ", "-", str_replace("-", "", str_replace("+", "", $data[$i]->tg_nama))));
            $href = "";
            if ($data[$i]->tg_jenis == 1) {
                $href = base_url("tour-group/detail/" . $url_name . "-" . $data[$i]->tg_kode);
            } else {
                $href = base_url("tour-packages/detail/" . $url_name . "-" . $data[$i]->tg_kode . "?tpd=" . $data[$i]->tpd_kode);
            }

            echo "<a href='" . $href . "' class='tour-group' data-anim='show-up' data-anim-threshold='self'>";
            echo "<div class='tour-group-image' data-src='" . base_url("assets/images/tour_groups/tour_groups_" . $data[$i]->tg_kode . "." . $data[$i]->tg_image_extension . "?d=" . strtotime($data[$i]->modified_date)) . "'></div>";
            echo "<div class='tour-group-date'>" . $data[$i]->tg_tglStartFormatted . " - " . $data[$i]->tg_tglEndFormatted . "</div>";
            echo "<div class='tour-group-location'>" . $data[$i]->tg_rute . "</div>";
            $pembimbing = trim($data[$i]->tg_pembimbing);
            if ($pembimbing != "") {
                echo "<div class='tour-group-with'>with " . $pembimbing . "</div>";
            }
            echo "<div class='tour-group-price'>" . strtoupper($data[$i]->tgha_kurs) . " " . number_format($data[$i]->tgha_harga, 0, ".", ",") . "</div>";
            echo "</a>";
        }
        ?>
        </div>
        <div class="paging">
            <?php
            $get = "";
            if ($tour != null) {
                $get = "tour=" . $tour . "&month=" . $month . "&year=" . $year . "&page=";
            } else {
                $get = "&page=";
            }
            
            if ($page == 1) {
                echo "<div class='page-prev disabled'>Prev</div>";
            } else {
                echo "<a href='" . base_url("register-tour?" . $get . ($page - 1)) . "' class='page-prev'>Prev</a>";
            }

            $iLength = $page_count;

            for ($i = 1; $i <= $iLength; $i++) {
                $active = "";
                if ($i == $page) {
                    echo "<div class='page active'>" . $i . "</div>";
                } else {
                    echo "<a href='" . base_url("register-tour?" . $get . $i) . "' class='page'>" . $i . "</a>";
                }
            }

            if ($page == $page_count) {
                echo "<div class='page-next disabled'>Next</div>";
            } else {
                echo "<a href='" . base_url("register-tour?" . $get . ($page + 1)) . "' class='page-next'>Next</a>";
            }

            ?>
        </div>
    </div>
</div>