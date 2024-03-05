<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | Update</title>
        <link rel="stylesheet" href="css.css">
        <?php
            session_start();
            if(!isset($_SESSION['signed_in'])){
                header('Location: ./');
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $id = $_POST["id"];
                $fname = $_POST["fname"];
                $lname = $_POST["lname"];
                $gender = $_POST["gender"];
                $age = $_POST["age"];
                $province = $_POST["province"];
                $email = $_POST["email"];

                $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                $stmt = $mysqli->stmt_init();  
                $sql = 'UPDATE `user` SET `user_fname`=?,`user_lname`=?,`user_gender`=?,`user_age`=?,`user_province`=?,`user_email`=? WHERE user_username = ? AND user_password = MD5(?);';
                $stmt->prepare($sql);
                $params = [$fname,$lname,$gender,$age,$province,$email,$_SESSION["signed_in"][0],$_SESSION["signed_in"][1]];
                $stmt->bind_param('ssiiisss', ...$params);
                $status = $stmt->execute();
                $stmt->close();
                if($status)
                    echo "
                        <script>
                            alert('Update ข้อมูลสำเร็จ');
                            window.history.back();
                        </script>
                    ";
                else
                    echo "
                        <script>
                            alert('Update ข้อมูลล้มเหลว');
                            window.history.back();
                        </script>
                    ";
            }
        ?>
        </head>
</html>