<?php


namespace App\Classes;


class Register extends Db
{
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;
    public $hashed_password;

    public $registerValidation = FALSE;

    public $errorMsg = '';
    public $registerMsg = '';

    // Fetch data
    public function fetch_data($username, $email, $password, $passwordConfirm)
    {
        // Fetch data from sign up form
        // Escape and store to variables
        $this->username = $this->connection->real_escape_string(htmlspecialchars($username));
        $this->email = $this->connection->real_escape_string(htmlspecialchars($email));
        $this->password = $this->connection->real_escape_string(htmlspecialchars($password));
        $this->passwordConfirm = $this->connection->real_escape_string(htmlspecialchars($passwordConfirm));

        return $this;
    }

    public function check_user()
    {
        // Check the username
        // Validate and check if exists
        if (isset($this->username) && $this->username != '') {
            $query = "SELECT * FROM users WHERE `username` = '{$this->username}'";
            $result = $this->connection->query($query);

            if ( $result -> num_rows > 0) {
                while ( $row = $result ->fetch_assoc() ) {
                    $this->errorMsg = 'User already exists.';
                }
                $this->registerValidation = FALSE;
                return $this;
            } else {
                if (!preg_match("/^[a-zA-Z-' ]*$/",$this->username)) {
                    $this->errorMsg = "Only letters and white space allowed in username.";

                    $this->registerValidation = FALSE;
                    return $this;
                } else {
                    $this->registerValidation = TRUE;
                }
            }
        }

        // Check email
        // Validate and check if exists
        if (isset($this->email) && $this->email != '') {
            $emailQuery = "SELECT * FROM users WHERE `email` = '{$this->email}'";
            $result = $this->connection->query($emailQuery);

            if ( $result -> num_rows > 0) {
                while ( $row = $result ->fetch_assoc() ) {
                    $this->errorMsg = 'There is a user registered on this email.';
                }
                $this->registerValidation = FALSE;
                return $this;
            } else {
                if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $this->errorMsg = 'Invalid email.';
                    $this->registerValidation = FALSE;
                    return $this;
                } else {
                    $this->registerValidation = TRUE;
                }
            }
        }

        // Check password
        if (isset($this->password) && $this->password != '') {
            if (isset($this->password) && $this->password != '') {

                // Check if password is more than 8 characters
                if (strlen($this->password) < 8) {
                    $this->errorMsg = 'Password needs to be at least 8 characters.';
                    $this->registerValidation = FALSE;
                    return $this;
                }

                // Check if password is confirmed
                if (!isset($this->passwordConfirm) || $this->passwordConfirm == '') {
                    $this->errorMsg = 'You need to confirm the password.';
                    $this->registerValidation = FALSE;
                    return $this;
                } else {
                    // Check if password is same as the confirmed password
                    if ($this->password != $this->passwordConfirm) {
                        $this->errorMsg = 'Passwords do not match.';
                        $this->registerValidation = FALSE;
                        return $this;
                    }
                }

            } else {
                $this->errorMsg = 'You need to fill in a password';
                $this->registerValidation = FALSE;
                return $this;
            }
        }

        return $this;
    }

    public function hash_password()
    {
        if ($this->registerValidation === TRUE) {
            // Hash the password
            $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->hashed_password = $hashed_password;
        }

        return $this;
    }

    public function register_user()
    {
        if ($this->registerValidation === TRUE) {
            $stmt = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $theUsername, $theEmail, $thePassword);

            $theUsername = $this->username;
            $theEmail = $this->email;
            $thePassword = $this->hashed_password;

            $stmt->execute();

            $stmt->close();
            $this->connection->close();

            $this->registerMsg = 'New user added';
        } else {
            $this->registerMsg = 'Something went wrong';
        }

        return $this;
    }
}