<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>書福</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php
    session_start();
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
    // 設定連線編碼
    // 检测连接
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }
    mysqli_query($conn, "SET NAMES 'utf8'");
    if (isset($_GET['del'])) {
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM users WHERE Email='$email'";
        $mid = 0;
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $mid = $row['ID'] / 1;
        }
        $sql = "UPDATE users SET Flag = 0 WHERE Email='$email'";
        mysqli_query($conn, $sql);
        $_SESSION["login_session"] = false;
        // header("Location: index.php");
        // $sql = "DELETE FROM cart WHERE MID=$mid;";
        // mysqli_query($conn, $sql);

        // $sql = "DELETE FROM users WHERE Email='$email';";
        // if (mysqli_query($conn, $sql)){
        //     echo '<script language="javascript">';
        //     echo 'comfirm("已刪除帳戶");';
        //     echo '</script>';
        //     $_SESSION["login_session"] = false;
        //     header("Location: index.php");
        // }
        // else{
        //     echo '<script language="javascript">';
        //     echo 'alert("刪除失敗");';
        //     echo '</script>';
        // }

    }
    function logout()
    {
        unset($_SESSION["login_session"]);
        unset($_SESSION["email"]);
    }
    function addcart()
    {
        if (isset($_SESSION["login_session"])) {
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
            // 設定連線編碼
            mysqli_query($conn, "SET NAMES 'utf8'");
            // 检测连接
            if ($conn->connect_error) {
                die("連接失敗: " . $conn->connect_error);
            }
            $cartid = $_GET['cartid'];
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM users WHERE Email='$email'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $mid = $row['ID'];
            }
            $sql = "INSERT INTO cart (MID,PID,Amount) VALUES ($mid,$cartid,1)";
            if ($conn->query($sql) === TRUE) {
                echo '<script language="javascript">';
                echo 'alert("加入購物車");';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("已經加入購物車");';
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("請登入後再點擊");';
            echo '</script>';
        }
    }
    if (isset($_GET['logout'])) {
        logout();
    }
    if (isset($_GET['cartid'])) {
        addcart();
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="header" class="text-center">
        <a class="col-6" href=".\index.php" style="color: rgb(199, 255, 125); font-size: 1.2cm; font-weight: 500;"><img src="../image/web2.png"></a>
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class="nav-link" href=".\index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href=".\category.php"> 商品列表 <span class="sr-only">(current)</span></a>
                </li>
                <?php 
                if(isset($_SESSION['login_session'])){
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
                    <form class="form-inline" action="search.php" method="GET">
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

    <div class="container" style="width:70%">
    <div id="demo" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <!-- <li data-target="#demo" data-slide-to="2"></li> -->
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner" >
                        <div class="carousel-item active">
                            <img style="width: 100%;" src="../image/黑.png">
                        </div>
                        <div class="carousel-item">
                            <img style="width: 100%;" src="../image/書.jpg">
                        </div>
                        <!-- <div class="carousel-item"> -->
                            <!-- <img style="width: 100%;" src="../image/首.png"> -->
                        <!-- </div> -->
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>

        </div>
    </div>
    
    <div class="row justify-content-center">
        <!-- <div class="col-1" style="margin-left: 80px; background-color: rgb(161, 161, 161); height: 500px;">
            <h3>類別</h3><br>
            <a class="link" href="category.php?type=0">推薦</a><br>
            <a class="link" href="category.php?type=1">輕小說</a><br>
            <a class="link" href="category.php?type=2">歐美文學</a><br>
            <a class="link" href="category.php?type=3">青春幻想</a><br>
            <a class="link" href="category.php?type=4">歐美科幻</a><br>
            <a class="link" href="category.php?type=5">人文史地</a><br>
            <a class="link" href="category.php?type=6">健康</a><br>
        </div> -->
        <div class="col-8">
            <table class="table" style="text-align:center;">
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
                // 設定連線編碼
                mysqli_query($conn, "SET NAMES 'utf8'");
                // $numbers = range(1, 20);
                // //shuffle 將陣列順序隨即打亂
                // shuffle($numbers);
                // //array_slice 取該陣列中的某一段
                // $num = 6;
                // $arr = array_slice($numbers, 0, $num);
                // for ($i = 0; $i < 5; $i++) {
                //     $pid = $arr[$i];
                //     $sql = "SELECT * FROM product WHERE ID = $pid";
                //     $result = mysqli_query($conn, $sql);
                //     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //         echo '<tr>
                //                     <td>
                //                         <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                //                     </td>
                //                     <td>
                //                         <div style="width: 350px">
                //                             <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                //                         </div>
                //                     </td>
                //                     <td>
                //                         <p>NT'. $row['Price'] . '</p>
                //                     </td>
                //                     <td>
                //                         <form action="?cartid=' . $pid . '" method = "post">
                //                             <input type="submit" value="加入購物車" class="btn btn-primary">
                //                         </form>
                //                     </td>
                //                 </tr>';
                //     }
                // }
                ?>
                <?php
                echo '<div align="center" class="border">';
                echo '<h3>大家最愛買</h3>';
                echo '</div>';
                /*用庫存排列*/ 
                $sql = "SELECT * FROM product ORDER BY Reserve DESC";
                $result = mysqli_query($conn, $sql);
                $count = 0;
                while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) && $count++ < 5) {
                    $pid = $row['ID']/1;
                    echo '<tr>
                            <td>
                                <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                            </td>
                            <td>
                                <div style="width: 350px">
                                    <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                </div>
                            </td>
                            <td>
                                <p>NT'. $row['Price'] . '</p>
                            </td>
                            <td>
                                <form action="?cartid=' . $pid . '" method = "post">
                                    <input type="submit" value="加入購物車" class="btn btn-primary">
                                </form>
                            </td>
                        </tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>