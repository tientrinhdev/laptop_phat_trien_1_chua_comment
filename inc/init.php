<?
    
    /*
        Phuong thuc tu dong load cac class tuong ung
    */
    spl_autoload_register(
        function($className){
            $fileName = strtolower($className) . ".php";
            $dirRoot = dirName(__DIR__);
            require $dirRoot . "/classes/" . $fileName;
        }
    );
    //goi tap tin config
    require dirname(__DIR__) . "/config.php";
    if(session_id() === '') session_start();

    //Hàm quản lý lỗi 
    function errorHandler($level, $message ,$file, $line){
        throw new ErrorException($message, 0, $level, $file, $line);
    }

    //hàm quản lý exception
    function exceptionHandler($ex){
        if(DEBUG){
            echo "<h2>Lỗi</h2>";
            echo "<p>Exception: " .get_class($ex) ."</p>";
            echo "<p>Nội dung: " .$ex->getMessage() ."</p>";
            echo "<p>Tập tin: " .$ex->getFile() ." dòng thứ :". $ex->getLine() . "</p>";
        }else{
            echo "<h2>Lỗi. Vui lòng thử lại</h2>";
        }
        exit();
    }
    //đăng kí với PHP
    set_error_handler('errorHandler');
    set_exception_handler('exceptionHandler');
?>