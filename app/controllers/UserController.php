<?php defined('CORE') OR exit('No direct script access allowed');
class UserController extends Controller {
	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
		$this->load_model('Users');
		$this->view->setLayout('default');
	}

	public function index() {
		if (Users::currentUser()) {
			self::profile();
		}
		redirect('user/login');
	}

	public function login() {
		$loginModel = new UserLogin();
		if($this->request->isPost()) {
			if(config('csrf_protection')) Hash::csrfCheck();
			$loginModel->assign($this->request->get());
			$loginModel->validator();
			if($loginModel->validationPassed()) {
				$user = $this->UsersModel->findByUsername($_POST['username']);
				if($user && password_verify($this->request->get('password'), $user->password)) {
					$remember = $loginModel->getRememberChecked();
					$user->login($remember);
					redirect();
				} else {
					$loginModel->addErrorMessage('username','There is an error with your username or passowrd');
				}
			}
		}
		$this->view->login = $loginModel;
		$this->view->displayErrors = $loginModel->getErrorMessages();
		$this->view->render('user/login');
	}

	public function profile() {
		$this->view->render('user/profile');
	}

	public function register() {
		// $newUser = New Users();
		$registerModel = new UserRegister();
		if($this->request->isPost()) {
			if(config('csrf_protection')) Hash::csrfCheck();
			$registerModel->assign($this->request->get());
			$registerModel->setConfirm($this->request->get('cpassword'));
			$registerModel->getFullName([$this->request->get('first_name'),$this->request->get('last_name')]);
			if($registerModel->save()) {
				redirect('user/login');
			}
		}
		$this->view->register = $registerModel;
		$this->view->displayErrors = $registerModel->getErrorMessages();
		$this->view->render('user/register');
	}

	public function logout() {
		if (Users::currentUser()) {
			Users::currentUser()->logout();
		}
		redirect();
	}
}
