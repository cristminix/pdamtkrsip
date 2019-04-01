<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<div class="col-lg-12 mc" >
	<form action="<?=site_url('apppayroll/report/payslip')?>" method="post" class="report">
		<div class="row">
		<div class="col-md-6">
			
		</div>
		<div class="col-md-6">
		</div>

	</div>
	<div class="row">
		<div class="col-md-6">
			
				<div class="form-group row">
						<label for="pa" class="col-md-2">Periode:</label>
						<div class="col-md-3"><input placeholder="mm/YY" name="pa" type="text" class="form-control" id="pa" role="datepicker" value="<?=date('m/Y')?>"></div>
						<label class="col-md-2" for="pb" style="width: 48px">s.d:</label>
						<div class="col-md-3"><input placeholder="mm/YY" name="pb" type="text" class="form-control" id="pb" role="datepicker" value="<?=date('m/Y')?>"></div>
						 
				</div>
			
			</div>
		<div class="col-md-6">
			
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-6">
			<button name="proses" type="submit" class="btn btn-info" value="yes"><i class="fa fa-search"></i> Proses</button>
		</div>
		<div class="col-md-6">
		</div>

	</div>
</form>
	<div class="row">
		<div class="col-md-12">
			<div class="content" style="padding: 1em;margin: 1em -1em">
				<div class="alert alert-info">
					Button <?= $button_pressed ? 'Is' : 'Not'?> Pressed !
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

	$(document).ready(function(){
		$('input[role=datepicker]').datepicker({
			language: 'id',
			minViewMode: 'months',
			format:'mm/yyyy'
		});
	});
</script>