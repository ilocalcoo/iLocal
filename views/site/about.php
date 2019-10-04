<?php

/* @var $this yii\web\View */

use app\assets\AboutAsset;

AboutAsset::register($this);
?>

<div class="row justify-content-center text-center">
	<h3>Места, акции и события рядом с тобой</h3>
</div>
<div class="row justify-content-center">
	<img src="img/about/notebook.png" alt="notebook" class="notebook">
</div>
<p class="row text-center">
	I’m Local помогает узнавать о местах, акциях и событиях поблизости напрямую от местного малого бизнеса и
	организаторов мероприятий. Это сервис для коммуникации между локальным бизнесом и людьми поблизости.
</p>
<div class="row">
	<div class="col-md-6 col-12	text-ellipse text-column">
		<h2 class="text-center">Узнавай первым!</h2>
		<br>
		<p class="text-center">Открывается рядом магазин, детский центр или аптека? Ты узнаешь об этом первым!</p>
	</div>
	<div class="col-md-6 col-12 phone">
		<img src="img/about/body.png" alt="body" class="phone-body">
		<img src="img/about/screen1.png" alt="screen" class="phone-screen">
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-12 phone mobile-order">
		<img src="img/about/body.png" alt="body" class="phone-body">
		<img src="img/about/screen3.png" alt="screen" class="phone-screen">
	</div>
	<div class="col-md-6 col-12 text-ellipse text-column">
		<h2 class="text-center">Загляни в афишу событий</h2>
		<br>
		<p class="text-center">Городской фестиваль или ярмарка на соседнем бульваре, бесплатные пробные занятия твоего
			любимого
			вида
			спорта или экскурсия с биологом в парке - следи за событиями для всей семьи.
		</p>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-12 text-ellipse text-column">
		<h2 class="text-center">Выбирай! Не пропускай!</h2>
		<br>
		<p class="text-center">Не хочешь пропустить большую распродажу детских товаров или камерную дегустацию c выгодными
			предложениями
			в винотеке поблизости? Акции подскажут, как с пользой распорядиться временем и деньгами.
		</p>
	</div>
	<div class="col-md-6 col-12 phone">
		<img src="img/about/body.png" alt="body" class="phone-body">
		<img src="img/about/screen2.png" alt="screen" class="phone-screen">
	</div>
</div>
<div class="row justify-content-center">
	<div class="col-md-8 col-12 text-ellipse mt-5">
		<h2 class="text-center">И ехать никуда не надо!</h2>
		<br>
		<p class="text-center">Задача платформы – сделать время, проведенное рядом с домом, комфортным и насыщенным,
			развивать
			инфраструктуру, помогая малому бизнесу быть востребованным и создавать качественные предложения
			для людей поблизости.
		</p>
	</div>
</div>
<div class="thanks text-center">
	<h3>Пройди опрос!</h3>
	<a class="typeform-share button text-center" href="https://ekaterina565236.typeform.com/to/XMTLLM" data-mode="popup"
		 style="display:inline-block;text-decoration:none;background-color:rgba(254, 138, 128, 0.9);color:white;
		 cursor:pointer;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:20px;text-align:center;
		 height:50px;padding:0px 33px;border-radius:25px;max-width:100%;white-space:nowrap;overflow:hidden;
		 text-overflow:ellipsis;font-weight:bold;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;"
		 target="_blank">НАЧАТЬ</a>
	<script> (function () {
      var qs, js, q, s, d = document, gi = d.getElementById, ce = d.createElement, gt = d.getElementsByTagName,
        id = "typef_orm_share", b = "https://embed.typeform.com/";
      if (!gi.call(d, id)) {
        js = ce.call(d, "script");
        js.id = id;
        js.src = b + "embed.js";
        q = gt.call(d, "script")[0];
        q.parentNode.insertBefore(js, q)
      }
    })() </script>
	<h3>Спасибо!</h3>
	<p>Есть, что сказать или возникли вопросы? Будем рады!</p>
	<div>hello@imlocal.ru</div>
</div>
<div class="back">
	<img src="img/about/ellipse1.svg" alt="ellipse1" class="spot spot1">
	<img src="img/about/ellipse2.svg" alt="ellipse2" class="spot spot2">
	<img src="img/about/ellipse3.svg" alt="ellipse3" class="spot spot3">
	<img src="img/about/ellipse4.svg" alt="ellipse4" class="spot spot4">
</div>
<div class="back-mobile"></div>


