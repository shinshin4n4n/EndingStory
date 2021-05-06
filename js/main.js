$(function () {
    var $magic = $('#magic');
    var $heal = $('#heal');
    var $mgheal = $('#mgheal');
    var $escape = $('#escape');
    var $back = $('#back');
    var $mgback = $('#mgback');
    var $battleInputArea = $('.battle-input-area');
    var $healSelects = $('.heal-selects');
    var $menuSelects = $('.menu-selects');
    var $magicSelects = $('.magic-selects');
    var $powerUp = $('#powerUp');
    var $mgmagic = $('#mgmagic');
    var $magicAttack = $('#magic-attack');
    var $randamMagicAttack = $('#randam-magic-attack');
    var $heroBGM = $('#hero-bgm');
    var $heroBossBGM = $('#hero-boss-bgm');
    var $magicianBGM = $('#magician-bgm');
    var $magicianBossBGM = $('#magician-boss-bgm');
    var $mute = $('#mute');
    var $attack = $('#attack');
    var $battleInputArea = $('.battle-input-area');
    var set = 0;

    //操作音の再生
    $('span').on('click', function(){
        $('#push-sound').get(0).play();
    });

    //攻撃ボタン選択時
    $attack.on('click', function () {

        //ボタン連続入力処理防止
        if(set == 1){
           return; 
        }
        set = 1;

        //効果音
        $('#push-sound').get(0).play();

        //フォームの非表示
        $battleInputArea.hide(200);
        
        //攻撃アクション
        attack();

        //フォームの再表示
        setTimeout(function(){
            $battleInputArea.show(200);
            set = 0;
        }, 2000);
    });

    //ちからをためるボタン選択時
    $powerUp.on('click', function(){
        //アニメーション中のフォームを一時無効化
        $battleInputArea.hide(200);

        //ボタン連続入力処理防止
        if(set == 1){
            return; 
        }
        set = 1;

        //ちからをためるアクション
        powerUp();

        //メニューをもとの表示に戻す
        $healSelects.hide();
        $menuSelects.show();
        //フォームの有効化
        setTimeout(function(){
            $battleInputArea.show(200);
            set = 0;
        }, 2000);

    });

    //にげるボタン選択時
    $escape.on('click', function(){

        //ボタン連続入力処理防止
        if(set == 1){
            return; 
        }
        set = 1;

        $battleInputArea.hide(200);
        escape();

        //メニューをもとの表示に戻す
        $healSelects.hide();
        $menuSelects.show();
        //フォームの有効化
        setTimeout(function(){
            $battleInputArea.show(200);
            set = 0;
        }, 2000);
    });

    //かいふくボタン選択時
    $heal.on('click', function () {

        //ボタン連続入力処理防止
        if(set == 1){
            return; 
        }
        set = 1;

        //アニメーション中のフォームを一時無効化
        $battleInputArea.hide(200);

        //かいふくアクション
        heal();

        //メニューをもとの表示に戻す
        $healSelects.hide();
        $menuSelects.show();
        //フォームの有効化
        setTimeout(function(){
            $battleInputArea.show(200);
            set = 0;
        }, 2000);

    });
    
    //まどうしかいふくボタン選択時
    $mgheal.on('click', function () {

        //ボタン連続入力処理防止
        if(set == 1){
            return; 
        }
        set = 1;
        //アニメーション中のフォームを一時無効化
        $battleInputArea.hide(200);
    
        //かいふくアクション
        heal();
    
        //メニューをもとの表示に戻す
        $magicSelects.hide();
        $menuSelects.show();
        //フォームの有効化
         setTimeout(function(){
            $battleInputArea.show(200);
            set = 0;
        }, 2000);
    });

    //魔法メニューの表示
    $magic.on('click', function(){
        $menuSelects.hide();
        $healSelects.show();
    });

    //まどうしへん魔法メニューの表示
    $mgmagic.on('click', function(){
        $menuSelects.hide();
        $magicSelects.show();
    });

    //魔法メニューをとじる
    $back.on('click',function(){

        $healSelects.hide();
        $menuSelects.show();
    });

    //まどうしへん魔法メニューをとじる
    $mgback.on('click',function(){

        $magicSelects.hide();
        $menuSelects.show();
    });

    //まどうしへん魔法こうげき
    $magicAttack.on('click', function(){
        //ボタン連続入力処理防止
        if(set == 1){
            return; 
        }
        set = 1;
       
        //アニメーション中のフォームを一時無効化
       $battleInputArea.hide(200);

       //まほうこうげきアクション
       magicAttack('n');

       //メニューをもとの表示に戻す
       $magicSelects.hide();
       $menuSelects.show();
       //フォームの有効化
       setTimeout(function(){
           $battleInputArea.show(200);
           set = 0;
       }, 2000); 
    });

    //まどうしへん魔法こうげき
    $randamMagicAttack.on('click', function(){
        //ボタン連続入力処理防止
        if(set == 1){
            return; 
        }
        set = 1;
        //アニメーション中のフォームを一時無効化
        $battleInputArea.hide(200);
    
        //まほうこうげきアクション
        magicAttack('r');
    
        //メニューをもとの表示に戻す
        $magicSelects.hide();
        $menuSelects.show();
        //フォームの有効化
        setTimeout(function(){
            $battleInputArea.show(200);
            set = 0;
        }, 2000); 
     });

    $mute.on('click',function(){
        $heroBGM.get(0).muted = true;
        $heroBossBGM.get(0).muted = true;
        $magicianBGM.get(0).muted = true;
        $magicianBossBGM.get(0).muted = true;
    });
});


function escape() {
    console.log('にげる非同期通信開始');
    var $escape = $('#escape');
    var data = $escape.data('ajaxescape');
    var $heroHP = $('#hero-hp');
    var $knockdowncnt = $('#knockDownCnt');
    var $battleInputArea = $('.battle-input-area>span');

    //アニメーション中のフォームを一時無効化
    $battleInputArea.prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "ajaxEscape.php",
        data: { ajaxescape: data }
    }).done(function (data) {
        console.log('サーバー接続成功');
        console.log(data);
        /*アニメーション表示*/

        //メッセージの表示
        showMsg(data.message);

        //効果音の再生
        $('#escape-sound').get(0).play();

        /*敵、味方のHP表示の更新*/
        $knockdowncnt.html(data.knockDownCnt);

        //2秒後(戦闘終了、敵からの攻撃または次のモンスターに切り替え)にの動作
        setTimeout(function(){

            alterEnemyProp(data.strongFlg, data.enemyImg, data.BackImg, data.enemyName, data.enemyHP);  

            if(data.EnemyAttackFlg){
                //振動アニメーション
                enemyAttackAnimation(data.strongFlg);
                
                //HPの更新
                $heroHP.html(data.heroHP);

                //ゲームオーバー処理
                if(data.gameOverFlg){
                    gameOver(data.enemyName);
                }
            }
         }, 2000);

       //MP0以下のとき、魔法メニューの無効化
       MagicDisplayOff(data.heroMP);

    }).fail(function (xhr, textStatus, errorThrown) {
        console.log('接続失敗');
    });
}

function heal() {

    /*回復コマンドの選択
    ↓
    回復 味方HPの更新
    ↓
    敵モンスターからダメージ    
    */

    console.log('かいふく非同期通信開始');
    var $heal = $('#heal');
    var data = $heal.data('ajaxheal');
    var $heroHP = $('#hero-hp');
    var $heroMP = $('#hero-mp');
    var $knockdowncnt = $('#knockDownCnt');
    var $battleInputArea = $('.battle-input-area>p>span');
    var $healAudio = $('#heal-audio').get(0);
    //アニメーション中のフォームを一時無効化
    $battleInputArea.prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "ajaxHeal.php",
        data: { ajaxheal: data }
    }).done(function (data) {
 
        //メッセージの表示
        showMsg(data.message);

        /*HP・MP表示の更新*/
        $heroHP.html(data.heroHP);
        $heroMP.html(data.heroMP);
        
        //MPがないばあい、まほうはつかえない
        if(data.heroMP <= 0){
            $heal.hide();
        }
        
        $knockdowncnt.html(data.knockDownCnt);

        setTimeout(function(){
            $healAudio.play();            
        }, 200);

        //2秒後(戦闘終了、敵からの攻撃または次のモンスターに切り替え)にの動作
        setTimeout(function(){

                       //敵画像・名前の更新
                       alterEnemyProp(data.strongFlg, data.enemyImg, data.BackImg, data.enemyName, data.enemyHP);  

                       if(data.EnemyAttackFlg){
           
                           //振動アニメーション
                           enemyAttackAnimation(data.strongFlg);
                           
                           //HPの更新
                           $heroHP.html(data.heroHP);
           
                           //ゲームオーバー処理
                           if(data.gameOverFlg){
                               gameOver(data.enemyName);
                           }
                       }
         }, 2000);

         //MP0以下のとき、魔法メニューの無効化
         MagicDisplayOff(data.heroMP);


    }).fail(function (xhr, textStatus, errorThrown) {
        console.log('接続失敗');
    });
}

function powerUp() {

    /*ちからをためるコマンドの選択
    ↓
    味方の攻撃力が倍HPの更新
    ↓
    敵モンスターからダメージ    
    */

    console.log('ちからをためる非同期通信開始');
    var $powerUp = $('#powerUp');
    var data = $powerUp.data('ajaxpowerup');
    var $heroHP = $('#hero-hp');
    var $heroMP = $('#hero-mp');
    var $knockdowncnt = $('#knockDownCnt');
    var $powerUpAudio = $('#powerup-audio').get(0);
    var $battleInputArea = $('.battle-input-area>p>span');
    
    //アニメーション中のフォームを一時無効化
    $battleInputArea.prop('disabled', true);

    setTimeout(function(){
        $powerUpAudio.play();            
    }, 200);

    $.ajax({
        type: "POST",
        url: "ajaxPowerUp.php",
        data: { ajaxpowerup: data }
    }).done(function (data) {
        console.log('サーバー接続成功');
        console.log(data);
        /*アニメーション表示*/

        //メッセージの表示
        showMsg(data.message);

        /*MP表示の更新*/
        $heroMP.html(data.heroMP);
        
        //MPがないばあい、まほうはつかえない
        if(data.heroMP <= 0){
            $powerUp.css('color', 'red');
            $powerUp.hide();
        }
        
        $knockdowncnt.html(data.knockDownCnt);

        //2秒後(戦闘終了、敵からの攻撃または次のモンスターに切り替え)にの動作
        setTimeout(function(){

            //敵画像・名前の更新
            alterEnemyProp(data.strongFlg, data.enemyImg, data.BackImg, data.enemyName, data.enemyHP);  

            if(data.EnemyAttackFlg){

                //振動アニメーション
                enemyAttackAnimation(data.strongFlg);
                
                //HPの更新
                $heroHP.html(data.heroHP);

                //ゲームオーバー処理
                if(data.gameOverFlg){
                    gameOver(data.enemyName);
                }
            }
         }, 2000);

         //MP0以下のとき、魔法メニューの無効化
         MagicDisplayOff(data.heroMP);

    }).fail(function (xhr, textStatus, errorThrown) {
        console.log('接続失敗');
    });
}

//まどうし編のみ使用
function magicAttack(kind) {

    console.log('こうげき非同期通信開始');
    var $magicAttack = $('#magic-attack'); //インプレッション
    var $randamMagicAttack = $('#randam-magic-attack');
    var $magicAttackAudio = $('#magic-audio').get(0);
    var $rmagicAttackAudio = $('#randam-magic-audio').get(0);
    var data;
    if(kind == 'n'){
        data = $magicAttack.data('ajaxmgc');
    }else if(kind == 'r'){
        data = $randamMagicAttack.data('ajaxmgc');
    }
    var $heroHP = $('#hero-hp');
    var $heroMP = $('#hero-mp');
    var $enemyHP = $('#enemy-hp');
    var $knockdowncnt = $('#knockDownCnt');

    $.ajax({
        type: "POST",
        url: "ajaxMagicAttack.php",
        data: { ajaxmgc: data }
    }).done(function (data) {
        console.log('サーバー接続成功');
        console.log(data);
        
        //メッセージコマ送り表示
        showMsg(data.message);

        /*表示の更新*/
        $knockdowncnt.html(data.knockDownCnt);
        $heroMP.html(data.heroMP);

        setTimeout(function(){
            
            //まほうこうげきの振動　はげしめ
            $('.enemy-area').effect( 'shake', {direction:'up',distance:100, times:30});
            $('.enemy-area').effect( 'shake', {direction:'both',distance:100, times:30});
            
            //敵HPの更新
            $enemyHP.html(data.enemyHP);       
            //効果音再生
            if(kind == 'n'){
                $magicAttackAudio.play();
            }else if(kind == 'r'){
                $rmagicAttackAudio.play();
            }

            //ゲームクリア時はクリア画面に
            if(data.completeFlg){
                setTimeout(function(){
                window.location.href = "complete.php" 
                return;
                },2000)
            }
       },200);

       //HPが増えている場合→新しいモンスターにチェンジ
       var preKnockDownCnt = sessionStorage.getItem('preKnockDownCnt');
       if(data.knockDownCnt > preKnockDownCnt ){
            alterBGM(data.strongFlg,data.heroName);
       }
                   
       //セッションに敵HPを格納　
       sessionStorage.setItem('preKnockDownCnt', data.knockDownCnt);

  
        //2秒後(戦闘終了、敵からの攻撃または次のモンスターに切り替え)にの動作
        setTimeout(function(){

            //敵画像・名前の更新
            alterEnemyProp(data.strongFlg, data.enemyImg, data.BackImg, data.enemyName, data.enemyHP); 

            //敵からの攻撃時、画面を揺らす
            if(data.EnemyAttackFlg){
                //振動アニメーション
                enemyAttackAnimation(data.strongFlg);
                
                //HPの更新
                $heroHP.html(data.heroHP);

                //ゲームオーバー処理
                if(data.gameOverFlg){
                    gameOver(data.enemyName);
                }
            }
         }, 2000);

        //MP0以下のとき、魔法メニューの無効化
        MagicDisplayOff(data.heroMP);

    }).fail(function (xhr, textStatus, errorThrown) {
        console.log('接続失敗');
    });
}


function MagicDisplayOff(mp){
    $magic = $('#magic');
    $mgmagic = $('#mgmagic');
    $rmagic = $('#randam-magic-attack');

    if(mp<30){
        $rmagic.empty();

    }

    if(mp<=0){
        $magic.hide();
        $mgmagic.hide();
    }
}

function attack() {

    console.log('こうげき非同期通信開始');
    var $attack = $('#attack');
    var data = $attack.data('ajaxattack');
    var $heroHP = $('#hero-hp');
    var $enemyHP = $('#enemy-hp');
    var $knockdowncnt = $('#knockDownCnt');
    var $battleInputArea = $('.battle-input-area>span');
    var $attackAudio = $('#attack-audio').get(0);

    //アニメーション中のフォームを一時無効化
    $battleInputArea.prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "ajaxAttack.php",
        data: { ajaxattack: data }
    }).done(function (data) {
        console.log('サーバー接続成功');
        console.log(data);
        
        //ゲームクリア時はクリア画面に
        if(data.completeFlg){
             window.location.href = "complete.php"
             return;
        }
        //メッセージコマ送り表示
        showMsg(data.message);

        $knockdowncnt.html(data.knockDownCnt);

        setTimeout(function(){
            //攻撃の振動
            $('.enemy-area').effect( 'shake', {direction:'both',distance:10, times:20});
            
            //敵HPの更新
            $enemyHP.html(data.enemyHP);
            
            //効果音再生
            $attackAudio.play();
       },200);


       //倒した数が増えた時、モンスターの画面、BGMの切替切り替え
       var preKnockDownCnt = sessionStorage.getItem('preKnockDownCnt');
       
       //敵を倒した時、BGMを更新
       if(data.knockDownCnt > preKnockDownCnt ){
            alterBGM(data.strongFlg,data.heroName);
       }
                   
       //セッションに敵HPを格納　
       sessionStorage.setItem('preKnockDownCnt', data.knockDownCnt);

        //2秒後(戦闘終了、敵からの攻撃または次のモンスターに切り替え)にの動作
        setTimeout(function(){
   
            //敵画像・名前の更新
            alterEnemyProp(data.strongFlg, data.enemyImg, data.BackImg, data.enemyName, data.enemyHP);  

            if(data.EnemyAttackFlg){

                //振動アニメーション
                enemyAttackAnimation(data.strongFlg);
                
                //HPの更新
                $heroHP.html(data.heroHP);

                //ゲームオーバー処理
                if(data.gameOverFlg){
                    gameOver(data.enemyName);
                }
            }

         }, 2000);

      //MP0以下のとき、魔法メニューの無効化
      MagicDisplayOff(data.heroMP);


    }).fail(function (xhr, textStatus, errorThrown) {
        console.log('接続失敗');
    });
}

function showMsg(str){

    /*メッセージコマ送り表示
    全ての文字をspanで囲んで一文字ずつ表示
    */
   console.log(str);
   var $MsgArea = $('.battle-msg-area>p');
   var newHTML = "";

   //<br>だけスルーして各文字をspanで囲む
   str.split(/<br>/).forEach(function (s) {
       newHTML += '<span>';
       s.split('').forEach(function (chr) {
           newHTML += '<span>' + chr + '</span>';
       });
       newHTML += '<br></span>';
   });

   //HTML文の置換
   $MsgArea.html(newHTML);

   //span毎に表示
   var txtIdx = 0;
   setInterval(function () {
       $MsgArea.find('span').eq(txtIdx).css('opacity', '1');
       txtIdx++;
   }, 20);

}

function alterEnemyProp(strongFlg, enemyImg, backImg, enemyName, enemyHP){

    var $enemyImg = $('.enemy-img');
    var $main = $('main');
    var $body = $('body');
    var $enemyName = $('#enemy-name');
    var $enemyHP = $('#enemy-hp');

    if(strongFlg){
        $enemyImg.css('visibility', 'hidden');
        $main.css('background-image', 'url("' + enemyImg + '")');
        $body.css('background-image', 'url("' + backImg + '")');
    }else{
        $enemyImg.attr('src', enemyImg);
        $enemyImg.css('visibility', 'visible');
        $main.css('background-image', 'none');
        $body.css('background-image', 'url("' + backImg + '")');
    }
    $enemyName.html(enemyName);
    $enemyHP.html(enemyHP);
}

function alterBGM(strongFlg,heroName){

    if(strongFlg){
          if(heroName == 'ゆうしゃ' || heroName == 'しんのゆうしゃ'){
              $('#hero-bgm').get(0).pause();
              $('#hero-boss-bgm').get(0).currentTime = 0;
              $('#hero-boss-bgm').get(0).play();
          }else{
              $('#magician-bgm').get(0).pause();
              $('#magician-boss-bgm').get(0).currentTime = 0;
              $('#magician-boss-bgm').get(0).play();
          }
    }else{                
          if(heroName == 'ゆうしゃ' || heroName == 'しんのゆうしゃ'){
              $('#hero-boss-bgm').get(0).pause();
              $('#hero-bgm').get(0).play();
          }else{
              $('#magician-boss-bgm').get(0).pause();
              $('#magician-bgm').get(0).play();
          }
    }
}

function gameOver(enemyName){

    $window = $('.window');
    $attack = $('#attack');
    $magic = $('#magic');
    $mgmagic = $('#mgmagic');
    $escape = $('#escape');

    //ウィンドウの枠色を赤
    $window.css('border', 'solid 4px red');
    $window.css('color', 'red');
    $('header>h2>span').html('ゲームオーバー');
    
    //メニューの非表示化
    $attack.css('display','none');
    $magic.css('display','none');
    $mgmagic.css('display','none');
    $escape.css('display','none');

    //ラスボス時には、エンディングへ
    if(enemyName == 'しんのゆうしゃ' || enemyName == 'しんのまどうし'){
        $('#ending-story').show();
    }else{
        $('#ending-story').hide();
    }
}

function enemyAttackAnimation(strongFlg){

    if(strongFlg){ //中ボス時は激しいゆれ
        $('.window').effect('shake', {direction:'up',distance:30,times:20});
        $('.window').effect('shake',{direction:'both',distance:10,times:10});
    }else{
        //雑魚キャラは通常の揺れ
        $('.window').effect('shake');
    }

    $('#enemy-attack-audio').get(0).play();
}
