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
		$word=$_POST['word'];
		$situation=$_POST['situation'];
		$count=$_POST['count'];

		print '<h2>追加言葉('.$word.')</h2>';
		print '</nav>';

		try{
		  $dsn='mysql:dbname=translate;host=localhost';
		  $user='root';
		  $password='';
		  $dbh=new PDO($dsn,$user,$password);
		  $dbh->query('SET NAMES utf8');

		  $a=0;
		  $pluss=0;

		  while($count>$a){
			$a++;
			$translate=$_POST['translate_'.$a.''];
			$symbol=$_POST['symbol_'.$a.''];
			$sound=$_POST['sound_'.$a.''];
			$language=$_POST['language_'.$a.''];

			if($translate!=null){
			  $sql='INSERT INTO word(SITUATION_ID,LANGUAGE_ID,WORD,SOUND,TRANSLATE_WORD,SYMBOL,WORD_KEY) VALUES(?,?,?,?,?,?,?)';
			  $stmt=$dbh->prepare($sql);
			  $data[0]=$situation;
			  $data[1]=$a;
			  $data[2]=$word;
			  $data[3]=$sound;
			  $data[4]=$translate;
			  $data[5]=$symbol;
			  $data[6]=$word_key; 
			  $stmt->execute($data);

			  print '<h3>'.$language.'</h3>';

			  print '<ul>';
			  print '<li>翻訳言葉：'.$translate.'</li>';
			  print '<li>発音：'.$symbol.'</li>';
			  print '<li>音声データ：'.$sound.'</li>';
			  print '</ul>';
			  print '<hr>';
			  $pluss++;
			}
		  }

		  $dbh=null;
		  if($pluss==0){
			print '<p>追加できませんでした。</p>';
		  }else{
			print '<p>追加しました。</p>';
		  }
		  print '<a href="../manage_top.html">トップに戻る</a>';
		}
		catch(Exception $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}
		?>


	  </div>
	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>