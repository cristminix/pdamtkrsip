<div class="row">
	<div class="col-lg-12">
		<h3><i class="fa fa-star fa-fw"></i> Data Pengangkatan Capeg Pegawai</h3>
		<div class="panel panel-success">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<div class="row">
          <form role="form" id="form_capeg">
            <div class="col-lg-6">
							<div class="form-group">
								<label>TMT Capeg</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="tmt_capeg">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('tmt_capeg',$data->tmt_capeg,'class="form-control" id="tmt_capeg" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date datetimePicker -->
                </div>
                <!-- /.dateContainer -->
              </div>
			  
			    	<label>Masa Kerja Pengangkatan Capeg</label>
								<div class="form-group input-group">
									<span class="input-group-addon">Tahun</span>
									<?=form_input('mk_th',$data->mk_th,'class="form-control"');?>
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon">Bulan</span>
									<?=form_input('mk_bl',$data->mk_bl,'class="form-control"');?>
								</div>
			  
              <!-- /.form-group -->
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-6">
							<div class="form-group">
								<label>Nomor SK</label>
								<?=form_input('sk_nomor',$data->sk_nomor,'class="form-control"');?>
								
							</div>
							<div class="form-group">
								<label>Tanggal SK</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="sk_tanggal">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('sk_tanggal',$data->sk_tanggal,'class="form-control" id="sk_tanggal" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date datetimePicker -->
                </div>
                <!-- /.dateContainer -->
							</div>
							<div class="form-group">
								<label>Pejabat Penetap</label>
								<?=form_input('sk_pejabat',$data->sk_pejabat,'class="form-control"');?>

                </div>
              <button type="submit" class="btn btn-primary btn-block">Simpan</button>
            </div>
            <!-- /.col-lg-6 (nested) -->
          </form>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<script type="text/javascript">
$(document).ready(function() {
    if($("input[name='tmt_capeg']").val() == '00-00-0000'){$("input[name='tmt_capeg']").val('');}
    if($("input[name='sk_tanggal']").val() == '00-00-0000'){$("input[name='sk_tanggal']").val('');}
    $('.datetimePicker #tmt_capeg').datetimepicker();
    $('.datetimePicker #sk_tanggal').datetimepicker();
    $('form#form_capeg')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					tmt_capeg: { validators: { date: { format: 'DD-MM-YYYY'} } },
					sk_tanggal: { validators: { date: { format: 'DD-MM-YYYY'} } }
				}
			})
			.on('error.validator.bv', function(e, data){
				/* // Prevent li.active menu become affected */
				$("li.bv-tab-error").removeClass('bv-tab-error')
			})
			.on('success.validator.bv', function(e, data){
				/* // Prevent li.active menu become affected */
				$("li.bv-tab-success").removeClass('bv-tab-success')
			})
			.on('success.form.bv', function(e) {
				// Prevent form submission
				e.preventDefault();

				// Get the form instance
				var $form = $(e.target);

				// Get the BootstrapValidator instance
				var bv = $form.data('bootstrapValidator');

				var data = $("form#form_capeg").serializeArray();
				data.push({name: 'ID', value: '<?php echo $id_pegawai;?>'});
				data.push({name: 'm', value: 'capeg'});
				data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitform');?>", data, function(result) {
					// enabling submit button for next submit
					$("div#dropdown22 button:disabled").removeAttr('disabled');
					// show alert notification
					$( "#dropdown22 .row .col-lg-12" ).prepend( result );
					// set alert notification to automaticaly close
					$(".alert").delay(4000).slideUp(200, function() {
						$(this).alert('close');
					});
				});
			});
      $('.datetimePicker #tmt_capeg')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_capeg').bootstrapValidator('revalidateField', 'tmt_capeg');
      });
      $('.datetimePicker #sk_tanggal')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_capeg').bootstrapValidator('revalidateField', 'sk_tanggal');
      });
});
</script>