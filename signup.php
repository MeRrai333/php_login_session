<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | signup.php</title>
        <link rel="stylesheet" href="css.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="regis.js"></script>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $user = $_POST["user"];   
                $pass = $_POST["pass"];
                $fname = $_POST["fname"];
                $lname = $_POST["lname"];
                $gender = $_POST["gender"];
                $age = $_POST["age"];
                $province = $_POST["province"];
                $email = $_POST["email"];

                mysqli_report(MYSQLI_REPORT_OFF);
                $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                $stmt = $mysqli->stmt_init();  
                $sql = 'INSERT INTO user VALUES (0, ?, MD5(?), ?, ?, ?, ?, ?, ?, ?)';
                $stmt->prepare($sql);
                $params = [$user, $pass, $fname, $lname, $gender, $age, $province, $email, 1];
                $stmt->bind_param('ssssiiisi', ...$params);
                $status = $stmt->execute();
                $stmt->close();
                if($status)
                    echo "<script>
                        alert('สำเร็จ');
                        window.location.href = './';
                    </script>";

                else
                    echo "<script>
                        alert('ล้มเหลว username/email มีอยู่ในระบบ');
                        history.back();
                    </script>";
            }
        ?>
    </head>
</html>