<?php

  class GAME_MODE{
    const HERO = 1;
    const MAGICIAN = 2;
  }

  class Creature{
    protected $name;
    protected $hp;
    protected $atk;//攻撃力
    protected $spd;//スピード
    protected $msg; //戦闘の際の声
    protected $img; //戦闘の際の声
    
    public function __construct($name, $hp,  $atk, $spd,$msg, $img){
      
      $this->name = $name;
      $this->hp = $hp;
      $this->atk = $atk;
      $this->spd = $spd;
      $this->msg = $msg;
      $this->img = $img;
    }

    public function setHP($val){
      $this->hp = $val;
    }

    public function setATK($val){
      $this->atk = $val;
    }

    public function setSPD($val){
      $this->spd = $val;
    }
    public function setMsg($val){
      $this->msg = $val;
    }

    public function getName(){
      return $this->name;
    }

    public function getHP(){
      return $this->hp;
    }
    public function getMP(){
      return $this->mp;
    }
    public function getATK(){
      return $this->atk;
    }
    public function getDFC(){
      return $this->dfc;
    }
    public function getSPD(){
      return $this->spd;
    }
    public function getMsg(){
      return '「'.$this->msg.'」';
    }
    public function getImg(){
        return $this->img;
      }

  }

  //モンスタークラス
    class Enemy extends Creature{
        public function __construct($name, $hp, $atk, $spd, $msg, $img){
          parent::__construct($name, $hp, $atk, $spd, $msg, $img);
        }

        //敵の通常攻撃
        public function attack($obj){
            $attackPoint = mt_rand((int)($this->atk*0.8),(int)($this->atk*1.2));        
            $obj->setHP($obj->getHP() - $attackPoint);
            Message::set($this->getName().'のこうげき！');
            Message::set($this->getMsg());
            Message::set($obj->getName().'は'.$attackPoint.'のダメージをうけた!!');
        }
  }

  //強キャラフラグ
   class ENEMY_KIND{
       const ZAURUS = 0;
       const MARMAID = 1;
       const LASTBOSS = 2;
       const HINOTORI = 3;
       const LASTMAGICIAN = 4;
       const FLYDRAGON = 5;
       const DEVIL = 6;
       const ZETTON = 7;
   }

    class StrongEnemy extends Enemy{
        private $kind;
        private $backImg; //ボス背景画像
        public function __construct($name, $hp, $atk, $spd, $msg, $img, $kind, $backImg){
            parent::__construct($name, $hp, $atk, $spd, $msg, $img);
            $this->kind = $kind;
            $this->backImg = 'img/background/'.$backImg;
          }

        public function attack($obj){
            $minRate = 0.8;
            $maxRate = 1.2;
            $attackPoint = mt_rand((int)($this->atk*$minRate),(int)($this->atk*$maxRate));

            if(!mt_rand(0,1)){
                $attackPoint = mt_rand((int)($this->atk*$minRate),(int)($this->atk*$maxRate))*2;        
                $obj->setHP($obj->getHP() - $attackPoint);
                Message::set($this->getName().'のきちくレベルのはげしいこうげき！！');
                // Message::set($this->getMsg());
                Message::set($obj->getName().'は'.$attackPoint.'のダメージをうけた!!');
            }else{
                parent::attack($obj);
            }
        }
        public function getBackImg(){
          return $this->backImg;
        }
        public function getKind(){
          return $this->kind;
        }
    } 

  //主人公クラス
  class Hero extends Creature{
    protected $mp;
    protected $backImg;
    public function __construct($name, $hp, $mp, $atk, $spd, $msg, $img, $backImg){
      parent::__construct($name, $hp, $atk, $spd, $msg, $img);
      $this->mp = $mp;
      $this->backImg = 'img/background/'.$backImg;
    }

    public function setMP($val){
      $this->mp = $val;
    }

    public function getBackImg(){
      return $this->backImg;
    }

    //通常攻撃
    public function attack($obj){
      //与えるダメージ　攻撃力の0.8-1.2
      $AttackPoint = mt_rand((int)$this->atk*0.8, (int)$this->atk*1.2);
      
      if(!mt_rand(0,9)){
        //会心の一撃

        $obj->setHP($obj->getHP() - $AttackPoint*2);
        $AttackPoint *= 2;
        Message::set($this->getName().'のこうげき！');
        Message::set('ほんきのいちげき！！マジ卍！');
        Message::set($obj->getName().'に'.$AttackPoint.'のダメージをあたえた！');
      }else{
        $obj->setHP($obj->getHP()-$AttackPoint);
        Message::set($this->getName().'のこうげき！');
        Message::set($this->getMsg());
        Message::set($obj->getName().'に'.$AttackPoint.'のダメージ！');
      }
    }

    //回復まほう
    public function heal(){
      $max = $this->getHP() * 3;
      $min = $this->getHP() * 2;
      $healPoint = mt_rand((int)$min, (int)$max);

      $nowHP = $this->getHP();
      $setPoint = $this->getHP() + $healPoint;
      if($setPoint > 99999 ) $setPoint = 99999;
  
      $this->setHP($setPoint);
  
      $setPoint = $setPoint - $nowHP;

      //10ポイントのMP消費
      $this->setMP($this->getMP() - 10);
      Message::set('たまにはやすむゆうきもひつよう！いったんしょうきゅうし！');
      Message::set($this->getName().'は'.$setPoint.'ポイントかいふく！');
    }

    //とくぎ ちからをためる
    public function powerUp(){
      
      $powerUpPoint = $this->getATK();
      $this->setATK($this->getATK() + $powerUpPoint);
      $this->setMP($this->getMP() - 10);
      Message::set('ホルモンのちから！おとこをみせてやる！');
      Message::set($this->getName().'は'.$powerUpPoint.'強くなった！');
      
    }

    public function escape($enemy){
      error_log('にげるフェーズ非同期');
      error_log('逃げるフェーズ');

      //逃げる判定
      $Escapable = false;

      Message::set('にげるぞ！にげるははじだがなんとやら！');
      Message::set('せなかのきずは、けんしのはじだがやむをえない！');

      $heroSpd = $this->getSPD();
      $enemySpd = $enemy->getSPD();

      if($enemySpd > $heroSpd){
        $Escapable = false;
        Message::set('にげきれなかった！');
        Message::set('ボスをあいてににげるとはなさけない！！');        
      }

      if($heroSpd - $enemySpd >0){
        $Escapable = true;
        Message::set('うまくにげきれた！');
      }
      return $Escapable;
    }

  }

  class Magician extends Hero{
    public function __construct($name, $hp, $mp, $atk, $spd, $msg, $img, $backImg){
      parent::__construct($name, $hp, $mp, $atk, $spd, $msg, $img, $backImg);
  }

  public function magicAttack($obj){
    
    //魔法攻撃はスピード依存
    $AttackPoint = mt_rand((int)$this->getSPD()*0.8, (int)$this->getSPD()*1.2);
    $consumedMP = 10;

    $this->setMP($this->getMP() - 10);
      
      if(!mt_rand(0,3)){
        //会心の魔法一撃
        $AttackPoint *= 2;
        $obj->setHP($obj->getHP() - $AttackPoint);
        Message::set($this->getName().'のまりょくがぼうそうした！');
        Message::set('「これってもしかして...、バズってるぅぅーーー？？」');
        Message::set($obj->getName().'に'.$AttackPoint.'のだいダメージ！');
      }else{
        $obj->setHP($obj->getHP()-$AttackPoint);
        Message::set($this->getName().'のまほうこうげき！');
        Message::set('「コツコツいくよ！インプレッションフレア！」');
        Message::set($obj->getName().'に'.$AttackPoint.'のダメージ！');
      }
  }

  public function randamMagicAttack($obj){

    $AttackPoints = array(500,2000,10000,30000);
    $AttackPoint = $AttackPoints[mt_rand(0,3)];
    $consumedMP = 30;

    //MP消費
    $this->setMP($this->getMP()-$consumedMP);

    $obj->setHP($obj->getHP()-$AttackPoint);
    Message::set($this->getName().'のランダムまほうこうげき！');
    Message::set('ねらっていくわよ！３，２，１, BUZZ！');
    Message::set($obj->getName().'に'.$AttackPoint.'のダメージ！');
  }

  //オーバーライド セリフだけ変える
  public function escape($enemy){
    error_log('にげるフェーズ非同期');
    error_log('逃げるフェーズ');

    //逃げる判定
    $Escapable = false;

    Message::set('にげるわよ！にげるははじだがなんとやら！');
    Message::set('きらわれるゆうき！にがてなあいてにゃかまってられない！');

    $heroSpd = $this->getSPD();
    $enemySpd = $enemy->getSPD();

    if($enemySpd > $heroSpd){
      $Escapable = false;
      Message::set('にげきれなかった！');
      Message::set('ボスをあいてににげるとはなさけない！！');        
    }

    if($heroSpd - $enemySpd >0){
      $Escapable = true;
      Message::set('うまくにげきれた！');
    }
    return $Escapable;
  }

  //オーバーライド
    public function heal(){
    $max = $this->getHP() * 1.5;
    $min = $this->getHP() * 0.5;
    $healPoint = mt_rand((int)$min, (int)$max);

    $nowHP = $this->getHP();
    $setPoint = $this->getHP() + $healPoint;
    if($setPoint > 99999 ) $setPoint = 99999;

    $this->setHP($setPoint);

    $setPoint = $setPoint - $nowHP;

    //10ポイントのMP消費
    $this->setMP($this->getMP() - 10);
    Message::set($this->getName().'のかいふくまほう！');
    Message::set('じんせいはリカバリのれんぞく！たてなおすわよ！');
    Message::set($this->getName().'は'.$setPoint.'ポイントかいふく！');
  }

}


  abstract class Message{

    public static function set($msg){
      //一行毎に配列に追加
        if(empty($_SESSION['message'])){
          $_SESSION['message'] = array();
        }
        $_SESSION['message'][] = $msg.'<br>';
        error_log($msg);
    }

    public static function getMessage(){

        $msgCnt = count($_SESSION['message']);
        $preMsgCnt = empty($_SESSION['preMsgCnt']) ? 0 : $_SESSION['preMsgCnt']; 
        $dispMsg = '';
        //新規に追加されたMsgのみ取得
        for($i = $preMsgCnt; $i<=$msgCnt; $i++){
            $dispMsg .= $_SESSION['message'][$i];
        }
        $_SESSION['preMsgCnt'] = $msgCnt;
        return $dispMsg;
    }

    public static function clear(){
      unset($_SESSION['message']);
    }
  }


?>