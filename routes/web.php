<?php

use core\Router;
use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;

// Instantiate repositories if not done already
$articleRepository = new ArticleRepository(/* pass any required dependencies */);
$userRepository = new UserRepository(/* pass any required dependencies */);

// Instantiate controllers with dependencies
$articleController = new ArticleController($articleRepository);
$settingsController = new SettingsController($userRepository);

// User/Auth related
Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);
Router::get('/register', [RegistrationController::class, 'index']);
Router::post('/register', [RegistrationController::class, 'register']);
Router::post('/logout', [LogoutController::class, 'logout']);

// Article related
Router::get('/articles', [$articleController, 'index']); // display articles
Router::get('/articles/create', [$articleController, 'create']); // show form to create article
Router::post('/articles/store', [$articleController, 'store']); // process creating a new article
Router::get('/articles/edit/{id}', [$articleController, 'edit']); // show form to edit article
Router::post('/articles/update/{id}', [$articleController, 'update']); // process updating an article
Router::post('/articles/delete/{id}', [$articleController, 'delete']); // process deleting an article

// Settings related
Router::get('/settings', [$settingsController, 'index']); // display user settings
Router::post('/settings/update', [$settingsController, 'update']); // process updating user settings
