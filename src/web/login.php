<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>login.php</title>
</head>
<body>
<?php
session_start();  // 啟用交談期
$Email = "";  $password = "";
// 取得表單欄位值
if ( isset($_POST["Email"]))
   $Email = $_POST["Email"];
if ( isset($_POST["password"]) )
   $password = $_POST["password"];
// 檢查是否輸入使用者名稱和密碼
if ($Email != "" && $password != "") {
   // 建立MySQL的資料庫連接 
   $link = mysqli_connect("220.132.211.121","ZYS",
                          "qwe12345","bookmarket")
        or die("無法開啟MySQL資料庫連接!<br/>");
   //送出UTF8編碼的MySQL指令
   mysqli_query($link, 'SET NAMES utf8'); 
   // 建立SQL指令字串
   $sql = "SELECT * FROM users WHERE password='";
   $sql.= $password."' AND Email='".$Email."'";
   echo $Email;
   echo $password;
   // 執行SQL查詢
   $result = mysqli_query($link, $sql);
   $total_records = mysqli_num_rows($result);
   // 是否有查詢到使用者記錄
   if ( $total_records > 0 ) {
      // 成功登入, 指定Session變數
      $_SESSION["login_session"] = true;
      header("Location: index.php");
   } else {  // 登入失敗
      echo "<center><font color='red'>";
      echo "使用者名稱或密碼錯誤!<br/>";
      echo "</font>";
      $_SESSION["login_session"] = false;
   }
   mysqli_close($link);  // 關閉資料庫連接  
}
?>
<form action="login.php" method="post" >
  <div align="center" style="background-color:#82FF82;padding:10px;margin-bottom:5px;">
    <br>
    <label for="Email">Email:</label>
    <input type="text" name="Email" id="Email" required autofocus/>
    <br>  
    <br> 
    <label for="password">密碼:</label>
    <input type="password" name="password" id="password" required/>
    <br>
    <br>
    <input type="submit" value="登入"/>
  </div>
</form>
</body>
</html>