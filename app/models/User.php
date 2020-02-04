<?php

    class User{

        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function register($data)
        {
            $this->db->query('INSERT INTO users (name, email, password, role) values (:name, :email, :password, "user")');
            // Bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            // Execute
            if ( $this->db->execute() ) {
                return true;
            } else {
                return false;
            }
        }


        public function login($user,$password)
        {
            $this->db->query('SELECT * from users where name = :user');
            $this->db->bind(':user', $user);
            $row = $this->db->single();

            $hashed_password = $row->password;
            if ( password_verify($password,$hashed_password) ) {
                return $row;
            } else {
                return false;
            }
        }

        public function checkPassword($user,$password)
        {
            $this->db->query('SELECT * from users where name = :user');
            $this->db->bind(':user', $user);
            $row = $this->db->single();

            $hashed_password = $row->password;
            if ( password_verify($password,$hashed_password) ) {
                return $row;
            } else {
                return false;
            }
        }

        public function getUserByName($user)
        {
            $this->db->query('SELECT * FROM users WHERE name = :user');
            // Bind values
            $this->db->bind(':user', $user);
            $this->db->single();

            // Check row
            if ( $this->db->rowCount() > 0 ) {
                return true;
            } else {
                return false;
            }
        }

        public function getUserById($id)
        {
            $this->db->query('SELECT * FROM users WHERE id = :id');
            // Bind values
            $this->db->bind(':id', $id);
            return $this->db->single();
        }

           public function addUser($data)
        {
            $this->db->query('INSERT INTO users (name, email, password) values (:name, :email, :password)');
            // Bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            // Execute
            if ( $this->db->execute() ) {
                return true;
            } else {
                return false;
            }
        }

        public function getUsers()
        {
            $this->db->query('SELECT * FROM users');
            return $this->db->resultSet();

        }    }