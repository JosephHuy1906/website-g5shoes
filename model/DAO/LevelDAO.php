<?php
    include('../model/level.php');

    class LevelDAO {
        private $database;

        public function __construct() {
            $this->database = new Database();
            $this->database = $this->database->getDatabase();
            $this->database->query("SET NAMES 'utf8'");
        }

        // lấy levell qua id
        public function getlevelById($levelID) {
            if ($this->database->connect_error) {
                return false;
            } else {
                $query = $this->database->prepare('SELECT * FROM level WHERE levelID  = ?');
                $query->bind_param('i', $levelID);

                if ($query->execute()) {
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                        $level = $result->fetch_assoc();
                        return new level($level['levelID'], $level['role']);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

    }       
?>
