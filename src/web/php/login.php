<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php
    session_start();  // 啟用交談期
    $Email = "";
    $password = "";
    // 取得表單欄位值
    if (isset($_POST["Email"]))
        $Email = $_POST["Email"];
    if (isset($_POST["password"]))
        $password = $_POST["password"];
    // 檢查是否輸入使用者名稱和密碼
    if ($Email != "" && $password != "") {
        // 建立MySQL的資料庫連接 
        $dsn = "mysql:dbname=bookstore;host=220.132.211.121;port=3306";
        $username = "ZYS";
        $pass = "qwe12345";
        try {
            // 建立MySQL伺服器連接和開啟資料庫 
            $link = new PDO($dsn, $username, $pass);
            // 指定PDO錯誤模式和錯誤處理
            $link->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            $sql = "SELECT * FROM users WHERE Password = '$password' AND Email='$Email'";
            // echo "SQL查詢字串: $sql <br/>";
            // 送出UTF8編碼的MySQL指令
            $link->query('SET NAMES utf8');
            // 送出查詢的SQL指令
            if ($result = $link->query($sql)) {
                // echo "<br/><b>帳戶資料:</b><hr/>";  // 顯示查詢結果
                // // 取得記錄數
                $total_records = $result->rowCount();
                // echo "資料筆數: $total_records 筆<br/>";
                if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    if($row['Flag'] == 1){  //成功登入, 指定Session變數
                        echo '<script language="javascript">';
                        echo 'alert("登入成功");';
                        echo '</script>';
                        $_SESSION["login_session"] = true;
                        $_SESSION["email"] = $Email;
                        header("Location: index.php");
                    }
                    else {
                        echo '<script language="javascript">';
                        echo 'alert("使用者帳號或密碼錯誤哦~~~");';
                        echo '</script>';
                        $_SESSION["login_session"] = false;
                    }
                    
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("使用者帳號或密碼錯誤哦~~~");';
                    echo '</script>';
                    $_SESSION["login_session"] = false;
                }
            }
        } catch (PDOException $e) {
            echo "連接失敗: " . $e->getMessage();
        }
        $link = null;
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
                    <a class="nav-link" href=".\cart.php"> 購物車 <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <form class="form-inline" action="search.php" method="GET">
                        <input class="form-control mr-sm-2" type="text" id="kw" name="kw" placeholder="Search" required>
                        <input type="submit" value="搜尋" class="btn btn-outline-success my-2 my-sm-0">
                    </form>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <a class="btn btn-outline-success my-2 my-sm-0" href=".\signup.php" role="button">
                    註冊</a>
            </form>
            <form class="form-inline mt-2 mt-md-0">
                <a class="btn btn-outline-success my-2 my-sm-0" href=".\login.php" role="button">
                    登入</a>
            </form>
        </div>
    </nav>
    <form action="login.php" method="post">
        <div align="center" style="padding:10px;margin-bottom:5px;">
            <h1 style=font-weight:bold;> 會員登入 </h1>
            <br>
            <label for="Email">Email:</label>
            <input type="email" name="Email" id="Email" required autofocus />
            <br>
            <br>
            <label for="password">密碼:</label>
            <input type="password" name="password" id="password" required />
            <br>
            <br>
            <input type="submit" value="登入" />
        </div>
    </form>
</body>

</html>