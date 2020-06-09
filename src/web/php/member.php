<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>會員專區</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="header" class="text-center">
        <a class="col-6" href=".\index.php" style="color: rgb(199, 255, 125); font-size: 1.2cm; font-weight: 500;"><img src="../image/web2.png"></a>
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href=".\index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href=".\category.php"> 商品列表 <span class="sr-only">(current)</span></a>
                </li>
                <?php
                session_start();
                if (isset($_SESSION['login_session'])) {
                    echo
                        '<li class="nav-item active">
                        <a class="nav-link" href=".\cart.php"> 購物車 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href=".\donation.php"> 捐贈書籍 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href=".\switch.php"> 以書換書 <span class="sr-only">(current)</span></a>
                    </li>';
                }
                ?>
                <li>
                    <form class="form-inline" action="search.php" method="get">
                        <input class="form-control mr-sm-2" type="text" id="kw" name="kw" placeholder="Search" required>
                        <input type="submit" value="搜尋" class="btn btn-outline-success my-2 my-sm-0">
                    </form>
                </li>
            </ul>
            <?php
            if (isset($_SESSION["login_session"])) {
                if ($_SESSION["login_session"]) {
                    echo '<a href="member.php" style="color: rgb(255,255,255)">' . $_SESSION["email"] . '</a>';
                    echo '<form class="form-inline mt-2 mt-md-0">
                        <a class="btn btn-outline-success my-2 my-sm-0" href="index.php?logout=true" role="button">
                            登出</a>
                    </form>';
                } else {
                    echo '<form class="form-inline mt-2 mt-md-0">
                        <a class="btn btn-outline-success my-2 my-sm-0" href=".\signup.php" role="button">
                            註冊</a>
                    </form>
                    <form class="form-inline mt-2 mt-md-0">
                        <a class="btn btn-outline-success my-2 my-sm-0" href=".\login.php" role="button">
                            登入</a>
                    </form>';
                }
            } else {
                echo '<form class="form-inline mt-2 mt-md-0">
                    <a class="btn btn-outline-success my-2 my-sm-0" href=".\signup.php" role="button">
                        註冊</a>
                </form>
                <form class="form-inline mt-2 mt-md-0">
                    <a class="btn btn-outline-success my-2 my-sm-0" href=".\login.php" role="button">
                        登入</a>
                </form>';
            }
            ?>
        </div>
    </nav>
        <br>
        <div align="center">
            <h1 style=font-weight:bold;> 會員專區 </h1>
        </div>
        
    <div class="row ">
        <div align="center" class="col" style="background-color:rgb(75,81,78); "><a style="color: rgb(255, 255, 255);" href="member.php?update=true">更改會員資料</a></div>
        <div align="center" class="col" style="background-color:rgb(75,81,78); "><a style="color: rgb(255, 255, 255);" href="member.php?purchase=true">購買紀錄</a></div>
        <div align="center" class="col" style="background-color:rgb(75,81,78);"><a style="color: rgb(255, 255, 255);" href="member.php?switch=true">換書紀錄</a></div>
    </div>
    <?php
        $servername = "220.132.211.121";
        $username = "ZYS";
        $pass = "qwe12345";
        $dbname = "bookstore";
        $conn = mysqli_connect($servername, $username, $pass);
        if (empty($conn)) {
            print mysqli_error($conn);
            die("無法連結資料庫");
            exit;
        }
        if (!mysqli_select_db($conn, $dbname)) {
            die("無法選擇資料庫");
        }
        mysqli_query($conn, "SET NAMES 'utf8'");
        if(isset($_GET['update']) || (!isset($_GET['update'])&&!isset($_GET['purchase'])&&!isset($_GET['switch']))){
            $sql = 'SELECT * FROM users WHERE "'.$_SESSION['email'].'" = Email';

            //送出UTF8編碼的MySQL指令
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $oldpass = $row['Password'];
            $newpass = "";
            $oldadd = $row['Address'];
            $newadd = "";
            $Email = $_SESSION['email'];
            if (isset($_POST["password"]))
                $newpass = $_POST["password"];
            if (isset($_POST["address"]))
                $newadd = $_POST["address"];
            
            if($newadd != ""&& $newpass != ""&& ($newadd != $oldadd || $newpass != $oldpass) ){    //update account
                $sql = "UPDATE users SET users.Password = '$newpass', users.Address = '$newadd' WHERE Email = '$Email'";
                mysqli_query($conn, $sql);
                echo '<script>
                    var r = alert("已更改資料");
                    location.href="member.php"; 
                </script>'; 
                // header("Location: member.php");
            }
            echo '
            <form action="member.php" method="post">
                <div align="center" style="padding:10px;margin-bottom:5px;">
                    <br>
                    <label for="Email">Email:</label>
                    <a>'.$row['Email'].'</a>
                    <br>
                    <br>
                    <label for="password">密碼:</label>
                    <input type="password" name="password" id="password" value="'.$row['Password'].'" required />
                    <br>
                    <br>
                    <label for="address">地址:</label>
                    <input type="text"" name=" address" id="address" value="'.$row['Address'].'" required />
                    <br>
                    <br>
                    <label for="id"">點數 :</label>
                    <a>'.$row['Reward_points'].'(可換書)</a>
                    <br>
                    <label for="id"">ID :</label>
                    <a>'.$row['ID'].'</a>
                    <br>
                    <input type="submit" onclick="update()" value="更改會員帳戶" method="post" />
                </div>
            </form>';
        }
        else if(isset($_GET['purchase'])){
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM users WHERE Email = '$email'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $MID = $row['ID'];
            }
            $sql = "SELECT * FROM purchase WHERE MID = $MID ORDER BY Date DESC";
            $result = mysqli_query($conn, $sql);
            echo '<div align="center">';
            echo '<table class="table" style="text-align:center;">';
            echo '<tr>
                        <td>購買ID</td>
                        <td>商品預覽圖</td>
                        <td>商品名稱</td>
                        <td>購買日期</td>
                        <td>數量</td>
                    </tr>';
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $ID = $row['ID'];
                $Amount = $row['Amount'];
                $Date = $row['Date'];
                $PID = $row['PID'];
                $pid = intval($PID);
                $sql = "SELECT * FROM product WHERE ID = $PID";
                $r = mysqli_query($conn, $sql);
                $tuple = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $Pname = $tuple['Name'];
                echo '<tr>
                        <td>' . $ID . '</td>
                        <td><a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a></td>
                        <td><a class="link" href=".\product.php?pid=' . $pid . '">' . $Pname . '</a></td>
                        <td>' . $Date . '</td>
                        <td>' . $Amount . '</td>
                    </tr>';
                    
            }
            echo '</table>';
            echo '</div>';
            
        }
        else if(isset($_GET['switch'])){
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM users WHERE Email = '$email'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $MID = $row['ID'];
            }
            $sql = "SELECT * FROM switch WHERE MID = $MID ORDER BY Date DESC";
            $result = mysqli_query($conn, $sql);
            echo '<div align="center">';
            echo '<table class="table" style="text-align:center;">';
            echo '<tr>
                        <td>兌換ID</td>
                        <td>商品名稱</td>
                        <td>交換日期</td>
                        <td>ISBN</td>
                        <td>數量</td>
                    </tr>';
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $ID = $row['ID'];
                $Amount = $row['Amount'];
                $Date = $row['Date'];
                $ISBN = $row['ISBN'];
                
                $sql = "SELECT * FROM used_book WHERE ISBN = '$ISBN'";
                $r = mysqli_query($conn, $sql);
                $tuple = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $Title = $tuple['Title'];
                echo '<tr>
                        <td>' . $ID . '</td>
                        <td>' . $Title . '</td>
                        <td>' . $Date . '</td>
                        <td>'. $ISBN .'</td>
                        <td>' . $Amount . '</td>
                    </tr>';
            }
            echo '</table>';
            echo '</div>';
        }
    ?>
</body>

</html>