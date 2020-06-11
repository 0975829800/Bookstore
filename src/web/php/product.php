<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>
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
    $sql = "SELECT * FROM product WHERE ID = $PID";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $bookname = $row['Name'];
        $bookprice = $row['Price'];
        $introduction = $row['Introduction'];
        $reserve = $row['Reserve'];
    }
    $ISBN = NULL;
    $P_house = NULL;
    $P_date = NULL;
    $Category = NULL;
    $author = NULL;
    $sql = "SELECT * FROM book WHERE PID = $PID";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo ("Error: " . mysqli_error($connect));
        exit();
    }
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $ISBN = $row['ISBN'];
        $P_house = $row['P_house'];
        $P_date = $row['P_date'];
        $Category = $row['Category'];

    }
    if ($ISBN) {
        $sql = "SELECT * FROM author WHERE ISBN = $ISBN";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $author = $row['Author'];
        }
    }
    // echo "bookname";
    if($bookname!= ""){
        echo $bookname;
    }
    ?>
    </title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
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
            $destination = '?pid='.$PID.'&cartid=' . $PID;
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
    <br><br>
    <div class="container pt-4">
        <div id="sitebody">
            <?php
            function addcart()
            {
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
                if (isset($_SESSION["login_session"])) {
                    $cartid = $_GET['cartid'];
                    $email = $_SESSION['email'];
                    $mid = 0;
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
            if (isset($_GET['cartid'])) {
                addcart();
            }
            $comment = "";
            $score="";
            if(isset($_POST['comment'])){
                $comment = $_POST['comment'];
            }
            if(isset($_POST['score'])){
                $score = $_POST['score'];
            }
            if($score != ""&& $comment != ""){
                $mid = $_SESSION['ID'];
                $sql = "INSERT INTO review VALUES ($PID,$mid,$score,'$comment')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo '<script language="javascript">';
                    echo 'alert("已新增評論");';
                    // echo 'location.href=".\product.php?pid='.$pid .'"';
                    echo '</script>';
                }
            }
            echo $PID.'.jpg';
            echo '<div id="sidebar_left" class="col-2">
                    <img align="center" src="../product_img/'.$PID.'.jpg" height = "400"></a>
                </div>';
            echo '<div style="width: 500px; margin-left: 400px;" id="content" class="col-7">
                    名稱 :  ' . $bookname . '
                    <br>價格 :  ' . $bookprice . '';
            if ($author != NULL) {
                echo '<p>作者:  ' . $author . '';
            }
            if ($ISBN != NULL) {
                echo '<br>類別:  ' . $Category . '';
                echo "<br>出版社: " . $P_house . "";
                echo "<br>出版日期: " . $P_date . "";
                echo "<br>ISBN: " . $ISBN . "";
            }
            echo "<br>庫存數量: " . $reserve . "";
            echo '<form action="' . $destination . '" method = "post">
                    <input type="submit" value="加入購物車" class="btn btn-primary">
            </form>';
            echo '</div>';
            echo '<br><br><br><br><b><font size="5">產品介紹 : </font></b><br>';  // 顯示查詢結果
            echo $introduction;
            ?>
            <br><br>
            <b><font size="5">評論 :</font></b>
        </div>
    </div>
    <div class="mx-auto" style="width: 900px;">
        <?php
            echo '<div align="center">';
            echo '<table class="table" style="text-align:center;">';
            echo '<tr>
                <td width="200px">評分</td>
                <td>評論</td>
                <td>用戶</td>
            </tr>';
            $flag = 1;//if he can add review
            $sql = "SELECT * FROM review WHERE PID = $PID";
            $result = mysqli_query($conn, $sql);
            if($result){
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $Score = $row['Score'];
                    $Comment = $row['Comment'];
                    $mid = $row['MID']/1;
                    $sql = "SELECT * FROM users WHERE ID = $mid";
                    $r = mysqli_query($conn, $sql);
                    $tuple = mysqli_fetch_array($r, MYSQLI_ASSOC);
                    $Email = $tuple['Email'];
                    echo '<tr>
                        <td>' . $Score . '</td>
                        <td style="font-size:24px">' . $Comment . '</td>
                        <td>' . $Email . '</td>';
                    if($mid == $_SESSION['ID']){
                        $flag = 0;
                        echo '<td>
                        <form action="product.php?pid='.$PID.'&del=true" method="post">
                            <button type="submit" class="btn btn-info">刪除評論</button>
                        </form>
                        </td>';
                    }
                    echo'</tr>';
                }
                echo '</table>';
                echo '</div>';
            }
            else{
                echo '還沒有人評論<br>';    //無用
            }
            if($flag){
                echo'<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">我要寫評論<i class="fas fa-edit"></i></button>
                <div id="demo" class="collapse form-group">
                    <label for="score">評分 1(差) ~ 5(好): </label>
                    <div>
                        <select class="form-control" form="review" id="score" name="score">
                            <option>1</option>   
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <textarea form="review" required placeholder="對此商品的評論" class="form-control text" rows="5" name="comment" id="comment"></textarea>
                    <form name="review" id="review" method="post">
                        <button type="submit" class="btn btn-info">提交評論</button>
                    </form>
                </div>';
                
            }
            else{
                echo'<button disabled type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">我要寫評論<i class="fas fa-edit"></i></button>';
            }

            if(isset($_GET['del'])){
                echo '<script language="javascript">';
                echo 'var check = confirm("確定要刪除評論嗎?");';
                echo 'if (check){
                        location.href = "product.php?pid='.$PID.'&confirm=true";
                    }
                    ';
                    
                echo '</script>';
            }
            if(isset($_GET['confirm'])){
                $MID = $_SESSION['ID'];
                $sql = "DELETE FROM review WHERE PID = $PID AND MID = $MID";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo '<script language="javascript">';
                    echo 'alert("刪除成功");';
                    echo 'location.href = "product.php?pid='.$PID.'"';
                    echo '</script>';
                }
            }

        ?>
        
    </div>
    <br>
</body>

</html>