<div class="row" style="padding-bottom:10px;">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading"><b><?=$isi->nama_penyesuaian_ijazah;?></b></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-3">
							<b>Nomor sertifikat:</b>
							<div><input type=text class="form-control" value="<?=@$isi->nomor_sertifikat;?>" disabled></div>
					</div>
					<div class="col-lg-3">
							<b>Tanggal sertifikat:</b>
							<div><input type=text class="form-control" value="<?=@$isi->tanggal_sertifikat;?>" disabled></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="dok_penyesuaian_ijazah">
<div class="row">
<?php
	foreach($row AS $key=>$val){
?>
<div class="col-lg-4">
	<div class="panel panel-default">
		<div class="panel-heading"><div class="btn btn-info btn-sm"><b><?=($key+1);?></b></div></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="thumbnail">
							<div class="caption" style="text-align:center;">
								<p>
								<a href="" class="label label-danger" onclick="hapus_dok('penyesuaian_ijazah','<?=$val->id_dokumen;?>','<?=($key+1);?>');return false;"><i class="fa fa-trash fa-fw"></i> Hapus</a>
								</p>
							</div>
							<img id="view_penyesuaian_ijazah_<?=$val->id_dokumen;?>" src="<?=base_url();?>assets/media/file/<?=$val->nip_baru;?>/<?=$val->tipe_dokumen;?>/<?=$val->file_thumb;?>">
					</div>
				</div>
				<div class="col-lg-6">
					<b>Judul dokumen:</b>
					<div><input type="text" class="form-control" value="<?=$val->keterangan;?>" id="ket_dok_<?=$val->id_dokumen;?>" onblur="satuket(<?=$val->id_dokumen;?>);return false;"></div>
					<b>Sub-judul:</b>
					<div><input type="text" class="form-control" value="<?=$val->sub_keterangan;?>" id="sub_ket_dok_<?=$val->id_dokumen;?>" onblur="satuket(<?=$val->id_dokumen;?>);return false;"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
</div>
<!--row-->
</div>
<!--id dokumen-->


<div class="row" id="konfirm_hapus_penyesuaian_ijazah" style="display:none;"><div class="col-lg-6">
	<div class="panel panel-default">
		<div class="panel-heading" id="head_preview_penyesuaian_ijazah"></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-7" id="preview_penyesuaian_ijazah"></div>
				<div class="col-lg-5">
					<div id="tb_hapus_penyesuaian_ijazah">
						<div class="btn btn-danger" onclick="ok_hapus('penyesuaian_ijazah',<?=$idd;?>); return false;"><i class="fa fa-trash fa-fw"></i> Hapus</div>
						<div class="btn btn-default" onclick="batal_hapus('penyesuaian_ijazah'); return false;"><i class="fa fa-close fa-fw"></i> Batal</div>
					</div>
					<div id="tunggu_hapus_penyesuaian_ijazah" style="display:none;"><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></div>
				</div>
				<!--col-lg-6-->
			</div>
			<!--row-->
		</div>
	</div>
</div></div>
<!--id dokumen-->


<script type="text/javascript">
$(document).ready(function(){
	$('#head_dok').html('<i class="fa fa-photo"></i> <b>PENYESUAIAN IJAZAH</b><div class="btn btn-default btn-xs pull-right" onclick="kembali2();return false;"><i class="fa fa-close fa-fw"></i></div>');
});

    $('.thumbnail').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    ); 
</script>
