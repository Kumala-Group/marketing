<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?= $version->versi_update ?>">
    <meta name="keywords" content="Kumala Group">
    <meta name="author" content="PIXINVENT">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <title>Login page - <?= $this->config->item('nama_aplikasi'); ?></title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon_kmg.png" type="image/gif">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/vendors/css/extensions/pace.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/pages/login-register.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/img_marketing/dist/owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/img_marketing/dist/owlcarousel/dist/assets/owl.theme.default.min.css">

    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/img_marketing/dist/owlcarousel/dist/owl.carousel.min.js"></script>
    <style>
        .error {
            padding-top: 5px;
            color: red;
        }

        .form-simple input[type="text"] {
            margin-bottom: 10px;
        }

        .bg {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            background-image: url("<?= base_url("assets/images/support-bg.jpg") ?>");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column  blank-page blank-page bg">
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="offset-xs-1 col-lg-4 col-xl-3 col-md-5 col-sm-6 col-xs-10 p-0" style="margin-bottom: 100px;">
                        <div class="card m-0" style="border-radius: 25px;">
                            <div class="p-2 text-xs-center">
                                <img src="<?= base_url() ?>assets/img/logo.png" width="170" alt="branding logo"></div>
                                <h4 style="margin-top: -20px;"><center>IT Helpdesk</center></h4>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <form class="form-horizontal form-simple" id="form" method="post" action="<?php echo base_url(); ?>login_ticketing">
                                        <div class="alert alert-info" style="display: flex; justify-content: center;">
                                            Untuk login silakan masukkan NIK pada username dan password!
                                        </div>    
                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" style="border-radius: 25px;" required>
                                            <div class="form-control-position">
                                                <i class="icon-head"></i>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="border-radius: 25px;" required>
                                            <div class="form-control-position">
                                                <i class="icon-key3"></i>
                                            </div>
                                        </fieldset>

                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input type="checkbox" onclick="showPassword()"> <span class="lbl"> Lihat Password</span>
                                        </fieldset>

                                        
                                        
                                        <button type="submit" id="submit" class="btn btn-info btn-round btn-block" style="border-radius: 25px;"><i class="icon-unlock2"></i> Login</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-transparent">
                                <div>
                                    <div class="text-xs-center text-danger" id="error">
                                        <?php
                                        $valid = validation_errors();
                                        if (!empty($valid)) {
                                            echo validation_errors();
                                        }
                                        $info = $this->session->flashdata('result_login');
                                        if (!empty($info)) {
                                            echo validation_errors();
                                            echo $this->session->flashdata('result_login');
                                        }
                                        ?>
                                    </div>

                                    <p class="text-xs-center text-gray-dark m-0" style="font-size: 10pt;">Copyright © 2017 IT Kumala Group. All Rights Reserved. <br>
                                        <strong><?= $version->versi_update ?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="w-100" style="position: absolute;bottom: 0;padding-bottom: 30px;">
                    <div style="position: absolute; background-color: black; opacity: 0.3; width: 100%;height: 100%;"></div>
                    <div class="offset-md-1 col-md-10 pt-2">
                        <div class="owl-carousel owl-theme">
                            <?php foreach ($logo as $v) : ?>
                                <div class="item">
                                    <img src="<?= "https://kumalagroup.id/assets/img_marketing/partner/$v->gambar" ?>" alt="partner" width="auto" height="50" style="object-fit: contain;">
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/app.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/img_marketing/dist/jquery.validate.min.js"></script>
    <script>
        function showPassword() {
            var x = document.getElementById("password");

            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        $('.owl-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000,
            mouseDrag: false,
            responsiveClass: true,
            navs: false,
            dots: false,
            margin: 30,
            responsive: {
                576: {
                    items: 6,
                },
                768: {
                    items: 6,
                },
                992: {
                    items: 8,
                },
                1200: {
                    items: 10,
                }
            }
        });
    </script>
</body>

</html>