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

		print '<h2>修正言葉('.$_POST['word'].')</h2>';

		print '</nav>';

		$word_lang=$_POST['word_lang'];
		$language=$_POST['language'];
		$translate=$_POST['translate'];
		$symbol=$_POST['symbol'];
		$sound=$_POST['sound'];
		$word_key=$_POST['word_key'];

		$flag=0;

		if($translate == ''){
		  print '翻訳言葉が入力されていません。<br />';
		  $flag=1;
		}
		if($symbol == ''){
		  print '発音が入力されていません。<br />';
		  $flag=1;
		}

		if($flag == 0){
		  try{
			$dsn='mysql:dbname=translate;host=localhost';
			$user='root';
			$password='';
			$dbh=new PDO($dsn,$user,$password);
			$dbh->query('SET NAMES utf8');

			$sql='UPDATE word SET TRANSLATE_WORD=?,SYMBOL=?,SOUND=? WHERE WORD_KEY=?, LANGUAGE_ID=?';
			$stmt=$dbh->prepare($sql);
			$data[]=$translate;
			$data[]=$symbol;
			$data[]=$sound;
			$data[]=$word_key;
			$data[]=$word_lang;
			$stmt->execute($data);

			$dbh=null;

			print '<ul>';
			print '<li>翻訳言葉：'.$translate.'</li>';
			print '<li>発音：'.$symbol.'</li>';
			print '<li>音声データ：'.$sound.'</li>';
			print '</ul>';

			print '<p>修正しました。</p>';
			print '<a href="../manage_top.html">トップに戻る</a>';
		  }
		  catch(Exception $e){
			print 'ただいま障害により大変ご迷惑をおかけしております。';
			exit();
		  }
		}else{
			print '<form>';
			print '<input type="button" onclick="history.back()" value="戻る">';
			print '</form>';
		}
		?>


	  </div>
	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>