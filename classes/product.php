<?
date_default_timezone_set("Asia/Bangkok");
class Product
{
    public $id;
    public $productname;
    public $branch;
    public $description;
    public $price;
    public $imagefile;
    public $id_user;
    public $created_day;

    public function __construct($productname = null, $branch = null, $description = null, $price = null, $imagefile = null, $id_user = null, $created_day = null)
    {
        $this->productname = $productname;
        $this->branch = $branch;
        $this->description = $description;
        $this->price = $price;
        $this->imagefile = $imagefile;
        $this->id_user = $id_user;
        $this->created_day = date('Y-m-d  h:i:s');
    }

    private function validate(){
        return  $this->productname && $this->branch && $this->description &&   $this->price;
    }

    public static function count($conn)
    {
        try {
            $sql = "select count(id) from products";
            return $conn->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
//Hàm thêm vào thông tin
    public function add($conn)
    {
        if ($this->validate()) {
            try {
                $sql = "insert into products (productname, branch, description, price, imagefile, id_user, created_day) values (:productname, :branch, :description, :price, :imagefile, :id_user, :created_day)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':productname', $this->productname, PDO::PARAM_STR);
                $stmt->bindValue(':branch', $this->branch, PDO::PARAM_STR);
                $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
                $stmt->bindValue(':price', $this->price, PDO::PARAM_INT);
                $stmt->bindValue(':imagefile', $this->imagefile, PDO::PARAM_STR);
                $stmt->bindValue(':id_user', $this->id_user, PDO::PARAM_INT);
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

    //Hàm lấy ra thông tin
public static function getAll($conn)
{
    try {
        $sql = "select * from products order by id asc";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');
        if ($stmt->execute()) {
            $products = $stmt->fetchAll();
            return $products;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}
//Hàm lấy ra thông tin bằng id
public static function getById($conn, $id)
    {
        try {
            $sql = "select * from products where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');
            if ($stmt->execute()) {
                $book = $stmt->fetch();
                return $book;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
//Hàm phân trang
    public static function getPaging($conn, $limit, $offset)
    {
        try {
            $sql = "select * from products order by productname asc limit :limit offset :offset";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');
            if ($stmt->execute()) {
                $products = $stmt->fetchAll();
                return $products;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
//Hàm sửa thông tin sản phẩm trừ ảnh
public function update($conn)
{
    try {
        $sql = "update products set productname =:productname, branch =:branch, description=:description, price=:price where id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':productname', $this->productname, PDO::PARAM_STR);
        $stmt->bindValue(':branch', $this->branch, PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindValue(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

//Hàm sửa ảnh của sản phẩm
public function updateImage($conn, $id, $imagefile)
{
    try {
        $sql = "update products
        set imagefile =:imagefile where id =:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':imagefile', $this->imagefile, $this->imagefile == null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
//Hàm xóa sản phẩm bằng id
    public function deleteById($conn, $id)
    {
        try {
            $sql = "delete from products where id =:id";
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