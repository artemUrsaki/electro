<?php

class User extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->db_connection();
    }

    public function register($fname, $lname, $email, $phone, $country, $city, $street, $hnumber, $postal, $password) {
        try {
            $query = "INSERT IGNORE INTO `address` (country, city, street, house_number, postal_code) 
            VALUES(:user_country, :user_city, :user_street, :user_hnumber, :user_postal);
            INSERT INTO `user` (first_name, last_name, email, mobile, password, address_id) 
            VALUES(:user_fname, :user_lname, :user_email, :user_phone, :user_password, (
                SELECT address_id FROM `address` WHERE country = :user_country 
                AND city = :user_city 
                AND street = :user_street 
                AND house_number = :user_hnumber 
                AND postal_code = :user_postal
            ))";

            $data = array(
                'user_country'=>$country,
                'user_city'=>$city,
                'user_street'=>$street,
                'user_hnumber'=>$hnumber,
                'user_postal'=>$postal,
                'user_fname'=>$fname,
                'user_lname'=>$lname,
                'user_email'=>$email,
                'user_phone'=>$phone,
                'user_password'=>md5($password),
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);
            
            return true;
        } catch(PDOException $e) {
            echo 'Registration error: ' .$e->getMessage();
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM user WHERE email = :user_email AND password = :user_password";
            
            $data = array(
                'user_email'=>$email,
                'user_password'=>md5($password),
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);
            $user = $statement->fetch();
            
            if($statement->rowCount() == 1) {
                $_SESSION['logged-in'] = true;
                $_SESSION['is-admin'] = $user->user_role;
                $_SESSION['user-id'] = $user->user_id;
                return true;
            }
            return false;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}