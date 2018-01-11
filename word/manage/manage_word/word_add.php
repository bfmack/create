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

		$situation=$_GET['situation'];

		try{

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql = 'SELECT * FROM language';
		$stmt = $dbh->query($sql);
		$stmt->execute();
		$count=$stmt->rowCount(); //テーブルに登録している国の数

		$sql='SELECT SITUATION FROM situation WHERE SITUATION_ID=?';
		$stmt=$dbh->prepare($sql);
		$data[0]=$situation;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$situ=$rec['SITUATION'];

		print '<h2>追加('.$situ.')</h2>';

		print '<form method="post" action="word_add_check.php">';
		print '<dt>新規言葉</dt>';
		print '<dd><input type="text" name="word" style="width:500px" value=""></dd>';

		$b=1;
		while(1){
		  $sql='SELECT word_key FROM word WHERE WORD_KEY=?';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=$b;
		  $stmt->execute($data);

		  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

		 if($rec['word_key']==NULL){
			break;
		  }
		  $b++;
		}

		print '<input type="hidden" name="situation" value="'.$situation.'">';
		print '<input type="hidden" name="word_key" value="'.$b.'">';
		print '<input type="hidden" name="count" value="'.$count.'">';

		$a=0;
		while($count>$a){
			$a++;
			$sql='SELECT LANGUAGE FROM language WHERE LANGUAGE_ID=?';
			$stmt=$dbh->prepare($sql);
			$data[0]=$a;
			$stmt->execute($data);

			$rec=$stmt->fetch(PDO::FETCH_ASSOC);
			$language=$rec['LANGUAGE'];

			print '<input type="hidden" name="word_lang_'.$a.'" value="'.$a.'">';
			print '<input type="hidden" name="language_'.$a.'" value="'.$language.'">';
			print '<h3>'.$language.'</h3>';
			print '<dt>翻訳言葉</dt>';
			print '<dd><input type="text" name="translate_'.$a.'" style="width:500px" value=""></dd>';
			print '<dt>発音</dt>';
			print '<dd><input type="text" name="symbol_'.$a.'" style="width:500px" value=""></dd>';
			print '<dt>音声データ</dt>';
			print '<dd><input type="text" name="sound_'.$a.'" style="width:500px" value=""></dd>';

			print '<hr>';
		  }

		  print '<input type="button" onclick="history.back()" value="戻る">';
		  print '<input type="submit" value="OK">';
		print '</form>';

		$dbh=null;
		}
		catch(Exceptio $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}
		?>
		</nav>
	  </div>
	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>