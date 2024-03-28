<?
class User
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $role;
    public $verify_token;
    public $verify_status;
    public function __construct($username = null, $password = null, $email = null, $role = null, $verify_token = null, $verify_status = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
        $this->verify_token = $verify_token;
        $this->verify_status = $verify_status;
    }

    // Xác thực người dùng
    public static function authenticate($conn, $username, $password)
    {
        $sql = "select * from users where username=:username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            $hash = $user->password;
            return password_verify($password, $hash);
        }
    }

    //Kiểm tra
    private function validate()
    {
        return $this->username != '' && $this->password != '';
    }

    //Thêm một người dùng mới
    public function addUser($conn)
    {
        if ($this->validate()) {
            $sql = "insert into users(username, password, email, role, verify_token)
                    values (:username, :password, :email, :role, :verify_token)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':role', $this->role, PDO::PARAM_INT);
            $stmt->bindValue(':verify_token', $this->verify_token, PDO::PARAM_STR);
            return $stmt->execute();
        } else
            return false;
    }

        //Hàm lấy ra thông tin
public static function getAll($conn)
{
    try {
        $sql = "select * from users where role = 0 order by id asc";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');
        if ($stmt->execute()) {
            $user = $stmt->fetchAll();
            return $user;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}
    //lấy ra thông tin 1 người theo username và password
    public static function getByUsernamePass($conn, $username, $password)
    {

        try {
            $sql = "select * from users where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user->password)) {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    //lấy ra thông tin bằng username
    public static function getByUsername($conn, $username)
    {

        try {
            $sql = "select * from users where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    //Thay đổi mật khẩu
    public function updatePassWord($conn, $username, $password)
    {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "update users
            set password =:password where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Xóa user

    public static function deleteUser($conn, $username)
    {
        try {
            $sql = "delete from users where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function deleteUserById($conn, $id)
    {
        try {
            $sql = "delete from users where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //Kiểm tra email
    public static function getByEmail($conn, $email)
    {
        try {
            $sql = "select * from users where email=:email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
            if ($stmt->execute()) {
                $user = $stmt->fetch();
                return $user;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    //Lấy ra thông tin của 1 user bằng email và verify_token
    public static function getAllByEmailAndToken($conn, $email, $verify_token)
    {
        try {
            $sql = "select * from users where email = :email and verify_token=:verify_token";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':verify_token', $verify_token, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
            if ($stmt->execute()) {
                $user = $stmt->fetch();
                return $user;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    //thay đổi trạng thái xác thực email
    public function updateVerify_status($conn, $email, $verify_token)
    {
        try {
            $sql = "update users
            set verify_status = 1 where email=:email and verify_token =:verify_token";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':verify_token', $verify_token, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //thay đổi verify_token
    public function updateVerify_Token($conn, $email, $verify_token)
    {
        try {
            $sql = "update users
            set verify_token =:verify_token where email=:email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':verify_token', $verify_token, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    
}
