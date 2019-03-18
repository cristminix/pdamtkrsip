<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Suami/Istri</th>
          <th>Tanggal Menikah</th>
          <th>Pendidikan - Pekerjaan</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($data as $row):?>
        <tr id="pernikahanform-<?=$row->id_peg_perkawinan;?>">
          <td>
            <div class="pull-left">
              <div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">
                  <i class="fa fa-gears fa-fw"></i> Aksi
                  <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu pull-right">
									<li><a href="#" 
										onclick="loadForm('<?php echo $id_pegawai;?>','<?php echo $row->id_peg_perkawinan;?>','pernikahan','form','form_pernikahan');return false"">
										<i class="fa fa-edit fa-fw"></i> Ubah Data</a>
									</li>
									<li class="divider"></li>
									<li><a href="#" onclick="delPegPernikahan(<?php echo $row->id_peg_perkawinan;?>);">
										<i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
									</li>
                </ul>
                </div>
            </div>
          </td><td>
            <?php echo $row->nama_suris;?><br/>
            <?php echo $row->tempat_lahir_suris;?> ( <em><?php echo $row->tanggal_lahir_suris;?></em> )
          </td><td>
            <?php echo $row->tanggal_menikah;?>
          </td><td>
            <?php echo $row->pendidikan_suris;?> - <em><?php echo $row->pekerjaan_suris;?></em>
          </td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
