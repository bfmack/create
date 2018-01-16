<!DOCTYPE html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>あいさつの言葉（多言語学習アプリ）</title>
	<meta name="description" content="あいさつの言葉（多言語学習アプリ）のページです">

	<link rel="stylesheet" href="common/css/normalize.css">
	<link rel="stylesheet" href="common/css/style.css">

  </head>

  <body>
	<div id="page">
	  <header id="pageHead">
		<?php
		$situation_img=$_POST['situation_img'];
		$situation=$_POST['situation'];
		$situation_key=$_POST['situation_key'];
		?>

		<h1 id="siteTitle"><?php print $situation; ?></h1>
		<p id="subtitle"><?php print $situation; ?>の言葉をいろんな言語で表示するページです。</p>
		<nav class="globalNavi">
		  <ul>
			<li><a href="index.php">ホーム</a></li>
			<?php
			require('common/php/situation_data.php');
			require('common/php/word_data.php')
			?>
		  </ul>
		</nav>
	  </header>

	<p class="topicPath"><a href="index.php">ホーム</a> &gt; <?php print $situation; ?></p>


	  <div id="pageBody">
		<nav class="mainNavi">
		  <h2>言葉の選択</h2>
		  <ul>
			<?php

			if($mw==0){
			  print '関連ワードがまだありません';
			}

			for($no=0; $no<$mw; $no++){
			  if(${"word_img".$no}!=null){
				print '<li class="situation"><form method="post" name="translate'.$no.'" action="translate.php">';
				print '<input type="hidden" name="situation" value='.$situation.'>';
				print '<input type="hidden" name="situation_key" value='.$situation_key.'>';
				print '<input type="hidden" name="word" value='.${"word".$no}.'>';
				print '<input type="hidden" name="word_key" value='.${"word_key".$no}.'>';
				print '<input type="hidden" name="situation_img" value='.$situation_img.'>';
				print '<a href="javascript:document.translate'.$no.'.submit()"><img src="img/'.$situation_img.'/'.${"word_img".$no}.'.png" height=50 width=50><br>'.${"word".$no}.'</a>';
				print '</form></li>';
			  }
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