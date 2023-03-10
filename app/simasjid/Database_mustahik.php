<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_mustahik extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();

		$this->load->model('db_mustahik_m');
	}

	public function index()
	{
		$this->access_control->check_role();

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/css/timeline.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/js/timeline.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'mustahik/database_mustahik';
		
		$this->js 		= 'halaman/database_mustahik';
		
		$this->_data 	= array(
			'title' 	=> 'An-Naafiu - Database Jamaah',
			'mustahik'	=> $this->db_mustahik_m->getDataMustahik(),
			'btn_add' 	=> $this->app_m->getContentMenu('tambah-data-mustahik'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-data-mustahik'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-data-mustahik')
		);

		$this->load_view();
	}

	public function json_data()
	{
		$data = [];
		$mustahik = $this->db_mustahik_m->getDataMustahik();

		foreach ($mustahik as $value) {
			$data[] = ['data'=>$value->nama];
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get()
	{
		$this->access_control->check_role();

		$post 	= $this->input->post(null, TRUE);
		
		$data 	= (!verify($post['id_jamaah'])) ? [] : $this->db_mustahik_m->getDataByHash($post['id_jamaah']);
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	function _rules()
	{
		$rules = array(
			array(
				'field' => 'id_jamaah',
				'label' => 'ID Jamaah',
				'rules' => 'verify_hash',
				'error' => [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'trim|required|regex_match[/[a-zA-Z0-9 \'.,]+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumerik dan [\'.,].'
				]
			),
			array(
				'field' => 'nama_kk',
				'label' => 'Nama Kepala Keluarga',
				'rules' => 'trim|required|regex_match[/[a-zA-Z0-9 \'.,]+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumerik dan [\'.,].'
				]
			),
			array(
				'field' => 'tempat_lahir',
				'label' => 'Tempat Lahir',
				'rules' => 'trim|required|regex_match[/[a-zA-Z0-9 \'.,]+$/]',
				'errors'=> [
					'required' => '{field} belum diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumerik dan [\'.,].'
				]
			),
			array(
				'field' => 'tgl_lahir',
				'label' => 'Tgl Lahir',
				'rules' => 'required|regex_date',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_date' => '{field} harus merupakan tanggal yang valid.'
				]
			),
			array(
				'field' => 'gender',
				'label' => 'Gender',
				'rules' => 'trim|required|regex_match[/[a-z ]+$/]',
				'errors'=> [
					'required' => '{field} belum dipilih.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfabet dan spasi'
				]
			),
			array(
				'field' => 'gol_darah',
				'label' => 'Gol. Darah',
				'rules' => 'trim|regex_match[/[a-zA-Z0-9 \'.,]+$/]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter alfabet dan spasi'
				]
			),
			array(
				'field' => 'pekerjaan',
				'label' => 'Pekerjaan',
				'rules' => 'trim|regex_match[/[a-zA-Z0-9 \'.,]+$/]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumerik dan [\'.,].'
				]
			),
			array(
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules'	=> 'trim|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#\/\-_.,]',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
			array(
				'field' => 'telepon',
				'label' => 'No. Telepon',
				'rules' => 'trim|phone_regex',
				'errors'=> [
					'phone_regex' => 'Format {field} yang valid (+62xxx / 021xxx / xxx-xxx) maksimal 16 karakter.'
				]
			),
			array(
				'field' => 'status_p',
				'label' => 'Status',
				'rules' => 'trim|required|regex_match[/[a-z ]+$/]',
				'errors'=> [
					'required' => '{field} belum dipilih.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfabet dan spasi'
				]
			),
			array(
				'field' => 'kategori',
				'label' => 'Kategori',
				'rules' => 'trim|required|regex_match[/[a-z ]+$/]',
				'errors'=> [
					'required' => '{field} belum dipilih.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfabet dan spasi'
				]
			),
		);

		return $rules;
	}

	public function tambah()
	{
		$post = $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$data = array(
				'user_id' => $this->session->userdata('uid'),
				'nama' => $post['nama'],
				'nama_kk' => $post['nama_kk'],
				'tempat_lahir' => $post['tempat_lahir'],
				'tgl_lahir' => $post['tgl_lahir'],
				'gender' => $post['gender'],
				'gol_darah' => $post['gol_darah'],
				'pekerjaan' => $post['pekerjaan'],
				'alamat' => $post['alamat'],
				'telepon' => $post['telepon'],
				'status_p' => $post['status_p'],
				'kategori' => $post['kategori']
			);

			$status = ($this->db_mustahik_m->tambahData($data) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Data berhasil ditambahkan.' : 'Data gagal ditambahkan.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));	
	}

	public function edit()
	{
		$post = $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$data = array(
				'user_id' => $this->session->userdata('uid'),
				'nama' => $post['nama'],
				'nama_kk' => $post['nama_kk'],
				'tempat_lahir' => $post['tempat_lahir'],
				'tgl_lahir' => $post['tgl_lahir'],
				'gender' => $post['gender'],
				'gol_darah' => $post['gol_darah'],
				'pekerjaan' => $post['pekerjaan'],
				'alamat' => $post['alamat'],
				'telepon' => $post['telepon'],
				'status_p' => $post['status_p'],
				'kategori' => $post['kategori']
			);

			$status = ($this->db_mustahik_m->editData($data, $post['id_jamaah']) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Data berhasil diubah.' : 'Data gagal diubah.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));	
	}

	public function hapus()
	{
		$this->access_control->check_role();

		$post = $this->input->post(null, TRUE);
		
		if(!verify($post['id_jamaah']))
		{
			$status = 0;
			$msg = 'Anda belum memilih data yang akan dihapus.';
		}
		else
		{
			$status = ($this->db_mustahik_m->hapusData($post['id_jamaah']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil menghapus data.' : 'Gagal menghapus data.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));		
	}
}