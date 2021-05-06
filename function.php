<?php
//ログ取り
ini_set('log_errors','off');
//出力ファイル指定
//ini_set('error_log','php.log');

//================================
// デバッグ
//================================
//開発時にtrueリリース時はfalse
$debug_flg = true;
//セッションを使う
session_start();

  //標準のゆうしゃステータス
  define('MY_HP', 700);
  define('MY_MP', 60);
  define('MY_ATK', 200);
  define('MY_SPD', 100);
  define('MY_MSG', 'まいにちのきんトレのせいかをみせてやる！');
  define('MY_MG_MSG', 'じこけいはつしょでまなんだちしき、おひろめよ！');
  define('MY_IMG', 'img/hero/hero.png');
  define('MY_MG_IMG', 'img/hero/magician.png');

  //ゆうしゃ編のざこキャラ
  $enemies[] = new Enemy('おじゃまじょババア', 900,150,50,'ふしぎなちからがわいたらどうしようかのう。ヒヒヒ', 'img/enemy/ojamajobabaa.png');
  $enemies[] = new Enemy('せいごぜろかげつ',   300,100,50,'オギャーと泣くなりほうりゅうじ', 'img/enemy/seigozerokagetu.png');
  $enemies[] = new Enemy('カルシウムデッド',   800,120,50,'カルシウムたりてる？イライラしちゃイヤ！', 'img/enemy/karusiumudeddo.png');
  $enemies[] = new Enemy('ぜんちじゅうねん',   600,140,50,'ぬりぐすりのみぐすりサプリメント！！！', 'img/enemy/zentijuunenn.png');
  $enemies[] = new Enemy('もりもりみみりん',   1000,200,50,'ホエイ！カゼイン！ソイ！チャレンジ！', 'img/enemy/morimorimimirin.png');


  //まどうし編のざこキャラ  
  $enemies[] = new Enemy('ヒーハードラゴン', 700,180,50,'スパイシーフレア！ヒーーーハーーー！！', 'img/enemy/hiihaadragon.png');
  $enemies[] = new Enemy('げろげろげろっぴ', 300,100,50,'ゲロゲロゲロゲロげろおんせん！', 'img/enemy/aogaeru.png');
  $enemies[] = new Enemy('ギャルおに', 500,120,50,'ももたろうってさ…ヤバくね？', 'img/enemy/gyaruoni.png');
  $enemies[] = new Enemy('ポリリズムゾンビ', 900,200,50,'いきたりしんだりのくりかえし！', 'img/enemy/poririzumuzonbi.png');
  $enemies[] = new Enemy('おかあちゃんだい３けいたい', 1000,250,50,'ごはんいらないならいいなさいよ！', 'img/enemy/okaachandainikeitai.png');
  
  //ゆうしゃ編のボス
  $sp_enemies[] = new StrongEnemy('リアルザウルス', 2500,500,200,'がおー', 'img/enemy/zaurusu.png', ENEMY_KIND::ZAURUS, 'mukasi.jpg');
  $sp_enemies[] = new StrongEnemy('ニップレスマーメイド', 4000,700,200,'わたしのくびれ、ひきしまってるでしょ！', 'img/enemy/nippuresumaameido.png',ENEMY_KIND::MARMAID, 'dark.jpg');
  $sp_enemies[] = new StrongEnemy('しんのゆうしゃ', 38000,5000,200,'きさまだけがしゅじんこうだとおもうなよ！', 'img/enemy/lastboss.png',ENEMY_KIND::LASTBOSS, 'top.jpg');
  $sp_enemies[] = new StrongEnemy('だいえんじょう', 8000,1000,200,'せっし400ど！インフルエンス！！', 'img/enemy/hinotori.png',ENEMY_KIND::HINOTORI, 'sky.jpg');
  
  //まどうし編のボス
  $sp_enemies[] = new StrongEnemy('しんのまどうし', 38000,5000,2000,'ちしきだけではだめね。けいけんよ！', 'img/enemy/lastmagician.png',ENEMY_KIND::LASTMAGICIAN, 'mecha.png');
  $sp_enemies[] = new StrongEnemy('つばさをください', 8000,1000,2000,'いま、ねがいごとがかなうならば！', 'img/enemy/flydragon.png',ENEMY_KIND::FLYDRAGON, 'sky.jpg');
  $sp_enemies[] = new StrongEnemy('ゴシック・ブラッディ・ロリータ', 4000,700,2000,'ゴシック・ロリータや！フォントちゃうわ！', 'img/enemy/devilgirl.png',ENEMY_KIND::DEVIL, 'dark.jpg');
  $sp_enemies[] = new StrongEnemy('ゼットン120%', 2500,500,2000,'ウルトラ◯ンをこえたちから！るああーー！！', 'img/enemy/zetton.png',ENEMY_KIND::ZETTON, 'dark.jpg');
  
  $titleAnimationFlg= false;

function init($mode){

  error_log('初期化！ゲームスタート');
  createHero($mode);
  createEnemy();
  $_SESSION['knockDownCnt'] = 0;
  $_SESSION['endingFlg'] = false;
  $_SESSION['completeFlg'] = false;

}

function gameOver(){
  $_SESSION = array();
}

function createHero($mode){

  if($mode == GAME_MODE::HERO){
    $hero = new Hero('ゆうしゃ', MY_HP, MY_MP, MY_ATK, MY_SPD, MY_MSG, MY_IMG, 'sougen.jpg');
  }
  if($mode == GAME_MODE::MAGICIAN){
    $hero = new Magician('まどうし', MY_HP*0.8, MY_MP*4, MY_ATK*0.8, MY_SPD*4, MY_MG_MSG, MY_MG_IMG, 'dansion.jpg');
  }
  $_SESSION['hero'] = $hero;
  Message::set($hero->getName().'のたびがはじまった！');

}

function createEnemy(){
  global $enemies;
  global $sp_enemies;
  global $strongFlg; //強敵フラグ

  $enemy = $enemies[mt_rand(0,4)];
  
  if($_SESSION['mode'] == GAME_MODE::MAGICIAN){
    $enemy = $enemies[mt_rand(5,9)];
  }

if($_SESSION['mode'] == GAME_MODE::HERO){
    //4回以上で強敵出現
      if($_SESSION['knockDownCnt'] == 4){  
        $strongFlg = ENEMY_KIND::ZAURUS;
        $_SESSION['strongFlg'] = $strongFlg;
        $enemy = $sp_enemies[ENEMY_KIND::ZAURUS];
      }else if($_SESSION['knockDownCnt'] == 6){
        $strongFlg = ENEMY_KIND::MARMAID;
        $_SESSION['strongFlg'] = $strongFlg;
        $enemy = $sp_enemies[ENEMY_KIND::MARMAID];
      }else if($_SESSION['knockDownCnt'] == 10){
        $strongFlg = ENEMY_KIND::LASTBOSS;
        $_SESSION['strongFlg'] = $strongFlg;
        $enemy = $sp_enemies[ENEMY_KIND::LASTBOSS];
       }else if($_SESSION['knockDownCnt'] == 8){
          $strongFlg = ENEMY_KIND::HINOTORI;
          $_SESSION['strongFlg'] = $strongFlg;
          $enemy = $sp_enemies[ENEMY_KIND::HINOTORI];
      }else{
        $strongFlg = 0;
        $_SESSION['strongFlg'] = $strongFlg;
      } 
  }else{
    //4回以上で強敵出現
    if($_SESSION['knockDownCnt'] == 4){  
      $strongFlg = ENEMY_KIND::ZETTON;
      $_SESSION['strongFlg'] = $strongFlg;
      $enemy = $sp_enemies[ENEMY_KIND::ZETTON];
    }else if($_SESSION['knockDownCnt'] == 6){
      $strongFlg = ENEMY_KIND::DEVIL;
      $_SESSION['strongFlg'] = $strongFlg;
      $enemy = $sp_enemies[ENEMY_KIND::DEVIL];
    }else if($_SESSION['knockDownCnt'] == 10){
      $strongFlg = ENEMY_KIND::LASTMAGICIAN;
      $_SESSION['strongFlg'] = $strongFlg;
      $enemy = $sp_enemies[ENEMY_KIND::LASTMAGICIAN];
     }else if($_SESSION['knockDownCnt'] == 8){
        $strongFlg = ENEMY_KIND::FLYDRAGON;
        $_SESSION['strongFlg'] = $strongFlg;
        $enemy = $sp_enemies[ENEMY_KIND::FLYDRAGON];
    }else{
      $strongFlg = 0;
      $_SESSION['strongFlg'] = $strongFlg;
    } 

  }

  $_SESSION['enemy'] = $enemy;

  Message::set($_SESSION['enemy']->getName().'があらわれた！');
}

function enemyAttack($hero, $enemy){
    global $enemyAttackFlg;
    global $gameOverFlg;
    global $backImg;
    global $kind;
   //敵からの攻撃
   $enemy->attack($hero);
   $enemyAttackFlg = true;
   //HPが0になったらゲームオーバー
   if($hero->getHP() <= 0){
    
    //HPのマイナス表示を回避
    $hero->setHP(0); 
    Message::set($hero->getName().'はしんでしまった！');
    $gameOverFlg = true;

    if($enemy instanceof StrongEnemy){
      if($enemy->getKind() == ENEMY_KIND::LASTBOSS ||
        $enemy->getKind() == ENEMY_KIND::LASTMAGICIAN){
          //エンディングフラグ
         $_SESSION['endingFlg'] = true;
      }  
    }
  }
}