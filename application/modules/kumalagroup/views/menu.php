<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <?php
            $akses = $this->model_konfigurasi_user->menu();
            $menu_akses = explode(",", $akses);




            //Menu Manajemen Aplikasi
            echo open_parent("icon-ios-cog-outline", "Manajemen Sistem");
            echo _child($menu_akses, 'Konfigurasi User', 'konfigurasi_user', (($this->uri->segment('1') == 'konfigurasi_user') ? 'active' : ''), '' . base_url() . 'kumalagroup_konfigurasi_user');
            echo _child($menu_akses, 'User Profil', 'user_profil', (($this->uri->segment('1') == 'user_profil') ? 'active' : ''), '' . base_url() . 'kumalagroup_user_profil');
            echo close_parent();
            // echo close_parent();
            // echo _header($menu_akses, "<strong><center>Hino</center></strong>", "hino");

            echo open_parent("icon-tasks", "Kasir");

            echo open_parent('', "Bank Penerimaan");
            echo _child($menu_akses, 'Unit', 'bank_penerimaan_unit', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_bank_penerimaan/unit') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_bank_penerimaan/unit');
            echo _child($menu_akses, 'After Sales', 'bank_penerimaan_after_sales', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_bank_penerimaan/after_sales') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_bank_penerimaan/after_sales');
            echo _child($menu_akses, 'Operational', 'bank_penerimaan_operational', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_bank_penerimaan/operasional') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_bank_penerimaan/operasional');
            echo close_parent();

            echo open_parent('', "Bank Pengeluaran");
            echo _child($menu_akses, 'Unit', 'bank_pengeluaran_unit', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_bank_pengeluaran/unit') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_bank_pengeluaran/unit');
            echo _child($menu_akses, 'After Sales', 'bank_pengeluaran_after_sales', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_bank_pengeluaran/after_sales') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_bank_pengeluaran/after_sales');
            echo _child($menu_akses, 'Operational', 'bank_pengeluaran_operational', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_bank_pengeluaran/operasional') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_bank_pengeluaran/operasional');
            echo close_parent();

            echo open_parent('', 'Kas Penerimaan');
            echo _child($menu_akses, 'Unit', 'kas_penerimaan_unit', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kas_penerimaan/unit') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kas_penerimaan/unit');
            echo _child($menu_akses, 'After Sales', 'kas_penerimaan_after_sales', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kas_penerimaan/after_sales') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kas_penerimaan/after_sales');
            echo close_parent();

            echo open_parent('', 'Kas Pengeluaran');
            echo _child($menu_akses, 'Unit', 'kas_pengeluaran_unit', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kas_pengeluaran/unit') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kas_pengeluaran/unit');
            echo _child($menu_akses, 'After Sales', 'kas_pengeluaran_after_sales', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kas_pengeluaran/after_sales') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kas_pengeluaran/after_sales');
            echo close_parent();

            echo open_parent('', 'Piutang & Aging');
            echo _child($menu_akses, 'Detail Pembayaran SPK', 'detail_pembayaran_spk', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kartu_piutang_n_aging/detail_pembayaran_spk') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kartu_piutang_n_aging/detail_pembayaran_spk');
            echo _child($menu_akses, 'Kartu Piutang Invoice', 'kartu_piutang_invoice', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kartu_piutang_n_aging/kartu_piutang_invoice') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kartu_piutang_n_aging/kartu_piutang_invoice');
            echo _child($menu_akses, 'Aging Schedule', 'aging_schedule', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_kartu_piutang_n_aging/aging_schedule') ? 'active' : ''), '' . base_url() . 'audit/kumalagroup_kartu_piutang_n_aging/aging_schedule');
            echo close_parent();

            echo close_parent();
            echo single_menu_link($menu_akses, "icon-tasks", "Data SPK", "kumalagroup_audit_data_spk", (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_data_spk/data_spk') ? 'active' : ''),  base_url() . 'audit/kumalagroup_data_spk/data_spk');
            echo single_menu_link($menu_akses, "icon-tasks", "Data DO", "kumalagroup_audit_data_do", (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_data_do/data_do') ? 'active' : ''),  base_url() . 'audit/kumalagroup_data_do/data_do');

            echo open_parent("icon-tasks", "Probid");
            echo _child($menu_akses, 'Dashboard Biaya', 'dashboard_biaya', (($this->uri->segment('2') == 'kumalagroup_dashboard_biaya') ? 'active' : ''), '' . base_url() . 'probid/kumalagroup_dashboard_biaya');
            echo _child($menu_akses, 'Master Biaya', 'master_biaya', (($this->uri->segment('2') . '/' . $this->uri->segment('3') == 'kumalagroup_probid/master_biaya') ? 'active' : ''), '' . base_url() . 'probid/kumalagroup_probid/master_biaya');
            echo _child($menu_akses, 'Daftar Biaya', 'daftar_biaya', (($this->uri->segment('2') == 'kumalagroup_daftar_biaya') ? 'active' : ''), '' . base_url() . 'probid/kumalagroup_daftar_biaya');
            echo _child($menu_akses, 'Laporan Biaya', 'laporan_biaya', (($this->uri->segment('2') == 'kumalagroup_laporan_biaya') ? 'active' : ''), '' . base_url() . 'probid/kumalagroup_laporan_biaya');
            echo close_parent();
            ?>
        </ul>
        <br><br>
    </div>
</div>
<script>
    $('ul.menu-content:empty').closest('li').remove();
    $('ul.menu-content:empty').closest('li').remove();
    // $('.active').click(function(e) {
    //     e.preventDefault();
    // });
</script>