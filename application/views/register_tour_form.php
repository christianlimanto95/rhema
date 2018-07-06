<div class="section">
    <div class="section-title">PENDAFTARAN PESERTA TOUR</div>
    <div class="tour-detail">
        <?php
        if ($tour_group->tg_jenis == 1) {
            echo $tour_group->tg_nama . " <br />" . $tour_group->tg_tglStart . " - " . $tour_group->tg_tglEnd . " <br />" . $tour_group->tg_rute;
        } else {
            echo $tour_group->tg_nama . " <br />" . $tour_group->tg_description . " <br /><div class='pilih-tanggal'>Pilih Tanggal : </div>";
            echo "<div class='select select-date' data-type='date' data-value='" . $tpd_value . "'>";
                echo "<div class='select-text'>" . $tpd_text . "</div>";
                echo "<span class='dropdown-icon' style='background-image: url(" . base_url("assets/icons/down.png") . ");'></span>";
                echo "<div class='dropdown-container dropdown-container-date' data-type='date'>";
                    $iLength = sizeof($tpd);
                    for ($i = 0; $i < $iLength; $i++) {
                        echo "<div class='dropdown-item' data-value='" . $tpd[$i]->tpd_kode . "'>" . $tpd[$i]->tg_tglStart . " - " . $tpd[$i]->tg_tglEnd . "</div>";
                    }
                echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <form class="form-container form-daftar" method="post" action="<?php echo base_url("register_tour/do_register_tour"); ?>">
        <input type="hidden" name="tg_jenis" value="<?php echo $tour_group->tg_jenis; ?>" />
        <input type="hidden" name="tg_kode" value="<?php echo $tour_group->tg_kode; ?>" />
        <input type="hidden" name="tg_title" value="<?php echo $tour_group->tg_nama; ?>" />
        <input type="hidden" name="tpd_kode" value="<?php echo $tpd_value; ?>" />
        <div class="form-subsection-title">DATA PRIBADI</div>
        <div class="form-item">
            <div class="form-left">Email</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-email" name="tp_email" maxlength="100" />
                <span class="error error-email"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Nama</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-nama-depan" name="tp_namaDepan" maxlength="100" />
                <span class="error error-nama-depan"></span>
            </div>
        </div>
        <!--<div class="form-item">
            <div class="form-left">Nama Belakang (sesuai paspor)</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-nama-belakang" name="tp_namaBelakang" maxlength="100" />
                <span class="error error-nama-belakang"></span>
            </div>
        </div>-->
        <div class="form-item">
            <div class="form-left label-jk">Jenis Kelamin</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_jenisKelamin" class="input-jk" value="" />
                <div class="radio-container jk-radio-container" data-name="jk" data-value="l">
                    <div class="radio"></div>
                    <div class="radio-text">Laki-laki</div>
                </div>
                <div class="radio-container jk-radio-container" data-name="jk" data-value="p">
                    <div class="radio"></div>
                    <div class="radio-text">Perempuan</div>
                </div>
                <span class="error error-jk"></span>
            </div>
        </div>
        <!--<div class="form-item">
            <div class="form-left label-gd">Golongan Darah</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_golonganDarah" class="input-gd" value="" />
                <div class="radio-container gd-radio-container" data-name="gd" data-value="a">
                    <div class="radio"></div>
                    <div class="radio-text">A</div>
                </div>
                <div class="radio-container gd-radio-container" data-name="gd" data-value="b">
                    <div class="radio"></div>
                    <div class="radio-text">B</div>
                </div>
                <div class="radio-container gd-radio-container" data-name="gd" data-value="o">
                    <div class="radio"></div>
                    <div class="radio-text">O</div>
                </div>
                <div class="radio-container gd-radio-container" data-name="gd" data-value="ab">
                    <div class="radio"></div>
                    <div class="radio-text">AB</div>
                </div>
                <span class="error error-gd"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Nama Ayah Kandung</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-nama-ayah" name="tp_namaAyah" maxlength="100" />
                <span class="error error-nama-ayah"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Nama Ibu Kandung</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-nama-ibu" name="tp_namaIbu" maxlength="100" />
                <span class="error error-nama-ibu"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Nama Kakek (dari pihak Ayah)</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-nama-kakek" name="tp_namaKakek" maxlength="100" />
                <span class="error error-nama-kakek"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">No. Paspor</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-passport" name="tp_noPaspor" maxlength="9" placeholder="A0000000" />
                <span class="error error-passport"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Masa Berlaku Paspor</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_masaBerlaku" class="input-masa-berlaku-passport" value="" />
                <input type="text" class="form-input-inline input-expire-date input-date" maxlength="2" placeholder="dd" data-type="number" />
                /
                <input type="text" class="form-input-inline input-expire-month input-month" maxlength="2" placeholder="mm" data-type="number" />
                /
                <input type="text" class="form-input-inline input-expire-year input-year" maxlength="4" placeholder="yyyy" data-type="number" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left label-foto-passport">Foto Paspor</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tg_fotoPaspor" class="input-foto-passport" value="" />
                <div class="upload-container">
                    <div class="upload-button">
                        <div class="upload-text">Choose Image</div>
                    </div>
                    <input type="file" class="input-upload input-upload-foto-passport" name="input-image" accept="image/*" />
                </div>
                <img class="image-preview" />
                <div class="btn btn-negative btn-delete-image">Delete Image</div>
                <span class="error error-foto-passport"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Tempat Lahir</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-tempat-lahir" name="tp_tempatLahir" />
                <span class="error error-tempat-lahir"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Tanggal Lahir</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_tanggalLahir" class="input-tanggal-lahir" value="" />
                <input type="text" class="form-input-inline input-birth-date input-date" maxlength="2" placeholder="dd" data-type="number" />
                /
                <input type="text" class="form-input-inline input-birth-month input-month" maxlength="2" placeholder="mm" data-type="number" />
                /
                <input type="text" class="form-input-inline input-birth-year input-year" maxlength="4" placeholder="yyyy" data-type="number" />
                <span class="error"></span>
            </div>
        </div>-->
        <div class="form-item">
            <div class="form-left label-no-hp">No. HP <span class="question-mark">?<div class="question-mark-description">No. HP tiap orang berbeda walaupun suami, istri, kecuali anak di bawah umur 11 tahun.</div></span></div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <div class="input-hp-container">
                    <input type="text" class="form-input-inline input-hp" maxlength="20" name="tp_noHP_1" data-type="number" />
                </div>
                <!--<div class="btn-tambah-no-hp">Tambah No. HP</div>-->
                <span class="error error-hp"></span>
            </div>
        </div>
        <!--<div class="form-item">
            <div class="form-left label-address">Alamat Rumah</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <textarea class="form-input-inline input-address" name="tp_alamatRumah"></textarea>
                <span class="error error-address"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Telepon Rumah</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-phone" maxlength="20" name="tp_teleponRumah" data-type="number" placeholder="0317531234" />
                <span class="error error-phone"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left label-status">Status Perkawinan</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="statusNikah" value="" class="input-status" />
                <div class="radio-container status-radio-container status-radio-lajang" data-name="status" data-value="lajang">
                    <div class="radio"></div>
                    <div class="radio-text">Lajang</div>
                </div>
                <div class="radio-container status-radio-container status-radio-menikah" data-name="status" data-value="menikah">
                    <div class="radio"></div>
                    <div class="radio-text">Menikah</div>
                </div>
                <div class="radio-container status-radio-container status-radio-other" data-name="status" data-value="other">
                    <div class="radio"></div>
                    <div class="radio-text">Lain-lain <input type="text" class="form-input-inline input-status-other radio-text-additional-input" name="tp_statusNikahOther" readonly /></div>
                </div>
                <span class="error error-status"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Nama Istri / Suami</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-istri-suami" name="tp_namaIstriSuami" maxlength="100" />
                <span class="error error-istri-suami"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Anggota Keluarga yang Ikut Serta Dalam Group Ini (jika ada)</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_anggotaKeluarga" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Jika Pernah, Sebutkan Tgl Perjalanan ke Israel Sebelumnya</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_tglTripSebelum" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Kunjungan ke Negara Lain (1-5 Tahun Terakhir)</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_negaraKunjungan" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-subsection-title">B. PEKERJAAN <i>(wajib diisi)</i></div>
        <div class="form-item">
            <div class="form-left">Jabatan</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_jabatan" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Nama Perusahaan</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_namaPerusahaan" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left label-company-address">Alamat Lengkap Perusahaan</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <textarea class="form-input-inline" name="tp_alamatPerusahaan"></textarea>
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Telepon Kantor</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline input-company-telephone" name="tp_teleponKantor" maxlength="20" data-type="number" placeholder="0317531234" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-subsection-title">C. KESEHATAN</div>
        <div class="form-item">
            <div class="form-left label-pernah-rs">Pernah dirawat di Rumah Sakit dalam 1 tahun terakhir</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_pernahMasukRS" class="input-rs" value="" />
                <div class="radio-container rs-radio-container rs-radio-ya" data-name="rs" data-value="ya">
                    <div class="radio"></div>
                    <div class="radio-text">Ya, karena sakit <input type="text" class="form-input-inline input-rs-ya radio-text-additional-input" name="tp_alasanMasukRS" readonly /></div>
                </div>
                <div class="radio-container rs-radio-container rs-radio-tidak" data-name="rs" data-value="tidak">
                    <div class="radio"></div>
                    <div class="radio-text">Tidak</div>
                </div>
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left label-sedang-sakit">Apakah sedang menderita penyakit</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_sedangMenderitaSakit" value="" />
                <div class="checkbox-container penyakit-checkbox-container" data-name="penyakit" data-value="diabetes">
                    <div class="checkbox"></div>
                    <div class="checkbox-text">Diabetes</div>
                </div>
                <div class="checkbox-container penyakit-checkbox-container" data-name="penyakit" data-value="jantung">
                    <div class="checkbox"></div>
                    <div class="checkbox-text">Jantung</div>
                </div>
                <div class="checkbox-container penyakit-checkbox-container" data-name="penyakit" data-value="ginjal">
                    <div class="checkbox"></div>
                    <div class="checkbox-text">Ginjal</div>
                </div>
                <div class="checkbox-container penyakit-checkbox-container" data-name="penyakit" data-value="kanker">
                    <div class="checkbox"></div>
                    <div class="checkbox-text">Kanker</div>
                </div>
                <div class="checkbox-container penyakit-checkbox-container" data-name="penyakit" data-value="tekanan_darah_tinggi">
                    <div class="checkbox"></div>
                    <div class="checkbox-text">Tekanan Darah Tinggi</div>
                </div>
                <div class="checkbox-container penyakit-checkbox-container" data-name="penyakit" data-value="lainnya">
                    <div class="checkbox"></div>
                    <div class="checkbox-text">Lainnya <input type="text" class="form-input-inline input-sakit-lainnya checkbox-text-additional-input" readonly /></div>
                </div>
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left label-hamil">Pernah anda sedang hamil pada saat ini (<i>khusus wanita</i>)</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="hidden" name="tp_sedangHamil" class="input-hamil" value="" />
                <div class="radio-container hamil-radio-container" data-name="hamil" data-value="ya">
                    <div class="radio"></div>
                    <div class="radio-text">Ya, usia kandungan <input type="text" class="form-input-inline input-hamil-ya radio-text-additional-input" name="tp_usiaHamil" data-type="number" maxlength="1" readonly /> bulan</div>
                </div>
                <div class="radio-container hamil-radio-container hamil-radio-container-tidak" data-name="hamil" data-value="tidak">
                    <div class="radio"></div>
                    <div class="radio-text">Tidak</div>
                </div>
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Sebutkan pantangan makanan anda</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_pantanganMakanan" maxlength="100" placeholder="ayam, udang, seafood" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-subsection-title">D. KEANGGOTAAN GEREJA &amp; BIDANG PELAYANAN</div>
        <div class="form-item">
            <div class="form-left">Gereja</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_gereja" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>
        <div class="form-item">
            <div class="form-left">Pelayanan</div>
            <div class="form-titikdua">:</div>
            <div class="form-right">
                <input type="text" class="form-input-inline" name="tp_pelayanan" maxlength="100" />
                <span class="error"></span>
            </div>
        </div>-->
    </form>
    <div class="button-invers btn-register">
        <div class="button-left"></div>
        <div class="button-right"></div>
        <div class="button-text">Daftar</div>
    </div>
</div>
<div class="dialog dialog-detail">
    <div class="dialog-background">
        <div class="dialog-box">
            <div class="dialog-close-icon" style="background-image: url(<?php echo base_url("assets/icons/close_icon.png"); ?>);"></div>
            <div class="dialog-header">Pastikan Informasi Sudah Benar</div>
            <div class="dialog-body">
                <div class="dialog-form-item">
                    <div class="dialog-form-label">Email</div>
                    <div class="dialog-form-value form-value-email"></div>
                </div>
                <div class="dialog-form-item">
                    <div class="dialog-form-label">Nama</div>
                    <div class="dialog-form-value form-value-nama-depan"></div>
                </div>
                <!--<div class="dialog-form-item">
                    <div class="dialog-form-label">Nama Belakang</div>
                    <div class="dialog-form-value form-value-nama-belakang"></div>
                </div>-->
                <div class="dialog-form-item">
                    <div class="dialog-form-label">Jenis Kelamin</div>
                    <div class="dialog-form-value form-value-jenis-kelamin"></div>
                </div>
                <!--<div class="dialog-form-item">
                    <div class="dialog-form-label">Tempat Lahir</div>
                    <div class="dialog-form-value form-value-tempat-lahir"></div>
                </div>-->
                <div class="dialog-form-item">
                    <div class="dialog-form-label">No. HP</div>
                    <div class="dialog-form-value form-value-no-hp"></div>
                </div>
                <!--<div class="dialog-form-item">
                    <div class="dialog-form-label">Alamat Rumah</div>
                    <div class="dialog-form-value form-value-alamat-rumah"></div>
                </div>-->
            </div>
            <div class="dialog-footer">
                <div class="button btn-confirm-submit">
                    <div class="button-left"></div>
                    <div class="button-right"></div>
                    <div class="button-text">Daftar</div>
                </div>
            </div>
        </div>
    </div>
</div>