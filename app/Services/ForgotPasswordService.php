<?php

namespace Services;

use Exception\SqlException;
use mysqli;
use Swift_Mailer;
use Swift_Message;

class ForgotPasswordService
{
    private mysqli $connection;
    private Swift_Mailer $mailer;
    private string $baseUrl;

    public function __construct(mysqli $connection, Swift_Mailer $mailer, $baseUrl)
    {
        $this->connection = $connection;
        $this->mailer = $mailer;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param $email
     * @return void
     * @throws SqlException
     */
    public function forgotPassword($email): void
    {
        if ($this->userExist($email)){
            $token = $this->createForgotPasswordToken($email);
            $this->sendForgotPasswordEmail($email, $token);
        }
    }

    /**
     * @param $email
     * @return bool
     * @throws SqlException
     */
    private function userExist($email): bool
    {
        if ($statement = $this->connection->prepare("SELECT name FROM users WHERE email = ?")){
            $statement->bind_param("s", $email);
            $statement->execute();
            $result = $statement->get_result();
            $record = $result->fetch_assoc();
            if ($record != null){
                return true;
            }
        } else {
            throw new SqlException($this->connection->error);
        }
        return false;
    }

    /**
     * @param $token
     * @return bool
     * @throws SqlException
     */
    public function checkTokenExist($token): bool
    {
        if ($statement = $this->connection->prepare("SELECT count(*) as total FROM password_reset WHERE token = ? AND expiry > ?")) {
            $now = date("Y-m-d H:i:s");
            $statement->bind_param("ss", $token, $now);
            $statement->execute();
            $result = $statement->get_result();
            $record = $result->fetch_assoc();
            return ($record["total"] > 0);
        } else {
            throw new SqlException($this->connection->error);
        }
    }

    /**
     * @param $email
     * @return string
     * @throws SqlException
     */
    private function createForgotPasswordToken($email): string
    {
        $token = hash("sha256", uniqid(time(), true));
        $this->deleteTokensForEmail($email);
        $this->addToken($email, $token);
        return $token;
    }

    /**
     * @param $email
     * @param string $token
     * @return void
     */
    private function addToken($email, string $token): void
    {
        $message = new Swift_Message();
        $message->addFrom("photo@galery.com", "Photos page");
        $message->setSubject("Password reset");
        $message->setTo($email);
        $url = $this->baseUrl ."/reset?token=". $token;
        $message->setBody("Hello there! \n Your password has been reset! 
            You can set a new password by clicking on the link: $url ");
        $this->mailer->send($message);
    }

    /**
     * @param $email
     * @return void
     * @throws SqlException
     */
    private function deleteTokensForEmail($email): void
    {
        if ($statement = $this->connection->prepare("DELETE FROM password_reset WHERE email = ?")){
            $statement->bind_param("s", $email);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
    }

    /**
     * @param $email
     * @param string $token
     * @return void
     * @throws SqlException
     */
    private function sendForgotPasswordEmail($email, string $token): void
    {
        if ($statement = $this->connection->prepare("INSERT INTO password_reset (email, token, expiry) VALUES (?,?,?)")){
            $expiry = date("Y-m-d H:i:s", time() + 7200);
            $statement->bind_param("sss", $email, $token, $expiry);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
    }

    /**
     * @param $token
     * @return string
     * @throws SqlException
     */
    private function getEmailWithToken($token): string
    {
       if ($statement = $this->connection->prepare("SELECT email FROM password_reset WHERE token = ?")) {
           $statement->bind_param("s", $token);
           $statement->execute();
           $result = $statement->get_result();
           $record = $result->fetch_assoc();
           return $record["email"];
       } else {
           throw new SqlException($this->connection->error);
       }
    }

    /**
     * @param $token
     * @param $password
     * @return void
     * @throws SqlException
     */
    public function updatePassword($token, $password): void
    {
        if ($statement = $this->connection->prepare("UPDATE users SET password = ? WHERE email = ?")){
            $email = $this->getEmailWithToken($token);
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $statement->bind_param("ss", $hash, $email);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
        $this->deleteToken($token);
    }

    /**
     * @param $token
     * @return void
     * @throws SqlException
     */
    private function deleteToken($token)
    {
        if ($statement = $this->connection->prepare("DELETE FROM password_reset WHERE token = ?")){
            $statement->bind_param("s", $token);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
    }
}