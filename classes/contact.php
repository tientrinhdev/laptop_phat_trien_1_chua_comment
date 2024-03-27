<?
date_default_timezone_set("Asia/Bangkok");
class Contact
{
    public $id;
    public $id_code;
    public $name;
    public $phone;
    public $email;
    public $feedback;
    public $created_day;

    public function __construct($id_code = null, $name = null, $phone = null, $email = null, $feedback = null, $created_day = null)
    {
        $this->id_code = $id_code;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->feedback = $feedback;
        $this->created_day = date('Y-m-d  h:i:s');
    }

    private function validate()
    {
        return  $this->name && $this->phone && $this->email &&   $this->feedback && $this->feedback;
    }

    public function add($conn)
    {
        if ($this->validate()) {
            try {
                $sql = "insert into contact (id_code,name, phone, email, feedback, created_day) values (:id_code,:name, :phone, :email, :feedback, :created_day)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id_code', $this->id_code, PDO::PARAM_STR);
                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':feedback', $this->feedback, PDO::PARAM_STR);
                $stmt->bindValue(':created_day', $this->created_day, PDO::PARAM_STR);
                return $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            return false;
        }
    }
//lấy ra hết thông tin
    public static function getAll($conn)
    {
        try {
            $sql = "select * from contact order by id desc";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Contact');
            if ($stmt->execute()) {
                $contacts = $stmt->fetchAll();
                return $contacts;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
//Lấy ra hết thông tin bằng id
    public static function getAllbyId($conn, $id)
    {
        try {
            $sql = "select * from contact where id=:id ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Contact');
            if ($stmt->execute()) {
                $contacts = $stmt->fetch();
                return $contacts;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    //Cập nhật trạng thái trả lời
    public function updateStatus($conn, $id){
        try{
            $sql = "update contact set status=:status where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':status', 'Đã trả lời', PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    //Xóa 
    public function deleteById($conn, $id)
    {
        try {
            $sql = "delete from contact where id =:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
