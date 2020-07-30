<?php

class DBH{
    private static function getDB(){
        global $common;
        if(isset($common)){
            return $common->getDB();
        }
        throw new Exception("Failed to find reference to common");
    }
    private static function response($data, $status = 200, $message = ""){
        return array("status"=>$status, "message"=>$message, "data"=>$data);
    }
    private static function verify_sql($stmt){
        if(!isset($stmt)){
            throw new Exception("stmt object is undefined");
        }
        $e = $stmt->errorInfo();
        if($e[0] != '00000'){
            $error = var_export($e, true);
            throw new Exception("SQL Error: $error");
        }
    }
    public static function login($email, $pass){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/query/login.sql");
            $stmt = DBH::getDB()->prepare($query);
            $stmt->execute([":email" => $email]);
            DBH::verify_sql($stmt);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($pass, $user["password"])) {
                    unset($user["password"]); /**TODO remove password before we return results**/
                    return DBH::response($user);
                } else {
                    echo "<div style='text-align: center'>Invalid Email or Password</div>";
                }
            } else {
                echo "<div style='text-align: center'>Invalid Email or Password</div>";
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }
    public static function register($email, $fname, $lname, $pass){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/query/register.sql");
            $stmt = DBH::getDB()->prepare($query);
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            $result = $stmt->execute([":email" => $email, ":first_name"=> $fname,
              ":last_name" => $lname , ":password" => $pass]);
            DBH::verify_sql($stmt);
            /*if($result){
                return DBH::response( "<b>Registration successful</b>");
            }
            else{
                return DBH::response("Registration unsuccessful");
            }*/
        }
        catch(Exception $e){
            error_log($e->getMessage());
            echo "<div style='text-align: center'>Email already exists</div>";
        }
    }
}