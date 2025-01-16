<?php
namespace Src\users;

abstract class User {
    protected $db;
    protected $username;
    protected $password;
    protected $email;
    protected $role;

    public function __construct($db, $username, $password, $email, $role) {
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }

    abstract public function register();

    public function login() {
    }

    public function logout() {
        session_unset();
        session_destroy();
    }
}
