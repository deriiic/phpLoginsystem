<?php

namespace App\Classes;

class Login extends Db
{
    public $username;
    public $password;

    public $loginValidate = FALSE;
    public $userValidate = False;
    public $passwordValidate = FALSE;
    public $rememberMe = FALSE;

    public $loginAttempts = 0;
    public $loginKey = '';

    public $errorMsg = '';

    // Fetch data from input
    public function get_data($username, $password, $rememberMe = FALSE)
    {
        $this->username = $this->connection->real_escape_string(htmlspecialchars($username));
        $this->password = $this->connection->real_escape_string(htmlspecialchars($password));

        // If user chooses to keep signed in
        if (isset($rememberMe) && $rememberMe != FALSE) {
            $this->rememberMe = TRUE;
        }

        return $this;
    }

    // Check if user session is not authenticated
    public function check_session()
    {
        if (isset($_SESSION['auth']) === FALSE) {
            header("location: http://localhost:8080/");
            exit;
        }
    }

    // Check if user is signed in
    // First check session then cookie
    public function check_signed()
    {
        if (isset($_SESSION['auth']) === TRUE) {
            header("location: http://localhost:8080/admin/");
            exit;
        }

        // Validate token stored in cookie
        if (isset($_COOKIE['tokens_remember_cookie'])) {
            $token = $_COOKIE['tokens_remember_cookie'];
            $fetchUser = "SELECT * FROM users WHERE login_key = '{$token}'";
            $result = $this->connection->query($fetchUser);

            if ($result -> num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->username = $row['username'];
                    $this->loginKey = $row['login_key'];
                }
            }

            // Initiate session if not already initiated
            $_SESSION['auth'] = TRUE;
            $_SESSION['username'] = $this->username;
            $_SESSION['token'] = $this->loginKey;

            header("location: http://localhost:8080/admin/");

            exit;
        }
    }

    // Validate data on login submit
    public function validate_data()
    {
        // Check if username input
        if (!isset($this->username) || $this->username == '') {
            $this->errorMsg = 'You need to enter the username.';
            return $this;
        }

        // Check if password input
        if (!isset($this->password) || $this->password == '') {
            $this->errorMsg = 'You need to enter the password.';
            return $this;
        }

        // Validate the username
        if (isset($this->username)) {
            $query = "SELECT * FROM users WHERE `username` = '{$this->username}'";
            $result = $this->connection->query($query);


            if ($result -> num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $this->loginAttempts = $row['login_attempt'] + 1;
                }

                if ($this->loginAttempts >= 6) {
                    $this->errorMsg = 'You have made your attempts. Please reset your password.';

                    $this->userValidate = FALSE;
                    return $this;
                } else {
                    $attemptQuery = "UPDATE users SET login_attempt = {$this->loginAttempts} WHERE username = '{$this->username}'";

                    if ($this->connection->query($attemptQuery) == TRUE) {
                        $this->errorMsg = '';
                    }
                }

                // User valid if exists in database
                $this->userValidate = TRUE;
            } else {
                // If username don't exist
                $this->errorMsg = 'We have no account registered with this username.';
                $this->userValidate = FALSE;
            }
        }

        // Check password for the validates username
        if (isset($this->password) && $this->userValidate == TRUE) {
            $query = "SELECT * FROM users WHERE `username` = '{$this->username}'";
            $result = $this->connection->query($query);

            if ($result -> num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hash = $row['password'];
                }

                if (password_verify($this->password, $hash)) {
                    $this->passwordValidate = TRUE;
                    $this->loginValidate = TRUE;
                } else {
                    $this->errorMsg = 'Wrong password.';
                }
            }
        } else {
            $this->errorMsg = 'User not found.';
            $this->loginValidate = FALSE;
            return $this;
        }

        return $this;
    }

    // Generate tokens for each login attempt
    // Used as tokens for cookie
    public function generate_key()
    {
        if ($this->loginValidate === TRUE) {
            // Generate random key
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = substr(str_shuffle($permitted_chars), 0, 40);
            $this->loginKey = $token;

            $keyQuery = "UPDATE users SET login_key = '{$this->loginKey}' WHERE username = '{$this->username}'";

            if ($this->connection->query($keyQuery) === FALSE) {
                $this->errorMsg = $this->connection->error;
            }

            $attemptsReset = "UPDATE users SET login_attempt = 0 WHERE username = '{$this->username}'";

            if ($this->connection->query($attemptsReset) === FALSE) {
                $this->errorMsg = $this->connection->error;
            }

            // Initiate session
            $_SESSION['auth'] = TRUE;
            $_SESSION['username'] = $this->username;
            $_SESSION['token'] = $this->loginKey;

            // If checked "Keep me signed in"
            // Create a cookie
            if ($this->rememberMe === TRUE) {
                setcookie("tokens_remember_cookie", "{$this->loginKey}", time() + (86400 * 30 * 30), "/");
            }

            return $this;
        }
    }

    // Logout
    public function logout()
    {
        // Destroy and unset sessions
        session_unset();
        session_destroy();

        // If existing, kill cookie
        if (isset($_COOKIE['tokens_remember_cookie'])) {
            unset ($_COOKIE['tokens_remember_cookie']);
            setcookie('tokens_remember_cookie', null, -1, '/');
        }

        header("location: http://localhost:8080/");

        return $this;
    }
}