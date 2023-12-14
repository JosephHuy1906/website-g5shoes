<?php
    include_once('../model/notification.php');
    class notificationDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }


        public function getNotificationByUser($idUser) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare("SELECT * FROM notification WHERE idUser=? ORDER BY idNotification DESC");
                $query->bind_param('s', $idUser);
                
                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $notifications = [];
                        while ($row = $result->fetch_assoc()) {
                            $notification = new notification(
                            $row['idNotification'], 
                            $row['idProduct'],
                            $row['idUser'], 
                            $row['notificationLevel'],
                            $row['dateCreate']);
                            $notifications[] = $notification;
                        }
                        return $notifications;
                    } else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }


        public function addNotification($idProduct, $idUser, $notificationLevel) {
            if($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('INSERT INTO notification(idProduct, idUser, notificationLevel) VALUES (?,?,?)');
                $query->bind_param('sss',$idProduct, $idUser, $notificationLevel);
                $query->execute();
            }
        }

        //Xoá notification theo id
    public function Deletenotification($idNotification ){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('DELETE FROM notification WHERE idNotification=?');
            $query->bind_param('s', $idNotification );
            $query->execute();
        }
    }
    }       
?>
