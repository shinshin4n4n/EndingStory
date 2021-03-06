<?php
require('classes.php');
require('function.php');


error_log('ajaxHeal');

//json形式で値を返す
header("Content-type: application/json; charset=UTF-8");

$enemyAttackFlg = false;

//攻撃する
if(!empty($_POST['ajaxheal'])){
      error_log('かいふくフェーズ非同期');

      $_SESSION['hero']->heal();

      enemyAttack($_SESSION['hero'], $_SESSION['enemy']);

      if($_SESSION['enemy'] instanceof StrongEnemy){
        error_log('強キャラ出現で画像切替');
        $backImg = $_SESSION['enemy']->getBackImg();
        $kind = $_SESSION['enemy']->getKind();
      }else{
        error_log('弱キャラなので草原に！');
        $backImg = $_SESSION['hero']->getBackImg();
        $kind = 0;
      }

      $res = ['message' => Message::getMessage()
            , 'heroName' => $_SESSION['hero']->getName()
            , 'heroHP' => $_SESSION['hero']->getHP()
            , 'heroMP' => $_SESSION['hero']->getMP()
            , 'enemyName' => $_SESSION['enemy']->getName()
            , 'enemyHP' => $_SESSION['enemy']->getHP()
            , 'enemyImg' => $_SESSION['enemy']->getImg()
            , 'enemyKind' => $kind
            , 'BackImg' => $backImg
            , 'strongFlg' => $_SESSION['enemy'] instanceof StrongEnemy
            , 'knockDownCnt' => $_SESSION['knockDownCnt']
            , 'EnemyAttackFlg' => $enemyAttackFlg
            , 'gameOverFlg' => $gameOverFlg
            , 'completeFlg' => $completeFlg
            ];
      echo json_encode($res);
      
    }else{
        error_log('非同期ポスト送信なし');
    }

?>