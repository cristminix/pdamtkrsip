<?php

class Cp extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->auth->restrict();
    }

    public function index() {
        $sess = $this->session->userdata('logged_in');
        $data['ssn'] = $sess;
        $data['menu_list'] = $this->menu_top();


        $this->templateName = $sess['section_name'];
        $this->viewPath = '../../assets/themes/' . $this->templateName . '/';
        $this->load->view($this->viewPath . 'index', $data);

        // $frm['gbr_captcha'] = $this->gbr_captcha();
        // $this->load->view("app_admin/login/index",$frm);
    }

    private function menu_top($id_menu = 0) {
        $sess = $this->session->userdata('logged_in');
        $idd = $sess['id_user'];
        $id_groups = $sess['id_group'];

        $sqlstr = "SELECT a.* FROM p_setting_item a WHERE a.id_setting='2' AND a.id_parent='$id_menu' ORDER BY a.urutan ASC";
        $hslquery = $this->db->query($sqlstr)->result();

        $data = array();
        foreach ($hslquery as $key => $val) {
            $sqlstrb = "SELECT a.meta_value
			FROM p_setting_item a 
			WHERE a.id_setting='3' AND a.meta_value LIKE '%\"id_menu\":\"" . $val->id_item . "\"%'  AND a.meta_value LIKE '%\"group_id\":\"$id_groups\"%'";
            $hslqueryb = $this->db->query($sqlstrb)->result();
            if (!empty($hslqueryb)) {
                $jj = json_decode($hslqueryb[0]->meta_value);
                $data[] = $jj;
            }
        }

        $menu_sidebar = "<div class=\"navigation\" id=\"top-menu\"><ul class=\"prettyGallery\" style=\"width: 99%;\">";
        foreach ($data as $row) {
            $sqlstrd = "SELECT a.* FROM p_setting_item a WHERE a.id_item='" . @$row->id_menu . "'";
            $hslqueryd = $this->db->query($sqlstrd)->result();
            $jj = json_decode($hslqueryd[0]->meta_value);

            $child = $this->getChild(@$row->id_menu);
            $menu_sidebar .= "<li><div id='m" . @$row->id_menu . "' class=\"pasive\">";
            if (strlen($child) > 0) {
                $menu_sidebar .= "<a onclick=\"loadFragment('#main_panel_container','" . site_url() . $child . "'); getActiveNav(" . @$row->id_menu . "); loadsidebar(" . @$row->id_menu . "); return false;\" href=\"javascript:void(0)\">";
            } else {
                $menu_sidebar .= "<a onclick=\"loadFragment('#main_panel_container','" . site_url() . @$jj->path_menu . "'); getActiveNav(" . @$row->id_menu . "); loadsidebar(" . @$row->id_menu . "); return false;\" href=\"javascript:void(0)\">";
            }
            $menu_sidebar .= "<span><img src=\"" . site_url() . "assets/themes/cp/img/common/" . @$jj->icon_menu . "\"></span><br>" . @$hslqueryd[0]->nama_item . "</a>";
            $menu_sidebar .= "</div></li>";
        }
        $menu_sidebar .= "</ul></div>";
        return $menu_sidebar;
    }

//////////////////////////////////////////////////////////////////////////////////////////
    function getChild($id_menu) {
        $sess = $this->session->userdata('logged_in');
        $idd = $sess['id_user'];
        $id_group = $sess['id_group'];

        $sqlstr = "SELECT a.* FROM p_setting_item a WHERE a.id_setting='2' AND a.id_parent='$id_menu' ORDER BY a.urutan ASC LIMIT 0,1";
        $hslquery = $this->db->query($sqlstr)->result();
        $data = array();
        foreach ($hslquery as $key => $val) {
            $sqlstrb = "SELECT a.meta_value
			FROM p_setting_item a 
			WHERE a.id_setting='3' AND a.meta_value LIKE '%\"id_menu\":\"" . $val->id_item . "\"%'  AND a.meta_value LIKE '%\"group_id\":\"$id_group\"%'";

            $hslqueryb = $this->db->query($sqlstrb)->result();
            if (!empty($hslqueryb)) {
                $jj = json_decode($hslqueryb[0]->meta_value);
                $data[] = $jj;
            }
        }

        $list_menu = '';
        foreach ($data as $i => $row):
            $sqlstrd = "SELECT a.* FROM p_setting_item a WHERE a.id_item='" . @$row->id_menu . "'";
            $hslqueryd = $this->db->query($sqlstrd)->result();
            $jj = json_decode($hslqueryd[0]->meta_value);

            $child = $this->getChild(@$row->id_menu);
            if (strlen($child) > 0) {
                $list_menu .= $child;
            } else {
                $list_menu .= $jj->path_menu;
            }
        endforeach;
        return $list_menu;
    }

//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
    function sidebar($id_menu = 100) {  // 100 = default-> Dashboard	
        $sess = $this->session->userdata('logged_in');
        $idd = $sess['id_user'];
        $id_group = $sess['id_group'];

        $sqlstr = "SELECT a.* FROM p_setting_item a WHERE a.id_setting='2' AND a.id_parent='$id_menu' ORDER BY a.urutan ASC";
        $hslquery = $this->db->query($sqlstr)->result();

        $data = array();
        foreach ($hslquery as $key => $val) {
            $sqlstrb = "SELECT a.meta_value FROM p_setting_item a 
			WHERE a.id_setting='3' AND a.meta_value LIKE '%\"id_menu\":\"" . $val->id_item . "\"%'  AND a.meta_value LIKE '%\"group_id\":\"$id_group\"%'";
            $hslqueryb = $this->db->query($sqlstrb)->result();
            if (!empty($hslqueryb)) {
                $jj = json_decode($hslqueryb[0]->meta_value);
                $data[] = $jj;
            }
        }

        $menu_sidebar = "";
        if (count($data) > 0) {
            $menu_sidebar .= '<script type="text/javascript">
					$(".sidebar").show();
					$(".content-box").css("margin","-3px 5px 0 215px");
					</script>';
        } else {
            $menu_sidebar .= '<script type="text/javascript">
					$(".sidebar").hide();
					$(".content-box").css("margin","-3px 5px 0 10px");
					</script>';
        }
        foreach ($data as $row) {
            $sqlstrd = "SELECT a.* FROM p_setting_item a WHERE a.id_item='" . @$row->id_menu . "'";
            $hslqueryd = $this->db->query($sqlstrd)->result();
            $jj = json_decode($hslqueryd[0]->meta_value);


            $child = $this->getChildSide($row->id_menu);
            if (strlen($child) > 0) {
                $menu_sidebar .= "<li> <a href=\"javascript:void(0)\">" . $hslqueryd[0]->nama_item . "</a>";
                $menu_sidebar .= "<ul>" . $child . "</ul>";
                $menu_sidebar .= "</li>";
            } else {
                $menu_sidebar .= "<li> <a href=\"javascript:void(0)\">" . $hslqueryd[0]->nama_item . "</a></li>";
            }
        }
        $menu_sidebar .= "</ul>";
        echo $menu_sidebar;
    }

////////////////////////////////////////////////////////////////////////////////////////////////	
    function getChildSide($id_menu) {
        $sess = $this->session->userdata('logged_in');
        $idd = $sess['id_user'];
        $id_group = $sess['id_group'];

        $sqlstr = "SELECT a.* FROM p_setting_item a WHERE a.id_setting='2' AND a.id_parent='$id_menu' ORDER BY a.urutan ASC";
        $hslquery = $this->db->query($sqlstr)->result();

        $data = array();
        foreach ($hslquery as $key => $val) {
            $sqlstrb = "SELECT a.meta_value FROM p_setting_item a 
			WHERE a.id_setting='3' AND a.meta_value LIKE '%\"id_menu\":\"" . $val->id_item . "\"%'  AND a.meta_value LIKE '%\"group_id\":\"$id_group\"%'";

            $hslqueryb = $this->db->query($sqlstrb)->result();
            if (!empty($hslqueryb)) {
                $jj = json_decode($hslqueryb[0]->meta_value);
                $data[] = $jj;
            }
        }

        $list_menu = '';
        foreach ($data as $i => $row):
            $sqlstrd = "SELECT a.* FROM p_setting_item a WHERE a.id_item='" . @$row->id_menu . "'";
            $hslqueryd = $this->db->query($sqlstrd)->result();
            $jj = json_decode($hslqueryd[0]->meta_value);
            $list_menu .= "<li><a id=m" . $row->id_menu . " href=\"javascript:void(0)\" onClick=\"loadFragment('#main_panel_container','" . site_url($jj->path_menu) . "'); getActiveSidebar(" . $row->id_menu . ");return false;\">" . $hslqueryd[0]->nama_item . "</a></li>";
        endforeach;
        return $list_menu;
    }

//////////////////////////////////////////
}
