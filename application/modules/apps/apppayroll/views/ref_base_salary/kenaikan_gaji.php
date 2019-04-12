<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- <script type="text/javascript" src="<?=base_url()?>assets/jspdf/jspdf.debug.js"></script> -->
<!-- <script type="text/javascript" src="<?=base_url()?>assets/jspdf/jspdf.plugin.autotable.js"></script> -->

<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/vue.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/axios.min.js"></script>
<!-- <script type="text/javascript" src="<?=base_url()?>assets/excellentexport/excellentexport.js"></script> -->
<script type="text/javascript" src="<?=base_url()?>assets/pdfmake/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/pdfmake/vfs_fonts.js"></script>


<div class="col-lg-12 mc" id="app">
    <form action="<?=site_url('apppayroll/ref_base_salary/edit/kenaikan_gaji')?>" method="post" class="kenaikan_gaji">
        <div class="row">
        <div class="col-md-8">
            <div class="form-group row">
        <label for="pa" class="col-md-2">Tahun:</label>
        <div class="col-md-4"><?= form_dropdown('tahun',$tahun_list,$tahun,'class="form-control" v-model="tahun"')?></div>
    </div>
        </div>
        <div class="col-md-4">
        </div>

    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group row">
        <label for="pa" class="col-md-2">Prosentase :</label>
        <div class="col-md-4"><?= form_input('prosentase',$prosentase,'class="form-control" v-model="prosentase"')?></div>
    </div>
        </div>
        <div class="col-md-4">
        </div>

    </div>
   
    <div class="row">
        <div class="col-md-6">
            <button :disabled="button_pressed" name="proses"  class="btn btn-info" value="yes" @click="onProcessForm()"><i v-bind:class="{'fa fa-search':!button_pressed,'fa fa-spinner fa-spin':button_pressed}"></i> Proses</button>
            
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="padding-top: 1em">
            <table id="grid" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 30px"><input type="checkbox" name="ck_all" v-model='ck_all'></th>
                        <th style="text-align: right;width: 120px">Kode Peringkat</th>
                        <th style="text-align: right;width: 120px">MK Peringkat</th>
                        <th style="text-align: right;width: 120px">Gaji Pokok</th>
                        <th style="text-align: right;width: 120px">Penambahan</th>
                        <th style="text-align: right;width: 120px">Gaji Pokok Baru</th>
                        <th> NAMA PANGKAT</th>
                        <th style="text-align: center;" width="30px">Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in salaries.data">
                        <td style="text-align: center;"><input type="checkbox" name="ck_item[]" :value="r.id_gaji_pokok"></td>
                        <td style="text-align: right;"><span v-text="r.kode_golongan"></span></td>
                        <td style="text-align: right;"><span v-text="r.mk_peringkat"></span></td>
                        <td style="text-align: right;"><span v-text="r.gaji_pokok_before"></span></td>
                        <td style="text-align: right;"><span v-text="r.gaji_pokok_add"></span></td>
                        <td style="text-align: right;"><span v-text="r.gaji_pokok"></span></td>
                        <td><span v-text="r.nama_pangkat"></span></td>
                        <td style="text-align: center;"><span v-text="r.tahun"></span></td>
                    </tr>
                    <tr v-show="salaries.data.length == 0">
                        <td colspan="8"> Tidak Ada Data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
   
</div>
<iframe style="display: none" id="ifr"></iframe>
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
    table.table-lap th.tc{
        text-align: center !important;
    }
    table.table-lap th.vm{
        vertical-align: middle !important;

    }
    table.table-lap th.vt{
        vertical-align: top !important;

    }
    table.table-lap th{
        white-space: nowrap !important;
    } 
    .grid{
        width: 99%;
        margin: 0 auto;
        overflow: auto;
    }
    table.table-lap td.tc{
        text-align: center !important;
    }
    table.table-lap td.tl{
        text-align: left !important;
    }
    table.table-lap td.tr{
        text-align: right !important;
    }
</style>
<script type="text/javascript">
 
    var KG={};
    $(document).ready(function(){
        // $('.main > h3').html('DAFTAR GAJI PEGAWAI');        
        KG = new Vue({
            el:'#app',
            data : {
                tahun_list : <?=json_encode($tahun_list)?>,
                prosentase : '<?=$prosentase?>', 
                tahun : '<?=$tahun?>',
                button_pressed: <?=$button_pressed?'true':'false'?>,
                salaries:{data:[],tahun:0,prosentase:0},
                ck_all:false
            },
            mounted(){
                $("form.kenaikan_gaji").submit(function(e){
                    e.preventDefault(e);
                });
            },
            methods:{
                onProcessForm:function(){
                    var prxy_url = '<?=site_url('apppayroll/ref_base_salary/edit/kenaikan_gaji')?>';
                    this.button_pressed = true;
                    this.salaries = {data:[],tahun:0,prosentase:0};
                    var postData = {
                        tahun : this.tahun,
                        prosentase : this.prosentase,
                        proses : 'yes',
                        cmd:'get_list'
                    };
                    var self = this;
                    axios.post(prxy_url,postData).then(function (response) {
                        self.salaries = response.data;
                        self.button_pressed = false;
                      })
                      .catch(function (error) {
                        alert(error);
                      });
                }
            }
        });
        //

    });
</script>