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
                    <li>
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
    <?php
        $title = "";
        $category = "";
        $ISBN = "";
        $amount = 0;
        if(isset($_POST['Title']))
            $title = $_POST['Title'];
        if(isset($_POST['Category']))
            $category = $_POST['Category'];
        if(isset($_POST['ISBN']))
            $ISBN = $_POST['ISBN'];
        if(isset($_POST['Amount']))
            $amount = $_POST['Amount'];
        if($ISBN != ""&&$category != ""&&$title != ""&&$amount != 0){
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
            $sql = 'SELECT * FROM users WHERE Email = "'.$_SESSION['email'].'";';
            //送出UTF8編碼的MySQL指令
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $mid = $row['ID']/1;


            /*insert used_book*/
            $sql = "INSERT INTO used_book VALUES ('$title','$ISBN','$category',$amount);";
            $result = mysqli_query($conn, $sql);
            if(!$result){   //already have same book
                /*get used_book*/ 
                $sql = "SELECT * FROM used_book WHERE ISBN = '$ISBN';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $amount += $row['Amount'];
                $sql = "UPDATE used_book SET used_book.Amount = $amount WHERE ISBN = '$ISBN';";
                $result = mysqli_query($conn, $sql);
                $amount -= $row['Amount'];
                echo '<script>
                var r = alert("非常感謝您的捐贈"); 
                </script>';
            }
            else{
                echo '<script>
                var r = alert("非常感謝您的捐贈"); 
                </script>'; 
            }

            /*insert donor*/
            $sql = "INSERT INTO donor VALUES ($mid,'$ISBN',$amount);";
            $result = mysqli_query($conn, $sql);
            if(!$result){
                /*get used_book*/ 
                $sql = "SELECT * FROM donor WHERE MID = $mid;";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $amount += $row['Amount'];
                $sql = "UPDATE donor SET donor.Amount = $amount WHERE MID = $mid AND ISBN = '$ISBN';";
                $result = mysqli_query($conn, $sql);
                // echo '<script>
                // var r = alert("再加入donor"); 
                // </script>';
            }
            else{
                // echo '<script>
                // var r = alert("加入donor"); 
                // </script>'; 
            }
        }
    ?>
    <form action="donation.php" method="post">
        <div align="center" style="padding:10px;margin-bottom:5px;">
            <h1 style=font-weight:bold;> 書籍捐贈 </h1>
            <br>
            <h6> 請輸入書的各項資料 </h6>
            <label for="Title">標題:</label>
            <input type="text" name="Title" id="Title" required autofocus />
            <br>
            <label for="ISBN">ISBN:</label>
            <input type="text" name="ISBN" id="ISBN" required />
            <br>
            <label for="Category">類別:</label>
            <input type="text" name="Category" id="Category" required />
            <br>
            <label for="Amount">數量:</label>
            <input type="text" value="1" name="Amount" maxlength="3">
            <br>
            <input type="submit" value="捐贈" />
        </div>
    </form>
</body>

</html>