<?php
include '../model/comment.php';
class CommentDAO
{
    private $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->database = $this->database->getDatabase();
        $this->database->query("SET NAMES 'utf8'");
    }

    
    // Lấy feedback qua id comment
    public function getCommentById($idcomment) {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM comment WHERE commentID = ?');
            $query->bind_param('s', $idcomment);

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $comment = $result->fetch_assoc();
                    return new comment($comment['commentID'],
                    $comment['userID'],
                    $comment['productID'],
                    $comment['postdate'],
                    $comment['content']);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    //Lấy comment theo id sản phẩm
    public function getCommentByIDProduct($productID)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM comment WHERE productID = ?');
            $query->bind_param('s', $productID);

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $comments = [];
                    while ($row = $result->fetch_assoc()) {
                        $comment = new comment(
                            $row['commentID'],
                            $row['userID'],
                            $row['productID'],
                            $row['postdate'],
                            $row['content']
                        );
                        $comments[] = $comment;
                    }
                    return $comments;
                } else return false;
            } else return false;
        }
    }

    //Thêm comment mới
    public function AddComment($userID, $productID, $postdate, $content)
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO comment(userID, productID, postdate, content) VALUES (?,?,?,?)');
            $query->bind_param('ssss', $userID, $productID, $postdate, $content);
            $query->execute();
        }
    }


    //Lấy toàn bộ comment
    public function getAllComment()
    {
        if ($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `comment` ORDER BY commentID DESC');

            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows > 0) {
                    $comments = [];
                    while ($row = $result->fetch_assoc()) {
                        $comment = new comment($row['commentID'], $row['userID'], $row['productID'], $row['postdate'], $row['content']);
                        $comments[] = $comment;
                    }
                    return $comments;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    // xoá comment theo id
    public function DeleteComment($commentID){
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('DELETE FROM comment WHERE commentID=?');
            $query->bind_param('s', $commentID);
            $query->execute();
        }
    }
}
?>