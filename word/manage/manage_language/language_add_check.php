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

		$language=$_POST['language'];
		$national_flag=$_POST['national_flag'];

		print '<h2>言語追加('.$language.')</h2>';

		print '</nav>';

		$flag=0;

		if($language == ''){
		  print '国名が入力されていません。<br />';
		  $flag=1;
		}
		if($national_flag == ''){
		  print '国旗が入力されていません。<br />';
		  $flag=1;
		}

		if($flag == 0){
		  try{
			$dsn='mysql:dbname=translate;host=localhost';
			$user='root';
			$password='';
			$dbh=new PDO($dsn,$user,$password);
			$dbh->query('SET NAMES utf8');

			$sql='INSERT INTO language(LANGUAGE,NATIONAL_FLAG) VALUES(?,?)';
			$stmt=$dbh->prepare($sql);
			$data[]=$language;
			$data[]=$national_flag;
			$stmt->execute($data);

			$dbh=null;

			print '<ul>';
			print '<li>国名：'.$language.'</li>';
			print '<li>国旗：'.$national_flag.'</li>';
			print '</ul>';

			print '<p>追加しました。</p>';
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