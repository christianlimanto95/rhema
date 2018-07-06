<div class="section">
    <div class="peserta-item-container">
        <?php
        $iLength = sizeof($tp);
        for ($i = 0; $i < $iLength; $i++) {
            echo "<div class='peserta-item'>";
            echo "<div class='tanggal'>" . $tp[$i]->created_date . "</div>";
            echo "<div class='peserta-item-detail'>";
            echo "<div class='tour-title'>" . $tp[$i]->tg_nama . "<br />" . $tp[$i]->tg_tglStart . " - " . $tp[$i]->tg_tglEnd . "<br />" . $tp[$i]->tg_rute . "</div>";
            echo "<div class='peserta-item-detail-expand'>";
            echo "<div class='item-label'>Email :</div><div class='item-value'>" . $tp[$i]->tp_email . "</div><br />";
            echo "<div class='item-label'>No HP :</div><div class='item-value'>" . $tp[$i]->tp_noHP_1 . "</div><br />";
            echo "<div class='item-label'>Nama :</div><div class='item-value'>" . $tp[$i]->tp_namaDepan . "</div><br />";
            $jk = "Laki - laki";
            if ($tp[$i]->tp_jenisKelamin == "p") {
                $jk = "Perempuan";
            }
            echo "<div class='item-label'>Jenis Kelamin :</div><div class='item-value'>" . $jk . "</div><br />";
            echo "</div>";
            echo "</div>";
            if ($tp[$i]->status == 1) {
                echo "<form class='form-follow-up' method='post' action='" . base_url("admin/follow_up_tour_peserta") . "'>";
                echo "<input type='hidden' name='tp_kodePeserta' value='" . $tp[$i]->tp_kodePeserta . "' />";
                echo "<div class='btn btn-follow-up'>Done Follow Up</div>";
                echo "</form>";
            }
            echo "</div>";
        }
        ?>
    </div>
    <div class="paging">
        <?php
        if ($page == 1) {
            echo "<div class='paging-pref disabled'>Previous</div> ";
        } else {
            echo "<a href='" . base_url("admin?page=" . ($page - 1)) . "' class='paging-pref'>Previous</a> ";
        }
        for ($i = 0; $i < $page_count; $i++) {
            $href = base_url("admin?page=" . ($i + 1));
            if ($i + 1 == $page) {
                echo "<a href='" . $href . "' class='paging-page active'>" . ($i + 1) . "</a>";
            } else {
                echo "<a href='" . $href . "' class='paging-page'>" . ($i + 1) . "</a>";
            }
        }
        if ($page == $page_count) {
            echo " <div class='paging-pref disabled'>Next</div>";
        } else {
            echo " <a href='" . base_url("admin?page=" . ($page + 1)) . "' class='paging-pref'>Next</a>";
        }
        ?>
    </div>
</div>