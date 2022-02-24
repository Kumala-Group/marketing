<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Marketing Kumala Group</title>
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/img_marketing/img/logo.png">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/img_marketing/img/logo.png">
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
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/img_marketing/dist/themes/default/style.min.css">
    <script src="<?= base_url() ?>assets/img_marketing/dist/jstree.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.js"></script>
    <link href="<?= base_url() ?>assets/img_marketing/dist/summernote.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/img_marketing/dist/datepicker.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/img_marketing/dist/bootstrap-datepicker.js"></script>
    
    <!--toastr -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/robust/app-assets/vendors/css/extensions/toastr.css')?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/robust/app-assets/vendors/css/extensions/toastr.min.css')?>">

    <!--sweetalert -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/robust/app-assets/vendors/css/extensions/sweetalert.css')?>"> -->


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- multiselect: https://github.com/davidstutz/bootstrap-multiselect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js" integrity="sha512-ljeReA8Eplz6P7m1hwWa+XdPmhawNmo9I0/qyZANCCFvZ845anQE+35TuZl9+velym0TKanM2DXVLxSJLLpQWw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.min.css" integrity="sha512-wHTuOcR1pyFeyXVkwg3fhfK46QulKXkLq1kxcEEpjnAPv63B/R49bBqkJHLvoGFq6lvAEKlln2rE1JfIPeQ+iw==" crossorigin="anonymous" />
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <style>
        .border-secondary {
            border-color: #eee;
        }

        .error {
            padding-top: 5px;
            color: #DA4453;
        }

        .select2-container--classic .select2-selection--single,
        .select2-container--default .select2-selection--single {
            height: 32px !important;
            padding: 2px;
            border-color: #D9D9D9 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 4px;
            right: 1px;
            width: 20px;
        }

        @media (min-width: 1367px) {

            .select2-container--classic .select2-selection--single,
            .select2-container--default .select2-selection--single {
                height: 37px !important;
                padding: 4px;
                border-color: #D9D9D9 !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 6px;
                right: 1px;
                width: 20px;
            }
        }
    </style>
</head>

<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns fixed-navbar">
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav">
                    <li class="nav-item mobile-menu hidden-md-up float-xs-left">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="navbar-brand nav-link"><img alt="branding logo" src="<?= base_url() ?>assets/img_marketing/img/kumala.png" data-expand="<?= base_url() ?>assets/img_marketing/img/kumala.png" data-collapse="<?= base_url() ?>assets/img_marketing/img/logo.png" class="brand-logo"></a>
                    </li>
                    <li class="nav-item hidden-md-up float-xs-right">
                        <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content container-fluid">
                <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                    <ul class="nav navbar-nav">
                        <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5"> </i></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-xs-right">
                        <li class="dropdown dropdown-notification nav-item">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="nav-link nav-link-label">
                                <i class="ficon icon-bell4"></i><span class="tag tag-pill tag-default tag-danger tag-default tag-up counter"></span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifikasi</span>
                                        <span class="notification-tag tag tag-default tag-danger float-xs-right m-0 counter"></span>
                                    </h6>
                                </li>
                                <li class="list-group scrollable-container" id="notifikasi"></li>
                                <li class="dropdown-menu-footer" style="display: none;">
                                    <a href="<?= base_url("notifikasi") ?>" class="dropdown-item text-muted text-xs-center">Lihat semua notifikasi</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                <span class="avatar avatar-online"><img src="<?= base_url() ?>assets/robust/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"></span>
                                <span class="user-name"><?= $this->session->userdata('nama_lengkap') ?></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?= base_url() ?>marketing/logout" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?= $this->view('component/sidebar') ?>
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-body">
                <?= $this->view($content) ?>
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
    <script src="<?= base_url() ?>assets/img_marketing/dist/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/img_marketing/dist/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>assets/img_marketing/dist/summernote.min.js"></script>

     <!-- toastr -->
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/extensions/toastr.min.js')?>"></script>
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/extensions/toastr-custom.js')?>"></script>

    <!-- sweetalert2 -->
    <!-- <script src="<?= base_url('assets/robust/app-assets/vendors/js/sweetalert2/sweetalert2.all.min.js')?>"></script> -->

    <script>
        $('.table_aplikasi').DataTable({
            "ordering": false
        });
        $('#tanggal').datepicker({
            'format': 'dd-mm-yyyy'
        });
        $('.summernote').summernote();
        <?php if (in_array($this->session->userdata('level'), [1, 2])) { ?>
            var html = "";
            refresh_notifikasi();
            setInterval(function() {
                html = "";
                refresh_notifikasi();
            }, (60 * 1000));
        <?php } ?>
        $('a[data-toggle="tab"]').on('show.bs.tab', function() {
            if ($(this).attr('href') != "#tab1")
                localStorage.setItem('active', $(this).attr('href'));
        });
        var active = localStorage.getItem('active');
        if (active) $('.nav-tabs a[href="' + active + '"]').tab('show');

        function input_number(e) {
            if ($.inArray(e.which, [187, 107, 8, 37, 39, 46, 190]) != -1) {
                return;
            } else if ((e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105)) {
                e.preventDefault();
            }
        }

        function format_rupiah(e) {
            var number_string = e.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                r = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                r += separator + ribuan.join('.');
            }
            return r;
        }

        function refresh_notifikasi() {
            $.post("<?= base_url("notifikasi") ?>", {
                'load': true
            }, function(r) {
                $('.counter').html(r.count + " Baru");
                if (r.notifikasi == undefined) {
                    html = '<a href="javascript:void(0)" class="list-group-item"><p class="notification-text text-muted m-0">Tidak ada notifikasi untuk saat ini.</p></a>';
                    $('.dropdown-menu-footer').css('display', "none");
                } else {
                    $.each(r.notifikasi, function(key, v) {
                        var status = v.status == 1 ? "text-muted" : "";
                        html += '<a href="javascript:void(0)" onclick="update_notifikasi(' + v.id + ',`<?= base_url() ?>' + v.link + '`);" class="list-group-item"><div class="media"><div class="media-body"><h6 class="media-heading ' + status + '">' + v.kategori + '</h6><p class="notification-text font-small-3 text-muted">' + v.deskripsi + '</p><small><time class="media-meta text-muted">' + v.time + '</time></small> </div> </div> </a>';
                    });
                    $('.dropdown-menu-footer').removeAttr("style");
                }
                $('#notifikasi').html(html);
            }, "json");
        }

        function update_notifikasi(id, link) {
            $.post("<?= base_url("notifikasi") ?>", {
                'update': true,
                'id': id
            }, function() {
                location = link;
            });
        }

        function loading() {
            $('.form-body').block({
                message: '<div class="icon-spinner9 icon-spin icon-lg"></div>',
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
            localStorage.setItem('saveButtonState', $('#submit').html());
            $('#submit').prop('disabled', true);
            $('#submit').html('<i class="icon-check2"></i> Loading...');
        }

        function unload() {
            $('.form-body').unblock();
            $('#submit').remove();
        }

        function reload() {
            var buttonState = localStorage.getItem('saveButtonState');
            $('.form-body').unblock();
            $('#submit').prop('disabled', false);
            $('#submit').html(buttonState);
        }

        function toAngka(rp) {
            var replaced = rp.replace(/[.,]/g,
                function(piece) {
                    var replacements = {
                        ".": ' ',
                        ",": "."
                    };
                    return replacements[piece] || piece;
                });
            return replaced.split(' ').join("");
        }

        function pesan(status, teks) {
            if (status == 'success') {
                v_status = 'Sukses';
                v_class = 'gritter-success';
            }
            if (status == 'error') {
                v_status = 'Error'
                v_class = 'gritter-error';
            }
            if (status == 'warning') {
                v_status = 'Peringatan'
                v_class = 'gritter-warning';
            }		
            toastr[status](teks, v_status);
        }
    </script>
</body>

</html>