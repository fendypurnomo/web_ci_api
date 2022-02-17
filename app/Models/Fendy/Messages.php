<?php

namespace App\Models\Fendy;

class Messages extends \CodeIgniter\Model
{
	protected $table      = 'tabel_pesan';
	protected $primaryKey = 'pesan_id';
	protected $returnType = 'object';

	protected $allowedFields = [
		'pesan_nama',
		'pesan_email',
		'pesan_subjek',
		'pesan_isi'
	];

	protected $useTimestamps = true;
	protected $createdField  = 'pesan_tanggal';

	public function getAllData($paging = null)
	{
		if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
			foreach ($query as $row) {
				$data[] = $this->data($row);
			}

			$page         = $paging->page;
			$perPage      = $paging->perPage;
			$totalRecords = $this->countAll();
			$totalPages   = ceil($totalRecords / $perPage);

			return [
				'data'         => $data,
				'page'         => $page,
				'perPage'      => $perPage,
				'totalPages'   => $totalPages,
				'totalRecords' => $totalRecords
			];
		}
		return false;
	}

	public function createData($post)
	{
		$data = [
			'pesan_nama'   => $post->name,
			'pesan_email'  => $post->email,
			'pesan_subjek' => $post->subject,
			'pesan_isi'    => $post->content
		];

		if ($this->insert($data)) {
			return [
				'success' => true,
				'status'  => 200,
				'message' => 'Message created successfully'
			];
		}
		return false;
	}

	public function showData($id)
	{
		if ($row = $this->find($id)) {
			return [
				'data' => $this->data($row)
			];
		}
		return false;
	}

	public function updateData($id, $put)
	{
		$data = [
			'pesan_nama'   => $put->name,
			'pesan_email'  => $put->email,
			'pesan_subjek' => $put->subject,
			'pesan_isi'    => $put->content
		];

		if ($this->update($id, $data)) {
			return [
				'success' => true,
				'status'  => 200,
				'message' => 'Data pesan berhasil diperbarui'
			];
		}
		return false;
	}

	public function deleteData($id)
	{
		if ($this->find($id)) {
			$this->delete($id);
			return [
				'success' => true,
				'status'  => 200,
				'message' => 'Data pesan berhasil dihapus'
			];
		}
		return false;
	}

	private function data($row)
	{
		return [
			'id'      => $row->pesan_id,
			'name'    => $row->pesan_nama,
			'email'   => $row->pesan_email,
			'subject' => $row->pesan_subjek,
			'message' => $row->pesan_isi,
			'date'    => $row->pesan_tanggal
		];
	}
}
