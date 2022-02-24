<script type="text/javascript">
$(document).ready(function(){

	$("#simpan_open_username").click(function(){

		var string = $("#form-open-username").serialize();


		if(!$("#change_username").val()){
			$.gritter.add({
				title: 'Peringatan..!!',
				text: 'Username tidak boleh kosong',
				class_name: 'gritter-error'
			});

			$("#change_username").focus();
			return false();
		}



		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ban_adm_profil/simpan_open_username",
			data	: string,
			cache	: false,
			start : $("#simpan_open_username").html('...Sedang diproses...'),
			success	: function(data){
				$("#simpan_open_username").html('<i class="icon-save"></i> Simpan');
				$.gritter.add({
					title: 'Info..!!',
					text: data,
					class_name: 'gritter-error'
				});
			}
		});

	});

});
</script>
<div class="row-fluid">
    <div class="span12">
    	<form name="form-open-username" id="form-open-username">
        <fieldset>
        <div class="profile-user-info">

						<div class="profile-info-row">
                <div class="profile-info-name"> Username </div>
                <div class="profile-info-value">
                    <input type="text" name="change_username" id="change_username" value="<?php echo $open_username;?>" class="span6"  />
                </div>
            </div>

		    </div><!--profil info-->
        </fieldset>
        <div class="form-actions center">
             <button type="button" name="simpan_open_username" id="simpan_open_username" class="btn btn-mini btn-primary">
             <i class="icon-save"></i> Simpan
             </button>
        </div>
		</form>
    </div><!--/span-->
</div><!--/row-fluid-->
