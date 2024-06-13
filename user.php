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
    if(isset($input["mode"]) && $input["mode"] == "search"){
        search();
    }else if(isset($input["mode"]) && $input["mode"] == "narabekae"){
        narabekae();
    }else if(isset($input["mode"]) && $input["mode"] == "fav"){
        fav();
    }else{
        display(); //表示処理
    }
}catch(PDOException $e){
    echo "接続失敗";
    echo "エラー内容：".$e -> getMessage();
}

////////////////////////////////////////////////////
//関数(機能)を別々に作っていきます

function display(){ //display(画面に表示)という関数を作成
    //基本処理で定義した変数を使えるようにする
    global $dbh, $input;

    //SQL文を用意
    $sql=<<<sql
    select * from job_table where flag = 0;
sql;
    $stmt = $dbh -> prepare($sql);
    $stmt -> execute();

    //$blockがテキストかつ中身がないことを定義する
    $block = "";

    //テンプレートファイルの読み込み
    $fh = fopen("user.tmpl", "r+"); //読み込みモードで。insert.tmlを開く
    $fs = filesize("user.tmpl"); //ファイルサイズを調べる(のちのfread関数で使う)
    $insert_tmpl = fread($fh, $fs); //ファイルの読み込みを行う

    while($row = $stmt -> fetch()){ //レコードを1行ずつ繰り返し$blockに詰め込む
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

        //stock.htmlに差し込む変数に格納する
        $block .= $insert; //ループするたびに、insert_tmplの値を追記していく
    }

    //stock.htmlの!block!に$blockを置き換える
    $fh = fopen("user.html", "r+");
    $fs = filesize("user.html");
    $top = fread($fh, $fs); //80~82行目でやったことと同じ
    
    //$top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);

    //全てを差し替えたデータを、ブラウザに表示
    echo $top;
}

function search(){
    //基本処理で定義した変数を使えるようにする
    global $dbh, $input;

    $stmt = null; // スコープの概念上必要（phpだと大丈夫かも?）

    // 文字列が数字になるか(if)
    if(is_string($input)){
    // もし文字列になるなら、3回目のbaindParamのときに文字列を数字にしてsqlを実行する
    //SQL文を用意
    $sql = <<<sql
    SELECT * FROM job_table WHERE slogan LIKE ? OR job LIkE ? OR station LIKE ? OR hourly = ?;
    sql;

    $stmt = $dbh -> prepare($sql);
    $input["search"] = "%".$input["search"]."%";
    $stmt -> bindParam(1,$input["search"]);
    $stmt -> bindParam(2,$input["search"]);
    $stmt -> bindParam(3,$input["search"]);
    $stmt -> bindParam(4,$input["search"]);
    $stmt -> execute();
}
    // end
else{
    // できなかった場合に、hourly抜きのsqlを書いて実行する(else)
    $sql = <<<sql
    SELECT * FROM job_table WHERE slogan LIKE ? OR job LIkE ? OR station LIKE ?;
    sql;

    $stmt = $dbh -> prepare($sql);
    $input["search"] = "%".$input["search"]."%";
    $stmt -> bindParam(1,$input["search"]);
    $stmt -> bindParam(2,$input["search"]);
    $stmt -> bindParam(3,$input["search"]);
    $stmt -> execute();
}

    //$blockがテキストかつ中身がないことを定義する
    $block = "";

    //テンプレートファイルの読み込み
    $fh = fopen("user.tmpl", "r+"); //読み込みモードで。insert.tmlを開く
    $fs = filesize("user.tmpl"); //ファイルサイズを調べる(のちのfread関数で使う)
    $insert_tmpl = fread($fh, $fs); //ファイルの読み込みを行う

    while($row = $stmt -> fetch()){ //レコードを1行ずつ繰り返し$blockに詰め込む
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

        //stock.htmlに差し込む変数に格納する
        $block .= $insert; //ループするたびに、insert_tmplの値を追記していく
    }
    //stock.htmlの!block!に$blockを置き換える
    $fh = fopen("user.html", "r+");
    $fs = filesize("user.html");
    $top = fread($fh, $fs); //80~82行目でやったことと同じ
    
    //$top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);

    //全てを差し替えたデータを、ブラウザに表示
    echo $top;
}

function narabekae(){
    //基本処理で定義した変数を使えるようにする
    global $dbh,$input;

    $stmt = null; // $stmt を初期化する

    if($input["narabekae"] == "desc")
    {
        //SQL文を用意
        $sql=<<<sql
            SELECT * FROM job_table WHERE flag = 0 ORDER BY id DESC;
        sql;
    }else if($input["narabekae"] == "hourly")
    {
        //SQL文を用意
        $sql=<<<sql
            SELECT * FROM job_table WHERE flag = 0 ORDER BY hourly DESC;
        sql;       
        }
        
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

    //$blockがテキストかつ中身がないことを定義する
    $block = "";

    //テンプレートファイルの読み込み
    $fh = fopen("user.tmpl", "r+"); //読み込みモードで。insert.tmlを開く
    $fs = filesize("user.tmpl"); //ファイルサイズを調べる(のちのfread関数で使う)
    $insert_tmpl = fread($fh, $fs); //ファイルの読み込みを行う

    while($row = $stmt -> fetch()){ //レコードを1行ずつ繰り返し$blockに詰め込む
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

        //stock.htmlに差し込む変数に格納する
        $block .= $insert; //ループするたびに、insert_tmplの値を追記していく
    }

    //stock.htmlの!block!に$blockを置き換える
    $fh = fopen("user.html", "r+");
    $fs = filesize("user.html");
    $top = fread($fh, $fs); //80~82行目でやったことと同じ
    
    //$top(stock.htmlのデータ)の!block!に$blockを置き換える
    $top = str_replace("!block!", $block, $top);

    //全てを差し替えたデータを、ブラウザに表示
    echo $top;

}

function fav(){
    // グローバル変数を使用できるようにする
    global $dbh, $input;

    // 入力の中に 'id' が設定されているかどうかを確認する
    if(isset($input['id'])) {
        // flag を更新するための SQL ステートメントを準備し、実行する
        $sql=<<<sql
            UPDATE job_table SET flag = 2 WHERE id = ?;
        sql;
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $input['id']);
        $stmt->execute();
    }

}
    
    function fav_display(){
        global $dbh, $input;

        // flag = 2 のレコード（お気に入り）を取得する
        $sql = "SELECT * FROM job_table WHERE flag = 2";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    
        // ブロックを初期化する
        $block = "";
    
        // テンプレートファイルを読み込む
        $fh = fopen("user_fav.tmpl", "r+");
        $fs = filesize("user_fav.tmpl");
        $top = fread($fh, $fs);
    
        // 取得したレコードをループする
        while($row = $stmt->fetch()){ 
            // テンプレート内のプレースホルダーをデータベースのデータで置き換える
            $insert = str_replace("!id!", $row["id"], $top);
            $insert = str_replace("!shop_name!", $row["shop_name"], $insert);
            $insert = str_replace("!slogan!", $row["slogan"], $insert);
            $insert = str_replace("!job!", $row["job"], $insert);
            $insert = str_replace("!station!", $row["station"], $insert);
            $insert = str_replace("!hourly!", $row["hourly"], $insert);
    
            // ブロックに追加する
            $block .= $insert;
        }
    
        $fh = fopen("user_fav.html", "r+");
        $fs = filesize("user_fav.html");
        $top = fread($fh, $fs); //80~82行目でやったことと同じ
    
        // テンプレート内の !block! を生成されたブロックで置き換える
        $top = str_replace("!block!", $block, $top);
    
        // 変更されたテンプレートを出力する
        echo $top;
        
}