 <?php // Начинаем сессию
session_start();

 header('Content-Type: text/html; charset=utf-8');

// Подключаем конфиг
include "../config.php";

// Выход
if (isset($_GET['exit'])) {
    // Удаляем сессии
    $_SESSION = array();
	session_destroy();
	
	// Удаляем кук
	setcookie("login", "", time()-3600);
	setcookie("id", "", time()-3600);
	
	header("Location: /index.php");
	/*
	// Оповещаем пользователя
	echo "Вы успешно вышли. Для перехода на главную страницу пройдите по <a href='../../index.html'>ссылке</a>.";
	
	// Завершаем сценарий
	exit();*/
}




// Вытаскиваем куки, если они есть
if(isset($_COOKIE['id']) && isset($_COOKIE['login'])) {
     // Для удобства создаем переменные для сессий
     $account = trim($_SESSION['login']);
     $removeplus = str_replace("+", " ", $account);
     $login = mb_convert_encoding($removeplus, 'UTF-8', mb_detect_encoding($removeplus));
     
	$id = $_SESSION['id'];
	
    // Создаем сессии пользователя - id и login
	$_SESSION['id'] = $_COOKIE['id'];
	$_SESSION['login'] = $_COOKIE['login'];
	
	// Обновляем куки, действительны в течение месяца ~30 дней
	setcookie("login", $_COOKIE['login'], time()+60*60*24*7*4);
	setcookie("id", $_COOKIE['id'], time()+60*60*24*7*4);
    
	//вписываем последний онлайн
	$sql = "UPDATE `users` SET `online` = '" . time() . "' WHERE `id` = '$id'";
        mysqli_query($conn, $sql) or die (mysqli_error());
        
    	//вписываем последний онлайн анимагу
	if($animag_approve == 1 and $animag_visibility == 1) {
	$sql = "UPDATE `animagus` SET `online` = '" . time() . "' WHERE `login` = '$login'";
        mysqli_query($conn, $sql) or die (mysqli_error()); }
    
} else {

// Иначе - производим авторизацию

// Если форма заполнена - пытаемся войти
if(!empty($_POST['auth'])) {
			// Защищаем код
			$gologin = strip_tags($_POST['logingo']);
			$gopassword = md5($_POST['password']);
	
	// Проверяем существование пользователя через БД
	$sql = "SELECT `id`, `password`, `dostup` FROM `users` WHERE `login` = '$gologin'";
	$res = mysqli_query($conn, $sql);
	
	// Если пользователь существует, продолжаем
	if(mysqli_num_rows($res)) {
		$rows = mysqli_fetch_array($res);
		$r_password = $rows['password'];
		$r_id = $rows['id'];
		$r_dost = $rows['dostup'];
			
		// Если профиль активен
		if($r_dost !== "-1") {
		
		// Если пароль совпадает
		if($gopassword == $r_password) {
		
		    // И последнее - доступ не должен быть меньше единицы
			//if($rows['dostup'] > 0) {
			
				// Создаем куки, действительны в течение месяца ~30 дней
					setcookie("login", $gologin, time()+60*60*24*7*4);
					setcookie("id", $r_id, time()+60*60*24*7*4);
                    setcookie("password", $r_password, time()+60*60*24*7*4);

					// Создаем сессии пользователя - id и login
			$_SESSION['id'] = $r_id;
			$_SESSION['login'] = $gologin;
			$_SESSION['password'] = $r_password;
			
		   // Оповещаем пользователя о возможности войти
	        	header("Location: https://". $_SERVER['HTTP_HOST'] ."/potions/");
	        // echo "$_SESSION[login], Вы успешно вошли на сайт. Для продолжения пройдите по <a href='index.php'>ссылке</a>.";
            //} else $erorrs[] = "Ошибка доступа.";
		} else { $error .= "<span class='dashicons dashicons-welcome-comments'></span> Вы ввели неверный пароль.<br>"; }
	} else  { $error .= "<span class='dashicons dashicons-welcome-comments'></span> Ваш профиль канул в неактив. Увы, вход невозможен. <a href='https://magismo.ru/feedback.php?purpose=reenter'><u>Обратитесь к администрации</u></a>, если хотите восстановиться.<br>"; }
	} else  { $error .= "<span class='dashicons dashicons-welcome-comments'></span> Вы ввели неверный логин.<br>";  }
} 
}


// Часовой пояс
$zaprosik = "SELECT * FROM `users` WHERE `login`='$login'";
$obr = mysqli_query($conn, $zaprosik);
$spck = mysqli_fetch_array($obr);
$tz = $spck['timezone'];

if (empty($tz)) {
    date_default_timezone_set('Europe/Moscow');
    $year = 2022;
	$month = 02;
	$day = 18;
	$hour = 22;
	$min = 00;
	$sec = 00;

	$target = mktime($hour, $min, $sec, $month, $day, $year);
	$current = time();
	$difference = $target - $current;

	$rDay = floor($difference/60/60/24);
	$rHour = floor(($difference-($rDay*60*60*24))/60/60);
	$rMin = floor(($difference-($rDay*60*60*24)-$rHour*60*60)/60);
	$rSec = floor(($difference-($rDay*60*60*24)-($rHour*60*60))-($rMin*60));
}
else {
    date_default_timezone_set($tz);
    $year = 2022;
	$month = 02;
	$day = 18;
	$hour = 22;
	$min = 00;
	$sec = 00;

	$target = mktime($hour, $min, $sec, $month, $day, $year);
	$current = time();
	$difference = $target - $current;

	$rDay = floor($difference/60/60/24);
	$rHour = floor(($difference-($rDay*60*60*24))/60/60);
	$rMin = floor(($difference-($rDay*60*60*24)-$rHour*60*60)/60);
	$rSec = floor(($difference-($rDay*60*60*24)-($rHour*60*60))-($rMin*60));
}

 ?>
 
<!DOCTYPE html>
<html>
    <head>
<meta http-equiv="Content-Type" content="text/html;  charset=utf-8" />
<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<meta name="language" content="ru" />
<!--[if lt IE 9]><script src="/html5.js"></script><![endif]-->
<meta name="description" content="Университет магических искусств, основанный в 2011 году" />
<link rel="stylesheet" href="https://magismo.ru/potions/css/styles.css" media="screen">
<link rel="icon" href="https://magismo.ru/favicon.ico" type="image/x-icon" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" id="dashicons-css" href="../castle_style/dashicons.css" type="text/css" media="all">
<link rel="canonical" href="https://magismo.ru/">
<link rel="shortlink" href="https://magismo.ru/">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<title>Магисмо &middot; Зельеваренье</title>
     
    </head>
    
<body onload="countdown();">



<script type="text/javascript" src="https://magismo.ru/potions/js/effect.js"></script>

<style>
    .vapour {
    position: relative;
    display: flex;
    z-index: 1;
    padding: 0 20px;
    justify-content: center;
}

.vapour span {
    position: relative;
    bottom: 50px;
    display: block;
    margin: 0 2px 50px;
    min-width: 8px;
    height: 120px;
    background: #e7dfeb;
    border-radius: 50%;
    animation: animate 5s linear infinite;
    opacity: 0;
    filter: blur(10px);
    animation-delay: calc(var(--v) * -0.5s);
}

#puff {
    cursor:pointer;
    display:none;
    position:absolute;
    height:32px;
    width:32px;
    background: url(https://magismo.ru/potions/images/wvPeK.png) no-repeat;
}
ul{padding:0;font-family:Magismo}
li{
    list-style:none;
    background-color: #5c462c;
    border: none;
    color: white;
    text-decoration: none;
    cursor:pointer;
    float:left;
    margin:5px;
    padding:5px;
    vertical-align:middle;
}
a {
   text-decoration: none;
}
span {
    vertical-align:middle;
}

@keyframes animate {
    0% {
        transform: translateY(0) scaleX(1);
        opacity: 0;
    }
    15% {
        opacity: 1;
    }
    50% {
        transform: translateY(-150px) scaleX(5);
    }
    95% {
        opacity: 0;
    }
    100% {
        transform: translateY(-300px) scaleX(10);
    }
}


.readypotion {
    animation: float 6s ease-in-out infinite;
    position: absolute !important;
    top:5%;
    bottom: 0;
    left: 120px;
    right: 0;
    margin: auto;
}

/* keyframes for animation;  simple 0 to 360 */
@keyframes spin {
	from { transform: rotate(0deg); }
	to { transform: rotate(360deg); }
}

/* basic structure for the rays setup */
#raysDemoHolder	{ 
	
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

#rays	{ /* with animation properties */
	background: url("https://magismo.ru/potions/images/rays-main.png") 0 0 no-repeat; 
	position: fixed;
	top:5%;
    bottom: 0;
    left: 120px;
    right: 0;
    margin: auto;
	width: 490px; 
	height: 490px; 
	
	/* microsoft ie */
	animation-name: spin; 
	animation-duration: 40000ms; /* 40 seconds */
	animation-iteration-count: infinite; 
	animation-timing-function: linear;
}

#rays:hover {
	/* animation-duration: 10000ms; 10 seconds - speed it up on hover! */
	/* resets the position though!  sucks */
}

/* boooo opera */
-o-transition: rotate(3600deg); /* works */
</style>
<?php
if (empty($_SESSION['login'])) {
?>
<div class='noauth'><h3>Пожалуйста, войдите в систему, чтобы начать варку зелья.</h3>
    <?php 
    echo $error;
    ?>
    <form method='post'>
	    
  <p>
    <label>Ваш логин:<br></label>
    <input type='text' name='logingo' value="<?php if(isset($_COOKIE["login"])) { echo $_SESSION['login']; } ?>" id="login" required>

  </p>

  <p id="form-login-username">
    <label>Ваш пароль:<br></label>
    <input type="password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_SESSION['password']; } ?>" id="password" required>
 </p>
<!--<br><p style="float:left;white-space: nowrap;">
    
    <input type="checkbox" name="remember" id="mijc" class='art'><label for="mijc">Запомнить меня</label>
</p>
<br>-->
<br>
<input type="submit" name="auth" value="Войти" class="art-button">


</form>
    
    </div>
    
<?php
} else {
    
    

// Зелья
include "recipe/r1.php";
include "recipe/r2.php";
include "recipe/r3.php";
include "recipe/r4.php";
include "recipe/r5.php";
include "recipe/r6.php";
include "recipe/r7.php";
include "recipe/r8.php";
include "recipe/r9.php";
include "recipe/r10.php";
include "recipe/r11.php";
include "recipe/r12.php";
include "recipe/r13.php";
include "recipe/r14.php";
include "recipe/r15.php";
include "recipe/r16.php";
include "recipe/rkmarst3-3.php";

if(isset($_POST['select'])) {
  $potion = $_POST['potion'];
    header("Location: https://". $_SERVER['HTTP_HOST'] ."/potions/?potion=$potion");
}   
    
   
if(!isset($_GET['potion'])) {  
?>  
 <div class="content">
     
  <?php
  echo $login . " ";
  ?>
<a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>

     <h3>Выберите зелье, которое будете варить</h3>
     
     <form method="post">
         
         <select name="potion">
             <option></option>
             <option value='1'>1. Противоаллергическое зелье</option>
             <option value='2'>2. Эликсир бодрости</option>
             <option value='3'>3. Бодряще-лечащая настойка</option>
             <option value='4'>4. Тонизирующее зелье</option>
             <option value='5'>5. Зелье саламандры</option>
             <option value='6'>6. Зелье ночного зрения</option>
             <option value='7'>7. Зелье "Щит ясного сознания"</option>
             <option value='8'>8. Зелье "Хранитель от нечисти"</option>
             <option value='9'>9. Зелье "Увеличитель силы"</option>
             <option value='10'>10. Зелье "Приток сил"</option>
             <option value='11'>11. Быстрозаживляющая универсальная мазь</option>
             <option value='12'>12. Согревающая настойка</option>
             <option value='13'>13. Охлаждающая паста</option>
             <option value='14'>14. Противоядие от самых сильных любовных зелий</option>
             <option value='16'>15. Зелье ментального восстановления</option>
             
             <?php
             // проверяем статус тура в админке
$sqli = "SELECT * FROM `tury` WHERE `tur`='1'"; 
 $resu = mysqli_query($conn, $sqli);
  $check = mysqli_fetch_array($resu);
   $stats = $check['status'];
   // если тур активен, все предметы видны
    if($stats == 1) {
             
             
             $sql = "SELECT * FROM `contestants` WHERE `name`='$login'"; 
 $res = mysqli_query($conn, $sql);
 
 // если участник в списках, показываем предмет
  if(mysqli_num_rows($res)) {
      ?>
             <option value='15'>Зелье для первого тура турнира ЧВ</option>
             <? }
             }?>
           </select>
           
         <input type="submit" name="select" value="Выбрать">
     </form>
     </div>
<?
}  
}
?>

<?php
if($gotovo == 1) {
    echo '';
} else { 
    echo '<canvas id="canvas" class="smoke"></canvas>';
}
?>
 
<div class="cauldron float">
    
<?php
if($gotovo == 1) {
    echo '';
} else { 
    echo '<div class="vapour">
                <span style="--v:1;"></span>
                <span style="--v:2;"></span>
                <span style="--v:5;"></span>
                <span style="--v:4;"></span>
                <span style="--v:6;"></span>
                <span style="--v:19;"></span>
                <span style="--v:7;"></span>
                <span style="--v:8;"></span>
                <span style="--v:9;"></span>
                <span style="--v:10;"></span>
                <span style="--v:11;"></span>
                <span style="--v:18;"></span>
            </div>';
}
?>    
    
	
    </div>
<script>
function expandit(id){

  obj = document.getElementById(id);

  if (obj.style.display=='none') obj.style.display='';

  else obj.style.display='none';}
</script>

<script>
    function animatePoof() {
    var bgTop = 0,
        frame = 0,
        frames = 6,
        frameSize = 32,
        frameRate = 80,
        puff = $('#puff');
    var animate = function(){
        if(frame < frames){
            puff.css({
                backgroundPosition: "0 "+bgTop+"px"
            });
            bgTop = bgTop - frameSize;
            frame++;
            setTimeout(animate, frameRate);
        }
    };
    
    animate();
    setTimeout("$('#puff').hide()", frames * frameRate);
}
$(function() {
    
    $('span').click(function(e) {
        var xOffset = 24;
        var yOffset = 24;
        $(this).fadeOut('fast');
        
        $('#puff').css({
            left: e.pageX - xOffset + 'px',
            top: e.pageY - yOffset + 'px'
        }).show();
        animatePoof();
      $("#mess").fadeIn(1000).delay(2000).fadeOut();
     
  });   
});


$('#myLink').on("click", function (ev) {
  ev.preventDefault();                // prevent default anchor behavior
  const goTo = $(this).attr("href");  // store anchor href
       
  // do something while timeOut ticks ... 
       
  setTimeout(function(){
    window.location = goTo;
  }, 3000);                           // time in ms
}); 
</script>

<script type="text/javascript">
	var days = <?php echo $rDay; ?>  
	var hours = <?php echo $rHour; ?>  
	var minutes = <?php echo $rMin; ?>  
	var seconds = <?php echo $rSec; ?>  

  function countdown(){
  	seconds--;
  	if (seconds < 0){
  		minutes--;
  		seconds = 59
  	}
  	if (minutes < 0){
  		hours--;
  		minutes = 59
  	}
  	if (hours < 0){
  		days--;
  		hours = 23
  	}
  	
  	function pad(n) {
  		if ( n < 10 && n >= 0 ) {
  			return "0" + n;
  		} else {
  			return n;
  		}
  	}
  	
  	document.getElementById("countdown").innerHTML = pad(days)+":"+pad(hours)+":"+pad(minutes)+":"+pad(seconds);
  	setTimeout ( "countdown()", 1000 );
    
  }
</script>
</body>
</html>