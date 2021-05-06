<?php
require('classes.php');
require('function.php');
error_log('complete.php');

//URLの直入力時は、トップページに回避
  if($_SESSION['completeFlg'] == false){
    header('Location:./');
    exit;
  }


if(!empty($_POST['restart'])){
  //さいしょからはじめる
  gameOver();
  $_POST = array();
  header('Location:./');
  exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>エンディングストーリー</title>   
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>  
.intro{
  width:80%;
  text-align:center;
  height: 650px;
  font-size: 20px;
  line-height:30px;
  margin: 50px auto;
}
.intro .window{
  height: 100%;
  background-color:rgba(0,0,0,0.3);
  background-blend-mode:lighten;
}

main a{
  text-align:center;
  text-decoration: none;
}

.window a{
  text-decoration:none;
  color: #fffff4;
}
.window{
  width: 80%;
  margin:20px auto;
  padding: 10px;
  font-size: 20px;
}

</style>
</head>
<body>
  <header class="site-width">
      <h2 class="window"><span class="autoWriteBreak 100">エンディングストーリー Complete!!!</span></h2>
  </header>
  <main class="site-width">
    <div class="intro">
      <div class="window">
      <p><span class="autoWriteBreak 80">
遊んでくれてありがとう！！<br>
<br>
作成者:しん（@shinshin4n4n）<br>
<br>
画像：イラストAC <a href="https://www.ac-illust.com/">https://www.ac-illust.com/</a><br><br>
画像：qut <a href="https://lud.sakura.ne.jp/">https://lud.sakura.ne.jp/</a><br><br>
背景画像：ぴぽや <a href="https://lud.sakura.ne.jp/">https://pipoya.net/</a><br><br>
ＢＧＭ・効果音：魔王魂 <a href="https://maou.audio/">https://maou.audio/</a><br><br>
効果音：無料音楽で遊ぼう！/無料効果音
<br><a href="https://taira-komori.jpn.org/">https://taira-komori.jpn.org/</a><br><br>
<br>
エンディングストーリー<br>
<br>
Fin.<br>
</span></p>
</div>
</div>
    <div class="window">
      <form action="" method="post" style="padding:0;">
        <input style="cursor:pointer;text-align:center;" name="restart" type="submit" value="さいしょからあそぶ">
      </form>
    </div>  
  </main>

  <footer>
  </footer>
  <script src="js/vendor/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <script src="js/autoWrite.min.js"></script>
  <script src="js/main.js"></script>
  <script type="text/javascript" charset="utf-8"></script>
</body>
</html>