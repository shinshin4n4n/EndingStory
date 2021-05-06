<?php
require('classes.php');
require('function.php');


error_log('ajaxMagicAttack');

//json形式で値を返す
header("Content-type: application/json; charset=UTF-8");

$enemyAttackFlg = false;


//ゲームオーバー
$gameOverFlg = false;
$completeFlg = false;

//攻撃する
if(!empty($_POST['ajaxmgc'])){
      error_log('非同期まほう攻撃フェーズ');
      error_log(print_r($_POST['ajaxmgc'],true));

      $kind = $_POST['ajaxmgc'];
      if($kind == 'mgc'){ //通常まほうこうげき
        error_log('通常まほう攻撃');
        $_SESSION['hero']->magicAttack($_SESSION['enemy']);
      }else if($kind == 'randmgc'){ //ランダムまほうこうげき
        error_log('ランダムまほう攻撃');
        $_SESSION['hero']->randamMagicAttack($_SESSION['enemy']); 
      }
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

    }else{
        error_log('非同期ポスト送信なし');
    }
?>