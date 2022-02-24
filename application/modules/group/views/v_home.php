<div class="mb-3 title-page"><i class="fa fa-home title-page-icon"></i> <span class="title-page-text">Data Posko</span></div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 p-0">
        <div class="form-place" id="form-place">
            <h5 class="mb-3" id="form-title"></h5>
            <form class="form" name="form-cari" id="form-cari">
                <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="inputState">Berangkat Dari :</label>
                    <select id="asal" name="asal" class="form-control">
                        <option value="" selected>-- Pilih Bus --</option>  
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="inputState">Tujuan Ke :</label>
                    <select id="tujuan" name="tujuan" class="form-control">
                        <option value="" selected>-- Pilih Bus --</option>  
                    </select>
                </div>
                </div>
                <div class="form-group">
                <label for="inputAddress">Tgl. Keberangkatan :</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control col-md-3" id="tanggal" name="tanggal" placeholder="DD/MM/YYYY">
                    <div class="input-group-prepend">
                    <div class="input-group-text"><span class="fa fa-calendar"></span></div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Nama Bus :</label>
                    <select id="bus" name="bus" class="form-control col-md-5">
                        <option value="" selected>-- Pilih Bus --</option>            
                    </select>
                </div>
                <button type="button" name="simpan" id="simpan" class="btn btn-primary btn-md"><i class="fa fa-floppy-o"></i> Simpan</button>
            </form>
        </div>        
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 p-0">       
        <div class="table-place">      
            <table class="table table-bordered dt-responsive nowrap" style="width:100%" id="example">
                <thead class="thead-light">
                    <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                    <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td><td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td><td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td><td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td><td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td><td class="text-center">
                            <a href="#" class="btn-action edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <a href="#" class="btn-action btn-action-delete delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>   
    </div>
</div>

<script>
$(document).ready(function() {
    $('#form-title').text('Tambah Data');
    $('#example').DataTable();
    $('#simpan').click(function(){
        proses1(this);
    });
    $('.edit').click(function(){
        proses1(this);
    });
    $('.delete').click(function(){
        proses1(this);
    });
});
</script>