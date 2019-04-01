<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-6">
			<form action="/action_page.php">
		<div class="form-group">
		<label for="pa">Periode:</label>
		<input type="text" class="form-control" id="pa" role="datepicker">
		</div>
		<div class="form-group">
		<label for="pb">s.d:</label>
		<input type="text" class="form-control" id="pb" role="datepicker">
		</div>
		
		<button type="submit" class="btn btn-default">Submit</button>
		</form>
		</div>
		<div class="col-md-6">
			
		</div>
		
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function(){
		$('input[role=datepicker]').datepicker({
			defaultViewDate: 'month'
		});
	});
</script>