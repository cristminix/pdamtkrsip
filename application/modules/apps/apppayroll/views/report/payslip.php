<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-2">
			<form action="<?=site_url('apppayroll/report/payslip')?>" method="post">
				<div class="form-group">
					<label for="pa">Periode:</label>
					<input name="pa" type="text" class="form-control" id="pa" role="datepicker" value="<?=date('m/Y')?>">
				</div>
				<div class="form-group">
					<label for="pb">s.d:</label>
					<input name="pb" type="text" class="form-control" id="pb" role="datepicker" value="<?=date('m/Y')?>">
				</div>

				<button name="proses" type="submit" class="btn btn-info" value="yes">Proses</button>
			</form>
			</div>
		<div class="col-md-10">
			
		</div>
		
	</div>
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

<script type="text/javascript">

	$(document).ready(function(){
		$('input[role=datepicker]').datepicker({
			language: 'id',
			minViewMode: 'months',
			format:'mm/yyyy'
		});
	});
</script>