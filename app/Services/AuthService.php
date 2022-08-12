<?php

namespace Services;

use Exception\SqlException;
use mysqli;
use Session\SessionInterface;

class AuthService
{
    private mysqli $connection;
    private SessionInterface $session;

    public function __construct(mysqli $connection, SessionInterface $session)
    {
        $this->connection = $connection;
        $this->session = $session;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * @throws SqlException
     */
    public function loginUser($email, $password): bool
    {
        if ($statement = mysqli_prepare($this->connection, 'SELECT name, password, locale FROM users WHERE email = ?'))
        {
            mysqli_stmt_bind_param($statement, "s", $email);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $record = mysqli_fetch_assoc($result);
            if ($record != null && password_verify($password, $record["password"])){
                $this->session->put("user", [
                    "name" => $record["name"],
                    "locale" => $record["locale"]
                ]);
                return true;
            }
            return false;
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function check()
    {
       return $this->session->has("user");
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->session->remove("user");
    }
}