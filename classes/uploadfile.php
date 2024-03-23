<?
    include "errorfileupload.php";

    class Uploadfile{
        public static function process(){
            try{
                if(empty($_FILES)){
                    Dialog::show('Không thể upload tập tin');
                    return null;
                }
                $rs = Errorfileupload::error($_FILES['file']['error']);
                if($rs != 'OK'){
                    Dialog::show($rs);
                    return null;
                }
    
                //Giới hạn kích thước file <= 2M
                $filemaxsize = FILE_MAX_SIZE;
                if($_FILES['file']['error'] > $filemaxsize){
                    Dialog::show('Kích thước tập tin phải <=' . $filemaxsize);
                    return null;
                }
                //giới hạn loại file hình ảnh
                $mime_types = FILE_TYPE;
                $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    
                //file upload sẽ lưu trong tmp_name
                $file_mime_type = finfo_file($fileinfo, $_FILES['file']['tmp_name']);
                if(! in_array($file_mime_type, $mime_types)){
                    Dialog::show('Kiểu tập tin phải là hình ảnh');
                    return null;
                }
                //Thực hiện upload file lên thư mục uploads trên server
                $pathinfo = pathinfo($_FILES['file']['name']);
                $filename = $pathinfo['filename'];
                $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
                //Xử lý khong ghi đè nếu đã tồn tai file trong uploads
                $fullname = $filename . '.'. $pathinfo['extension'];
                //tạo đường dẫn đến thư mục upload trên server
                $fileToHost = "../uploads/" . $fullname;
                $i = 1;
                while(file_exists($fileToHost)){
                    $fullname = $filename . "-$i." . $pathinfo['extension'];
                    $fileToHost = "../uploads/" . $fullname;
                    $i++;
                }
                //Lấy file tạm trong bộ nhớ đưa lên host
                $fileTmp = $_FILES['file']['tmp_name'];
    
                if(move_uploaded_file($fileTmp, $fileToHost)){
                    return $fullname;
                }else{
                    return null;
                }
            }catch(Exception $e){
                Dialog::show($e->getMessage());
            }
        }
    }
?>