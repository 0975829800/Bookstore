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
            $sql = "INSERT INTO cart (MID,PID) VALUES ($mid,$cartid)";
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
    <br><br>
    <div class="row">
        <div class="col-1" style="margin-left: 80px; background-color: rgb(161, 161, 161); height: 500px;">
            <h3>類別</h3><br>
            <a class="link" href="category.php?type=0">推薦</a><br>
            <a class="link" href="category.php?type=1">輕小說</a><br>
            <a class="link" href="category.php?type=2">歐美文學</a><br>
            <a class="link" href="category.php?type=3">青春幻想</a><br>
            <a class="link" href="category.php?type=4">歐美科幻</a><br>
            <a class="link" href="category.php?type=5">人文史地</a><br>
            <a class="link" href="category.php?type=6">健康</a><br>
        </div>
        <div class="col-8">
            <table class="table" style="text-align:center;">
                <?php
                $type = $_GET['type'];
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
                switch ($type) {
                    case 0:
                        $numbers = range(1, 20);
                        //shuffle 將陣列順序隨即打亂
                        shuffle($numbers);
                        //array_slice 取該陣列中的某一段
                        $num = 6;
                        $arr = array_slice($numbers, 0, $num);
                        for ($i = 0; $i < 5; $i++) {
                            $pid = $arr[$i];
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            $sql = "SELECT * FROM product WHERE ID = $pid";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                            }
                        }
                        mysqli_free_result($result);
                        break;
                    case 1:
                        $sql = "SELECT Name, PID, Price FROM book, product WHERE Category = '輕小說' AND PID = ID";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = intval($row['PID']);
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                        }
                        break;
                    case 2:
                        $sql = "SELECT Name, PID, Price FROM book, product WHERE Category = '歐美經典文學' AND PID = ID";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = intval($row['PID']);
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                        }
                        break;
                    case 3:
                        $sql = "SELECT Name, PID, Price FROM book, product WHERE Category = '青春幻想' AND PID = ID";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = intval($row['PID']);
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                        }
                        break;
                    case 4:
                        $sql = "SELECT Name, PID, Price FROM book, product WHERE Category = '歐美科幻/奇幻小說' AND PID = ID";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = intval($row['PID']);
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                        }
                        break;
                    case 5:
                        $sql = "SELECT Name, PID, Price FROM book, product WHERE Category = '人文史地' AND PID = ID";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = intval($row['PID']);
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                        }
                        break;
                    case 6:
                        $sql = "SELECT Name, PID, Price FROM book, product WHERE Category = '健康' AND PID = ID";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $pid = intval($row['PID']);
                            $destination = '?type=' . $type . '&cartid=' . $pid;
                            echo '<tr>
                                        <td>
                                            <a href=".\product.php?pid=' . $pid . '"><img align="center" src="../product_img/' . $pid . '.jpg" height = "100px"></a>
                                        </td>
                                        <td>
                                            <div style="width: 400px">
                                                <a class = "link" href=".\product.php?pid=' . $pid . ' ">' . $row['Name'] . '</a>
                                            </div>
                                        </td>
                                        <td>
                                            <p>' . $row['Price'] . '</p>
                                        </td>
                                        <td>
                                            <form action="' . $destination . '" method = "post">
                                                <input type="submit" value="加入購物車" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>';
                        }
                        break;
                }

                ?>
            </table>
        </div>
    </div>
</body>

</html>