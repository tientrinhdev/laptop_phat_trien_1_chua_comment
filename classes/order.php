<?
date_default_timezone_set("Asia/Bangkok");
class Order{
    public $id_code;
    public $id_user;
    public $name;
    public $email_order;
    public $phone;
    public $address;
    public $note;
    public $total;
    public $paymentmethods;
    public $created_order;

    public function __construct($id_code= null,$id_user = null, $name = null,$email_order = null, $phone = null, $address = null, $note = null, $total = null, $paymentmethods = null, $created_order = null)
    {
        $this->id_code = $id_code;
        $this->id_user = $id_user;
        $this->email_order = $email_order;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->note = $note;
        $this->total = $total;
        $this->paymentmethods = $paymentmethods;
        $this->created_order = date('Y-m-d  h:i:s');
    }

    public function add($conn)
    {
            try {
                $sql = "insert into orders (id_code, id_user, name,email_order, phone, address, note, total, paymentmethods, created_order) values (:id_code,:id_user, :name, :email_order, :phone , :address, :note, :total, :paymentmethods, :created_order)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id_code', $this->id_code, PDO::PARAM_STR);
                $stmt->bindValue(':id_user', $this->id_user, PDO::PARAM_INT);
                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':email_order', $this->email_order, PDO::PARAM_STR);
                $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
                $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
                $stmt->bindValue(':note', $this->note, PDO::PARAM_STR);
                $stmt->bindValue(':total', $this->total, PDO::PARAM_INT);
                $stmt->bindValue(':paymentmethods', $this->paymentmethods, PDO::PARAM_INT);
                $stmt->bindValue(':created_order', $this->created_order, PDO::PARAM_STR);
                $stmt->execute();
                $last_id = $conn->lastInsertId();
                return $last_id;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
    }
//Lấy ra hêt
    public static function getAll($conn){
        try {
            $sql = "select * from orders order by id desc";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
//Lấy ra hết bằng id user
    public static function getAllByIdUser($conn, $id_user){
        try {
            $sql = "select * from orders where id_user=:id_user order by id desc";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function updateStatus($conn, $id, $status){
        try{
            $sql = "update orders set status=:status where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            return $stmt->execute();
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    //Lấy ra hết bằng id
    public static function getAllById($conn, $id){
        try {
            $sql = "select * from orders where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                $result = $stmt->fetch();
                return $result;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    
    //Xóa 
    public static function deleteById($conn, $id)
    {
        try {
            $sql = "delete from orders where id =:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
?>