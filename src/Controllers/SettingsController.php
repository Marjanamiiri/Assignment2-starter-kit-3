<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class SettingsController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display the user settings page.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        // Get user information from the repository (you may use the session or other methods to determine the user)
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            $user = $this->userRepository->getUserById($userId);

            // Render the settings page with user information
            $this->render('settings', [
                'user' => $user,
            ]);
        } else {
            // Redirect to the login page or handle unauthorized access
            $this->redirect('/login');
        }
    }

    /**
     * Process the update of user settings.
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request): void
    {
        // Get user information from the repository (you may use the session or other methods to determine the user)
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            // Assuming you have form fields for updating settings, retrieve them from the request
            $newSettingValue = $request->input('setting_name');

            // Update the user settings in the repository (adjust this based on your actual implementation)
            $success = $this->userRepository->updateUserSettings($userId, ['setting_name' => $newSettingValue]);

            if ($success) {
                // Settings updated successfully, you may redirect to the settings page or another page
                $this->redirect('/settings');
            } else {
                // Handle failure to update settings (e.g., display an error message)
                $this->render('settings', ['error' => 'Failed to update settings']);
            }
        } else {
            // Redirect to the login page or handle unauthorized access
            $this->redirect('/login');
        }
    }
}
