<?
class Cart{
    public $id_order;
    public $id_product;
    public $quantity;
    public $price;

    public function __construct($id_order= null, $id_product = null, $quantity = null, $price = null)
    {
        $this->id_order = $id_order;
        $this->id_product = $id_product;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function add($conn)
    {
            try {
                $sql = "insert into cart (id_order, id_product, quantity, price) values (:id_order, :id_product, :quantity, :price)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id_order', $this->id_order, PDO::PARAM_INT);
                $stmt->bindValue(':id_product', $this->id_product, PDO::PARAM_INT);
                $stmt->bindValue(':quantity', $this->quantity, PDO::PARAM_INT);
                $stmt->bindValue(':price', $this->price, PDO::PARAM_INT);
                return $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
    }

    //Lấy ra thông tin đơn hàng
    public static function getAllById_Order($conn, $id_order){
        try{
            $sql = "select cart.*, products.*, orders.*
                    from cart 
                    join products on cart.id_product = products.id
                    join orders on cart.id_order = orders.id
                    where id_order=:id_order";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id_order', $id_order, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll();
                return $result;
            }else{
                return null;
            }
        }catch(Exception $e){
            echo $e->getMessage();
            return null;
        }
    }
}
?>