<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>signup</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<?php
    $Email = "";
    $password = "";
    $address = "";
    $ID = -1;
    if ( isset($_POST["Email"]) )
        $Email = $_POST["Email"];
    if ( isset($_POST["password"]) )
        $password = $_POST["password"];
    if ( isset($_POST["address"]) )
        $address = $_POST["address"];
    if ( isset($_POST["ID"]) )
        $ID = $_POST["ID"];

    if ($Email != "" && $password != "" && $address != ""&& $ID != -1) {
        $link = mysqli_connect("220.132.211.121","ZYS",
                       "qwe12345","bookstore")
        or die("無法開啟MySQL資料庫連接!<br/>");
        // echo "資料庫bookstore開啟成功!<br/>";
        mysqli_query($link, 'SET NAMES utf8'); 
        $sql = "INSERT INTO users(ID,Flag,Email,Password,Address) VALUES ($ID,1,\"$Email\",\"$password\",\"$address\")"; // 指定SQL字串        echo "SQL字串: $sql <br/>";
        
        //送出UTF8編碼的MySQL指令
        if(mysqli_query($link, $sql)){
            echo '<script language="javascript">';
            echo 'alert("註冊成功，請再次登入");';
            echo '</script>';
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("註冊失敗，請檢查輸入有無錯誤\n或帳號、ID已被註冊");';
            echo '</script>';
        }
    }

   // 建立MySQL的資料庫連接 

?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="header" class="text-center">
        <a class="col-6" href=".\index.php" style="color: rgb(199, 255, 125); font-size: 1.2cm; font-weight: 500;">書福</a>
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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
                    <form class="form-inline" action="/search.php">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search">
                        <a class="btn btn-outline-success my-2 my-sm-0" href=".\search.php" role="button">
                            搜尋</a>
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
<form action="signup.php" method="post" >
  <div align="center" style="padding:10px;margin-bottom:5px;">
    <h1 style=font-weight:bold;> 註冊會員 </h1>
    <br>
    <label for="Email">Email:</label>
    <input type="email" name="Email" id="Email" required autofocus/>
    <br>  
    <br> 
    <label for="password">密碼:</label>
    <input type="password" name="password" id="password" required/>
    <br>
    <br>
    <label for="address">地址:</label>
    <input type="text"" name="address" id="address" required/>
    <br>
    <br>
    <label for="id"">輸入ID(數字0~9999999999) :</label>
    <input type="value" name="ID"  id="ID">
    <br>
    <input type="submit" value="註冊"/>
  </div>
</form>
</body>
</html>