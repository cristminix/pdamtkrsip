<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="fa fa-star-half-o fa-fw"></i> Data Pengangkatan Capeg Pegawai
			</div>
			<div class="panel-body">
				<div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>TMT Capeg</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="tmt_capeg">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('tmt_capeg',$data->tmt_capeg,'class="form-control" id="tmt_capeg" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY" disabled=""');?>
                  </div>
                  <!-- /.input-group date #datetimePicker -->
                </div>
                <!-- /.dateContainer -->
              </div>
              <!-- /.form-group -->
								<label>Masa Kerja Pengangkatan Capeg</label>
								<div class="form-group input-group">
									<span class="input-group-addon">Tahun</span>
									<?=form_input('mk_th',$data->mk_th,'class="form-control" disabled=""');?>
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon">Bulan</span>
									<?=form_input('mk_bl',$data->mk_bl,'class="form-control" disabled=""');?>
								</div>
              </div>
              <!-- /.col-lg-6 (nested) -->
							<div class="col-lg-6">
							<div class="form-group">
								<label>Nomor SK</label>
								<?=form_input('sk_nomor',$data->sk_nomor,'class="form-control" disabled=""');?>
							</div>
							<div class="form-group">
								<label>Tanggal SK</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="sk_tanggal">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('sk_tanggal',$data->sk_tanggal,'class="form-control" id="sk_tanggal" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY" disabled=""');?>
                  </div>
                  <!-- /.input-group date #datetimePicker -->
                </div>
                <!-- /.dateContainer -->
							</div>
							<div class="form-group">
								<label>Pejabat Penetap</label>
								<?=form_input('sk_pejabat',$data->sk_pejabat,'class="form-control" disabled=""');?>
							</div>
            </div>
            <!-- /.col-lg-6 (nested) -->
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