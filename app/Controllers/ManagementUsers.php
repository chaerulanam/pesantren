<?php

namespace App\Controllers;

use App\Models\GroupsPermissionsModel;
use CodeIgniter\HTTP\ResponseTrait;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Config\Auth as AuthConfig;

class ManagementUsers extends BaseController
{
	use ResponseTrait;
	/**
	 * @var AuthConfig
	 */
	protected $config;

	public function __construct()
	{
		$this->config = config('Auth');
		$this->auth = service('authentication');
		$this->auth = service('authorization');
		$this->groupModel = new GroupModel();
		$this->permissionModel = new PermissionModel();
		$this->groupspermissionModel = new GroupsPermissionsModel();
	}
	public function index()
	{
		$data = [
			'myprofil' => $this->userModel->where('user_id', user_id())
				->join('users_profil', 'users_profil.user_id = users.id')
				->join('profil', 'users_profil.profil_id = profil.id')
				->join('orangtua', 'orangtua.profil_id = profil.id')
				->join('wali', 'wali.profil_id = profil.id')
				->get()->getRow(),
			'role' => $this->groupModel->findAll(),
			'title_meta' => view('admin/partials/title-meta', ['title' => 'Management Users', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
			'page_title' => view('admin/partials/page-title', ['title' => 'Management Users', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
		];
		// dd($data);
		return view('admin/management-users', $data);
	}

	public function datatable()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			if ($posts = $this->permissionModel
				->findAll()
			) {
				foreach ($posts as $key) {
					$row = array();
					$row[] = $key['name'];
					$row[] = $key['description'];
					if ($this->groupspermissionModel->hasgrouppermisiion($this->request->getGet('group_id'), $key['id']) == true) {
						$row[] = '<input type="checkbox" id="switch' . $key['id'] . '" data-id="' . $key['id'] . '" switch="info" checked />
				<label for="switch' . $key['id'] . '" data-on-label="Yes" data-off-label="No"></label>'; //$this->groupspermissionModel->hasgrouppermisiion(1, $key['id']);
					} else {
						$row[] = '<input type="checkbox" id="switch' . $key['id'] . '" data-id="' . $key['id'] . '" switch="info" />
					<label for="switch' . $key['id'] . '" data-on-label="Yes" data-off-label="No"></label>'; //$this->groupspermissionModel->hasgrouppermisiion(1, $key['id']);
					}
					$data[] = $row;
				}
				$data = array('responce' => 'success', 'posts' => $data);
			} else {
				$data = array('responce' => 'success', 'posts' => '');
			}
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function addgroupstopermission()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			$group_id = $this->request->getPost('group_id');
			$permission_id = $this->request->getPost('permission_id');
			$this->auth->addPermissionToGroup($permission_id, $group_id);
			$data = array('success' => 'Success Add Group to Permission');
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function removegroupstopermission()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			$group_id = $this->request->getPost('group_id');
			$permission_id = $this->request->getPost('permission_id');
			$this->auth->removePermissionFromGroup($permission_id, $group_id);
			$data = array('success' => 'Success Remove Group to Permission');
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
}