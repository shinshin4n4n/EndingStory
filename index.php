<?php
  require('classes.php');
  require('function.php');

  // gameOver();
  // exit;

  /*
  ゲームスタート
  ↓
  敵が出現　ランダム雑魚キャラ
  ↓×３
  中ボスが出現
  ↓
  強いキャラが出現×２
  ↓
  ラストボスが出現
  ↓
  エンディングストーリー
  ↓
  ボーナスバトル
  ↓
  敵HP0
  →Complete!!

  */

  /*非同期通信の実装
  攻撃ボタン→メッセージの更新
  */ 

  if(!empty($_POST)){

    error_log('ポスト送信有り');

    $startFlg = !empty($_POST['hero']) || !empty($_POST['magician']);
    $mode = '';
    $magicFlg = !empty($_POST['magic']);
    $restartFlg = !empty($_POST['restart']);
    $audioFlg = $_POST['audio'] == 'ON';
    //exit;

    //ゲームスタート
    if($startFlg && empty($_SESSION)){

        if(!empty($_POST['hero'])){
          $mode = GAME_MODE::HERO;
        }else if(!empty($_POST['magician'])){
          $mode = GAME_MODE::MAGICIAN;
        }
        $_SESSION['mode'] = $mode;
        $_SESSION['soundON'] = $audioFlg;
      init($mode);
    }

    //最初から始める
    if($restartFlg){
      error_log('再スタートフェーズ');
      error_log('さいしょから！');
      gameOver();
    }

    $_POST = array();

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
  .battle-msg-area{
    width: 65%;
    height: 215px;
    float: right;
    background-image: url("<?php if(!empty($_SESSION['hero'])) echo $_SESSION['hero']->getImg(); ?>");
    background-position: right;
    background-size: 25%;
    background-repeat: no-repeat;
}
<?php //ボスによってスタイルの追加
      if(!empty($_SESSION)){ ?>
        body{
          background-image: url("<?php echo $_SESSION['hero']->getBackImg(); ?>");
          }
        <?php if($_SESSION['bonus']){ ?>
          main{
            background-image: url("<?php echo $_SESSION['enemy']->getImg(); ?>"); 
          }    
      <?php }} ?>
  </style>
</head>
<body>
<audio id="push-sound" src="<?php if($_SESSION['soundON']) echo 'audio/push_sound.mp3' ;?>" pause="pause"></audio>
<audio id="escape-sound" src="<?php if($_SESSION['soundON']) echo 'audio/escape.mp3' ;?>" pause="pause"></audio>
<audio src="<?php if($_SESSION['soundON']) echo 'audio/attack.mp3' ;?>" id="attack-audio" pause="pause"></audio>
<audio src="<?php if($_SESSION['soundON']) echo 'audio/heal.mp3' ;?>" id="heal-audio" pause="pause"></audio>
<audio src="<?php if($_SESSION['soundON']) echo 'audio/powerup.mp3' ;?>" id="powerup-audio" pause="pause"></audio>
<audio src="<?php if($_SESSION['soundON']) echo 'audio/magic_attack.mp3' ;?>" id="magic-audio" pause="pause"></audio>
<audio src="<?php if($_SESSION['soundON']) echo 'audio/magic_elevator.mp3' ;?>" id="randam-magic-audio" pause="pause"></audio>
<audio src="<?php if($_SESSION['soundON']) echo 'audio/enemy_attack.mp3' ;?>" id="enemy-attack-audio" pause="pause"></audio>
  <?php if(empty($_SESSION)){
    error_log('トップ画面');?>
  <header class="site-width">
      <p></p>
      <h2 class="window"><span class="autoWriteBreak 100">エンディングストーリー</span></h2>
  </header>
  <main class="site-width">
    <div class="hero-select-area">
      <div class="hero-select">
        <img src="img/hero/hero.png" alt="">
        <p class="hero-name window">ゆうしゃ</p>
      </div>
      <div class="hero-select">
        <img src="img/hero/magician.png" alt="">
        <p class="hero-name window">まどうし</p>
      </div>
    </div>
    <div class="msg-area site-width window">
      <form action="" method="post">
        <select class="window" name="audio">
          <option value="ON" >サウンドON</option>
          <option value="OFF" selected>サウンドOFF</option>
        </select>
        <input id="hero-start" type="submit" name="hero" value="ゆうしゃではじめる">
        <input id="magician-start" type="submit" name="magician" value="まどうしではじめる">
        <a style="text-decoration:none;" href="intro.php">あらすじをみる</a>
      </form>
    </div>
  </div>
  </main>
  <footer>
  </footer>
  <?php }else{
        $gameOverFlg = $_SESSION['hero']->getHP() <= 0;
    ?>
    <?php if($_SESSION['mode'] == GAME_MODE::HERO){ ?> 
      <audio id="hero-bgm" src="<?php if($_SESSION['soundON']) echo 'audio/hero_bgm.mp3';?>" autoplay loop></audio>
      <audio id="hero-boss-bgm" src="<?php if($_SESSION['soundON']) echo 'audio/bossbgm.mp3';?>" pause="pause" loop></audio>
    <?php }else{?>
      <audio id="magician-bgm" src="<?php if($_SESSION['soundON']) echo 'audio/magician_bgm.mp3';?>" autoplay loop></audio>
      <audio id="magician-boss-bgm" src="<?php if($_SESSION['soundON']) echo 'audio/magician_boss_bgm.mp3';?>" pause="pause" loop></audio>

    <?php }?>
    <header class="site-width">
      <p></p>
      <h2 class="window">
      <span class="<?php if($titleAnimationFlg || $gameOverFlg) echo 'autoWriteBreak 30'; ?>">
        <?php if($gameOverFlg){
            echo 'ゲームオーバー';
        }else{
          echo '<span id="enemy-name">'.$_SESSION['enemy']->getName().'</span>があらわれた！';
         } ?>
    </span></h2>
  </header>
  <main class="site-width" style="text-align:center;">
    <div class="enemy-area">
      <img style="<?php if($_SESSION['bonus']){echo 'visibility:hidden;';} ?>" class="enemy-img" src="<?php echo $_SESSION['enemy']->getImg();?>" alt="">
    </div>
    <div class="status-area window">
      <p><?php echo $_SESSION['hero']->getName(); ?></p>
      <p>ＨＰ：<span id="hero-hp"><?php 
        if($_SESSION['hero']->getHP() > 0){
          echo $_SESSION['hero']->getHP(); 
        }else{
          echo '0';
        }
      ?></span></p>
      <p>ＭＰ︰<span id="hero-mp"><?php echo $_SESSION['hero']->getMP(); ?></span></p>
    </div>
    <div class="bottom-windows site-width">
          <p style="margin:0 auto;color:#fffff4;">敵のＨＰ︰<span id="enemy-hp"><?php echo $_SESSION['enemy']->getHP(); ?></span>
          倒した数:<span id="knockDownCnt"><?php echo $_SESSION['knockDownCnt']; ?></span></p>
          <form class="battle-input-area window" action="" method="post">
            <p><span class="menu-selects" id="attack" data-ajaxattack="attack">
            こうげき
          </span>
            <span class="heal-selects" id="powerUp" data-ajaxpowerup="powerup" hidden>テストステロン</span>
            <span class="magic-selects" id="magic-attack" data-ajaxmgc="mgc" hidden>インプレッション</span>
          </p>
            <p><span class="menu-selects" 
            id="<?php if($_SESSION['mode'] == GAME_MODE::HERO){echo 'magic';}else{echo 'mgmagic';} ?>">まほう</span>
            <span class="heal-selects" id="heal" data-ajaxheal="heal" hidden>ベッドイン</span>
            <span class="magic-selects" id="mgheal" hidden>リカバリー</span>
          </p>
            <p><span class="menu-selects" id="escape" data-ajaxescape="escape">にげる</span>
            <span class="magic-selects" id="randam-magic-attack" data-ajaxmgc="randmgc" hidden>スプレッドバズーカ</span>
            <p><span class="heal-selects" id="back" hidden>もどる</span></p>
            </p>
            <span class="" id="ending-story" data-ajaxpowerup="powerup" style="color: #fffff4;cursor:pointer;" hidden><a href="ending.php">エンディング<br>ストーリーへ</a></span>
            <p><span class="magic-selects" id="mgback" hidden>もどる</span></p>
            <input class="menu-selects" type="submit" name="restart" value="さいしょから">
          </form>
        <div class="battle-msg-area window">
            <p class="autoWriteBreak 20"><?php echo Message::getMessage(); ?></p>
        </div>
    </div>
  </div>
  </main>
  <footer>
  </footer>
  <?php } ?>
  <script src="js/vendor/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <script src="js/autoWrite.min.js"></script>
  <script src="js/main.js"></script>
  <script type="text/javascript" charset="utf-8"></script>
</body>
</html>