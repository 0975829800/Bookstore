<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>書福</title>
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
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE Email = '$email'";

    //送出UTF8編碼的MySQL指令
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $id = $row['ID'];
        $password = $row['Password'];
        $address = $row['Address'];
    }
    echo '
        <form action="index.php?change_information=true" method="post">
            <div align="center" style="padding:10px;margin-bottom:5px;">
                <h1 style=font-weight:bold;> 會員專區 </h1>
                <br>
                <label for="Email">Email:</label>
                <a>' . $email . '</a>
                <br>
                <br>
                <label for="password">新密碼:</label>
                <input type="password" name="password" id="password" value="' . $password . '">
                <br>
                <br>
                <label for="address">地址:</label>
                <input type="text"" name=" address" id="address" value="' . $address . '">
                <br>
                <br>
                <label for="id"">ID :</label>
                <a>' . $id . '</a>
                <br>
                <input type="submit" value="更新會員帳戶">
            </div>
        </form>';
    ?>
</body>

</html>