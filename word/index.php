<!DOCTYPE html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>多言語学習アプリ</title>
	<meta name="description" content="多言語学習アプリのページです">

	<link rel="stylesheet" href="common/css/normalize.css">
	<link rel="stylesheet" href="common/css/style.css">

  </head>

  <body>
	<div id="page">
	  <header id="pageHead">
		<h1 id="siteTitle">多言語翻訳アプリ</h1>
		<p id="subtitle">状況にあわせたことばをいろんな言語で表示するアプリです。</p>
		<nav class="globalNavi">
		  <ul>
		  <li><a href="#">ホーム</a></li>
		  <?php
		  require('common/php/situation_data.php');
		  ?>
		  </ul>
		</nav>
	  </header>

	  <p class="topicPath">ホーム</p>

	  <div id="pageBody">
		  <nav class="mainNavi">
		  <h2>シチュエーション選択</h2>
		  <ul>
			<?php
			for($no=0; ${"situation".$no} != NULL; $no++){
			  print '<li><form method="post" name="wordlist" action="wordlist.php">';
			  print '<input type="hidden" name="situation" value='.${"situation".$no}.'>';
			  print '<input type="hidden" name="situation_key" value='.${"situation_key".$no}.'>';
			  print '<input type="hidden" name="situation_img" value='.${"situation_img".$no}.'>';
			  print '<a href="javascript:wordlist['.$no.'].submit()"><img src="img/situation/'.${"situation_img".$no}.'.png" alt="" width=300 height=250></a>';
			  print '</form></li>';
			}
			?>
		  </ul>

		  </nav>
	  </div>


	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>