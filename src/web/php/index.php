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
    session_start();  // 啟用交談期
    $kw = "";
    if (isset($_POST['kw'])) {
        $kw =  $_POST['kw'];
        if ($kw != "") {  //Search
            // echo "<a href=""></a>";
            // $search = "search.php?kw".$kw;
            // header("Location: $search");
        } else {   //  useless
            echo '<script language="javascript">';
            echo 'alert("請輸入關鍵字");';
            echo '</script>';
        }
    }

    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="header" class="text-center">
        <a class="col-6" href=".\index.php" style="color: rgb(199, 255, 125); font-size: 1.2cm; font-weight: 500;">書福</a>
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class="nav-link" href=".\index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href=".\cart.php"> 購物車 <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <form class="form-inline" action="search.php" method="POST">
                        <input class="form-control mr-sm-2" type="text" id="kw" name="kw" placeholder="Search" required>
                        <input type="submit" value="搜尋" class="btn btn-outline-success my-2 my-sm-0">
                    </form>
                </li>

            </ul>
            <?php
            function logout()
            {
                unset($_SESSION["login_session"]);
            }

            if (isset($_GET['logout'])) {
                logout();
            }
            if(isset($_SESSION["login_session"])){
                if ($_SESSION["login_session"]) {
                    echo '<p style="color: rgb(255,255,255)">' . $_SESSION["email"] . '</p>';
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
    <br><br>
    <div class="row">
        <div class="col-1" style="margin-left: 80px; background-color: rgb(161, 161, 161); height: 500px;">
            <h3>類別</h3><br>
            <a class="link" href="category.php?type=0">推薦</a><br>
            <a class="link" href="category.php?type=1">輕小說</a><br>
            <a class="link" href="category.php?type=2">歐美文學</a><br>
            <a class="link" class="link" href="category.php?type=3">青春幻想</a><br>
            <a class="link" href="category.php?type=4">歐美科幻</a><br>
            <a class="link" href="category.php?type=5">人文史地</a><br>
            <a class="link" href="category.php?type=5">健康</a><br>
        </div>
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
                $numbers = range(1, 20);
                //shuffle 將陣列順序隨即打亂
                shuffle($numbers);
                //array_slice 取該陣列中的某一段
                $num = 6;
                $arr = array_slice($numbers, 0, $num);
                for ($i = 0; $i < 5; $i++) {
                    $pid = $arr[$i];
                    $sql = "SELECT * FROM product WHERE ID = $pid";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<tr>
                                    <td>
                                        <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                    </td>
                                    <td>
                                        <a class = "link" href=".\product.php?pid=' . $pid . ' style = "color : black>' . $row['Name'] . '</a>
                                    </td>
                                    <td>
                                        <p>' . $row['Price'] . 'NT</p>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary">加入購物車</button>
                                    </td>
                                </tr>';
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>