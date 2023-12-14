<?php 
include '../model/user.php';
class UserDAO {
    private $database;
    public function __construct() {
        $this->database = new Database();
        $this->database = $this->database->getDatabase();
        $this->database->query("SET NAMES 'utf8'");
    }

    //Lấy user theo id
    public function getUserByID($id) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`userID` = ?');
            $query->bind_param('s', $id);

            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['userID'], $user['email'], $user['fullName'], $user['gender'], $user['birthday'], $user['address'], $user['phoneNumber'], $user['password'], $user['avatar'], $user['levelID'], $user['code']);
                } else return false;
            } else return false;
        }
    }

       //Lấy user theo iduser
       public function getUserByIDUS($userID) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`userID` = ?');
            $query->bind_param('s', $userID);

            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['userID'], $user['email'], $user['fullName'], $user['gender'], $user['birthday'], $user['address'], $user['phoneNumber'], $user['password'], $user['avatar'], $user['levelID'], $user['code']);
                } else return false;
            } else return false;
        }
    }

    //Lấy user theo email
    public function getUserByMail($email) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`email` = ?');
            $query->bind_param('s', $email);

            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['userID'], $user['email'], $user['fullName'], $user['gender'], $user['birthday'], $user['address'], $user['phoneNumber'], $user['password'], $user['avatar'], $user['levelID'], $user['code']);
                } else return false;
            } else return false;
        }
    }

    //Lấy user theo email và password
    public function getUserByMailAndPassword($email,$password) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`email` = ? and `user`.`password` = ?');
            $query->bind_param('ss', $email,$password);

            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['userID'], $user['email'], $user['fullName'], $user['gender'], $user['birthday'], $user['address'], $user['phoneNumber'], $user['password'], $user['avatar'], $user['levelID'], $user['code']);
                } else return false;
            } else return false;
        }
    }

    //Thêm user mới
    public function AddUser($fullName,$email,$password,$gender,$birthday,$address,$phoneNumber,$avatar,$levelID,$code){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO user(fullName,email,password,gender,birthday,address,phoneNumber,avatar,levelID,code)
             VALUES (?,?,?,?,?,?,?,?,?,?)');
            $query->bind_param('ssssssssss', $fullName,$email,$password,$gender,$birthday,$address,$phoneNumber,$avatar,$levelID,$code);
            $query->execute();
        }
    }


    //Cập nhập user theo id
    public function UpdateUser($fullName,$email,$password,$phoneNumber,$gender,$birthday,$address,$avatar,$userID){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('UPDATE user SET fullName=?, email=?,gender=?, password=?, phoneNumber=?, birthday=?, address=?, avatar=? WHERE userID=?');
            $query->bind_param('sssssssss', $fullName, $email, $password, $phoneNumber, $gender, $birthday, $address, $avatar, $userID);
            $query->execute();
        }
    }

     //Cập nhập userAdmin theo id
     public function UpdateAdmin($fullName,$password,$avatar,$userID){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('UPDATE user SET fullName=?,  password=?, avatar=? WHERE userID=?');
            $query->bind_param('ssss', $fullName,  $password, $avatar, $userID);
            $query->execute();
        }
    }

    //Lấy toàn bộ user
    public function getAllUsers() {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user`');
            
            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $users = [];
                    while ($row = $result->fetch_assoc()) {
                        $user = new User($row['userID'], $row['email'], $row['fullName'], $row['gender'], $row['birthday'], $row['address'], $row['phoneNumber'], $row['password'], $row['avatar'], $row['levelID'], $row['code']);
                        $users[] = $user;
                    }
                    return $users;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    //Lấy user admin
    public function getAllUsersAdmin() {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM user WHERE levelID = 1');
            
            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $users = [];
                    while ($row = $result->fetch_assoc()) {
                        $user = new User($row['userID'], $row['email'], $row['fullName'], $row['gender'], $row['birthday'], $row['address'], $row['phoneNumber'], $row['password'], $row['avatar'], $row['levelID'] , $row['code']);
                        $users[] = $user;
                    }
                    return $users;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    //Xoá user theo id
    public function DeleteUser($id){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('DELETE FROM user WHERE userID=?');
            $query->bind_param('i', $id);
            $query->execute();
        }
    }
    
    public function updateUserPasswordByID($id, $password) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('UPDATE user SET `user`.`code`= ? WHERE `user`.`userID` = ?');
            $query->bind_param('ss', $password, $id);
            return $query->execute();
        }
    }

    public function updateUserPasswordByemail($email, $password) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('UPDATE user SET `user`.`password`= ? WHERE `user`.`email` = ?');
            $query->bind_param('ss', $password, $email);
            return $query->execute();
        }
    }

}

?>