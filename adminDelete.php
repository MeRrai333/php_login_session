<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | Signed in</title>
        <link rel="stylesheet" href="css.css">
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
                $stmt = $mysqli->stmt_init();  
                $sql = 'DELETE FROM user WHERE user_id = ?';
                $stmt->prepare($sql);
                $params = [$_GET["id"]];
                $stmt->bind_param('i', ...$params);
                $status = $stmt->execute();
                $result = $stmt->get_result(); 
                $stmt->close();
                if($status)
                    echo "<script>
                        alert('ลบ User สำเร็จ');
                        window.location.href = './showdata.php';
                    </script>";
                else
                    echo "<script>
                        alert('ลบ User ไม่สำเร็จ');
                        window.history.back();
                    </script>";
                
            }
        ?>
    </body>
</html>