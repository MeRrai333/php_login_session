<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale-1.0">
        <title>HW-8 Methit | Admin</title>
        <link rel="stylesheet" href="css.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="./showdata.js"></script>
        <?php
            session_start();
            if(!isset($_SESSION['signed_in'])){
                header('Location: ./');
            }
            else{
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
        ?>
    </head>
    <body style="display: flex; justify-content: center;  align-items: center; height: 100vh">
        <div class="userTableContainer">
            <div style="display: flex; justify-content: space-between;  align-items: center;">
                <h3>ADMIN</h3>
                <div>
                    <input id="searchText" type="text" placeholder="Search by username" value="<?php echo (isset($_GET['search']) ? $_GET['search'] : "")?>">
                    <button id="searchBTN" class="btnSearch">Search</button>
                </div>
                <a class="signOut" href="./signout.php">Sign out</a>
            </div>
            <table>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Role</th>
                    <th> </th>
                </tr>
                <?php
                    $mysqli = new mysqli('localhost', 'root', '', 'dbhw8');
                    $stmt = $mysqli->stmt_init();
                    $searchText = isset($_GET['search']) ? "%{$_GET['search']}%" : "%%";
                    $sql = 'SELECT * FROM user WHERE user_username LIKE ?';
                    $stmt->prepare($sql);
                    $stmt->bind_param('s', $searchText);
                    $status = $stmt->execute();
                    $result = $stmt->get_result(); 
                    $stmt->close();
                    $numRows = $result->num_rows;
                    if($numRows > 0){
                        $index = 1;
                        while($row = $result->fetch_assoc()){
                            $id = $row["user_id"];
                            $user = $row["user_username"];
                            $email = $row["user_email"];
                            if($row["user_role"] == 1)
                                $role = "user";
                            else if($row["user_role"] == 99)
                                $role = "admin";
                            else
                                $role = "error";
                            echo "<tr>
                                <td>$index</td>
                                <td>$user</td>
                                <td>$email</td>
                                <td>$role</td>
                                <td>
                                    <a href='./adminEdit.php?id=$id' class='aEdit'>Edit</a>
                                </td>
                            </tr>";
                            $index++;
                        }
                    }
                    else{
                        echo "<tr>
                            <td style='text-align: center;' colspan='5'>none</td>
                        </tr>";
                    }
                ?>
            </table>
            <div>
                <a class="aAdd" href="./adminAdd.php">ADD</a>
            </div>
        </div>
    </body>
</html>