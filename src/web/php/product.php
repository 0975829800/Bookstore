<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>書福</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="header" class="text-center">
        <a class="col-6" href=".\index.php" style="color: rgb(203, 212, 209); font-size: 1.2cm; font-weight: 500;">書福</a>
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
                    <form class="form-inline" action="search.php" method="POST">
                        <input class="form-control mr-sm-2" type="text" id="kw" name="kw" placeholder="Search" required>
                        <input type="submit" value="搜尋" class="btn btn-outline-success my-2 my-sm-0">
                    </form>
                </li>
            </ul>
            <?php
            session_start();
            if (isset($_SESSION["login_session"])) {
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
    <div class="container pt-4">
        <div id="sitebody">
            <?php
            // 建立MySQL的資料庫連接 
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
            $PID = $_GET['pid'];
            $sql = "SELECT * FROM pruduct WHERE ID = $PID";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo ("Error: " . mysqli_error($connect));
                exit();
            }
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $bookname = $row['Name'];
                $bookprice = $row['Price'];
                $introduction = $row['Introduction'];
            }
            $sql = "SELECT * FROM book WHERE PID = $PID";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $ISBN = $row['ISBN'];
                $P_house = $row['P_house'];
                $P_date = $row['P_date'];
                $Category = $row['Category'];
            }
            $sql = "SELECT * FROM author WHERE ISBN = $ISBN";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $auther = $row['Author'];
            }
            
            ?>
        </div>
    </div>

</body>

</html>