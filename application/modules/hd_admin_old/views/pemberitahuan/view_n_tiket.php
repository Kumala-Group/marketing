<script type="text/javascript">
		$(document).ready(function(){
				$("body").on("click", ".delete", function (e) {
						$(this).parent("div").remove();
				});

				$("#done_tiket").click(function(){
						var id_solv = $("#id_solv").val();
						var id_t_solv = $("#id_t_solv").val();
						var id_tiket = $("#id_tiket").val();
						var nik_exe = $("#nik_exe").val();
						var waktu_mulai = $("#waktu_mulai").val();

						var string = $("#my-form").serialize();



						$.ajax({
								type    : 'POST',
								url     : "<?php echo site_url(); ?>hd_adm_n_tiket/done",
								data    : string,
								cache   : false,
								success : function(data){
										alert(data);
										location.reload();
								}
						});
				});

		});

				function doneTiket(ID){
						var cari  = ID;
						console.log(cari);
						var string = $("#my-form"+cari).serialize();
					$.ajax({
						type    : 'POST',
						url     : "<?php echo site_url(); ?>hd_adm_n_tiket/done",
						data    : string,
						cache   : false,
						success : function(data){
								alert(data);
								location.reload();
						}
					});
				}
				function pendingTiket(ID){
						var cari  = ID;
						console.log(cari);
						var string = $("#my-form"+cari).serialize();
					$.ajax({
						type    : 'POST',
						url     : "<?php echo site_url(); ?>hd_adm_n_tiket/pending",
						data    : string,
						cache   : false,
						success : function(data){
								alert(data);
								location.reload();
						}
					});
				}
		function editData(ID){
				var cari  = ID;
				console.log(cari);
			$.ajax({
				type  : "GET",
				url   : "<?php echo site_url(); ?>hd_adm_ticketing/cari",
				data  : "cari="+cari,
				dataType: "json",
				success : function(data){
					$('#nik_exe').val('');
					$('#nama_exe').val('');
					$('#id_tiket').val(data.id_tiket);
					$('#nik').val(data.nik);
					$('#nama_pengadu').val(data.nama_karyawan);
					$('#cabang').val(data.nama_brand+' '+data.lokasi);
					$('#waktu_tiket').val(data.tgl_tiket+' '+data.wkt_tiket);
					$('#masalah').val(data.masalah);
					$('#priority').val(data.priority);
					$('#status_tiket').val(data.status_tiket);

				}
			});
		}
</script>
<link rel="stylesheet" href="<?php echo base_url();?>/assets/hd/assets/css/hdnotif.css" />
		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace-extra.js"></script>

        <div class="row-fluid">
									<div class="col-xs-12">
										<!-- #section:pages/inbox -->
										<div class="tabbable">

											<div class="tab-content no-border no-padding" style="width: 100%;">
												<div id="inbox" class="tab-pane in active">
													<div class="message-container">
														<!-- #section:pages/inbox.navbar -->
														<div id="id-message-list-navbar" class="message-navbar clearfix">
															<div class="message-bar">
																<div class="message-infobar" id="id-message-infobar">
																	<span class="blue bigger-150"><?php echo $judul;
                                  $this->load->model('model_isi');
                                  $n_nik = $this->session->userdata('username');
                                  $j_tiket= $this->model_isi->n_tiket($n_nik);?></span>
																	<span class="grey bigger-120">(<?php echo $j_tiket;?> ticket need respon!)</span>
																</div>


															</div>

															<div>




																<!-- /section:pages/inbox.navbar-search -->
															</div>
														</div>

														<!-- /section:pages/inbox.navbar -->
														<div class="message-list-container">
															<!-- #section:pages/inbox.message-list -->
															<div class="message-list" id="message-list">
																<!-- #section:pages/inbox.message-list.item -->

                                <?php

                                $i=1;
                                foreach($data->result() as $dt){ ?>
																<div class="message-item message-unread">
																	<label class="inline">
																		<span class="lbl">
                                      <?php
                                      if($dt->priority == 'Urgent'){
                                        echo "<button style='background-color:#ff4000;border: none;color: black;padding: 1px 7px;text-align: center;text-decoration: none;display: inline-block;font-size: 12px;'>";
                                      }elseif ($dt->priority == 'High') {
                                        echo "<button style='background-color:#ff8000;border: none;color: black;padding: 1px 13px;text-align: center;text-decoration: none;display: inline-block;font-size: 12px;'>";
                                      }elseif ($dt->priority == 'Normal') {
                                        echo "<button style='background-color:#ffbf00;border: none;color: black;padding: 1px 6px;text-align: center;text-decoration: none;display: inline-block;font-size: 12px;'>";
                                      }else {
                                        echo "<button style='background-color:#ffff00;border: none;color: black;padding: 1px 15px;text-align: center;text-decoration: none;display: inline-block;font-size: 12px;'>";
                                      }
                                      ?>
            <?php echo $dt->priority;?></button>
																		</span>
																	</label>

																	<span class="sender" title="<?php echo $dt->nama_karyawan.' - '.$dt->nama_brand.' '.$dt->lokasi;?>">
                                    <?php echo $dt->nama_karyawan.' - '.$dt->nama_brand.' '.$dt->lokasi;?></span>
																	<span class="time"><?php echo $dt->tgl_tiket.' '.$dt->wkt_tiket;?></span>

																	<span class="summary">
																		<span class="text">
																			<?php echo $dt->masalah;?>
																		</span>
																	</span>
																</div>
                                <?php } ?>

                                <div class="message-footer clearfix">

                                														</div>

                                														<div class="hide message-footer message-footer-style2 clearfix">

                                														</div>

															</div>


															<!-- /section:pages/inbox.message-list -->
														</div>



													</div>
												</div>
											</div><!-- /.tab-content -->
										</div><!-- /.tabbable -->

										<!-- /section:pages/inbox -->
									</div><!-- /.col -->
								</div><!-- /.row -->

                <?php

                $i=0;
                foreach($data->result() as $dt){ ?>
								<div class="hide message-content" id="notif<?php echo $i++;?>" name="notif<?php echo $i;?>">
									<form class="form-horizontal" name="my-form<?php echo $dt->id_tiket;?>" id="my-form<?php echo $dt->id_tiket;?>">
									<div class="message-header clearfix">
										<div class="pull-left">
											<i class="ace-icon fa fa-user bigger-150 orange2 middle"></i>
											<input type="hidden" name="id_solv" id="id_solv">
											<input type="hidden" name="id_tiket" id="id_tiket" value="<?php echo $dt->id_tiket;?>">
											<input type="hidden" name="id_t_solv" id="id_t_solv" value="<?php echo $dt->id_t_solv;?>">
											<input type="hidden" name="nik_exe" id="nik_exe" value="<?php echo $dt->nik_exe;?>">
											<input type="hidden" name="waktu_mulai" id="waktu_mulai" value="<?php echo $dt->waktu_mulai;?>">

											&nbsp;
											<?php echo $dt->nama_karyawan;?>
											&nbsp;
                      <i class="ace-icon fa fa-building bigger-150 orange2 middle"></i>
											<a href="#" class="sender"><?php echo $dt->nama_brand.' '.$dt->lokasi;?></a>

											&nbsp;
											<i class="ace-icon fa fa-clock-o bigger-150 orange2 middle"></i>
											<span class="time grey"><?php echo $dt->tgl_tiket.' '.$dt->wkt_tiket;?></span>
										</div>


										<div class="pull-right action-buttons">
											<a class="btn btn-small btn-success pull-right" onclick="javascript:doneTiket('<?php echo $dt->id_tiket;?>')">
	                        <i class="icon-check"></i>Done
	                    </a>
											<a class="btn btn-small btn-warning pull-left" onclick="javascript:pendingTiket('<?php echo $dt->id_tiket;?>')">
	                        <i class="icon-flag"></i>Pending
	                    </a>
										</div>
										</form>
									</div>

									<!-- /section:pages/inbox.message-header -->
									<div class="hr hr-double"></div>

									<!-- #section:pages/inbox.message-body -->
									<div class="message-body">
										<?php echo $dt->masalah;?>
									</div>

									<!-- /section:pages/inbox.message-body -->
									<div class="hr hr-double"></div>

									<!-- #section:pages/inbox.message-attachment -->


									<!-- /section:pages/inbox.message-attachment -->
								</div><!-- /.message-content -->

                <?php } ?>




                		<script type="text/javascript">
                			window.jQuery || document.write("<script src='<?php echo base_url();?>/assets/hd/assets/js/jquery.js'>"+"<"+"/script>");
                		</script>

                		<!-- <![endif]-->

                		<!--[if IE]>
                <script type="text/javascript">
                 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
                </script>
                <![endif]-->
                		<script type="text/javascript">
                			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>/assets/hd/assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
                		</script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/bootstrap.js"></script>

                		<!-- page specific plugin scripts -->
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/bootstrap-tag.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/jquery.hotkeys.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/bootstrap-wysiwyg.js"></script>

                		<!-- ace scripts -->
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.scroller.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.colorpicker.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.fileinput.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.typeahead.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.wysiwyg.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.spinner.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.treeview.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.wizard.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.aside.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.ajax-content.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.touch-drag.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.sidebar.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.sidebar-scroll-1.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.submenu-hover.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.widget-box.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.settings.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.settings-rtl.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.settings-skin.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.widget-on-reload.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.searchbox-autocomplete.js"></script>

                		<!-- inline scripts related to this page -->
                		<script type="text/javascript">
                			jQuery(function($){

                				//handling tabs and loading/displaying relevant messages and forms
                				//not needed if using the alternative view, as described in docs
                				$('#inbox-tabs a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                					var currentTab = $(e.target).data('target');
                					if(currentTab == 'write') {
                						Inbox.show_form();
                					}
                					else if(currentTab == 'inbox') {
                						Inbox.show_list();
                					}
                				})



                				//basic initializations
                				$('.message-list .message-item input[type=checkbox]').removeAttr('checked');
                				$('.message-list').on('click', '.message-item input[type=checkbox]' , function() {
                					$(this).closest('.message-item').toggleClass('selected');
                					if(this.checked) Inbox.display_bar(1);//display action toolbar when a message is selected
                					else {
                						Inbox.display_bar($('.message-list input[type=checkbox]:checked').length);
                						//determine number of selected messages and display/hide action toolbar accordingly
                					}
                				});


                				//display first message in a new area
                        <?php

                        $i=0;
                        foreach($data->result() as $dt){ ?>
                        $('.message-list .message-item:eq(<?php echo $i;?>) .text').on('click', function(){
                					var message = $(this).closest('.message-item');

                					//if message is open, then close it
                					if(message.hasClass('message-inline-open')) {
                						message.removeClass('message-inline-open').find('.message-content').remove();
                						return;
                					}

                					$('.message-container').append('<div class="message-loading-overlay"><i class="fa-spin ace-icon fa fa-spinner orange2 bigger-160"></i></div>');
                					setTimeout(function() {
                						$('.message-container').find('.message-loading-overlay').remove();
                						message
                							.addClass('message-inline-open')
                							.append('<div class="message-content" />')
                						var content = message.find('.message-content:last').html( $('#notif<?php echo $i;$i++?>').html() );

                						//remove scrollbar elements
                						content.find('.scroll-track').remove();
                						content.find('.scroll-content').children().unwrap();

                						content.find('.message-body').ace_scroll({
                							size: 150,
                							mouseWheelLock: true,
                							styleClass: 'scroll-visible'
                						});

                					}, 500 + parseInt(Math.random() * 500));

                				});
                        <?php } ?>
                        var Inbox = {
                					//displays a toolbar according to the number of selected messages
                					display_bar : function (count) {
                						if(count == 0) {
                							$('#id-toggle-all').removeAttr('checked');
                							$('#id-message-list-navbar .message-toolbar').addClass('hide');
                							$('#id-message-list-navbar .message-infobar').removeClass('hide');
                						}
                						else {
                							$('#id-message-list-navbar .message-infobar').addClass('hide');
                							$('#id-message-list-navbar .message-toolbar').removeClass('hide');
                						}
                					}
                				}

                				//show message list (back from writing mail or reading a message)
                				Inbox.show_list = function() {
                					$('.message-navbar').addClass('hide');
                					$('#id-message-list-navbar').removeClass('hide');

                					$('.message-footer').addClass('hide');
                					$('.message-footer:not(.message-footer-style2)').removeClass('hide');

                					$('.message-list').removeClass('hide').next().addClass('hide');
                					//hide the message item / new message window and go back to list
                				}

                				//show write mail form
                				Inbox.show_form = function() {
                					if($('.message-form').is(':visible')) return;
                					if(!form_initialized) {
                						initialize_form();
                					}


                					var message = $('.message-list');
                					$('.message-container').append('<div class="message-loading-overlay"><i class="fa-spin ace-icon fa fa-spinner orange2 bigger-160"></i></div>');

                					setTimeout(function() {
                						message.next().addClass('hide');

                						$('.message-container').find('.message-loading-overlay').remove();

                						$('.message-list').addClass('hide');
                						$('.message-footer').addClass('hide');
                						$('.message-form').removeClass('hide').insertAfter('.message-list');

                						$('.message-navbar').addClass('hide');
                						$('#id-message-new-navbar').removeClass('hide');


                						//reset form??
                						$('.message-form .wysiwyg-editor').empty();

                						$('.message-form .ace-file-input').closest('.file-input-container:not(:first-child)').remove();
                						$('.message-form input[type=file]').ace_file_input('reset_input');

                						$('.message-form').get(0).reset();

                					}, 300 + parseInt(Math.random() * 300));
                				}




                				var form_initialized = false;
                				function initialize_form() {
                					if(form_initialized) return;
                					form_initialized = true;

                					//intialize wysiwyg editor
                					$('.message-form .wysiwyg-editor').ace_wysiwyg({
                						toolbar:
                						[
                							'bold',
                							'italic',
                							'strikethrough',
                							'underline',
                							null,
                							'justifyleft',
                							'justifycenter',
                							'justifyright',
                							null,
                							'createLink',
                							'unlink',
                							null,
                							'undo',
                							'redo'
                						]
                					}).prev().addClass('wysiwyg-style1');



                					//file input
                					$('.message-form input[type=file]').ace_file_input()
                					.closest('.ace-file-input')
                					.addClass('width-90 inline')
                					.wrap('<div class="form-group file-input-container"><div class="col-sm-7"></div></div>');

                					//Add Attachment
                					//the button to add a new file input
                					$('#id-add-attachment')
                					.on('click', function(){
                						var file = $('<input type="file" name="attachment[]" />').appendTo('#form-attachments');
                						file.ace_file_input();

                						file.closest('.ace-file-input')
                						.addClass('width-90 inline')
                						.wrap('<div class="form-group file-input-container"><div class="col-sm-7"></div></div>')
                						.parent().append('<div class="action-buttons pull-right col-xs-1">\
                							<a href="#" data-action="delete" class="middle">\
                								<i class="ace-icon fa fa-trash-o red bigger-130 middle"></i>\
                							</a>\
                						</div>')
                						.find('a[data-action=delete]').on('click', function(e){
                							//the button that removes the newly inserted file input
                							e.preventDefault();
                							$(this).closest('.file-input-container').hide(300, function(){ $(this).remove() });
                						});
                					});
                				}

                			});
                		</script>

                		<!-- the following scripts are used in demo only for onpage help and you don't need them -->
                		<link rel="stylesheet" href="<?php echo base_url();?>/assets/hd/assets/css/ace.onpage-help.css" />

                		<script type="text/javascript"> ace.vars['base'] = '..'; </script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/elements.onpage-help.js"></script>
                		<script src="<?php echo base_url();?>/assets/hd/assets/js/ace/ace.onpage-help.js"></script>

		<link rel="stylesheet" href="<?php echo base_url();?>/assets/hd/docs/assets/js/themes/sunburst.css" />
    <script src="<?php echo base_url();?>/assets/hd/docs/assets/js/rainbow.js"></script>
    <script src="<?php echo base_url();?>/assets/hd/docs/assets/js/language/generic.js"></script>
    <script src="<?php echo base_url();?>/assets/hd/docs/assets/js/language/html.js"></script>
    <script src="<?php echo base_url();?>/assets/hd/docs/assets/js/language/css.js"></script>
    <script src="<?php echo base_url();?>/assets/hd/docs/assets/js/language/javascript.js"></script>
