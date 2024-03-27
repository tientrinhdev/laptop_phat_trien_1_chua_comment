<?
date_default_timezone_set("Asia/Bangkok");
class Comment{
    public $id_product;
    public $id_user;
    public $comment;
    public $created_day;

    public function __construct($id_product = null, $id_user = null, $comment = null, $created_day = null){
        $this->id_product = $id_product;
        $this->id_user = $id_user;
        $this->comment = $comment;
        $this->created_day = date('Y-m-d  h:i:s');
    }

    public function add($conn){
        try{
            $sql = "insert into comment (id_product, id_user, comment, created_day)
            values (:id_product, :id_user, :comment, :created_day)";
            $stmt= $conn->prepare($sql);
            $stmt->bindValue(':id_product', $this->id_product, PDO::PARAM_INT);
            $stmt->bindValue(':id_user', $this->id_user, PDO::PARAM_INT);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);
            $stmt->bindValue(':created_day', $this->created_day, PDO::PARAM_STR);
            return $stmt->execute();
        }catch(Exception $e){
            $e->getMessage();
            return false;
        }
    }

    public static function getAll($conn, $id)
    {
        try {
            $sql = "select comment.*, users.*
                    from comment
                    join users on comment.id_user = users.id
                    join products on comment.id_product = products.id
                    where comment.id_product = :id
                    order by created_day desc";
           $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
?>