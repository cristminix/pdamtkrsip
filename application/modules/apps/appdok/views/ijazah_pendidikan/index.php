<div  class="panel-body" id="isiDok_<?=$komponen;?>">
<?php
		date_default_timezone_set('UTC');
$jj = count($isi);
@$isi[$jj]->nama_jenjang = '<div class="btn btn-primary btn-xs" onClick="viewForm(\''.$komponen.'\',\'tambah\',\'xx\');"><i class="fa fa-plus fa-fw"></i> Tambah</div>';
@$isi[$jj]->thumb = 'assets/file/foto/photo.jpg';
$refr = ceil(count($isi)/3);

for($i=0;$i<$refr;$i++){
$awal = $i*3;
$akhir = ($i==($refr-1))?count($isi):$awal+3; 
?>
	<div class="row">
<?php
for($i2=$awal;$i2<$akhir;$i2++){
?>
<div class="col-md-4" style="padding-top: 5px;padding-bottom: 15px;">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-10">
					<b><span><?=($i2+1);?></span>. <span><?=$isi[$i2]->nama_jenjang;?></span></b> <?=(isset($isi[$i2]->tanggal_lulus))?"- <span>".date("d-m-Y", strtotime($isi[$i2]->tanggal_lulus))."</span>":"";?>
				</div>
				<?php
				if($i2!=$jj){
				?>
				<div class="col-lg-2">
						<div class="btn-group pull-right">
							<button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" type="button"><i class="fa fa-gear fa-fw"></i></button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li onclick="viewForm('<?=$komponen;?>','edit','<?=$isi[$i2]->id_peg_pendidikan;?>');return false;"><a href="#"><i class="fa fa-edit fa-fw"></i> Edit</a></li>
								<?php if($isi[$i2]->gbr=="kosong"){ ?>
								<li class="divider"></li>
								<li onclick="viewForm('<?=$komponen;?>','hapus','<?=$isi[$i2]->id_peg_pendidikan;?>');return false;"><a href="#"><i class="fa fa-trash fa-fw"></i> Hapus</a></li>
								<?php } ?>
							</ul>
						</div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="panel-body" style="padding:10px 15px 5px 15px;">
			<div class="row">
							<div class="col-md-5" style="padding:5px;">
								
								<div class="thumbnail">
									<?php
									if($i2!=$jj){
									?>
									<div class="caption" style="text-align:center;">
										<p>
										<a href="" class="label label-info" onclick="viewUppl('<?=$komponen;?>','<?=$isi[$i2]->id_peg_pendidikan;?>');return false;"><i class="fa fa-upload fa-fw"></i> Atur Dokumen</a>
										<a href="" class="label label-default" onclick="zoom_dok('<?=$komponen;?>','<?=$isi[$i2]->id_peg_pendidikan;?>');return false;"><i class="fa fa-search fa-fw"></i> Zoom</a>
										</p>
									</div>
									<?php
									}
									?>
									<img src="<?=base_url();?><?=$isi[$i2]->thumb;?>">
								</div>
							</div>
									<?php
									if($i2!=$jj){
									?>
							<div class="col-md-7" style="padding:5px;">
								<div><b>Nama pendidikan:</b></div>
								<div><input type=text class="form-control" value="<?=@$isi[$i2]->nama_pendidikan;?>" disabled></div>
								<div style="padding-top:10px;"><b>Sejak Pengangkatan CPNS:</b></div>
								<div><?=(isset($isi[$i2]->pendidikan_pertama) && $isi[$i2]->pendidikan_pertama == 'V')?'<div class="btn btn-success btn-xs"><i class="fa fa-check fa-fw"></i></div>':'<div class="btn btn-warning btn-xs"><i class="fa fa-close fa-fw"></i></div>';?></div>
								<div style="padding-top:15px;"><b>Diakui:</b></div>
								<div><?=(isset($isi[$i2]->diakui) && $isi[$i2]->diakui == 'V')?'<div class="btn btn-success btn-xs"><i class="fa fa-check fa-fw"></i></div>':'<div class="btn btn-warning btn-xs"><i class="fa fa-close fa-fw"></i></div>';?></div>
							</div>
									<?php
									}
									?>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
	</div>
	<!-- /.row -->
<?php
}
?>
</div>
<div  class="panel-body" id="formDok_<?=$komponen;?>" style="display:none;">
	<div class="row">
		<div class="col-md-3">
			<div class="thumbnail" id="wrapDok_<?=$komponen;?>"></div>
		</div>
		<!-- /.col-md-3 -->
	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-lg-12">
				<div id='iddDok_<?=$komponen;?>' style="display:none;"></div>
			 <div class="btn btn-danger btn-sm" onclick="okHapus_<?=$komponen;?>();"><i class="fa fa-trash"></i> Hapus</div>
			 <div class="btn btn-primary btn-sm" onclick="batalDok_<?=$komponen;?>();">Batal...</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<script type="text/javascript">
    $('.thumbnail').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    ); 
</script>
