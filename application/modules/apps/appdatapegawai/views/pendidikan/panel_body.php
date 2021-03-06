<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Jenjang / Jurusan</th>
					<th>Nama dan Lokasi Sekolah</th>
					<th>Tahun Lulus</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($data as $row):?>
				<tr>
					<td>
						<div class="pull-left">
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">
									<i class="fa fa-gears fa-fw"></i> Aksi
									<span class="caret"></span>
								</button>
								<ul role="menu" class="dropdown-menu pull-right">
									<li><a href="#" 
										onclick="loadForm('<?php echo $id_pegawai;?>','<?php echo $row->id_peg_pendidikan;?>','pendidikan','form','form_pendidikan');return false"">
										<i class="fa fa-edit fa-fw"></i> Ubah Data</a>
									</li>
									<li class="divider"></li>
									<li><a href="#" onclick="delPegPendidikan(<?php echo $row->id_peg_pendidikan;?>);">
										<i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
									</li>
								</ul>
							</div>
						</div>
					</td>
					<td>
						<?php echo $row->nama_jenjang;?><br/>
						<?php echo $row->nama_pendidikan;?>
					</td>
					<td>
						<?php echo $row->nama_sekolah;?><br/>
						<?php echo $row->lokasi_sekolah;?>
					</td>
					<td>
						<?php echo $row->tahun_lulus;?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
