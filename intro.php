<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>あらすじ</title>   
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
  .window{
    color:<?php
  if(!empty($SESSION['hero'])){
    if($_SESSION['hero']->getHP() <= 0){ echo 'red';}else{ echo '#fffff4';}
  }else{
    echo '#fffff4';
  }
  ?>;
  border:solid 4px <?php
  if(!empty($SESSION['hero'])){
    if($_SESSION['hero']->getHP() <= 0){ echo 'red';}else{ echo '#fffff4';}
  }else{
    echo '#fffff4';
  }
  ?>
  ;
}

.intro{
  width:80%;
  text-align:center;
  height: 650px;
  font-size: 20px;
  line-height:65px;
  margin: 50px auto;
}
.intro .window{
  height: 100%;
  background-color:rgba(0,0,0,0.3);
  /* background-image:url("img/hero/hero.png");
  background-size: 25%;
  background-repeat: no-repeat; */
  background-blend-mode:lighten;
}

main a{
  text-align:center;
  text-decoration: none;
}

.window{
  width: 80%;
  margin:20px auto;
  padding: 10px;
}

.window a{
  text-decoration:none;
  color: #fffff4;
}

.window a:hover{
  opacity:0.7;
}


</style>
</head>
<body>
  <header class="site-width">
      <h2 class="window"><span class="autoWriteBreak 100">あらすじ</span></h2>
  </header>
  <main class="site-width">
    <div class="intro">
      <div class="window">
      <p><span class="autoWriteBreak 50">えらばれしものしか見れない<br>
      エンディングストーリー。<br>
      「エンディングストーリーを、ひと目見てみたい」<br>
      立ち上がったのは、<br>
      とある町に住む一人の勇者だった。<br>
      ボスを倒して<br>
      エンディングストーリーにたどりつけ。<br>
      さあ、キミも一緒に<br>
      エンディングストーリーを見にいこう。</span></p>
      </div>
</div>
    <div class="window" id="intro-back" >
      <a href="./">スタートがめんにもどる</a>
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