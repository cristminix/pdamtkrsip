<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td id="ipt_psikotes">
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="tanggal_tes" name="tanggal_tes" value="<?=(!isset($val->tanggal_tes))?'':$val->tanggal_tes;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
		<span><div style="display:table float:center"><input type="text" class="form-control row-fluid" id="tempat" name="tempat" value="<?=(!isset($val->tempat))?'':$val->tempat;?>" style="height:30px;padding:1px 0px 0px 5px;"></div></span>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<?=form_textarea('hasil',(!isset($val->hasil))?'':$val->hasil,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
		</td>
	
</tr>

			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
<?php if(isset($val->id_peg_psikotes)){	?>
			<input type=hidden name="id_peg_psikotes" id="id_peg_psikotes" value="<?=$val->id_peg_psikotes;?>">
<?php	}	?>
			<div class="btn btn-primary" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Simpan</div>
			<button class="btn batal btn-default" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>