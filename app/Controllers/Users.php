<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Session\Session;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class Users extends BaseController
{
	protected $auth;
	use ResponseTrait;

	/**
	 * @var AuthConfig
	 */
	protected $config;

	/**
	 * @var Session
	 */
	protected $session;

	public function __construct()
	{
		// Most services in this controller require
		// the session to be started - so fire it up!
		$this->session = service('session');
		$this->config = config('Auth');
		$this->auth = service('authentication');
		$this->auth = service('authorization');
		$this->userModel = new UserModel();
		$this->groupModel = new GroupModel();
	}
	public function index()
	{
		if (in_groups('superadmin')) {
			$role = $this->groupModel->findAll();
		} else if (in_groups('admin')) {
			$role = $this->groupModel
				->where('name !=', 'superadmin')
				->findAll();
		}
		$data = [
			'myprofil' => $this->userModel->where('user_id', user_id())
				->join('users_profil', 'users_profil.user_id = users.id')
				->join('profil', 'users_profil.profil_id = profil.id')
				->join('orangtua', 'orangtua.profil_id = profil.id')
				->join('wali', 'wali.profil_id = profil.id')
				->get()->getRow(),
			'role' => $role,
			'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Users', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
			'page_title' => view('admin/partials/page-title', ['title' => 'Data Users', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
			'title_table' => 'Table Data Users',
		];

		// dd($data);
		return view('admin/users', $data);
	}

	public function datatable()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			if ($posts = $this->userModel
				->groupBy('users.id')
				->select('users.id as userid, username, email, GROUP_CONCAT(name SEPARATOR " | ") as name')
				->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
				->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
				->orderBy('users.id', 'DESC')
				->findAll()
			) {
				$no = 0;
				foreach ($posts as $key) {
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $key->username;
					$row[] = $key->email;
					$row[] = $key->name;
					if ($key->name == 'superadmin') {
						if ($key->userid == user_id()) {
							$row[] = '<div class="btn-group d-flex justify-content-center">
							<a href="javascript:void(0);" class="btn btn-outline-secondary" id="passmodal" data-bs-toggle="modal" data-bs-target=".passmodal" data-id="' . $key->userid . '">
							<i class="fas fa-key"></i>
							</a></div>';
						} else {
							$row[] = '<div class="btn-group d-flex justify-content-center">
                        -</div>';
						}
					} else {
						if ($key->userid == user_id()) {
							$row[] = '<div class="btn-group d-flex justify-content-center">
							<a href="javascript:void(0);" class="btn btn-outline-secondary" id="passmodal" data-bs-toggle="modal" data-bs-target=".passmodal" data-id="' . $key->userid . '">
							<i class="fas fa-key"></i>
							</a></div>';
						} else {
							if (in_groups('superadmin')) {
								$row[] = '<div class="btn-group d-flex justify-content-center">
                        		<a href="javascript:void(0);" class="btn btn-outline-secondary" id="passmodal" data-bs-toggle="modal" data-bs-target=".passmodal" data-id="' . $key->userid . '">
                       			<i class="fas fa-key"></i>
                       			</a>
                        		<a href="javascript:void(0);" class="btn btn-outline-info" id="editmodal" data-bs-toggle="modal" data-bs-target=".editmodal" data-id="' . $key->userid . '">
                        		<i class="fas fa-edit"></i>
                        		</a>
                        		<a href="javascript:void(0);" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->userid . '">
                        		<i class="fas fa-trash-alt"></i>
                        		</a></div>';
							} else {
								$row[] = '<div class="btn-group d-flex justify-content-center">
                       			-</div>';
							}
						}
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

	public function get_detail()
	{

		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			$id = $this->request->getGet('id');
			$user = $this->userModel->select('users.id as userid, username, email, name')->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
				->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')->find($id);
			$data = [
				'id' => $id,
				'username' => $user->username,
				'email' => $user->email,
				'role' => $user->name,
			];
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function edit()
	{

		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			$id = $this->request->getPost('id');

			$role_s = $this->request->getPost('role_s');
			$role = $this->request->getPost('role');

			if (!$this->auth->removeUserFromGroup($id, $role_s)) {
				$data = array('error' => 'Failed to delete group user');
			} else if (!$this->auth->addUserToGroup($id, $role)) {
				$data = array('error' => 'Failed to add group users');
			}

			$data = [
				'user_id' => user()->id,
				'pesan' => 'Changed user  ' . $this->request->getPost('username'),
			];
			$this->logModel->save($data);

			$data = array('success' => 'Successfully changed user  ' . $this->request->getPost('username'));


			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function delete()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			$id = $this->request->getPost('id');
			$user = $this->userModel->find($id);

			if (!$this->userModel->delete($id)) {
				$data = array('error' => 'Failed to delete user');
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			$data = [
				'user_id' => user()->id,
				'pesan' => 'Delete user  ' . $user->username,
			];

			$this->logModel->save($data);

			$data = array('success' => 'Successfully deleted user.');
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function import()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			if (!$this->validate(
				[
					'file' => [
						'rules' => 'uploaded[file]',
						'errors' => [
							'uploaded' => 'Upload Your File !',
						],
					],
				]
			)) {
				$validation = service('validation')->getErrors();
				$data = $validation;
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			$file = $this->request->getFile('file');
			$filename = $file->getTempName();

			$post = array_map('str_getcsv', file($filename));

			$data = array();
			foreach ($post as $key) {
				$data = [
					'username' => $key[0],
					'email' => $key[1] . '@anakkendali.com',
					'password' => $key[2],
				];

				$users = model(UserModel::class);

				// $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
				$user = new User($data);

				$this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

				// Ensure default group gets assigned if set
				if (!empty($this->config->defaultUserGroup)) {
					$users = $users->withGroup('none');
				}

				if (!$users->save($user)) {
					// return redirect()->back()->withInput()->with('errors', $users->errors());

					$data = $users->errors();
					$data[$csrfname] = $csrfhash;
					return $this->response->setJSON($data);
				}

				if ($this->config->requireActivation !== null) {
					$activator = service('activator');
					$sent = $activator->send($user);

					if (!$sent) {
						// return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
						$data = $activator->error() ?? lang('Auth.unknownError');
						$data[$csrfname] = $csrfhash;
						return $this->response->setJSON($data);
					}
					// Success!
					// return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
					$data = array('message' => lang('Auth.activationSuccess'));
					$data[$csrfname] = $csrfhash;
					return $this->response->setJSON($data);
				}

				$data = [
					'user_id' => user()->id,
					'pesan' => 'Add New User ' . $key[0],
				];

				$this->logModel->save($data);
			}
			$data = array('message' => lang('Auth.registerSuccess'));
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		}
	}

	//--------------------------------------------------------------------
	// Login/out
	//--------------------------------------------------------------------

	/**
	 * Displays the login form, or redirects
	 * the user to their destination/home if
	 * they are already logged in.
	 */
	public function login()
	{
		// No need to show a login form if the user
		// is already logged in.
		if ($this->auth->check()) {
			$redirectURL = session('redirect_url') ?? '/';
			unset($_SESSION['redirect_url']);

			return redirect()->to($redirectURL);
		}

		// Set a return URL if none is specified
		$_SESSION['redirect_url'] = session('redirect_url') ?? previous_url() ?? '/';

		return view($this->config->views['login'], ['config' => $this->config]);
	}

	/**
	 * Attempts to verify the user's credentials
	 * through a POST request.
	 */
	public function attemptLogin()
	{
		$rules = [
			'login' => 'required',
			'password' => 'required',
		];
		if ($this->config->validFields == ['email']) {
			$rules['login'] .= '|valid_email';
		}

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$login = $this->request->getPost('login');
		$password = $this->request->getPost('password');
		$remember = (bool) $this->request->getPost('remember');

		// Determine credential type
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		// Try to log them in...
		if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
			return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
		}

		// Is the user being forced to reset their password?
		if ($this->auth->user()->force_pass_reset === true) {
			return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
		}

		$redirectURL = session('redirect_url') ?? '/';
		unset($_SESSION['redirect_url']);

		return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
	}

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		if ($this->auth->check()) {
			$this->auth->logout();
		}

		return redirect()->to('/');
	}

	//--------------------------------------------------------------------
	// Register
	//--------------------------------------------------------------------
	public function attemptRegister()
	{
		// Check if registration is allowed
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();

			if (!$this->config->allowRegistration) {
				return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
			}

			$users = model(UserModel::class);

			// Validate basics first since some password rules rely on these fields
			$rules = [
				'username' => [
					'rules' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
					'errors' => [
						'required' => 'Username Harus Diisi !'
					],
				],
				'email'    => [
					'rules' => 'required|is_unique[users.email]',
					'errors' => [
						'required' => 'Nomor Hp Harus Diisi !'
					]
				],
				'group'    => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Role Harus Diisi !'
					]
				]

			];

			if (!$this->validate($rules)) {
				// return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
				// dd(service('validation')->getErrors());
				$data = $this->validator->getErrors();
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			$rules = [
				'password' => 'required|strong_password',
				'pass_confirm' => 'required|matches[password]',
			];


			if (!$this->validate($rules)) {
				// return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
				$data = $this->validator->getErrors();
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			// Save the user
			$allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
			$user = new User($this->request->getPost($allowedPostFields));

			$user->activate();

			$users = $users->withGroup($this->request->getPost('group'));

			if (!$users->save($user)) {
				// return redirect()->back()->withInput()->with('errors', $users->errors());

				$data = $users->errors();
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			$data = [
				'user_id' => user()->id,
				'pesan' => 'Add new user ' . $this->request->getPost('username'),
			];

			$this->logModel->save($data);

			// Success!
			// return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
			$data = array('message' => lang('Auth.registerSuccess'));
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	//--------------------------------------------------------------------
	// Forgot Password
	//--------------------------------------------------------------------

	/**
	 * Displays the forgot password form.
	 */
	public function forgotPassword()
	{
		if ($this->config->activeResetter === false) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		return view($this->config->views['forgot'], ['config' => $this->config]);
	}

	/**
	 * Attempts to find a user account with that password
	 * and send password reset instructions to them.
	 */
	public function attemptForgot()
	{
		if ($this->config->activeResetter === false) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		$users = model('UserModel');

		$user = $users->where('email', $this->request->getPost('email'))->first();

		if (is_null($user)) {
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

		// Save the reset hash /
		$user->generateResetHash();
		$users->save($user);

		$resetter = service('resetter');
		$sent = $resetter->send($user);

		if (!$sent) {
			return redirect()->back()->withInput()->with('error', $resetter->error() ?? lang('Auth.unknownError'));
		}

		return redirect()->route('reset-password')->with('message', lang('Auth.forgotEmailSent'));
	}

	/**
	 * Displays the Reset Password form.
	 */
	public function resetPassword()
	{
		if ($this->config->activeResetter === false) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		$token = $this->request->getGet('token');

		return view($this->config->views['reset'], [
			'config' => $this->config,
			'token' => $token,
		]);
	}

	/**
	 * Verifies the code with the email and saves the new password,
	 * if they all pass validation.
	 *
	 * @return mixed
	 */
	public function attemptReset()
	{
		if ($this->request->isAJAX()) {
			$csrfname = csrf_token();
			$csrfhash = csrf_hash();
			$users = model('UserModel');

			$rules = [
				'id' => 'required',
				'password' => 'required',
				'pass_confirm' => 'required|matches[password]',
			];

			if (!$this->validate($rules)) {
				// return redirect()->back()->withInput()->with('errors', $users->errors());
				$data = array('error', $users->errors());
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			$user = $users->where('id', $this->request->getPost('id'))
				->first();

			if (is_null($user)) {
				// return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
				$data = array('error', lang('Auth.forgotNoUser'));
				$data[$csrfname] = $csrfhash;
				return $this->response->setJSON($data);
			}

			// Reset token still valid?
			// if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
			//     // return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
			//     $data = array('error', lang('Auth.resetTokenExpired'));
			//     $data[$csrfname] = $csrfhash;
			//     return $this->response->setJSON($data);
			// }
			$data = [
				'user_id' => user()->id,
				'pesan' => 'Changed password user ' . $user->username,
			];

			// Success! Save the new password, and cleanup the reset hash.
			$user->password = $this->request->getPost('password');
			$user->reset_hash = null;
			$user->reset_at = date('Y-m-d H:i:s');
			$user->reset_expires = null;
			$user->force_pass_reset = false;
			$users->save($user);



			$this->logModel->save($data);

			$data = array('success' => lang('Auth.resetSuccess'));
			$data[$csrfname] = $csrfhash;
			return $this->response->setJSON($data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	/**
	 * Activate account.
	 *
	 * @return mixed
	 */
	public function activateAccount()
	{
		$users = model('UserModel');

		// First things first - log the activation attempt.
		$users->logActivationAttempt(
			$this->request->getGet('token'),
			$this->request->getIPAddress(),
			(string) $this->request->getUserAgent()
		);

		$throttler = service('throttler');

		if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$user->activate();

		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}

	/**
	 * Resend activation account.
	 *
	 * @return mixed
	 */
	public function resendActivateAccount()
	{
		if ($this->config->requireActivation === false) {
			return redirect()->route('login');
		}

		$throttler = service('throttler');

		if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$login = urldecode($this->request->getGet('login'));
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		$users = model('UserModel');

		$user = $users->where($type, $login)
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$activator = service('activator');
		$sent = $activator->send($user);

		if (!$sent) {
			return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
		}

		// Success!
		return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
	}

	protected function _render(string $view, array $data = [])
	{
		return view($view, $data);
	}
}