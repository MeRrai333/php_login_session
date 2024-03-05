<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | Sign in</title>
        <link rel="stylesheet" href="css.css">
        <?php
            session_start();
            if(isset($_SESSION['signed_in'])){
                header('Location: ./signedin.php');
            }
        ?>
    </head>
    <body style="display: flex; justify-content: center;  align-items: center; height: 100vh">
        <form class="loginCard" method="POST">
            <h3>SIGN IN</h3>
            <label>username</label>
            <input type="text" name="user">
            <label>password</label>
            <input type="password" name="pass">
            <a href="./regis.html" class="alink">Sign up</a>
            <input class="submitSignin" type="submit" value="Sign in">
        </form>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $user = $_POST["user"];
                $pass = $_POST["pass"];

                $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                $stmt = $mysqli->stmt_init();  
                $sql = 'SELECT user_username FROM user WHERE user_username = ? AND user_password = MD5(?);';
                $stmt->prepare($sql);
                $params = [$user, $pass];
                $stmt->bind_param('ss', ...$params);
                $status = $stmt->execute();
                $result = $stmt->get_result(); 
                $stmt->close();
                $numRows = $result->num_rows;
                if($numRows == 1){
                    $_SESSION["signed_in"] = array($user, $pass);
                    echo "
                        <script>
                            alert('sign in สำเร็จ');
                            window.location.href = './signedin.php';
                        </script>
                    ";
                }
                else{
                    echo "
                        <script>
                            alert('sign in ล้มเหลว user/password ไม่ถูกต้อง');
                            window.location.href = './';
                        </script>
                    ";
                }
            }
        ?>
    </body>
</html>