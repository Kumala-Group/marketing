<div class="mb-3 title-page"><i class="fa <?php echo $icon;?> title-page-icon"></i> <span class="title-page-text">Edit Profil</span></div>
    <div class="row">
  	    <div class="col-sm-3"><!--left col-->             

            <div class="text-center">
            <form role="form" class="form" name="form-image" id="form-image" enctype="multipart/form-data">
                <h5 id="user_name"><?php echo $nama;?></h5>
                <img src="<?php echo $url_image_profil;?>" id="img_show" class="avatar rounded-circle img-thumbnail mb-2" alt="avatar" style="height:200px;width:200px;">
                <h6 id="file_name">Update Profil Picture</h6>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="userfile" name="userfile" accept="image/*" required>
                    <label class="custom-file-label text-md-left text-left" for="customFile">Browse file</label>
                </div>
                <button type="button" name="update_image" id="update_image" class="btn btn-primary btn-md mt-3"><i class="fa fa-floppy-o"></i> Update</button>
            </form>
            </div>
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link nav-link-new active" data-toggle="tab" href="#profil"><i class="fa fa-user-circle"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link nav-link-new" data-toggle="tab" href="#akun"><i class="fa fa-key"></i> Account</a></li>
              </ul>

              
          <div class="tab-content tab-content-new">
            <div class="tab-pane active" id="profil">
                <div class="form-place-body mt-3">
                    <form role="form" class="form" name="form-profil" id="form-profil">
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama; ?>" Placeholder="Nama" required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" name="nik" id="nik" value="<?php echo $nik; ?>" Placeholder="NIK" required>
                                </div>
                            </div> 
                            <!-- <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $alamat; ?>" Placeholder="Alamat" required>
                                </div>
                            </div>   
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>Kontak</label>
                                    <input type="text" class="form-control" name="kontak" id="kontak" value="<?php echo $kontak; ?>" Placeholder="Kontak" required>
                                </div>
                            </div>                    -->
                    </form>
                </div> 
                <div class="form-place-footer text-center pt-0 pb-3">
                        <button type="button" name="update_profil" id="update_profil" class="btn btn-primary btn-md"><i class="fa fa-floppy-o"></i> Update</button>
                </div>
            </div><!--/tab-pane-->

            <div class="tab-pane" id="akun">
                <div class="form-place-body mt-3">
                    <form role="form" class="form" name="form-akun" id="form-akun">
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" Placeholder="Username" required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>Old Password</label>
                                    <input type="password" class="form-control" name="pass_old" id="pass_old" Placeholder="*****" required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" name="pass_new" id="pass_new" Placeholder="*****" required>
                                </div>
                            </div>     
                            <div class="form-group">
                                <div class="col-sm-12 p-0">
                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-control" name="pass_new_konfirm" id="pass_new_konfirm" Placeholder="*****" data-parsley-equalto="#pass_new" required>
                                </div>
                            </div>             
                    </form>
                </div> 
                <div class="form-place-footer text-center pt-0 pb-3">
                        <button type="button" name="update_akun" id="update_akun" class="btn btn-primary btn-md"><i class="fa fa-floppy-o"></i> Update</button>
                </div>
            </div><!--/tab-pane-->
           
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div>
<script>
$(document).ready(function() {

    $("#update_image").click(function(e) {
        e.preventDefault();
        if($('#form-image').parsley().validate()){
            var param = this;
            process1(param);
            var form = $('form')[0];
            var form_data = new FormData(form);
            ax_save = $.ajax({
                type    : 'POST',
                data    : form_data,
                contentType : false,
                processData : false,
                cache: false,
                async:false,
                url     : "<?php echo site_url('g_profil/update_image');?>",
                success : function(data) {
                process_done1(param,'<i class="fa fa-floppy-o"></i> Update'); 
                Swal.fire('Success!','Updated Successfully','success');
                d = new Date();
                $('#img_header').attr('src', data+'?'+d.getTime());
                $('#file_name').text('Update your profil picture');
                }
            }); 
        
        }else {
        return false();
        }

    });

    $("#update_profil").click(function(e) {
        e.preventDefault();
        if($('#form-profil').parsley().validate()){
        Swal.fire({
                title: 'Are you sure?',
                text: "Please check your data!",
                type: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    var param = this;
                    process1(param);
                    var form = $('form')[1];
                    var form_data = new FormData(form);
                    ax_save = $.ajax({
                        type    : 'POST',
                        data    : form_data,
                        contentType : false,
                        processData : false,
                        cache: false,
                        async:false,
                        url     : "<?php echo site_url('g_profil/update_profil');?>",
                        success : function(data) {
                        process_done1(param,'<i class="fa fa-floppy-o"></i> Update'); 
                        Swal.fire('Success!','Updated Successfully','success');
                        $('#user_name').text($('#nama').val());
                        $('#user_name_head').text($('#nama').val());
                        }
                    });
                }
                })   
        
        }else {
        return false();
        }

    });

    $("#update_akun").click(function(e) {
        e.preventDefault();
        if($('#form-akun').parsley().validate()){
        Swal.fire({
                title: 'Are you sure?',
                text: "Please check your data!",
                type: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    var param = this;
                    process1(param);
                    var form = $('form')[2];
                    var form_data = new FormData(form);
                    ax_save = $.ajax({
                        type    : 'POST',
                        data    : form_data,
                        contentType : false,
                        processData : false,
                        cache: false,
                        async:false,
                        url     : "<?php echo site_url('g_profil/update_akun');?>",
                        success : function(data) {
                            process_done1(param,'<i class="fa fa-floppy-o"></i> Update'); 
                            if(data=='0'){
                                Swal.fire('Error!','Password Lama salah','error');
                                $('#pass_old').focus();
                            }else{
                                Swal.fire('Updated Successfully!','','success');
                            }                        
                        }
                    });
                }
                })   
        
        }else {
        return false();
        }

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.fileName = input.files[0].name;
            reader.onload = function(e) {
                $('#img_show').attr('src', e.target.result);
                $('#file_name').text(e.target.fileName);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#userfile").change(function() {
        readURL(this);
    });

});
</script>
<script>
    $('#loading').hide();    
</script>