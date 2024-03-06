<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | Signed in</title>
        <link rel="stylesheet" href="css.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="./signedin.js"></script>
        <script>
            const del = (id) => {
                if(id == 1){
                    alert("ลบ admin หลักไม่ได้");
                    return;
                }
                let prom = prompt("Enter \"DELETE\" for delete user","");
                if(prom == "DELETE")
                    window.location.href = "./adminDelete.php?id=<?php echo $_GET['id']?>";
            }
        </script>
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
                            window.location.href = './signout.php';
                        </script>
                    ";
                }

                require("./gobal.php");
                $stmt = $mysqli->stmt_init();  
                $sql = 'SELECT * FROM user WHERE user_id = ?';
                $stmt->prepare($sql);
                $params = [$_GET["id"]];
                $stmt->bind_param('i', ...$params);
                $status = $stmt->execute();
                $result = $stmt->get_result(); 
                $stmt->close();
                $numRows = $result->num_rows;
                if($numRows == 1){
                    while($row = $result->fetch_assoc()){
                        $id = $row["user_id"];
                        $user = $row["user_username"];
                        $fname = $row["user_fname"];
                        $lname = $row["user_lname"];
                        $gender = $row["user_gender"];
                        $age = $row["user_age"];
                        $province = $row["user_province"];
                        $email = $row["user_email"];
                        $role = $row["user_role"];
                    }
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
        ?>
        <form class="loginCard" method="POST">
            <div style="display: flex; justify-content: space-between;  align-items: center;">
                <h3>EDIT</h3>
                <a class="aBack" href="./showdata.php">BACK</a>
            </div>
            <label>username</label>
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="text" name="user" value="<?php echo $user?>" readonly='readonly'>
            <label>ชื่อ</label>
            <input type="text" name="fname" id="fname" value="<?php echo $fname?>">
            <label>นามสกุล</label>
            <input type="text" name="lname" id="lname" value="<?php echo $lname?>">
            <label>เพศ</label>
            <select name="gender" id="gender">
                <option value="1" <?php echo ($gender == 1) ? "selected" : ""?>>ชาย</option>
                <option value="2" <?php echo ($gender == 2) ? "selected" : ""?>>หญิง</option>
            </select>
            <label>อายุ</label>
            <input type="number" min="1" name="age" id="age" value="<?php echo $age?>">
            <label>จังหวัด</label>
            <select name="province" id="province">
                <?php
                    foreach($provinceG as $k => $p){
                        if($k == 0) continue;
                        if($k == $province)
                            $selected = "selected";
                        echo "
                            <option value='$k' $selected>
                                $p
                            </option>
                        ";
                    }
                ?>
            </select>
            <label>E-mail</label>
            <input type="email" name="email" id="email" value="<?php echo $email?>">

            <input class="submitSignin" type="submit" value="Save">
            <button class="submitSignin" type="button" onclick="del(<?php echo $id?>)" dis>Delete</button>
        </form>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $id = $_POST["id"];
                $user = $_POST["user"];
                $fname = $_POST["fname"];
                $lname = $_POST["lname"];
                $gender = $_POST["gender"];
                $age = $_POST["age"];
                $province = $_POST["province"];
                $email = $_POST["email"];

                $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                $stmt = $mysqli->stmt_init();
                $sql = 'UPDATE `user` SET `user_username`=?,`user_fname`=?,`user_lname`=?,`user_gender`=?,`user_age`=?,`user_province`=?,`user_email`=? WHERE user_id = ?';
                $stmt->prepare($sql);
                $params = [$user,$fname,$lname,$gender,$age,$province,$email,$_GET["id"]];
                $stmt->bind_param('sssiiisi', ...$params);
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
    </body>
</html>