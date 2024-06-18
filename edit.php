<?php
///////////////////////////////////////////////////////////////////////
//基本処理

//データベースへのログイン情報
$dsn = "mysql:host=localhost;dbname=job;charset=utf8";
$user = "testuser";
$pass = "testpass";

//受け取ったデータを処理する
$origin = []; //ここに処理前のデータが入る
if(isset($_GET)){
    $origin += $_GET; //$originに処理前のGETのデータを入れる
}

//文字コードとHTMLエンティティズの処理を繰り返し行う
foreach($origin as $key => $value){
    //文字コードを処理
    $mb_code = mb_detect_encoding($value); //mb_detect_encodingで()内の現在の文字コードを調べる
    $value = mb_convert_encoding($value, "utf-8", $mb_code); //mb_convert_encodingで文字コードを変更。(文字コード変更する値, 変換する文字コード, 現在の文字コード)

    //HTMLエンティティズ処理
    $value = htmlentities($value, ENT_QUOTES);

    //処理が終わったデータを、$inputに入れなおす
    $input[$key] = $value;
}

//データベースへ接続
try{
    $dbh = new PDO($dsn,$user,$pass);
    if(isset($input["mode"]) && $input["mode"] == "edit"){
        edit();
    }else if(isset($input["mode"]) && $input["mode"] == "update"){
        update();
    }
}catch(PDOException $e){
    echo "接続失敗";
    echo "エラー内容：".$e -> getMessage();
}

function edit(){
    global $dbh, $input,$top;

    $sql=<<<sql
        SELECT * FROM job_table WHERE id = ?;
    sql;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $input["id"]);
    $stmt->execute();

    //テンプレートファイルの読み込み
    $fh = fopen("edit.tmpl", "r+"); //読み込みモードで。insert.tmlを開く
    $fs = filesize("edit.tmpl"); //ファイルサイズを調べる(のちのfread関数で使う)
    $insert_tmpl = fread($fh, $fs); //ファイルの読み込みを行う

    $row = $stmt -> fetch();

    //差し込み用テンプレートを初期化する
    $insert = $insert_tmpl;

    //DBの値を、PHPで使用する値として、変数に入れなおす
    $id = $row["id"];
    $shop_name = $row["shop_name"];
    $slogan = $row["slogan"];
    $job = $row["job"];
    $station = $row["station"];
    $hourly = $row["hourly"];

    //テンプレートファイルの文字を置き換える
    $insert = str_replace("!id!", $id, $insert);
    $insert = str_replace("!shop_name!", $shop_name, $insert);
    $insert = str_replace("!slogan!", $slogan, $insert);
    $insert = str_replace("!job!", $job, $insert);
    $insert = str_replace("!station!", $station, $insert);
    $insert = str_replace("!hourly!", $hourly, $insert);

    $edit = "";
    $edit .= $insert;

    echo $edit;
}

function update(){
    global $dbh, $input;

    $sql=<<<sql
        UPDATE job_table SET shop_name=?, slogan=?, job=?, station=?, hourly=? WHERE id=?;
    sql;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $input["shop_name"]);
    $stmt->bindParam(2, $input["slogan"]);
    $stmt->bindParam(3, $input["job"]);
    $stmt->bindParam(4, $input["station"]);
    $stmt->bindParam(5, $input["hourly"]);
    $stmt->bindParam(6, $input["id"]);

    if($stmt->execute()) {
        echo '<p style="text-align: center;
                        padding-top: 220px;
                        font-size: 1.8rem;">
                        更新されました。</p>';
        echo    '<button style="width: 300px;
                        padding: 8px;
                        display: block;
                        margin: 0 auto;
                        background-color: #585858;
                        color: white;
                        font-size: 1.1rem;
                        border: #585858 3px solid;
                        margin-top: 30px;
                        margin-bottom: 30px;
                        text-align: center;
                    }" onclick="location.href=\'kanri.php\'">管理ページへ</button>';
        } else {
        echo "更新に失敗しました。";
    }
}
