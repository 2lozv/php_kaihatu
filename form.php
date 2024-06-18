<?php
 
# 送信先アドレス
$mailto = "xxx@internetacademy.co.jp";
# 送信後画面からの戻り先
$toppage = "./user.php";
 
#===========================================================
# 入力情報の受け取りと加工
#===========================================================
$name = $_POST["name"];
$birthday = $_POST["birthday"];
$gender = $_POST["gender"];
$tel = $_POST["tel"];
$mail = $_POST["mail"];
$work = $_POST["work"];
 
# 無効化
$name = htmlentities($name,ENT_QUOTES, "UTF-8");
$birthday = htmlentities($birthday,ENT_QUOTES, "UTF-8");
$gender = htmlentities($gender,ENT_QUOTES, "UTF-8");
$tel = htmlentities($tel,ENT_QUOTES, "UTF-8");
$mail = htmlentities($mail,ENT_QUOTES, "UTF-8");
$work = htmlentities($work,ENT_QUOTES, "UTF-8");
 
# 改行処理
// $name = str_replace("¥r¥n", "", $name);
// $email = str_replace("¥r¥n", "", $email);
// $comment = str_replace("\r\n", "\t", $comment);
// $comment = str_replace("\r", "\t", $comment);
// $comment = str_replace("\n", "\t", $comment);
 
# 入力チェック
// if ($name == "") { error(" 名前が未入力です"); }
// if (!preg_match("/\w+@\w+/",$email)){ error(" メールアドレスが不正です");}
// if ($comment == "") { error(" コメントが未入力です"); }
 
// # 分岐チェック
if ($_POST["mode"] == "post") { conf_form(); }
else if($_POST["mode"] == "send") { send_form(); }
 
#-----------------------------------------------------------
# 確認画面
#-----------------------------------------------------------
function conf_form(){
  global $name,$birthday,$gender,$tel,$mail,$work;
 
  # テンプレート読み込み
  $conf = fopen("conf.tmpl","r") or die;
  $size = filesize("conf.tmpl");
  $data = fread($conf , $size);
  fclose($conf);
 
  # 文字置き換え
  $data = str_replace("!name!", $name, $data);
  $data = str_replace("!birthday!", $birthday, $data);
  $data = str_replace("!gender!", $gender, $data);
  $data = str_replace("!tel!", $tel, $data);
  $data = str_replace("!mail!", $mail, $data);
  $data = str_replace("!work!", $work, $data);
 
  # 表示
  echo $data;
  exit;
}
 
#-----------------------------------------------------------
# エラー画面
#-----------------------------------------------------------
// function error($msg){
//   $error = fopen("tmpl/error.tmpl","r");
//   $size = filesize("tmpl/error.tmpl");
//   $data = fread($error , $size);
//   fclose($error);
 
//   # 文字置き換え
//   $data = str_replace("!message!", $msg, $data);
 
//   # 表示
//   echo $data;
//   exit;
// }
 
#-----------------------------------------------------------
# CSV 書込
#-----------------------------------------------------------
function send_form(){
  global $name;
  global $email;
  global $comment;
 
  $user_input = array($name,$email,$comment);
  mb_convert_variables("SJIS","UTF-8",$user_input);
  $fh = fopen("user.csv","a");
  flock($fh,LOCK_EX);
  fputcsv($fh, $user_input);
  flock($fh,LOCK_UN);
  fclose($fh);
 
  # テンプレート読み込み
  $conf = fopen("send.tmpl","r") or die;
  $size = filesize("send.tmpl");
  $data = fread($conf , $size);
  fclose($conf);
 
  # 文字置き換え
  global $toppage;
  $data = str_replace("!top!", $toppage, $data);
  # 表示
  echo $data;
  exit;
}
