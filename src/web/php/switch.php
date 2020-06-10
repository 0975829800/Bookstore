<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>以書換書</title>
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
                    <li class="nav-item active">
                        <a class="nav-link" href=".\donation.php"> 捐贈書籍 <span class="sr-only">(current)</span></a>
                    </li>
                    <li>
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
            function logout()
            {
                unset($_SESSION["login_session"]);
                unset($_SESSION["email"]);
            }

            if (isset($_GET['logout'])) {
                logout();
            }
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
        $sql = 'SELECT * FROM users WHERE "'.$_SESSION['email'].'" = Email';
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $mid = $row['ID']/1;
        if($row['Reward_points'] == 0){
            echo '<script language="javascript">';
            echo 'alert("需要有點數才能換書哦!\n快去拿家中不需要的書來捐贈吧!");';
            echo 'location.href = "donation.php";'; 
            echo '</script>';
        }
        else{
            $points = $row['Reward_points'];
            echo '
            <h1 align="center" style=font-weight:bold; >以書換書</h1>
            <br><br>
            <h6 align="center" style=font-weight:bold; >點數共計 : '.$points.'</h6>
            <div align="center" style="padding:10px;margin-bottom:5px;>
                <br>
                <div class="dropdown ">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    選擇想交換的類別
                    </button>
                    <div class="dropdown-menu">
                        ';
                        
                        $sql = "SELECT DISTINCT Category, sum(Amount) as amount FROM used_book GROUP BY Category;";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            if($row['amount'] > 0){
                                echo '<a class="dropdown-item" href="?chose='.$row['Category'].'">'.$row['Category'].'</a>';
                            }
                            else{
                                echo '<a class="dropdown-item disabled" href="?chose='.$row['Category'].'">'.$row['Category'].'(現無庫存)</a>';
                            }
                        }
                        echo'
                    </div>
                </div>
            </div>';
        }
        $chose = "";
        if(isset($_GET['chose'])){
            $chose = $_GET['chose'];
        }
        if($chose != "" && !isset($_GET['confirm'])){
            echo '<script language="javascript">';
            echo 'var check = confirm("確定要換' . $chose . '的書?\n將隨機出書");';
            echo 'if (check){
                    location.href = "switch.php?chose=' . $chose . '&confirm=true";
                }
                else{
                    location.href = "switch.php";
                }
                ';
                
            echo '</script>';
        }
        else if($chose != "" && isset($_GET['confirm'])){   //comfirm for 
            $date = date("Y-m-d");
            $ID = rand(1,9999999999);
            $sql = "SELECT ISBN FROM used_book WHERE Category = '$chose' ORDER BY RAND() LIMIT 1;";//random
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $ISBN = $row['ISBN'];
            
            echo $sql = "INSERT INTO switch VALUES($ID,$mid,'$ISBN',1,'$date');";
            while(!($conn->query($sql) === TRUE)) {
                $ID = rand(1,9999999999);
                $sql = "INSERT INTO switch VALUES($ID,$mid,'$ISBN',1,$date);";
            } 
            echo '<script language="javascript">';
            echo 'alert("交換完成");';
            echo '</script>';

            $sql = "UPDATE used_book SET Amount = Amount - 1 WHERE ISBN = '$ISBN';";
            if($conn->query($sql) === TRUE){
                // echo '<script language="javascript">';
                // echo 'var check = alert("庫存-1");';
                // echo '</script>';
            }

            $sql = "UPDATE users SET Reward_points = Reward_points - 1 WHERE ID = $mid;";
            if($conn->query($sql) === TRUE){
                // echo '<script language="javascript">';
                // echo 'var check = alert("points -1");';
                // echo '</script>';
            }
            echo '<script language="javascript">';
            // echo 'location.href = "index.php";';
            echo '</script>';

        }
        
    ?>

</body>

</html>