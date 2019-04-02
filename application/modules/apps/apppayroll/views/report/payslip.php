<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/vue.min.js"></script>
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
				button_pressed: <?=$button_pressed?'true':'false'?>
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
					console.log(arguments);
					this.button_pressed = true;
				}
			}
		});
		//

	});
</script>