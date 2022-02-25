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
            // echo _child(
            //     $menu_akses,
            //     "Tiket",
            //     "tiket",
            //     ($index == 'tiket') ? "active" : "",
            //     base_url("admin/tiket")
            // );
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