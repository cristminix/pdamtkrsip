<div style="float:left;width:80%;margin-bottom:50px;">
    <form>
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS MENU</th>
        </tr>
        <tr>
          <td width="150">Nama Menu</td>
          <td colspan="3"><div class="ipt_text" style="width:200px;"><b><?=$hslquery[0]->menu_name; ?></b></div></td>
        </tr>
        <tr>
          <td>Icon Menu</td>
          <td colspan="3"><div class="ipt_text" style="width:200px;"><b><?=$hslquery[0]->icon_menu; ?></b></div></td>
        </tr>
        <tr>
          <td>Path Menu</td>
          <td colspan="3"><div class="ipt_text" style="width:200px;"><b><?=$hslquery[0]->menu_path; ?></b></div></td>
        </tr>
        <tr>
          <td>Keterangan Menu</td>
          <td colspan="3"><div class="ipt_text" style="width:200px;"><b><?=$hslquery[0]->keterangan; ?></b></div></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="button" onclick="simpan();" value="Hapus" class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
	function simpan(){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/menu/hapus_menu_aksi/",
				data:{	"idd":<?=$idd;?>,"idparent":"<?=$idparent;?>"	},
				success:function(data){
					$("[id^='row_<?=$rowparent;?>']").remove();
					loadIsiGrid("<?=$parent;?>",<?=$level;?>);
					batal();
				},//tutup::success
				dataType:"html"
			});//tutup ajax
	} //tutup::simpan
</script>