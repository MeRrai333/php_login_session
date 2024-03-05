<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | Admin Add</title>
        <link rel="stylesheet" href="css.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="adminAdd.js"></script>
    </head>
    <body style="display: flex; justify-content: center;  align-items: center; height: 100vh">
        <?php
            session_start();
            if(!isset($_SESSION['signed_in'])){
                header('Location: ./');
            }
            else{
                /* verify user is admin */
                $userAdmin = $_SESSION['signed_in'][0];
                $passAdmin = $_SESSION['signed_in'][1];
                $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                $stmt = $mysqli->stmt_init();  
                $sql = 'SELECT * FROM user WHERE user_username = ? AND user_password = MD5(?);';
                $stmt->prepare($sql);
                $params = [$userAdmin, $passAdmin];
                $stmt->bind_param('ss', ...$params);
                $status = $stmt->execute();
                $result = $stmt->get_result(); 
                $stmt->close();
                $numRows = $result->num_rows;
                if($numRows == 1){
                    while($row = $result->fetch_assoc()){
                        $role = $row["user_role"];
                    }
                    if($role != 99)
                        header("Location: ./signedin.php");
                }
                else{
                    echo "
                        <script>
                            alert('error session');
                            window.location.href = './';
                        </script>
                    ";
                }
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $user = $_POST["user"];   
                $pass = $_POST["pass"];
                $fname = $_POST["fname"];
                $lname = $_POST["lname"];
                $gender = $_POST["gender"];
                $age = $_POST["age"];
                $province = $_POST["province"];
                $email = $_POST["email"];
                $role = $_POST["role"];

                mysqli_report(MYSQLI_REPORT_OFF);
                $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                $stmt = $mysqli->stmt_init();  
                $sql = 'INSERT INTO user VALUES (0, ?, MD5(?), ?, ?, ?, ?, ?, ?, ?)';
                $stmt->prepare($sql);
                $params = [$user, $pass, $fname, $lname, $gender, $age, $province, $email, $role];
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
        <form class="loginCard" method="POST">
            <div style="display: flex; justify-content: space-between;  align-items: center;">
                <h3>ADMIN ADD</h3>
                <a class="aBack" href="./showdata.php">BACK</a>
            </div>
            <label>username</label>
            <input type="text" name="user" id="user">
            <label>password</label>
            <input type="password" name="pass" id="pass">
            <label>confirm password</label>
            <input type="password" name="pass2" id="pass2">
            <label>ชื่อ</label>
            <input type="text" name="fname" id="fname">
            <label>นามสกุล</label>
            <input type="text" name="lname" id="lname">
            <label>เพศ</label>
            <select name="gender" id="gender">
                <option value="0"></option>
                <option value="1">ชาย</option>
                <option value="2">หญิง</option>
            </select>
            <label>อายุ</label>
            <input type="number" min="1" name="age" id="age" value="20">
            <label>จังหวัด</label>
            <select name="province" id="province">
            </select>
            <label>E-mail</label>
            <input type="email" name="email" id="email">
            <label>Role</label>
            <select name="role" id="role">
                <option value="0"></option>
                <option value="1">User</option>
                <option value="99">Admin</option>
            </select>
            <input type="submit" value="Sign up">
        </form>
    </body>
</html>