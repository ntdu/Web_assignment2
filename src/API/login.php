<?php
    if(isset($_POST["rePassword"])) { 
        // signUp
        $username = $_POST["username"];
        $password = $_POST["rePassword"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        if (validation($username, $password, $phone, $email)) {
            include 'db_connection.php';
            $conn = OpenCon();
    
            $sql_check = "SELECT * FROM User WHERE username='$username'";
            if(mysqli_num_rows(mysqli_query($conn, $sql_check))!= 0){
                echo json_encode(['code'=>201, 'msg'=> "Username existed"]);
            } else {   
                $sql = "INSERT INTO User (username, password, phone, email, address) VALUES ('$username', '$password', '$phone', '$email', '$address')";
                
                if(mysqli_query($conn, $sql)){
                    echo json_encode(['code'=>200, 'msg'=>"success."]);
                } else{
                    echo json_encode(['code'=>500, 'msg'=>"ERROR: Could not able to execute $sql. " . mysqli_error($conn)]);
                }
            }
            CloseCon($conn);
        }
    }
    else {  
        // signIn
        $username = $_POST["username"];
        $password = $_POST["password"];

        include 'db_connection.php';
        $conn = OpenCon();

        $sql_check = "SELECT * FROM User WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql_check);
        $return = $result->fetch_all(MYSQLI_ASSOC);

        if(mysqli_num_rows($result)!= 0){
            echo json_encode(['code'=>200, 'msg'=> "success.", 'data'=>json_encode($return)]);
        } else {      
            echo json_encode(['code'=>201, 'msg'=>"error."]);
        }
        CloseCon($conn);
    }

    function validation($username, $password, $phone, $emails) {
        if (empty($username)) {
            echo json_encode(['code'=>201, 'msg'=>"Tên đăng nhập được yêu cầu!"]);
            return false;
        }
        if(strlen($username) < 2 || strlen($username) > 30) {
            echo json_encode(['code'=>201, 'msg'=>"Chiều dài tên đăng nhập phải từ 2 đến 30 ký tự"]);  
            return false;
        }
        if (empty($password)) {
            echo json_encode(['code'=>201, 'msg'=>"Mật khẩu được yêu cầu!"]);
            return false;
        } 
        if(strlen($password) < 2 || strlen($password) > 30) {
            echo json_encode(['code'=>201, 'msg'=>"Chiều dài mật khẩu phải từ 2 đến 30 ký tự"]);  
            return false;
        } 
        if (empty($phone)) {
            echo json_encode(['code'=>201, 'msg'=>"Số điện thoại được yêu cầu"]);
            return false;
        }
        if(strlen($phone) < 10 || strlen($phone) > 11) {
            echo json_encode(['code'=>201, 'msg'=>"Chiều dài số điện thoại phải từ 10 đến 11 số"]); 
            return false; 
        }
        if (empty($emails)) {
            echo json_encode(['code'=>201, 'msg'=>"Email được yêu cầu"]);
            return false;
        }
        if(!filter_var($emails, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['code'=>201, 'msg'=>"Email không xác định"]);  
            return false;
        }
        return true;
    }

?>