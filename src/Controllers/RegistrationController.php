<?php

namespace src\Controllers;

use core\Request;
use PDOException;
use src\Repositories\UserRepository as UserRepo;

class RegistrationController extends Controller
{

	/**
	 * @return void
	 */
	public function index(): void
	{
		$this->render('register');
	}

	public function register(Request $request): void
	{
		$password = $request->input('password');
		$name = $request->input('name');
		$email = $request->input('email');

		$userRepository = new UserRepo;

		$digest = password_hash($password, PASSWORD_BCRYPT);

		$userRepository->saveUser(
			email: $email,
			name: $name,
			passwordDigest: $digest
		);

		$this->setSessionData('user_id', 1);
	}
}
