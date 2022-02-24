<script type="text/javascript">
$(document).ready(function(){

	$("#simpan_pwd").click(function(){

		var string = $("#form-pwd").serialize();


		if(!$("#pwd_1").val()){
			$.gritter.add({
				title: 'Peringatan..!!',
				text: 'Password tidak boleh kosong',
				class_name: 'gritter-error'
			});

			$("#pwd_1").focus();
			return false();
		}

		if(!$("#pwd_2").val()){
			$.gritter.add({
				title: 'Peringatan..!!',
				text: 'Ulangi Password tidak boleh kosong',
				class_name: 'gritter-error'
			});

			$("#pwd_2").focus();
			return false();
		}

		if($("#pwd_1").val() != $("#pwd_2").val()){
			$.gritter.add({
				title: 'Peringatan..!!',
				text: 'Password baru tidak sama',
				class_name: 'gritter-error'
			});

			$("#pwd_2").focus();
			return false();
		}


		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ban_adm_profil/simpan_pwd",
			data	: string,
			cache	: false,
			start : $("#simpan_pwd").html('...Sedang diproses...'),
			success	: function(data){
				$("#simpan_pwd").html('<i class="icon-save"></i> Simpan');
				$.gritter.add({
					title: 'Info..!!',
					text: data,
					class_name: 'gritter-info'
				});
			}
		});

	});

});
</script>
<div class="row-fluid">
    <div class="span12">
    	<form name="form-pwd" id="form-pwd">
        <fieldset>
        <div class="profile-user-info">
        	<div class="profile-info-row">
                <div class="profile-info-name"> Password Lama </div>
                <div class="profile-info-value">
                    <input type="password" name="old_pwd" id="old_pwd" class="span6"  />
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Password Baru </div>
                <div class="profile-info-value">
                    <input type="password" name="pwd_1" id="pwd_1" class="span6"  />
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Ulangi Password Baru </div>
                <div class="profile-info-value">
                    <input type="password" name="pwd_2" id="pwd_2" class="span6"  />
                </div>
            </div>

		</div><!--profil info-->
        </fieldset>
        <div class="form-actions center">
             <button type="button" name="simpan_pwd" id="simpan_pwd" class="btn btn-mini btn-primary">
             <i class="icon-save"></i> Simpan
             </button>
        </div>
		</form>
    </div><!--/span-->
</div><!--/row-fluid-->
