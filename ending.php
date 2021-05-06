<?php
/*
  エンディングストーリーページ
*/

  require('classes.php');
  require('function.php');

  //URLの直入力時は、トップページに回避
  if($_SESSION['endingFlg'] == false){
    header('Location:./');
    exit;
  }


if(!empty($_POST)){

  $bonusFlg = !empty($_POST['bonus']);

  if($bonusFlg){

    if($_SESSION['mode'] == GAME_MODE::HERO){

    $_SESSION['enemy'] = new StrongEnemy('ゆうしゃ', 12000,2000,9999,'エンディングストーリーをみるのはこのぼくだ！', 'img/enemy/hero.png',ENEMY_KIND::LASTBOSS, 'sky.jpg');
    $_SESSION['hero'] = new Hero('しんのゆうしゃ', 12000, 800 ,2000,200,'ほんとうのしゅじんこうはこのおれだ！', 'img/enemy/lastboss.png', 'sky.jpg');

    }else{
      $_SESSION['enemy'] = new StrongEnemy('まどうし', 12000,2000,9999,'ちしきならだれにもまけない！オマージュスプレッド！', 'img/enemy/magician.png',ENEMY_KIND::LASTMAGICIAN, 'dark.jpg');
      $_SESSION['hero'] = new Magician('しんのまどうし', 12000, 800 ,2000,200,'…。あなたのエンディングはおあずけね。', 'img/enemy/lastmagician.png', 'dark.jpg');
    }

    $_SESSION['bonus'] = true;
    Message::set('さいごのたたかい！');
    Message::set($_SESSION['enemy']->getName().'があらわれた！');
    //トップ画面に遷移
    header('Location:./');
    exit;

  }

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
  .window{
    color: #fffff4;
    border:solid 4px #fffff4;
  }
  
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
  font-size: 16px;
}

</style>
</head>
<body>
  <header class="site-width">
      <h2 class="window"><span class="autoWriteBreak 100" style="font-size:20px;">エンディングストーリー</span></h2>
  </header>
  <main class="site-width">
    <div class="intro">
      <div class="window">
      <p><span class="autoWriteBreak 80">
      <?php if($_SESSION['mode'] == GAME_MODE::HERO){ ?>
...あれ？はなしがちがうぞ？<br>
ぼくはゆうしゃで、しゅじんこう。<br>
「エンディングストーリーをみるのはこのぼくだ」<br>
そうしんじてうたがわなかった。<br>
だれよりもからだをきたえてきたのに。<br>
だれよりもベンチプレスしてきたのに。<br>
そのさきにあったのは、<br>
ぼくよりもはるかにたくさんの<br>
くなんをのりこえてきたやつだった。<br>
いつから、じぶんならできるとおもっていたのだろう<br>
いつから、じぶん「だけ」が<br>
しゅじんこうだとおもっていたのだろう。<br>
ぼくよりちからのあるやつはたくさんいる。<br>
エンディングストーリーをめざしたことで<br>
じぶんのじつりょくのたりなさとプライドに<br>
あらためてきづけた。<br>
きょうからまた、もっともっとつよくならなくちゃ。<br>
プロテイン、のまなくちゃ。<br>
<?php }else if($_SESSION['mode'] == GAME_MODE::MAGICIAN){ ?>
あれ？まけちゃった…。<br>
わたしはまどうし。しゅじんこう。<br>
だれよりもたくさんちしきをつけてきたのに。<br>
だれよりもじこけいはつしょをたくさんよんできたのに。<br>
わたしはしらなかった。<br>
わたしよりもたくさんべんきょうしてきたひとがいる。<br>
わたしよりもたくさんのけいけんをしてきたひとがいる。<br>
わたしよりもはるかにたくさんの<br>
くなんをのりこえてきたひとがいる。<br>
いつから、じぶんならできるとおもっていたのだろう<br>
いつから、じぶん「だけ」が<br>
しゅじんこうだとおもっていたのだろう。<br>
わたしよりすぐれたひとはたくさんいる。<br>
エンディングストーリーをめざしたことで<br>
じぶんのじつりょくのたりなさとプライドに<br>
あらためてきづけた。<br>
きょうからまた、もっともっとつよくならなくちゃ。<br>
じこけいはつしょ、よまなくちゃ。<br>
<?php } ?>
「<?php echo $_SESSION['hero']->getName(); ?>」のエンディングストーリー<br>
（完）
</span></p>
</div>
</div>
    <div class="window">
      <!-- <p>
        <a href="./">ボーナスバトル</a>
      </p> -->
      <form action="" method="post" class="form-last-battle">
        <input style="cursor:pointer" id="last-battle" name="bonus" type="submit" value="ほんとうのラストバトル">
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