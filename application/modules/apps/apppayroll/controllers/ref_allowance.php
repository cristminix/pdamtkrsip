<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Ref_Allowance extends Apppayroll_Frontctl {

    public $main_mdl   = "ref_allowance_mdl";
    public $detail_mdl = "ref_allowance_detail_mdl";

    protected function _do_add_new($mdl) {
        $tpl   = 'add_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_post($mdl, $post);
        }

        $back_url      = $this->session->userdata(__FILE__ . 'back');
        $rs_form_input = array(
            'back_url' => $back_url
        );
        $this->set_page_title(lang("Allowance") . ': ' . lang('Add new'));

        if (!$post) {
            $data = compact('rs_form_input');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'name',
            'text',
            'class_mdl',
            'fetch_method',
            'annotation',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                 = md5($item);
            $rs_form_input[$md5] = array();
            if (isset($post['data'][$md5])) {
                $rs_form_input[$md5]['value'] = $post['data'][$md5];
            }
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        return $this->print_page($tpl);
    }

    protected function _do_add_post($mdl, $input) {
        $error         = array();
        $flash_message = array();
        if (!$input) {
            return $error;
        }

        extract($input);
        $var    = 'name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'class_mdl';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'fetch_method';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'annotation';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $duplicated = $this->{$this->main_mdl}->is_duplicated($name);
            if ($duplicated) {
                $error['name'] = lang('duplicated') . ': ' . $name;
            }
        }
        if (!$error) {

            $do_add = $this->{$this->main_mdl}->add_new_allowance($class_mdl, $fetch_method, $name, $text, $annotation);
            if ($do_add) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $do_add));
            }
            $error = array(true);
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_del($mdl, $id) {
        $tpl    = 'del_detail';
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url = $this->session->userdata(__FILE__ . 'back');
        $post     = $this->input->post();
        if ($post) {
            $flash_message = $this->_do_del_post($mdl, $id, $post);
            if ($flash_message) {

                $this->session->set_userdata('flash_message', $flash_message);
//                return $error;
            }
            redirect($back_url);
        }

        $data = compact('back_url', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("Allowance") . ' : ' . lang('Delete Confirmation'));
        return $this->print_page($tpl);
    }

    protected function _do_del_post($mdl, $id, $input) {

        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Delete error');
            return $flash_message;
        }
        $ymd    = date('ymd');
        $del_id = filter_var($input[md5('del_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($del_id != $id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }
        $del_id_hash = filter_var($input[md5('del_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($del_id . $ymd) != $del_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }

        return $this->{$mdl}->delete_row_by_id($del_id);
    }

    protected function _do_detail($detail_id, $detail_action = null, $var_id = null) {
        $ymd    = date('ymd');
        $mdl    = $this->detail_mdl;
        $this->load_mdl($mdl);
        $detail = $this->{$this->main_mdl}->fetch_detail($detail_id);

        $this->{$mdl}->rs_allowance_data = $detail;
        if ($detail_action) {
            if ($detail_action == md5('update' . date('ymd'))) {
                //update payslip
                return $this->_do_detail_update($mdl, $detail_id);
            }
            if ($detail_action == md5('new' . date('ymd'))) {
                return $this->_do_detail_add_new($mdl, $detail_id);
            }
            if ($detail_action == md5('del' . date('ymd'))) {
                if ($var_id) {
                    return $this->_do_detail_del($mdl, $var_id);
                }
            }
            $eid = $detail_action;
            if($detail_action != 'page'){
                 return $this->_do_detail_edit($mdl, $detail_id, $eid);                
            }
           
        }
        $this->session->set_userdata(__FILE__ . 'detail-back', base_url(uri_string()));

//        $this->set_form_filter($mdl);
//        $this->{$mdl}->set_rs_select();
//        $this->{$mdl}->set_joins();
        if (!$var_id) {
            $cur_page = 1;
        }else{
            $cur_page = $var_id;
        }
        if (!$per_page) {
            $per_page = $this->{$mdl}->rs_per_page;
        }


//        debug($this->detail_instance);

        $this->{$mdl}->set_rs_attr($detail_id);
        
        $this->set_common_views($mdl);
        $this->{$mdl}->rs_index_where .= " AND apr_allowance_id LIKE '" . $detail->id . "'";
        
        $ls                           = $this->{$mdl}->fetch_data($cur_page, $per_page);
//        debug($ls->result());die();
        $this->set_page_title(lang("Allowance Setup") . ': ' . $detail->text);
        $this->{$mdl}->rs_base_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $detail_id . '/page/') . '/';
        $this->set_pagination_detail($mdl);
        $back_url                     = $this->session->userdata(__FILE__ . 'back');
        $rs_action                    = $this->{$mdl}->get_rs_action($detail_id, $back_url);
        $this->set_data(compact('ls', 'rs_action'));
//        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    protected function _do_detail_add_new($mdl, $id) {
        $tpl = 'add_detail_var';

        $this->set_data(array('use_zebra_datepicker' => true));
        $error             = array();
        $post              = $this->input->post();
        $rs_allowance_data = $this->{$mdl}->rs_allowance_data;
        if ($post) {
            $error = $this->_do_detail_add_post($mdl, $post);
        }

        $back_url                                        = $this->session->userdata(__FILE__ . 'detail-back');
        $rs_form_input                                   = array(
            'back_url' => $back_url
        );
        $rs_form_inputs                                  = array(
            'effective_date',
            'variable_name',
            'value',
            'unit',
        );
        $rs_form_input[md5('apr_allowance_id')]['value'] = $rs_allowance_data->id;
        $this->set_page_title($rs_allowance_data->text . ': ' . lang('Add new'));
        if (!$post) {
            $data = compact('rs_form_input');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        foreach ($rs_form_inputs as $item) {
            $md5                 = md5($item);
            $rs_form_input[$md5] = array();
            if (isset($post['data'][$md5])) {
                $rs_form_input[$md5]['value'] = $post['data'][$md5];
            }
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }
        $data = compact('rs_form_input');
        $this->set_data($data);
        return $this->print_page($tpl);
    }

    protected function _do_detail_add_post($mdl, $input) {
        $error         = array();
        $flash_message = array();
        if (!$input) {
            return $error;
        }

        extract($input);
        $var    = 'effective_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'value';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'apr_allowance_id';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $var    = 'variable_name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $var    = 'unit';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {
            $do_add = $this->{$mdl}->add_new_allowance_var($effective_date, $variable_name, $value, $unit, $apr_allowance_id);
            if ($do_add) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s/%s/%s');
                return redirect(sprintf($r_url, md5('detail' . date('ymd')), $apr_allowance_id, $do_add));
            }
            $error = array(true);
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_detail_edit($mdl, $detail_id, $id) {
        $tpl               = 'edit_detail_var';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error             = array();
        $rs_allowance_data = $this->{$mdl}->rs_allowance_data;
//        debug($rs_allowance_data);die();
        $post              = $this->input->post();
        if ($post) {
            $error = $this->_do_detail_edit_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
//        debug($detail);die();
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(__FILE__ . 'detail-back');
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'apr_allowance_id',
            'effective_date',
            'variable_name',
            'value',
            'unit',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                 = md5($item);
            $rs_form_input[$md5] = array(
                'value' => $detail->{$item}
            );
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Allowance Setup Edit") . ': ' . sprintf(' %s ', $rs_allowance_data->text));
        return $this->print_page($tpl);
    }
    
    protected function _do_detail_edit_post($mdl, $id, $input) {
        $error         = array();
        $flash_message = array();
        if (!$input) {
            return $error;
        }

        extract($input);
        $var    = 'effective_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'value';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'apr_allowance_id';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $var    = 'variable_name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $var    = 'unit';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (!$error) {
            $do_add = $this->{$mdl}->update_allowance_var($id, $effective_date, $variable_name, $value, $unit);
            if ($do_add) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s/%s/%s');
                return redirect(sprintf($r_url, md5('detail' . date('ymd')), $apr_allowance_id, $do_add));
            }
            $error = array(true);
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_detail_update($mdl, $detail_id) {
        $tpl                             = 'detail_update';
        $detail                          = $this->{$mdl}->rs_allowance_data;
        $this->{$mdl}->set_rs_attr($detail_id);
        $this->set_common_views($mdl);
        $this->{$mdl}->rs_index_where    .= " AND apr_allowance_id LIKE '" . $detail->id . "'";
        $this->{$mdl}->rs_field_list['effective_date'] = 'effective_date';
        $ls                              = $this->{$mdl}->fetch_data(1,1000,'effective_date');
        $this->set_page_title(lang("Allowance Payslip Update") . ': ' . $detail->text);
        $this->set_pagination($mdl);
        $back_url                        = $this->session->userdata(__FILE__ . 'detail-back');
        $this->set_data(compact('ls', 'detail'));
        $obj                             = $detail->class_mdl;
        $this->load->model($obj, 'obj_instance');
        $this->obj_instance->alw_var_mdl = $this->{$mdl};
        $update_action_status            = $this->obj_instance->{$detail->fetch_method}();
        if ($update_action_status) {
            $this->{$this->main_mdl}->last_payslip_update($detail_id);
        }
        $this->set_data(compact('ls', 'detail', 'update_action_status', 'back_url'));
        $this->print_page($tpl);
    }

    protected function _do_edit($mdl, $id) {
        $tpl   = 'edit_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(__FILE__ . 'back');
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id',
            'name',
            'text',
            'class_mdl',
            'fetch_method',
            'annotation',
            'modified',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                       = md5($item);
            $rs_form_input[md5($item)] = array(
                'value' => $detail->{$item}
            );
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Allowance Edit") . ': ' . sprintf('%s - %s ', $detail->name, $detail->text));
        return $this->print_page($tpl);
    }

    protected function _do_edit_post($mdl, $id, $input) {

        $error         = array();
        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        extract($input);
        $ymd     = date('ymd');
        $edit_id = filter_var($data[md5('edit_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($edit_id != $id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $edit_id_hash = filter_var($data[md5('edit_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($edit_id . $ymd) != $edit_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID!');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        $error  = array();
        $var    = 'name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'class_mdl';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'fetch_method';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'annotation';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $duplicated = $this->{$this->main_mdl}->is_duplicated($name, $edit_id);
            if ($duplicated) {
                $error['name'] = lang('duplicated') . ': ' . $name;
            }
        }
        if (!$error) {

            $do_update = $this->{$this->main_mdl}->update_allowance($edit_id, $class_mdl, $fetch_method, $name, $text, $annotation);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $edit_id));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }
    
    public function edit($id = null, $cur_page = null, $per_page = null, $order_by = null, $sort_order = null) {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        if ($id) {

            if ($id == md5('detail' . date('ymd'))) {
                $detail_id        = $cur_page;
                $detail_action    = $per_page;
                $detail_action_id = $order_by;
                if ($detail_id) {
                    return $this->_do_detail($detail_id, $detail_action, $detail_action_id);
                }
            }

            if ($id == md5('del' . date('ymd'))) {
                if ($cur_page) {
                    return $this->_do_del($mdl, $cur_page);
                }
            }
            if ($id == md5('new' . date('ymd'))) {
                return $this->_do_add_new($mdl);
            }
            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(__FILE__ . 'back', base_url(uri_string()));
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->{$mdl}->set_rs_select();
        $this->{$mdl}->set_joins();
        if (!$cur_page) {
            $cur_page = 1;
        }
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$sort_order) {
            $sort_order = 'asc';
        }
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Allowance Management"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Allowance List"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

    protected function set_pagination_detail($mdl = null) {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }
        if (property_exists($this->{$mdl}, 'rs_field_list')) {
            $this->set_data(array('field_list' => $this->{$mdl}->rs_field_list));
        }
        if (property_exists($this->{$mdl}, 'rs_masked_field_list')) {
            $this->set_data(array('masked_field_list' => $this->{$mdl}->rs_masked_field_list));
        }
        if (property_exists($this->{$mdl}, 'rs_offset')) {
            $this->set_data(array('rs_offset' => $this->{$mdl}->rs_offset));
        }
        $sort_order = 'asc';
        if (property_exists($this->{$mdl}, 'rs_sort_order')) {
            if ($this->{$mdl}->rs_sort_order == 'asc') {
                $sort_order = 'desc';
            }
        }

        $this->set_data(compact('sort_order'));

        if (property_exists($this->{$mdl}, 'rs_order_by')) {
            $this->set_data(array('order_by' => $this->{$mdl}->rs_order_by));
        }
        $per_page = 10;
        if (property_exists($this->{$mdl}, 'rs_per_page')) {
            $per_page = $this->{$mdl}->rs_per_page;
        }
        $this->set_data(compact('per_page'));

        $config               = $this->{$mdl}->get_pagination_config();
        $config['total_rows'] = $this->{$mdl}->fetch_total_rows();
        if ($config['total_rows'] <= 10) {
            $pagination = "<br>";
            $this->set_data(compact('pagination'));
            return;
        }

        $per_page_options               = array();
        $per_page_options['list']       = $this->{$mdl}->rs_per_page_options;
        $per_page_options['total_rows'] = $config['total_rows'];
        $per_page_options['current']    = $per_page;
        $per_page_options['url_suffix'] = '';
        if ($this->{$mdl}->rs_order_by) {
            $per_page_options['url_suffix'] .= '/' . $this->{$mdl}->rs_order_by;
            if ($this->{$mdl}->rs_sort_order) {
                $per_page_options['url_suffix'] .= '/' . $this->{$mdl}->rs_sort_order;
            }
        }
//        $per_page_options['url_prefix'] = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/0/1/';
        $per_page_options['url_prefix'] = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $detail_id . '/page/') . '/1/';
//        $full_tag_open                  = $this->load->view('elements/pagination_per_page', compact('per_page_options'), true);
        $config['full_tag_open']        = '<nav>';
//        $config['full_tag_open'] .= $full_tag_open;
        $config['full_tag_open'] .= '<br><ul class="pagination">';
        $config['first_url']            = $config['base_url'] . '1/' . $per_page . $per_page_options['url_suffix'];

        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        if (!$pagination) {
//            $pagination = $this->load->view('elements/pagination_per_page', compact('per_page_options'), true);
        }
        $this->set_data(compact('pagination'));
    }
}
