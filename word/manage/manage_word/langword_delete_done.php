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
		  <h2>言葉削除</h2>
		</nav>

		<?php
		try{

		$word_id=$_POST['word_id'];

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql='DELETE FROM word WHERE WORD_ID=?';
		$stmt=$dbh->prepare($sql);
		$data[]=$word_id;
		$stmt->execute($data);

		$dbh=null;
		}

		catch(Exception $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}
		?>

		<p>削除しました。</p>
		<a href="../manage_top.html">戻る</a>

	  </div>

	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>