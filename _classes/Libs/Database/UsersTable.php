<?php

namespace Libs\Database;

use PDO;
use PDOException;

class UsersTable{
    private $db = null;

    public function __construct(MySQL $mysql){
        $this->db = $mysql->connect();
    }

    public function find($email, $password){ //take data from users table back
        try{
            $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email AND password=:password"); //select data from table
            $statement->execute(['email' => $email, 'password' => $password]); //take
            $user = $statement->fetch();

            return $user ?? false; //if there is user, return 
        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function insert($data){
        try{
            $statement = $this->db->prepare(
                "INSERT INTO users (name, email, password, created_at) VALUES (:name, :email,  :password, NOW())"
            ); //prepare data to add

            $statement->execute($data); //add data with execute

            return $this->db->lastInsertId(); //return the id of last added data's id
        } catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function add($data){
        try{
            $statement = $this->db->prepare(
                "INSERT INTO expenses (title, category, date, income, expenses) VALUES (:title, :category,  :date, :income, :expenses)"
            ); //prepare data to add

            $statement->execute($data); //add data with execute

            return $this->db->lastInsertId(); //return the id of last added data's id
        } catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function takeData($title, $category, $date, $income, $expenses, $balance){ //take data from users table back
        try{
            $statement = $this->db->prepare("SELECT * FROM expenses WHERE title=:title, category=:category, date=:date, income=:income, expenses=:expenses AND balance=:balance "); //select data from table
            $statement->execute(['title' => $title, 'category' => $category, 'date' => $date, 'income' => $income, 'expenses' => $expenses, 'balance' => $balance]); //take
            $data = $statement->fetch();

            return $data ?? false; //if there is user, return 

            // if ($data->num_rows > 0) {
            //     // output data of each row
            //     while($row = $data->fetch_assoc()) {
            //        $result[] = $row;
            //     }
            //    } else {
            //     $result = [];
            //    }
        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

}