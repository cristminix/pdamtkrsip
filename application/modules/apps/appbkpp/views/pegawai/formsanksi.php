  <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<i class="fa fa-edit fa-fw"></i> <b>Form Update Sanksi Pegawai</b>
								</div>
								<!--//col-lg-6-->
								<div class="col-lg-6">
									<div class="btn-group pull-right">
									<button class="btn btn-primary btn-xs" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-6-->
						</div>
						<!--//row-->
			</div>
			<div class="panel-body" style="padding-left:5px;padding-right:5px;">


<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default" style="margin-bottom:5px;" id="panel_pegawai">
			<div class="panel-heading">
				<span class="fa fa-user fa-fw"></span>
				<span id=judul_box_pegawai><b>RIWAYAT SANKSI PEGAWAI</b></span>
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:90px;">Nama</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=(trim($pegawai->gelar_depan) != '-')?trim($pegawai->gelar_depan).' ':'';?><?=(trim($pegawai->gelar_nonakademis) != '-')?trim($pegawai->gelar_nonakademis).' ':'';?><?=$pegawai->nama_pegawai;?><?=(trim($pegawai->gelar_belakang) != '-')?', '.trim($pegawai->gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">NIP</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=$pegawai->nip_baru;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Pangkat/Gol.</div>
										<div style="float:left; width:5px;">:</div>
										<div style="float:left;" id="pegawai_pangkat"><?=$pegawai->nama_pangkat." / ".$pegawai->nama_golongan;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Jabatan</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="pegawai_jabatan"><?=$pegawai->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Unit kerja</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="pegawai_unor"><?=$pegawai->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->





<div class="row sanksi" id="grid-data">
	<div class="col-lg-12">
		<div class="table-responsive">
<form id="form_sanksi" method="post" enctype="multipart/form-data">
	<input type=hidden name="id_pegawai" value="<?=$pegawai->id_pegawai;?>">
	<!--<input type=hidden name="nama_pegawai" value="<?=$pegawai->nama_pegawai;?>"> -->
	<!--<input type=hidden name="nip_baru" value="<?=$pegawai->nip_baru;?>">-->
	<div id="tampung" style="display:none;"></div>
<table class="table table-striped table-bordered table-hover" style="width:1024px;" id="riwayat_sanksi">
<thead id=gridhead>
<tr>
<th style="width:40px;text-align:center;vertical-align:middle;">No.</th>
<th style="width:55px;text-align:center;vertical-align:middle;">AKSI</th>
<th style="width:50px;text-align:center;vertical-align:middle;">NOMOR SK</th>
<th style="width:100px;text-align:center;vertical-align:middle;">TANGGAL SK</th>
<th style="width:150px;text-align:center;vertical-align:middle;">URAIAN</th>
</tr>
</thead>
<tbody>
<?=$sanksi;?>
<tr id='row_xx'>
<td id='nomor_xx'><?=$no;?></td>
<td id='aksi_xx' align=center>...</td>
<td id='pekerjaan_xx' colspan="5">
<button class="btn btn-primary" type="button" onclick="setSubForm('tambah','xx',<?=$no;?>);"><i class="fa fa-plus fa-fw"></i> Tambah riwayat sanksi</button>
</td>
</tr>
<tbody>
</table>
</form>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row jabatan #grid-data-->

						<div class="row">
								<div class="col-lg-12">
									<div class="btn-group pull-right">
									<button class="btn btn-primary" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-12-->
						</div>
						<!--//row-->


			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->


<script type="text/javascript">
$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	$("[id^='row_']").removeClass().show();
	$('#simpan').html('');
});

function setSubForm(aksi,idd,no){
	$('.btn.batal').click();

		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/formsanksi_"+aksi,
		data:{"idd": idd,"nomor":no },
		beforeSend:function(){
			$('#row_'+idd).addClass('success');
			$('<tr id="row_tt" class="success"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td></tr>').insertAfter('#row_'+idd);
		},
        success:function(data){
			$('#form_sanksi').attr('action','<?=site_url("appbkpp/pegawai/formsanksi_");?>'+aksi+'_aksi');
			$('#row_'+idd).hide();
			$('#row_tt').replaceWith(data);
		},
        dataType:"html"});
}
////////////////////////////////////////////////////////////////////////////
function baru(){
	$.ajax({
		type:"POST",
		url: "<?=site_url();?>appbkpp/pegawai/sanksi_riwayat",
		data: $("#form_sanksi").serialize(),
		beforeSend:function(){
			$('#riwayat_sanksi tbody').remove();
			$('<tbody><tr id="list_riwayat"><td colspan=7><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr></tbody>').insertAfter('#riwayat_sanksi thead');
		},
		success:function(data){
			var footer = '<tr id="row_xx"><td id="nomor_xx">'+data.no+'</td>';
			footer = footer +'<td id="aksi_xx" align=center>...</td><td id="pekerjaan_xx" colspan="7">';
			footer = footer +'<button class="btn btn-primary" type="button" onclick="setSubForm(\'tambah\',\'xx\','+data.no+');"><i class="fa fa-plus fa-fw"></i> Tambah riwayat sanksi</button>';
			footer = footer +'</td></tr>';
			var table = data.sanksi+footer;
			$('#list_riwayat').replaceWith(table);
			gopaging();
		}, // end success
	dataType:"json"}); // end ajax
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
//	var hasil=validasi_isian();
//	if (hasil!=false) {
	$.ajax({
		type:"POST",
		url: $("#form_sanksi").attr('action'),
		data: $("#form_sanksi").serialize(),
		beforeSend:function(){	
			$('.bt_simpan').remove();
		},
		success:function(data){
			baru();
			$('.btn.batal').click();
		}, // end success
		dataType:"html"}); // end ajax
//	} //endif Hasil
}
function validasi_isian(){
	var data="";
	var dati="";
			var iunr = $.trim($("#id_unor").val());
			var skno = $.trim($("#nomor_sk").val());
			var sktgl = $.trim($("#tanggal_sk").val());
			var uraian = $.trim($("#uraian").val());
			data=data+""+iunr+"*"+spno+"**";
			if( iunr ==""){	dati=dati+"UNIT KERJA tidak boleh kosong\n";	}
			if( skno ==""){	dati=dati+"NOMOR SK tidak boleh kosong\n";	}
			if( sktgl ==""){	dati=dati+"TANGGAL SK tidak boleh kosong\n";	}
			if( uraian ==""){	dati=dati+"URAIAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
function hapus(){
	$.ajax({
		type:"POST",
		url: $("#form_sanksi").attr('action'),
		data: $("#form_sanksi").serialize(),
		beforeSend:function(){	
			$('.bt_simpan').remove();
		},
		success:function(data){
			baru();
			$('.btn.batal').click();
		}, // end success
		dataType:"html"}); // end ajax
}
////////////////////////////////////////////////////////////////////////////
</script>