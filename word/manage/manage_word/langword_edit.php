<!DOCTYPE HTML>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>多言語学習アプリ(管理画面)</title>
	<meta name="description" content="多言語学習アプリの管理ページです">

	<link rel="stylesheet" href="../../common/css/normalize.css">
	<link rel="stylesheet" href="../../common/css/style.css">

  </head>

  <body>

	<div id="page">
	  <header id="pageHead">
		<h1 id="siteTitle">多言語翻訳アプリ(管理画面)</h1>
	  </header>

	  <div id="pageBody">
		<nav class="mainNavi">
		<?php

		$word_key=$_POST['word_key'];
		$language=$_POST['language'];
		$word=$_POST['word']; 
		$word_lang=$_POST['word_lang'];

		print '<h2>修正('.$word.')</h2>';
		try{

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql='SELECT SOUND,TRANSLATE_WORD,SYMBOL FROM word WHERE LANGUAGE_ID=?';
		$stmt=$dbh->prepare($sql);
		$data[0]=$word_lang;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$translate=$rec['TRANSLATE_WORD'];
		$symbol=$rec['SYMBOL'];
		$sound=$rec['SOUND'];

		$dbh=null;
		}
		catch(Exceptio $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}

		?>

		<h3><?php print $language; ?></h3>

		<form method="post" action="langword_edit_check.php">
		  <input type="hidden" name="word_key" value="<?php print $word_key; ?>">
		  <input type="hidden" name="word_lang" value="<?php print $word_lang; ?>">
		  <input type="hidden" name="word" value="<?php print $word; ?>">
		  <input type="hidden" name="language" value="<?php print $langage; ?>">
		  <dt>翻訳言葉</dt>
		  <dd><input type="text" name="translate" style="width:500px" value="<?php print $translate; ?>"></dd>
		  <dt>発音</dt>
		  <dd><input type="text" name="symbol" style="width:500px" value="<?php print $symbol; ?>"></dd>
		  <dt>音声データ</dt>
		  <dd><input type="text" name="sound" style="width:500px" value="<?php if($sound != NULL) print $sound; ?>"></dd>

		  <input type="button" onclick="history.back()" value="戻る">
		  <input type="submit" value="OK">
		</form>

		</nav>
	  </div>
	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>