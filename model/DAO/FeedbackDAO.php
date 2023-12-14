<?php 
include '../model/feedback.php';
class FeedbackDAO {
    private $database;
    public function __construct() {
        $this->database = new Database();
        $this->database = $this->database->getDatabase();
        $this->database->query("SET NAMES 'utf8'");
    }

  // Lấy feedback qua id comment
  public function getFeedbacktByCommentId($commentID) {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM feedback WHERE commentID = ?');
            $query->bind_param('s', $commentID);
            
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $feedbacks = [];
                while ($row = $result->fetch_assoc()) {
                    $feedback = new feedback($row['feedbackID'], $row['commentID'], $row['postdate'], $row['content'], $row['userID']);
                    $feedbacks[] = $feedback;
                }
                return $feedbacks;
            } else {
                return false;
            }
        } else {
            return false;
        }
        }
    }
      // Lấy feedback qua id comment
  public function getFeedbacktByUserId($userid) {
    if ($this->database->connect_error) {
        return false;
    } else {
        $query = $this->database->prepare('SELECT * FROM feedback WHERE userID = ?');
        $query->bind_param('i', $userid);

        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $feedback = $result->fetch_assoc();
                return new feedback($feedback['feedbackID'], $feedback['commentID'], $feedback['postdate'], $feedback['content'], $feedback['userID']);
            } else {
                return false;
            }
        } else {
            return false;
        }
        
    }
}

      // Lấy feedback qua id user
  public function getFeedbacktAllCommentIdUser($userid) {
    if ($this->database->connect_error) {
        return false;
    } else {
        $query = $this->database->prepare('SELECT * FROM feedback WHERE userID = ?');
        $query->bind_param('s', $userid);

        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $feedbacks = [];
                while ($row = $result->fetch_assoc()) {
                    $feedback = new feedback($row['feedbackID'], $row['commentID'], $row['postdate'], $row['content'], $row['userID']);
                    $feedbacks[] = $feedback;
                }
                return $feedbacks;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

    //Thêm feedback mới
    public function AddFeedback($userID,$commentID,$postdate,$content){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO feedback(userID, commentID, postdate, content) VALUES (?,?,?,?)');
            $query->bind_param('ssss', $userID,$commentID,$postdate,$content);
            $query->execute();
        }
    }


}

?>