<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>購物車</title>
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
    mysqli_query($conn, "SET NAMES 'utf8'");
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }
    $MID = $_SESSION['ID'];
    $sql = "SELECT * FROM cart WHERE MID=$MID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if(!$row){
        echo '<script language="javascript">';
        echo 'var check = alert("購物車內無商品，快去血拼吧!");';
        echo 'location.href = "index.php";';    
        echo '</script>';
    }

    function delcart()
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
            if ($conn->connect_error) {
                die("連接失敗: " . $conn->connect_error);
            }
            $delid = $_GET['delid'];
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM users WHERE Email='$email'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $mid = $row['ID'];
            }
            $sql = "DELETE FROM cart WHERE PID=$delid AND MID=$mid";
            if ($conn->query($sql) === TRUE) {
            } else {
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("請登入後再點擊");';
            echo '</script>';
        }
    }
    function buy()
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
            if ($conn->connect_error) {
                die("連接失敗: " . $conn->connect_error);
            }
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM users WHERE Email='$email'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $mid = $row['ID'];
            }
            $sum = 0;
            $amount = 0;
            $comfirm_page = "cart.php?confirm=true";
            for ($i = 1; $i <= 20; $i++) {
                if (isset($_POST[$i . '_amount'])) {
                    $amount = $_POST[$i . '_amount'];
                    $comfirm_page .= '&'.$i.'_amount='.$amount.'';
                } else {
                    $amount = 0;
                }
                if($amount > 0){
                    $sql = "SELECT * FROM product WHERE ID=$i";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $reserve = $row['Reserve'];
                        if($amount != 0&&$reserve < $amount){
                            echo '<script language="javascript">';
                            echo 'alert("很抱歉 '.$row['Name'].'的庫存量只剩'.$reserve.'件\n請重新選擇");';
                            echo 'location.href = "cart.php";';
                            echo '</script>';
                        }
                        $sum += $amount * $row['Price'];
                    }
                }
            }
            // echo $comfirm_page;
            if($sum != 0){
                echo '<script language="javascript">';
                echo 'var check = confirm("總共為' . $sum . '元\n是否確認購買?");';
                echo 'if (check){
                        location.href = "'.$comfirm_page.'";
                    }';
                echo '</script>';
            }
            else{
                echo '<script language="javascript">';
                echo 'var check = alert("購物車內無商品，快去血拼吧!");';
                echo 'location.href = "index.php";';    
                echo '</script>';
            }
            
        } else {
            echo '<script language="javascript">';
            echo 'alert("請登入後再點擊");';
            echo '</script>';
        }
    }
    function confirm()
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
            if ($conn->connect_error) {
                die("連接失敗: " . $conn->connect_error);
            }
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM users WHERE Email='$email'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $mid = $row['ID'];
            }
            date_default_timezone_set ("ASIA/Taipei");
            $date = date("Y-m-d");
            for ($i = 1; $i <= 20; $i++) {
                if (isset($_GET[$i . '_amount'])) {
                    $amount = $_GET[$i . '_amount'];
                    $rand = rand(1,9999999999);
                    $sql = "INSERT INTO purchase VALUES($rand,$amount,'$date',$mid,$i);";
                    while(!($conn->query($sql) === TRUE)) {
                        $rand = rand(1,9999999999);
                        $sql = "INSERT INTO purchase VALUES($rand,$amount,'$date',$mid,$i);";
                    } 
                }
            }            
               
            $sql = "DELETE FROM cart WHERE MID=$mid";
            if ($conn->query($sql) === TRUE) {
                echo '<script language="javascript">';
                echo 'alert("購買成功");';
                echo 'location . href = "index.php";';
                echo '</script>';
            } 
            else {
            }
        } 
        else {
            echo '<script language="javascript">';
            echo 'alert("請登入後再點擊");';
            echo '</script>';
        }
    }
    if (isset($_GET['delid'])) {
        delcart();
    }
    if (isset($_GET['buy'])) {
        buy();
    }
    if (isset($_GET['confirm'])) {
        confirm();
    }
    ?>
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
                if (isset($_SESSION['login_session'])) {
                    echo
                    '<li>
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

    <div class="row">
        <div class="col-1" style="margin-left: 80px; height: 500px;">

        </div>
        <div class="col-8">
            <form action="?buy=true" method="post">
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
                    if (isset($_SESSION["login_session"])) {
                        echo '<tr>
                            <td>
                                <p>商品圖</p>
                            </td>
                            <td>
                                <p>商品名稱</p>                        
                            </td>
                            <td>
                                <p>售價</p>
                            </td>
                            <td>
                                <p>購買數量</p>
                            </td>
                            <td>
                                <p>變更</p>
                            </td>
                        </tr>';
                        echo '<br><p style="color: rgb(0,0,0)">你的購物車</p>';
                        $sql = 'SELECT PID, Name,Price FROM cart,users u,product p WHERE MID = u.ID AND p.ID = PID  AND Email = "' . $_SESSION['email'] . '" ';
                        // echo $sql;
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = 1;
                            $pid = $row['PID'] / 1; //被0補滿會找不到圖片
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
                                            <p>' . $row['Price'] . 'NT</p>
                                        </td>
                                        <td>
                                            <input type="text" value="1" name="' . $pid . '_amount" maxlength="3" style="width:50px;"></p>
                                        </td>
                                        <td>
                                            <a href="?delid=' . $pid . '" class="btn btn-primary" role="button">清除商品</a>
                                        </td>
                                    </tr>';
                        }
                    } else {
                        echo '<script language="javascript">';
                        echo 'alert("請先登入");';
                        echo 'location.href="login.php"; ';
                        echo '</script>';
                    }
                    ?>
                </table>
                <div style="margin-top: 30px; text-align: right;">
                    <input type="submit" value="確認購買" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</body>

</html>