<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/vue.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/axios.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/excellentexport/excellentexport.js"></script>

<div class="col-lg-12 mc" id="app">
	<form action="<?=site_url('apppayroll/report/payslip')?>" method="post" class="report">
		<div class="row">
		<div class="col-md-8">
			<div class="form-group row">
		<label for="pa" class="col-md-2">Unit Kerja:</label>
		<div class="col-md-4"><?= form_dropdown('id_unor',$unor_list,$id_unor,'class="form-control" v-model="id_unor"')?></div>
	</div>
		</div>
		<div class="col-md-4">
		</div>

	</div>
	<div class="row">
		<div class="col-md-8">
			
				<div class="form-group row">
						<label for="pa" class="col-md-2">Periode:</label>
						<div class="col-md-3"><?=form_input('periode',$periode,'placeholder="mm/YY" name="periode"class="form-control" id="periode" role="datepicker"')?></div>
						
				</div>
			
			</div>
		<div class="col-md-4">
			
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-6">
			<button name="proses" type="submit" class="btn btn-info" value="yes" @click="onProcessForm()"><i v-bind:class="{'fa fa-search':!button_pressed,'fa fa-spinner fa-spin':button_pressed}"></i> Proses</button>
		</div>
		<div class="col-md-6">
		</div>

	</div>
</form>
	<div class="row">
		<div class="col-md-12">
			<div class="content" style="padding: 1em;margin: 1em -1em">
				<div v-bind:class="{'alert alert-info':button_pressed,'alert alert-warning':!button_pressed}">
					Button <span v-text="button_pressed?'Is':'Not'"></span> Pressed !
				</div>
				<div class="grid">
					<table class="table table-bordered table-lap">
						<thead>
							<tr>
								<th rowspan="2" class="tc vm">NO</th>
								<th>NAMA</th>
								<th colspan="5" class="tc">ABSENSI</th>
								<th colspan="4" class="tc">TUNJANGAN - TUNJANGAN</th>
								<th rowspan="2" class="tc vm">GAJI<br/>KOTOR</th>
								<th colspan="4" class="tc">POTONGAN - POTONGAN</th>
								<th rowspan="2" class="tc vm">JUMLAH<br/>POTONGAN</th>
								<th rowspan="2" class="tc vm">GAJI<br/>BERSIH</th>
								<th rowspan="2" class="tc vm">TANDA TANGAN</th>

							</tr>
							<tr>
								<th>REKENING NO. / EMPID<br/>JABATAN<br/>GAJI POKOK<br/>P-M-STATUS</th>
								<th class="tc vt">S</th>
								<th class="tc vt">I</th>
								<th class="tc vt">A</th>
								<th class="tc vt">L</th>
								<th class="tc vt">C</th>
								<th class="tc vt">ISTRI<br/>ANAK<br/>BERAS<br/>AIR</th>
								<th class="tc vt">JABATAN<br/>PRESTASI<br/>LEMBUR<br/>KHUSUS</th>
								<th class="tc vt">PERUMAHAN<br/>TRANSPORT<br/>KENDARAAN<br/>MAKAN</th>
								<th class="tc vt">SHIFT<br/>TPP<br/>PPH21</th>
								<th class="tc vt">PPH21<br/>ASTEK<br/>ASPEN<br/>FKP</th>
								<th class="tc vt">KOPERASI<br/>KOP. WAJIB<br/>D. WANITA<br/>TPTGR</th>
								<th class="tc vt">REK. AIR</th>
								<th class="tc vt">ZAKAT<br/>SHDQ</th>

							</tr>
						</thead>
						<tbody>
							<tr v-for="r in report_data">
								<td v-text="r.id"></td>
								<td v-html="'-/'+r.empl_id+'<br/>'+r.job_title+'<br/>'+r.base_sal+r.mar_stat+' ' + r.child_cnt"></td>
								<td v-text="r.attn_s"></td>
								<td v-text="r.attn_i"></td>
								<td v-text="r.attn_a"></td>
								<td v-text="r.attn_l"></td>
								<td v-text="r.attn_c"></td>


								<td v-html="r.alw_mar+'<br/>'+r.alw_ch+'<br/>'+r.alw_rc+'<br/>'+r.alw_wt"></td>
								<td v-html="r.alw_jt+'<br/>'+r.alw_prf+'<br/>'+r.alw_ot+'<br/>'+r.alw_adv"></td>
								<td v-html="r.alw_rs+'<br/>'+r.alw_tr+'<br/>'+r.alw_vhc_rt+'<br/>'+r.alw_fd"></td>
								<td v-html="r.alw_sh+'<br/>'+r.alw_tpp+'<br/>'+r.alw_pph21"></td>
								<td v-html="r.ddc_pph21+'<br/>'+r.ddc_bpjs_ket+'<br/>'+r.ddc_aspen+'<br/>'+r.ddc_f_kp"></td>
								<td v-html="r.ddc_wc+'<br/>'+r.ddc_wcl+'<br/>'+r.ddc_dw+'<br/>'+r.ddc_tptgr"></td>
								<td v-text="r.ddc_wb"></td>
								<td v-html="r.ddc_zk+'<br/>'+r.ddc_shd"></td>

							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.mc{
		margin-top: 1em
	}
	.mc > .row{
		margin-right: -28px !important;
		margin-left: -28px !important;
	}
	form.report  label{
		line-height: 32px;
	}
	input[role=datepicker]{
		text-align: center;
	}
	table.table-lap th.tc{
		text-align: center !important;
	}
	table.table-lap th.vm{
		vertical-align: middle !important;

	}
	table.table-lap th.vt{
		vertical-align: top !important;

	}
	table.table-lap th{
		white-space: nowrap !important;
	} 
	.grid{
		width: 99%;
		margin: 0 auto;
		overflow: auto;
	}

</style>
<script type="text/javascript">
	var RP={};
	$(document).ready(function(){
		
		RP = new Vue({
			el:'#app',
			data : {
				unor_list : <?=json_encode($unor_list)?>,
				id_unor : '<?=$id_unor?>',
				periode : '<?=$periode?>',
				bulan : '<?=$bulan?>',
				tahun : '<?=$tahun?>',
				button_pressed: <?=$button_pressed?'true':'false'?>,
				report_data:[]
			},
			mounted(){
				$('input#periode').datepicker({
					language: 'id',
					minViewMode: 'months',
					format:'mm/yyyy'
				}).on('changeDate',function(e){
					var dt = $(this).datepicker('getDate');
					RP.$data.periode = this.value;
					RP.$data.bulan = dt.getMonth()+1;
					RP.$data.bulan = RP.$data.bulan < 10 ? '0'+ RP.$data.bulan : RP.$data.bulan;
					RP.$data.tahun = dt.getFullYear();
				});
				$("form.report").submit(function(e){
		            e.preventDefault(e);
		        });
			},
			methods:{
				onProcessForm:function(){
					var prxy_url = '<?=site_url('apppayroll/report/payslip')?>';
					this.button_pressed = true;
					var postData = {
						id_unor : this.id_unor,
						periode : this.periode,
						proses : 'yes'
					};
					var self = this;
					axios.post(prxy_url,postData).then(function (response) {
					    self.report_data = response.data;
					  })
					  .catch(function (error) {
					    console.log(error);
					  });
				},

			}
		});
		//

	});
</script>