<?php
class Login extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_web');
    }
/////////////////////////////////////////////////////////
    public function index()
    {
        http_response_code(200);
        $session_data = $this->session->userdata('logged_in');
        $data['sesi'] = $session_data['back_office'];

        if (!empty($data['sesi'])) {redirect($data['sesi']);}

        $id_app               = $this->m_web->getopsivalue();
        $data['nama_app']     = @$id_app->nama_aplikasi;
        $data['slogan_app']   = @$id_app->slogan_aplikasi;
        $getCaptcha           = $this->gbr_captcha();
        $data['gbr_captcha']  = $getCaptcha['image'];
        $data['word']         = $getCaptcha['word'];
        $data['captcha_time'] = $getCaptcha['captcha_time'];
        $data['com_url']      = '';

        $this->viewPath = '../../assets/themes/login/';
        $this->load->view($this->viewPath . 'index', $data);
    }

    public function refresh()
    {
        $session_data = $this->session->userdata('logged_in');
        $data['sesi'] = $session_data['back_office'];

        if (!empty($data['sesi'])) {redirect($data['sesi']);}

        $id_app                = $this->m_web->getopsivalue();
        $data['nama_app']      = @$id_app->nama_aplikasi;
        $data['slogan_app']    = @$id_app->slogan_aplikasi;
        $getCaptcha            = $this->gbr_captcha();
        $data['gbr_captcha']   = $getCaptcha['image'];
        $data['word']          = $getCaptcha['word'];
        $data['captcha_time']  = $getCaptcha['captcha_time'];
        $data['user_name']     = $_POST['user_name'];
        $data['user_password'] = $_POST['user_password'];

        $this->viewPath = '../../assets/themes/login/';
        $this->load->view($this->viewPath . 'index', $data);
    }
/////////////////////////////////////////////////////////
    public function gbr_captcha()
    {
        $vals = array(
            // 'word' => $this->word,
            'img_path'   => './captcha/',
            'img_url'    => base_url() . 'captcha/',
            'font_path'  => './system/fonts/GARABD.ttf',
            'img_width'  => '150',
            'img_height' => 40,
        );
        $cap       = create_captcha($vals);
        $datamasuk = array(
            'captcha_time' => $cap['time'],
            'word'         => $cap['word'],
        );

        // $this->input->post($cap['word']);
        // $this->word= $cap['word'];
        $word       = $cap['word'];
        $expiration = time() - 3600;
        $this->db->query("DELETE FROM captcha WHERE word <> '" . $cap['word'] . "' AND captcha_time <> " . $cap['time']);
        $query = $this->db->insert_string('captcha', $datamasuk);
        $this->db->query($query);

        return array(
            'image'        => $cap['image'],
            'word'         => $cap['word'],
            'captcha_time' => $cap['time'],
        );
    }
    public function deleteImage()
    {
        // if(isset($_POST['word'])){
        // $idTime = '\a'.$_POST['captcha_time'].'.jpg';
        // $lastImage2 = FCPATH . "captcha".substr($idTime,0,1).substr($idTime,2,strlen($idTime));
        // unlink($lastImage2);
        // }

        $idTime = '\*';
        $files  = glob(FCPATH . "captcha" . $idTime); // get all file names
        // var_dump($files);
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
            // delete file
        }

        return $this;
    }
    ////////////////////////end captcha

    public function dologin()
    {
		
        $this->load->library('auth/auth');
        $this->form_validation->set_rules('user_name', "Nama User", 'trim|required');
        $this->form_validation->set_rules('user_password', "Password", 'trim|required');
        $this->form_validation->set_rules('captcha', "Captcha", 'trim|validate_captcha');

        if (empty($_POST['captcha']) || strtolower($_POST['captcha']) != strtolower($_POST['word'])) {
            $responce = array('result' => 'failed', 'message' => 'Cek Captcha');
        } else {

            if ($this->form_validation->run() == false) {
                $responce = array('result' => 'failed', 'message' => 'Username dan Password harus diisi');
            } else {
                $this->load->library('auth');
                $datalogin = array(
                    'user_name'     => $this->input->post('user_name'),
                    'user_password' => $this->input->post('user_password'),
                );
                if ($this->auth->process_login($datalogin) == false) {
                    $responce = array('result' => 'failed', 'message' => 'Username atau Password yang anda masukkan salah');
                } else {
                    $session_data = $this->session->userdata('logged_in');
                    $this->deleteImage();
                    $responce = array('result' => 'succes', 'message' => 'Login anda diterima. Mohon menunggu..', 'section' => $session_data['back_office']);
                }
            }

        }
        echo json_encode($responce);
    }
/////////////////////////////////////////////////////////
    public function keepalive()
    {
        echo 'OK';
    }
/////////////////////////////////////////////////////////
    public function out()
    {
        $session_data = $this->session->userdata('logged_in');
        $this->db->delete('user_online', array('user_id' => @$session_data['id_user']));
        $this->session->sess_destroy();
        echo "<script type=\"text/javascript\">location.href = '" . site_url() . "' + 'login'; </script>";
    }
/////////////////////////////////////////////////////////
}
