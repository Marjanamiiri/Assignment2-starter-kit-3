<?php

namespace src\Repositories;

use src\Models\User;

class UserRepository extends Repository
{

    /**
     * @param string $id
     * @return User|false
     */
    public function getUserById(string $id): User|false
    {
        $pdoStatement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $pdoStatement->execute([$id]);
        $user = $pdoStatement->fetch();

        return $user ? new User($user['id'], $user['name'], $user['email'], $user['password_digest'], $user['profile_picture']) : false;
    }

    /**
     * @param string $email
     * @return User|false
     */
    public function getUserByEmail(string $email): User|false
    {
        $pdoStatement = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $pdoStatement->execute([$email]);
        $user = $pdoStatement->fetch();

        return $user ? new User($user['id'], $user['name'], $user['email'], $user['password_digest'], $user['profile_picture']) : false;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $passwordDigest
     * @return User|false
     */
    public function saveUser(string $name, string $email, string $passwordDigest): User|false
    {
        $pdoStatement = $this->pdo->prepare('INSERT INTO users (name, email, password_digest) VALUES (?, ?, ?);');
        $success = $pdoStatement->execute([$name, $email, $passwordDigest]);

        if ($success) {
            $userId = $this->pdo->lastInsertId();
            $newUser = $this->getUserById($userId);
            return $newUser;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string|null $profilePicture
     * @return bool
     */
    public function updateUser(int $id, string $name, ?string $profilePicture = null): bool
    {
        $pdoStatement = $this->pdo->prepare('UPDATE users SET name = ?, profile_picture = ? WHERE id = ?');
        $success = $pdoStatement->execute([$name, $profilePicture, $id]);

        return $success;
    }
}
