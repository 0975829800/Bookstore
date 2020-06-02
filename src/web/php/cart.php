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
    // session_start();  // 啟用交談期
    // // 檢查Session變數是否存在, 表示是否已成功登入
    // if ( $_SESSION["login_session"] != true ) 
    //    header("Location: login.php");
    // echo "歡迎使用者進入網站!<br/>";
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
                <li class="nav-item active">
                    <a class="nav-link" href=".\index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <a class="nav-link" href=".\cart.php"> 購物車 <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <form class="form-inline" action="search.php" method="POST">
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

    <div class="row">
        <div class="col-1" style="margin-left: 80px; height: 500px;">

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
                                        <div style="width: 350px">
                                            <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                        </div>
                                    </td>
                                    <td>
                                        <p>' . $row['Price'] . 'NT</p>
                                    </td>
                                    <td>
                                        <input type="text" value="1" maxlength="3" style="width:27px;"></p>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary">我沒錢</button>
                                    </td>
                                </tr>';
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div style="width:200px; 
　　　　　　　　　　　　　white-space:nowrap;
            　　　　　　overflow:hidden;
            　　　　　　text-overflow:ellipsis;
            　　　　　　border:1px solid red">
　　　　 　　　　　　試試看試試看試試看試試看試試看試試看試試看試試看試試看試試看試試看
　　　　</div>
</body>

</html>