<?php
require('classes.php');
require('function.php');


error_log('ajaxAttack');

//json形式で値を返す
header("Content-type: application/json; charset=UTF-8");

$enemyAttackFlg = false;


//ゲームオーバー
$gameOverFlg = false;
$completeFlg = false;

//攻撃する
if(!empty($_POST['ajaxattack'])){
      error_log('非同期攻撃フェーズ');
      $_SESSION['hero']->attack($_SESSION['enemy']);
      
      //倒した！
      if($_SESSION['enemy']->getHP() <= 0){
        error_log('敵を倒した！');
        Message::set($_SESSION['enemy']->getName().'を倒した！アーメン！');
        
        $_SESSION['knockDownCnt']++;

        //ラスボス撃破でなければ、敵キャラ生成
        if($_SESSION['enemy'] instanceof StrongEnemy){
           if($_SESSION['enemy']->getKind() == ENEMY_KIND::LASTBOSS
            || $_SESSION['enemy']->getKind() == ENEMY_KIND::LASTMAGICIAN){
          //ゲームクリア画面に遷移
          error_log('ゲームクリア');
          $completeFlg = true;
          }else{
            createEnemy();
            $titleAnimationFlg = true;
          }
        }else{
          createEnemy();
          $titleAnimationFlg = true;
        }

      }else{ 
        //敵からの攻撃
        enemyAttack($_SESSION['hero'], $_SESSION['enemy']);
      }

        
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

            $_SESSION['completeFlg'] = $completeFlg;

      echo json_encode($res);

      $_POST = array();

    }else{
        error_log('非同期ポスト送信なし');
    }
?>