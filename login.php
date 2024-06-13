<?php
session_start(); // セッションを開始

$users = array(
    "user1" => "password1",
    "user2" => "password2",
    // 他のユーザーも同様に追加
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // ユーザー名とパスワードの一致を確認
    if (isset($users[$username]) && $users[$username] === $password) {
        // ログイン成功
        $_SESSION["username"] = $username;
        header("Location: kanri.php"); // ログイン後のページにリダイレクト
        exit();
    } else {
        // ログイン失敗
        echo "ユーザー名またはパスワードが間違っています。";
    }
}
?>
