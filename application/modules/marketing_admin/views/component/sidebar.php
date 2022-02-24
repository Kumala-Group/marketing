<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <?php
            $q_akses = q_data("*", 'kumalagroup.menu_akses', ['id_user' => $this->session->userdata('id_user')])->row();
            $menu_akses = explode(",", $q_akses->akses_menu);

            echo single_menu(
                $menu_akses,
                "icon-home",
                "Beranda",
                "beranda",
                ($index == 'beranda') ? "active" : "",
                base_url("marketing/beranda")
            );

            //Menu Manajemen Aplikasi
            echo open_parent("icon-ios-cog-outline", "Manajemen Sistem");
            echo _child(
                $menu_akses,
                "Konfigurasi User",
                "konfigurasi_user",
                ($index == 'konfigurasi_user') ? "active" : "",
                base_url("konfigurasi_user")
            );
            echo _child(
                $menu_akses,
                "User Profil",
                "user_profil",
                ($index == 'user_profil') ? "active" : "",
                base_url("user_profil")
            );
            echo "</ul></li>";

            // Dashboard
            echo _header($menu_akses, "<strong>Dashboard</strong>", "dashboard");
            echo open_parent("icon-ios-cog-outline", "Wuling");
            echo _child(
                $menu_akses,
                "Controlling Survei DO",
                "wuling_ctrl_survey_do",
                ($index == 'wuling_ctrl_survey_do') ? "active" : "",
                base_url("dashboard/wuling_ctrl_survey_do")
            );
            echo "</ul></li>";

            echo _header($menu_akses, "<strong>Manajemen Aplikasi</strong>", "manajemen_aplikasi");
            echo open_parent("icon-ios-bookmarks-outline", "Pustaka");
            echo _child(
                $menu_akses,
                "Brand",
                "brand",
                ($index == 'brand') ? "active" : "",
                base_url("aplikasi/brand")
            );
            echo _child(
                $menu_akses,
                "Model",
                "model",
                ($index == 'model') ? "active" : "",
                base_url("aplikasi/model")
            );
            echo _child(
                $menu_akses,
                "Tipe",
                "tipe",
                ($index == 'tipe') ? "active" : "",
                base_url("aplikasi/tipe")
            );
            echo _child(
                $menu_akses,
                "Warna",
                "warna",
                ($index == 'warna') ? "active" : "",
                base_url("aplikasi/warna")
            );
            echo "</ul></li>";

            echo open_parent("icon-ios-monitor-outline", "Website");
            echo _child(
                $menu_akses,
                "Karir",
                "karir",
                ($index == 'karir') ? "active" : "",
                base_url("aplikasi/karir")
            );
            echo _child(
                $menu_akses,
                "Partner",
                "partner",
                ($index == 'partner') ? "active" : "",
                base_url("aplikasi/partner")
            );
            echo _child(
                $menu_akses,
                "Property",
                "property",
                ($index == 'property') ? "active" : "",
                base_url("aplikasi/property")
            );
            echo "</ul></li>";

            echo open_parent("icon-ios-pulse-strong", "Website & Apps");
            echo _child(
                $menu_akses,
                "Berita",
                "berita",
                ($index == 'berita') ? "active" : "",
                base_url("aplikasi/berita")
            );
            echo _child(
                $menu_akses,
                "Dealer",
                "dealer",
                ($index == 'dealer') ? "active" : "",
                base_url("aplikasi/dealer")
            );
            echo _child(
                $menu_akses,
                "Otomotif",
                "otomotif",
                ($index == 'otomotif') ? "active" : "",
                base_url("aplikasi/otomotif")
            );
            echo _child(
                $menu_akses,
                "Fitur 360",
                "360Fitur",
                ($index == '360Fitur') ? "active" : "",
                base_url('marketing_admin/master_app/fitur_360')
            );
            echo _child(
                $menu_akses,
                "Slider",
                "slider",
                ($index == 'slider') ? "active" : "",
                base_url("aplikasi/slider")
            );
            echo "</ul></li>";

            echo open_parent("icon-ipad", "Apps");
            echo _child(
                $menu_akses,
                "Acara",
                "acara",
                ($index == 'acara') ? "active" : "",
                base_url("aplikasi/acara")
            );
            echo _child(
                $menu_akses,
                "Sparepart",
                "sparepart",
                ($index == 'sparepart') ? "active" : "",
                base_url("aplikasi/sparepart")
            );
            echo _child(
                $menu_akses,
                "Voucher",
                "voucher",
                ($index == 'voucher') ? "active" : "",
                base_url("aplikasi/voucher")
            );
            echo "</ul></li>";

            echo open_parent("icon-ios-pulse-strong", "Virtual Fair");
            echo _child(
                $menu_akses,
                "Dashboard",
                "dashboard_digifest",
                ($index == 'dashboard_digifest') ? "active" : "",
                base_url("virtual_fair/dashboard")
            );
            echo _child(
                $menu_akses,
                "Customer",
                "list_user",
                ($index == 'list_user') ? "active" : "",
                base_url("virtual_fair/list_user")
            );
            echo _child(
                $menu_akses,
                "Transaksi",
                "list_transaksi",
                ($index == 'list_transaksi') ? "active" : "",
                base_url("virtual_fair/list_transaksi")
            );
            echo _child(
                $menu_akses,
                "Main Stage",
                "main_stage",
                ($index == 'main_stage') ? "active" : "",
                base_url("virtual_fair/main_stage")
            );
            echo _child(
                $menu_akses,
                "Detail Unit",
                "detail_unit",
                ($index == 'detail_unit') ? "active" : "",
                base_url("virtual_fair/detail_unit")
            );
            echo _child(
                $menu_akses,
                "Pengaturan",
                "pengaturan",
                ($index == 'pengaturan') ? "active" : "",
                base_url("virtual_fair/pengaturan")
            );
            echo "</ul></li>";

            echo open_parent("icon-ios-pulse-strong", "Used Car");
            echo _child(
                $menu_akses,
                "Inventori",
                "ucinventori",
                ($index == 'ucinventori') ? "active" : "",
                base_url("marketing_admin/carimobilku/inventori")
            );
            // echo _child(
            //     $menu_akses,
            //     "Blog & Promo",
            //     "ucblog",
            //     ($index == 'ucblog') ? "active" : "",
            //     base_url("marketing_admin/carimobilku/blog")
            // );
            // echo _child(
            //     $menu_akses,
            //     "Slider",
            //     "ucslider",
            //     ($index == 'ucslider') ? "active" : "",
            //     base_url("marketing_admin/carimobilku/slider")
            // );
            echo "</ul></li>";

            echo _header($menu_akses, "<strong>Admin</strong>", "admin");
            echo single_menu(
                $menu_akses,
                "icon-ios-help-empty",
                "Bantuan",
                "bantuan",
                ($index == 'bantuan') ? "active" : "",
                base_url("admin/bantuan")
            );

            echo open_parent("icon-ios-chatbubble-outline", "Layanan");
            echo _child(
                $menu_akses,
                "Test Drive",
                "test_drive",
                ($index == 'test_drive') ? "active" : "",
                base_url("admin/test_drive")
            );
            echo _child(
                $menu_akses,
                "Penawaran",
                "penawaran",
                ($index == 'penawaran') ? "active" : "",
                base_url("admin/penawaran")
            );
            echo "</ul></li>";

            echo single_menu(
                $menu_akses,
                "icon-ios-email-outline",
                "Pelamar",
                "pelamar",
                ($index == 'pelamar') ? "active" : "",
                base_url("admin/pelamar")
            );

            echo open_parent("icon-ios-download-outline", "Apps Admin");
            echo _child(
                $menu_akses,
                "Booking Service",
                "booking_service",
                ($index == 'booking_service') ? "active" : "",
                base_url("admin/booking_service")
            );
            echo _child(
                $menu_akses,
                "Home Service",
                "home_service",
                ($index == 'home_service') ? "active" : "",
                base_url("admin/home_service")
            );
            echo _child(
                $menu_akses,
                "Saran",
                "saran",
                ($index == 'saran') ? "active" : "",
                base_url("admin/saran")
            );
            echo _child(
                $menu_akses,
                "Tiket",
                "tiket",
                ($index == 'tiket') ? "active" : "",
                base_url("admin/tiket")
            );
            echo "</ul></li>";

            //Menu Marketing Support
            echo _header($menu_akses, "<strong>Marketing Support</strong>", "marketing_support");
            echo _header($menu_akses, "<strong>Wuling</strong>", "wuling_header");
            echo open_parent("icon-ios-bookmarks-outline", "Pustaka");
            echo _child(
                $menu_akses,
                "Sumber Prospek",
                "wuling_sumber_prospek",
                ($index == 'wuling_sumber_prospek') ? "active" : "",
                base_url("marketing_support/wuling/sumber_prospek")
            );
            echo _child(
                $menu_akses,
                "Media Motivator",
                "wuling_media_motivator",
                ($index == 'wuling_media_motivator') ? "active" : "",
                base_url("marketing_support/wuling/media_motivator")
            );
            echo _child(
                $menu_akses,
                "Jenis Event",
                "wuling_jenis_event",
                ($index == 'wuling_jenis_event') ? "active" : "",
                base_url("marketing_support/wuling/jenis_event")
            );
            echo _child(
                $menu_akses,
                "Area Event",
                "wuling_area_event",
                ($index == 'wuling_area_event') ? "active" : "",
                base_url("marketing_support/wuling/area_event")
            );
            echo _child(
                $menu_akses,
                "Lokasi Event",
                "wuling_lokasi_event",
                ($index == 'wuling_lokasi_event') ? "active" : "",
                base_url("marketing_support/wuling/lokasi_event")
            );
            echo _child(
                $menu_akses,
                "Data Regional",
                "wuling_regional",
                ($index == 'wuling_regional') ? "active" : "",
                base_url("digital_leads/wuling_digital_leads/wuling_regional")
            );
            echo "</ul></li>";

            //master
            echo open_parent("icon-ios-monitor-outline", "Master");
            echo _child(
                $menu_akses,
                "Activity/Pameran",
                "wuling_activity",
                ($index == 'wuling_activity') ? "active" : "",
                base_url("marketing_support/wuling/activity")
            );
            echo _child(
                $menu_akses,
                "Digital Leads Customer",
                "wuling_marksup",
                ($index == 'wuling_marksup') ? "active" : "",
                base_url("marketing_support/wuling/marksup")
            );
            echo "</ul></li>";

            //data customer
            echo open_parent("icon-ios-monitor-outline", "Data Customer");
            echo _child(
                $menu_akses,
                "Customer Suspect & Prospek",
                "wuling_cust_suspect_prospek",
                ($index == 'wuling_cust_suspect_prospek') ? "active" : "",
                base_url("marketing_support/wuling/customer_suspect_prospek")
            );
            echo _child(
                $menu_akses,
                "Customer SPK",
                "wuling_cust_spk",
                ($index == 'wuling_cust_spk') ? "active" : "",
                base_url("marketing_support/wuling/customer_spk")
            );
            echo _child(
                $menu_akses,
                "Customer DO",
                "wuling_cust_do",
                ($index == 'wuling_cust_do') ? "active" : "",
                base_url("marketing_support/wuling/customer_do")
            );
            echo _child(
                $menu_akses,
                "Customer TestDrive",
                "wuling_cust_testdrive",
                ($index == 'wuling_cust_testdrive') ? "active" : "",
                base_url("marketing_support/wuling/customer_testdrive")
            );
            echo _child(
                $menu_akses,
                "Master Customer",
                "wuling_master_cust",
                ($index == 'wuling_master_cust') ? "active" : "",
                base_url("marketing_support/wuling/master_customer")
            );
            echo _child(
                $menu_akses,
                "Survei DO",
                "wuling_master_do",
                ($index == 'wuling_master_do') ? "active" : "",
                base_url("marketing_support/wuling/master_survei_do")
            );
            echo "</ul></li>";

            //marketing report
            echo open_parent("icon-ios-monitor-outline", "Marketing Report");
            echo _child(
                $menu_akses,
                "SPK by Type",
                "wuling_spk_by_type",
                ($index == 'wuling_spk_by_type') ? "active" : "",
                base_url("marketing_support/wuling/spk_by_type")
            );
            echo _child(
                $menu_akses,
                "DO by Type",
                "wuling_do_by_type",
                ($index == 'wuling_do_by_type') ? "active" : "",
                base_url("marketing_support/wuling/do_by_type")
            );
            echo _child(
                $menu_akses,
                "Aktivitas Penjualan",
                "wuling_aktivitas_penjualan",
                ($index == 'wuling_aktivitas_penjualan') ? "active" : "",
                base_url("marketing_support/wuling/aktivitas_penjualan")
            );
            echo _child(
                $menu_akses,
                "Aktivitas Penjualan by Model",
                "wuling_aktivitas_penjualan_by_model",
                ($index == 'wuling_aktivitas_penjualan_by_model') ? "active" : "",
                base_url("marketing_support/wuling/aktivitas_penjualan_by_model")
            );
            echo _child(
                $menu_akses,
                "Aktivitas Prospek",
                "wuling_aktivitas_prospek",
                ($index == 'wuling_aktivitas_prospek') ? "active" : "",
                base_url("marketing_support/wuling/aktivitas_prospek")
            );

            echo "</ul></li>";
            echo single_menu(
                $menu_akses,
                "icon-android-car",
                "Test Drive",
                "wuling_test_drive",
                ($index == 'test_drive') ? "active" : "",
                base_url("marketing_support/wuling/test_drive")
            );

            //honda
            echo _header($menu_akses, "<strong>Honda</strong>", "honda_header");
            echo open_parent("icon-ios-bookmarks-outline", "Pustaka");
            echo _child(
                $menu_akses,
                "Sumber Prospek",
                "honda_sumber_prospek",
                ($index == 'honda_sumber_prospek') ? "active" : "",
                base_url("marketing_support/honda/sumber_prospek")
            );
            echo _child(
                $menu_akses,
                "Media Motivator",
                "honda_media_motivator",
                ($index == 'honda_media_motivator') ? "active" : "",
                base_url("marketing_support/honda/media_motivator")
            );
            echo _child(
                $menu_akses,
                "Jenis Event",
                "honda_jenis_event",
                ($index == 'honda_jenis_event') ? "active" : "",
                base_url("marketing_support/honda/jenis_event")
            );
            echo _child(
                $menu_akses,
                "Area Event",
                "honda_area_event",
                ($index == 'honda_area_event') ? "active" : "",
                base_url("marketing_support/honda/area_event")
            );
            echo _child(
                $menu_akses,
                "Lokasi Event",
                "honda_lokasi_event",
                ($index == 'honda_lokasi_event') ? "active" : "",
                base_url("marketing_support/honda/lokasi_event")
            );
            echo "</ul></li>";

            //master
            echo open_parent("icon-ios-monitor-outline", "Master");
            echo _child(
                $menu_akses,
                "Activity/Pameran",
                "honda_activity",
                ($index == 'honda_activity') ? "active" : "",
                base_url("marketing_support/honda/activity")
            );
            echo "</ul></li>";

            //laporan
            echo open_parent("icon-ios-monitor-outline", "Laporan");
            echo _child(
                $menu_akses,
                "Survei DO",
                "honda_laporan_survei_do",
                ($index == 'honda_laporan_survei_do') ? "active" : "",
                base_url("marketing_support/honda_laporan_survei_do")
            );
            echo "</ul></li>";

            // HINO
            echo _header($menu_akses, "<strong>HINO</strong>", "hino_header");
            echo open_parent("icon-ios-bookmarks-outline", "Laporan");
            echo _child(
                $menu_akses,
                "Survei DO",
                "hino_laporan_survei_do",
                ($index == 'hino_laporan_survei_do') ? "active" : "",
                base_url("marketing_support/hino_laporan_survei_do")
            );
            echo "</ul></li>";

            // Customer Digital Leads
            echo _header($menu_akses, "<strong>Customer Digital Leads</strong>", "cust_dl");

            echo open_parent("icon-table2", "Wuling");
            echo _child(
                $menu_akses,
                "Tambah Cust. by Excel",
                "wuling_dl_tambah_excel",
                ($index == 'wuling_dl_tambah_excel') ? "active" : "",
                base_url("digital_leads/wuling_dl_tambah_excel")
            );
            echo _child(
                $menu_akses,
                "Tambah Cust. Satuan",
                "wuling_dl_tambah_satuan",
                ($index == 'wuling_dl_tambah_satuan') ? "active" : "",
                base_url("digital_leads/wuling_dl_tambah_satuan")
            );
            echo _child(
                $menu_akses,
                "Daftar Customer",
                "wuling_dl_customer",
                ($index == 'wuling_dl_customer') ? "active" : "",
                base_url("digital_leads/wuling_dl_customer")
            );
            echo _child(
                $menu_akses,
                "Data Follow Up",
                "wuling_dl_followup",
                ($index == 'wuling_dl_followup') ? "active" : "",
                base_url("digital_leads/wuling_dl_followup")
            );
            echo _child(
                $menu_akses,
                "Customer Lost",
                "wuling_dl_cust_lost",
                ($index == 'wuling_dl_cust_lost') ? "active" : "",
                base_url("digital_leads/wuling_dl_cust_lost")
            );
            echo "</ul></li>";

            echo _header($menu_akses, "<strong>Laporan Digital Leads</strong>", "lap_dl");
            echo open_parent("icon-table2", "Wuling");
            echo _child(
                $menu_akses,
                "History Follow Up",
                "wuling_history_fu",
                ($index == 'wuling_history_fu') ? "active" : "",
                base_url("digital_leads/wuling_history_fu")
            );
            echo _child(
                $menu_akses,
                "Customer SPK & DO",
                "wuling_lap_cust_spk_do",
                ($index == 'wuling_lap_cust_spk_do') ? "active" : "",
                base_url("digital_leads/wuling_lap_cust_spk_do")
            );
            echo "</ul></li>";

            echo _header($menu_akses, "<strong>Master Data Digi. Leads</strong>", "master_dl");
            echo open_parent("icon-table2", "Wuling");
            echo _child(
                $menu_akses,
                "Sales Digital",
                "wuling_master_sales_digital",
                ($index == 'wuling_master_sales_digital') ? "active" : "",
                base_url("digital_leads/wuling_master_sales_digital")
            );
            echo _child(
                $menu_akses,
                "Status Customer",
                "wuling_master_status_customer",
                ($index == 'wuling_master_status_customer') ? "active" : "",
                base_url("digital_leads/wuling_master_status_customer")
            );
            echo _child(
                $menu_akses,
                "Status Follow Up",
                "wuling_master_status_followup",
                ($index == 'wuling_master_status_followup') ? "active" : "",
                base_url("digital_leads/wuling_master_status_followup")
            );
            echo _child(
                $menu_akses,
                "Keterangan Follow Up",
                "wuling_master_keterangan_followup",
                ($index == 'wuling_master_keterangan_followup') ? "active" : "",
                base_url("digital_leads/wuling_master_keterangan_followup")
            );
            echo "</ul></li>";
            ?>
        </ul>
        <br><br>
    </div>
</div>
<script>
    $('ul.menu-content:empty').closest('li').remove();
    $('.active').click(function(e) {
        e.preventDefault();
    });
</script>