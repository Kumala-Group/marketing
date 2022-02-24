<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Berita</h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab1">
                                    <p class="card-title m-0" id="title_user">Tambah</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab2">
                                    <p class="card-title m-0">Kumala Group</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab3">
                                    <p class="card-title m-0">Honda KMG</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab4">
                                    <p class="card-title m-0">Mazda</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab5">
                                    <p class="card-title m-0">Carimobilku</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane" id="tab1">
                                <form id="form" class="form">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-1">
                                                    <select id="website" name="website" class="form-control" required>
                                                        <option value="" selected disabled>-- Silahkan Pilih Website --</option>
                                                        <option value="kumalagroup">Kumala Group</option>
                                                        <option value="honda">Honda KMG</option>
                                                        <option value="mazda">Mazda</option>
                                                        <option value="carimobilku">Carimobilku</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <select id="tipe" name="tipe" class="form-control" required>
                                                        <option value="" selected disabled>-- Silahkan Pilih Tipe --</option>
                                                        <option value="berita">Berita</option>
                                                        <option value="promo">Promo</option>
                                                        <option value="tips">Tips</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control summernote" required></textarea>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="level">Gambar Thumbnail <small class="text-danger">*Maks 50kB</small></label>
                                                    <input type="file" id="thumb" name="thumb" class="form-control-file" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="level">Gambar <small class="text-danger">*Maks 300kB</small></label>
                                                    <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                                </div>
                                                <!-- <p>Opsional dalam Bahasa Inggris</p>
                                                <div class="form-group mb-1">
                                                    <input type="text" id="title" name="title" class="form-control" placeholder="Title">
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="description">Description</label>
                                                    <textarea id="description" name="description" rows="2" class="form-control summernote"></textarea>
                                                </div> -->
                                                <input type="hidden" id="id" name="id" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions center">
                                        <a href="" class="btn btn-warning mr-1">
                                            <i class="icon-reload"></i> Reset
                                        </a>
                                        <button id="submit" class="btn btn-primary" disabled>
                                            <i class="icon-check2"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane active" id="tab2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#child_tab2">
                                            <p class="card-title m-0">Berita</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab3">
                                            <p class="card-title m-0">Promo</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab4">
                                            <p class="card-title m-0">Tips</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    <div class="tab-pane active" id="child_tab2">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($berita as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab3">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($promo as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab4">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tips as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#child_tab5">
                                            <p class="card-title m-0">Berita</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab6">
                                            <p class="card-title m-0">Promo</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab7">
                                            <p class="card-title m-0">Tips</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    <div class="tab-pane active" id="child_tab5">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($honda_berita as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab6">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($honda_promo as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab7">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($honda_tips as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#child_tab8">
                                            <p class="card-title m-0">Berita</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab9">
                                            <p class="card-title m-0">Promo</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab10">
                                            <p class="card-title m-0">Tips</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    
                                    <div class="tab-pane active" id="child_tab8">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($mazda_berita as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab9">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($mazda_promo as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab10">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($mazda_tips as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab5">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#child_tab11">
                                            <p class="card-title m-0">Berita</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab12">
                                            <p class="card-title m-0">Promo</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#child_tab13">
                                            <p class="card-title m-0">Tips</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    
                                    <div class="tab-pane active" id="child_tab11">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($carimobilku_berita as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($carimobilku_promo as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="child_tab13">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Tipe</th>
                                                        <th>Deskripsi</th>
                                                        <th>Gambar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($carimobilku_tips as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->judul ?></td>
                                                            <td><?= ucwords($r->type) ?></td>
                                                            <td><?= substr(strip_tags($r->deskripsi), 0, 300) ?>...</td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/berita/<?= $r->gambar ?>" width="200px"></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("#judul").keyup(function() {
        $('#submit').removeAttr('disabled');
    });
    $('#submit').click(function(e) {
        var breakout = false;
        e.preventDefault();
        if ($('#form').valid()) {
            var form_data = new FormData();
            form_data.append('simpan', true);
            $.each($('.form-body').find('.form-control'), function() {
                form_data.append($(this).attr('id'), $(this).val());
            });
            if ($('#thumb')[0].files.length != 0) {
                var thumb = $('#thumb')[0].files[0];
                var allowed_types = ["jpg", "jpeg", "png"];
                var ext = thumb.name.split(".").pop().toLowerCase();
                form_data.append('thumb', thumb);
                if ($.inArray(ext, allowed_types) == -1) {
                    swal("", "Silahkan pilih file gambar!", "warning");
                    breakout = true;
                }
                if ($('#thumb')[0].files[0].size / 1048576 > 0.05) {
                    swal("", "Ukuran file melebihi 50kB!", "warning");
                    breakout = true;
                }
            }
            if ($('#gambar')[0].files.length != 0) {
                var gambar = $('#gambar')[0].files[0];
                var allowed_types = ["jpg", "jpeg", "png"];
                var ext = gambar.name.split(".").pop().toLowerCase();
                form_data.append('gambar', gambar);
                if ($.inArray(ext, allowed_types) == -1) {
                    swal("", "Silahkan pilih file gambar!", "warning");
                    breakout = true;
                }
                if ($('#gambar')[0].files[0].size / 1048576 > 0.3) {
                    swal("", "Ukuran file melebihi 300kB!", "warning");
                    breakout = true;
                }
            }
            if (breakout) return false;
            else {
                loading();
                $.ajax({
                    type: 'post',
                    url: location,
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(r) {
                        if (r == 1) swal("", "Data berhasil disimpan!", "success").then(function() {
                            location.reload();
                        });
                        else if (r == 2) swal("", "Data berhasil diupdate!", "success").then(function() {
                            location.reload();
                        });
                        else swal("", "Data gagal disimpan!", "error").then(function() {
                            unload();
                        });
                    }
                });
            }
        }
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_user').html("Edit");
        $('#id').val(id);
        $('.nav-tabs a:first').tab('show');
        $('#thumb').removeAttr('required');
        $('#gambar').removeAttr('required');
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#website').val(r.website);
                $('#judul').val(r.judul);
                $('#tipe').val(r.tipe);
                $('#deskripsi').summernote('code', r.deskripsi);
                $('#title').val(r.title);
                $('#description').summernote('code', r.description);
            },
            "json"
        );
    }

    function hapus_data(id, data) {
        swal({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus data " + data + "!",
            icon: "warning",
            buttons: true
        }).then((ok) => {
            if (ok) {
                $.post(location, {
                    'hapus': true,
                    'id': id
                }, function() {
                    swal("", "Data berhasil dihapus!", "success").then(function() {
                        location.reload();
                    });
                });
            }
        });
    }
</script>