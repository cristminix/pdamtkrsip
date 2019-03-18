<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->session->set_userdata('visit');
        $this->load->model('m_web');
        $this->load->library("paging");
    }

    public function index() {
        $sessn = $this->carikanal("");
        $sessm['kanal'] = @$sessn->path_kanal;
        $sessm['tipe_kanal'] = @$sessn->tipe;
        $sessm['theme'] = @$sessn->theme;
        $sessm['id_kanal'] = @$sessn->id_kanal;
        $this->session->set_userdata('visit', $sessm);

        $id_app = $this->m_web->getopsivalue();
        $data['nama_app'] = @$id_app->nama_aplikasi;
        $data['slogan_app'] = @$id_app->slogan_aplikasi;

        $data['cTop'] = "";
        $gg = $this->m_web->getwrapper($this->uri->segment(2), "topbar");
        foreach ($gg->widget as $key => $val) {
            $data['cTop'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
        }
        $data['cMain'] = "";
        $gg = $this->m_web->getwrapper($this->uri->segment(2), "mainbar");
        foreach ($gg->widget as $key => $val) {
            $data['cMain'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
        }
        $data['cSide'] = "";
        $gg = $this->m_web->getwrapper($this->uri->segment(2), "sidebar");
        foreach ($gg->widget as $key => $val) {
            $data['cSide'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
        }

        $data['theme'] = $sessm['theme'];
        $this->viewPath = '../../assets/themes/' . $sessm['theme'] . '/';
        $this->load->view($this->viewPath . 'index', $data);
    }

    public function index_ASLI() {
        $sessn = $this->carikanal("");
        $sessm['kanal'] = @$sessn->path_kanal;
        $sessm['tipe_kanal'] = @$sessn->tipe;
        $sessm['theme'] = @$sessn->theme;
        $sessm['id_kanal'] = @$sessn->id_kanal;
        $this->session->set_userdata('visit', $sessm);

        $id_app = $this->m_web->getopsivalue();
        $data['nama_app'] = @$id_app->nama_aplikasi;
        $data['slogan_app'] = @$id_app->slogan_aplikasi;

        $data['cTop'] = "";
        $gg = $this->m_web->getwrapper($this->uri->segment(2), "topbar");
        foreach ($gg->widget as $key => $val) {
            $data['cTop'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
        }
        $data['cMain'] = "";
        $gg = $this->m_web->getwrapper($this->uri->segment(2), "mainbar");
        foreach ($gg->widget as $key => $val) {
            $data['cMain'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
        }
        $data['cSide'] = "";
        $gg = $this->m_web->getwrapper($this->uri->segment(2), "sidebar");
        foreach ($gg->widget as $key => $val) {
            $data['cSide'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
        }

        $data['theme'] = $sessm['theme'];
        $this->viewPath = '../../assets/themes/' . $sessm['theme'] . '/';
        $this->load->view($this->viewPath . 'index', $data);
    }

    public function index_bootstrap() {
        $sessn = $this->carikanal("");
        $sessm['kanal'] = @$sessn->path_kanal;
        $sessm['tipe_kanal'] = @$sessn->tipe;
        $sessm['theme'] = @$sessn->theme;
        $sessm['id_kanal'] = @$sessn->id_kanal;
        $this->session->set_userdata('visit', $sessm);

        $id_app = $this->m_web->getopsivalue();
        $data['nama_app'] = @$id_app->nama_aplikasi;
        $data['slogan_app'] = @$id_app->slogan_aplikasi;

        /*
          $data['cTop']="";
          $gg=$this->m_web->getwrapper($this->uri->segment(2),"topbar");
          foreach($gg->widget as $key=>$val){	$data['cTop'].=  Modules::run("web_".$val->nama_widget."",$val->id_widget,$val->id_wrapper,$val->opsi);	}
          $data['cMain']="";
          $gg=$this->m_web->getwrapper($this->uri->segment(2),"mainbar");
          foreach($gg->widget as $key=>$val){	$data['cMain'].=  Modules::run("web_".$val->nama_widget."",$val->id_widget,$val->id_wrapper,$val->opsi);	}
          $data['cSide']="";
          $gg=$this->m_web->getwrapper($this->uri->segment(2),"sidebar");
          foreach($gg->widget as $key=>$val){	$data['cSide'].=  Modules::run("web_".$val->nama_widget."",$val->id_widget,$val->id_wrapper,$val->opsi);	}
         */
        $data['theme'] = $sessm['theme'];
        $this->viewPath = '../../assets/themes/' . $sessm['theme'] . '/';
        $this->load->view($this->viewPath . 'index', $data);
    }

    public function kanal() {
        if ($this->uri->segment(2) == "") {
            redirect(site_url());
        } else {
            $sessn = $this->carikanal($this->uri->segment(2));
            if (!@$sessn->path_kanal) {
                redirect(site_url());
            } else {
                $sessm['kanal'] = @$sessn->path_kanal;
                $sessm['tipe_kanal'] = @$sessn->tipe;
                $sessm['theme'] = @$sessn->theme;
                $sessm['id_kanal'] = @$sessn->id_kanal;
                $this->session->set_userdata('visit', $sessm);

                $nama_app = $this->m_web->getopsivalue("nama_aplikasi");
                $data['nama_app'] = $nama_app->nama_aplikasi;
                $data['slogan_app'] = $sessn->nama_kanal;

                $data['cTop'] = "";
                $gg = $this->m_web->getwrapper($this->uri->segment(2), "topbar");
                foreach ($gg->widget as $key => $val) {
                    $data['cTop'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
                }
                $data['cMain'] = "";
                $gg = $this->m_web->getwrapper($this->uri->segment(2), "mainbar");
                foreach ($gg->widget as $key => $val) {
                    $data['cMain'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
                }
                $data['cSide'] = "";
                $gg = $this->m_web->getwrapper($this->uri->segment(2), "sidebar");
                foreach ($gg->widget as $key => $val) {
                    $data['cSide'].= Modules::run("web_" . $val->nama_widget . "", $val->id_widget, $val->id_wrapper, $val->opsi);
                }

                $data['theme'] = $sessm['theme'];
                $this->viewPath = '../../assets/themes/' . $sessm['theme'] . '/';
                $this->load->view($this->viewPath . 'index', $data);
            }
        }
    }

    public function detail() {
        $pil = $this->m_web->get_komponen();
        if (!in_array($this->uri->segment(2), $pil)) {
            redirect(site_url() . "404");
        } else {
            $data['cTop'] = Modules::run("web_" . $this->uri->segment(2) . "/" . $this->uri->segment(1) . "", $this->uri->segment(4), $this->uri->segment(3));
            $data['cMain'] = "";
            $data['cSide'] = "";

            $data['nama_app'] = str_replace("-", " ", $this->uri->segment(4));
            $data['slogan_app'] = str_replace("-", " ", $this->uri->segment(5));

            $sess = $this->session->userdata('visit');
            $data['theme'] = $sess['theme'];
            $this->viewPath = '../../assets/themes/' . $sess['theme'] . '/';
            $this->load->view($this->viewPath . 'index', $data);
        }
    }

    public function detail_COBA() {
        $pil = $this->m_web->get_komponen();
        if (!in_array($this->uri->segment(2), $pil)) {
            redirect(site_url());
        } else {
            $data['cTop'] = "";
            $data['cMain'] = Modules::run("web_" . $this->uri->segment(2) . "/" . $this->uri->segment(1) . "", $this->uri->segment(4), $this->uri->segment(3));
            $data['cSide'] = "masih ada";

            $data['nama_app'] = str_replace("-", " ", $this->uri->segment(4));
            $data['slogan_app'] = str_replace("-", " ", $this->uri->segment(5));

            $sess = $this->session->userdata('visit');
            $data['tpl'] = $sess['tpl'];
            $this->viewPath = '../../assets/themes/' . $sess['tpl'] . '/';
            $this->load->view($this->viewPath . 'index', $data);
        }
    }

    public function all() {
        $pil = $this->m_web->get_komponen();
        if (!in_array($this->uri->segment(2), $pil)) {
            redirect(site_url());
        } else {
            $data['cTop'] = Modules::run("web_" . $this->uri->segment(2) . "/" . $this->uri->segment(1) . "", $this->uri->segment(4), $this->uri->segment(3));
            $data['cMain'] = "";
            $data['cSide'] = "";

            $data['nama_app'] = "Index";
            $data['slogan_app'] = str_replace("-", " ", $this->uri->segment(5));

            $sess = $this->session->userdata('visit');
            $data['theme'] = $sess['theme'];
            $this->viewPath = '../../assets/themes/' . $sess['theme'] . '/';
            $this->load->view($this->viewPath . 'index', $data);
        }
    }

    public function carikanal($kanalpath) {
        $ctpl = $this->m_web->cari_kanal($kanalpath);
        return $ctpl;
    }

////////////////////////////////////////////////////////////////////
    function pagerB($n_itmsrch, $bat, $hal, $kehal = "paging", $bat_page = 2) {
        $diri = $n_itmsrch;
        $page = $this->paging->halamanB($n_itmsrch, $bat_page, $bat, $hal, $kehal);
        $halkehal = "hal" . $kehal;
        $b_halmaxkehal = "b_halmax" . $kehal;
        $gokehal = "go" . $kehal;
        $inputkehal = "input" . $kehal;

        $vala = "<div class='pagination'>";
        $i = 0;
        foreach ($page[$halkehal] as $keyb => $valb) {
            $vala = $vala . $valb;
            $i++;
        }
        $vala = $vala . "</div>";
        return $vala;
    }

// Untuk SEO
    function pagerD($n_itmsrch, $bat, $hal, $kehal = "paging", $bat_page = 2) {
        $page = $this->paging->halamanD($n_itmsrch, $bat_page, $bat, $hal, $kehal);
        $halkehal = "hal" . $kehal;
        $b_halmaxkehal = "b_halmax" . $kehal;
        $gokehal = "go" . $kehal;
        $inputkehal = "input" . $kehal;

        $vala = "<div class='pagination right'>";
        $i = 0;
        foreach ($page[$halkehal] as $keyb => $valb) {
            $vala = $vala . $valb;
            $i++;
        }
        $vala = $vala . "</div>";
        return $vala;
    }

}
