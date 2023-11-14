<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class LoginController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the login page.
     * @return void
     */
    public function index(): void
    {
        $this->render('login');
    }

    /**
     * Process the login attempt.
     * @param Request $request
     * @return void
     */
    public function login(Request $request): void
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Retrieve user by email from the repository
        $user = $this->userRepository->getUserByEmail($email);

        if ($user && password_verify($password, $user->getPasswordDigest())) {
            // Passwords match, user is authenticated
            // You may set a session variable or perform any other necessary actions

            // For example, set a session variable indicating the user is logged in
            $_SESSION['user_id'] = $user->getId();

            // Redirect to a dashboard or another page
            $this->redirect('/dashboard');
        } else {
            // Invalid credentials, display an error message
            $this->render('login', ['error' => 'Invalid email or password']);
        }
    }
}
