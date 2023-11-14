<?php

namespace src\Controllers;

class LogoutController extends Controller
{
    public function logout()
    {
        // Clear the user's session (assuming you are using sessions)
        session_start(); // Ensure the session is started
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session

        // Redirect to the login page or any other page as needed
        $this->redirect('/login');
    }
}
