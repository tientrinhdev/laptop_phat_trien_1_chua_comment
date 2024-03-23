<?
    class Contact{
        public $id;
        public $name;
        public $phone;
        public $email;
        public $feedback;

        public function __construct($name = null,$phone = null, $email = null, $feedback = null){
            $this->name = $name;
            $this->phone = $phone;
            $this->email = $email;
            $this->feedback = $feedback;
        }

        private function validate(){
            return  $this->name && $this->phone && $this->email &&   $this->feedback;
        }

        public function add($conn)
    {
        if ($this->validate()) {
            try {
                $sql = "insert into contact (name, phone, email, feedback) values (:name, :phone, :email, :feedback)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':feedback', $this->feedback, PDO::PARAM_STR);
                return $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            return false;
        }
    }

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
    }

    
?>