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

		$situation=$_POST['situation'];
		$situation_path=$_POST['situation_path'];

		print '<h2>シチュエーション追加</h2>';
		print '</nav>';

		try{
		  $dsn='mysql:dbname=translate;host=localhost';
		  $user='root';
		  $password='';
		  $dbh=new PDO($dsn,$user,$password);
		  $dbh->query('SET NAMES utf8');

		  $a=1;
		  while(1){
			$sql='SELECT SITUATION_KEY FROM situation WHERE SITUATION_KEY=?';
			$stmt=$dbh->prepare($sql);
			$data[0]=$a;
			$stmt->execute($data);

			$rec=$stmt->fetch(PDO::FETCH_ASSOC);

			if($rec['SITUATION_KEY']==NULL){
			  break;
			}
			$a++;
		  }

		  $sql='INSERT INTO situation(SITUATION,SITUATION_KEY,SITUATION_PATH) VALUES(?,?,?)';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=$situation;
		  $data[1]=$a;
		  $data[2]=$situation_path;
		  $stmt->execute($data);

		  print '<ul>';
		  print '<li>シチュエーション：'.$situation.'</li>';
		  print '<li>シチュエーションパス：'.$situation_path.'</li>';
		  print '</ul>';

		  print '<hr>';

		  $dbh=null;
		  print '<p>追加しました。</p>';
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