<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="KumalaGroup">
    <title>Marketing Kumala Group</title>
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/img_marketing/img/logo.png">
    <link rel=" shortcut icon" type="image/png" href="<?= base_url() ?>assets/img_marketing/img/logo.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
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

        .bg {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            background-image: url("<?= base_url("assets/images/background.jpg") ?>");
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
                                <img src="<?= base_url('assets/images/kmg-logo.png') ?>" xwidth="170" alt="branding logo"></div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <form class="form-horizontal form-simple" id="form">
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

                                        <button type="submit" id="submit" class="btn btn-info btn-round btn-block" style="border-radius: 25px;"><i class="icon-unlock2"></i> Login</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-transparent">
                                <div>
                                    <p class="text-xs-center text-danger" id="error" style="display: none;"></p>
                                    <p class="text-xs-center text-gray-dark m-0" style="font-size: 10pt;">Copyright © 2020 IT Kumala Group. All Rights Reserved. <br>
                                        <!-- <strong> Marketing Kumala Connect.V.1.00</strong></p> -->
                                        <strong><?= (empty($version->versi_update)) ? '' : $version->versi_update ?></strong></p>
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
    <script src="<?= base_url('assets/img_marketing/dist/sweetalert.min.js') ?>"></script>

    <script>
        var form = $('#form');
        $('#submit').click(function(e) {
            e.preventDefault();
            var data = form.serialize();
            if (form.valid()) {
                $.post(location, data, function(r) {
                    if (r == 1) {
                        swal("Berhasil", "Login sukses!", "success").then(function() {                            
                            location.reload();
                        });
                    }
                    else {
                        swal("Kesalahan", "Username atau Password salah!", "warning").then(function() {
                            form.trigger('reset');
                            unload();
                        });                        
                    }
                });
            }
        });
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