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

		$language_id=$_GET['language_id'];

		try{

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql='SELECT LANGUAGE,NATIONAL_FLAG FROM language WHERE LANGUAGE_ID=?';
		$stmt=$dbh->prepare($sql);
		$data[0]=$language_id;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$language=$rec['LANGUAGE'];
		$national_flag=$rec['NATIONAL_FLAG'];

		$dbh=null;

		print '<h2>修正('.$language.')</h2>';
		}
		catch(Exceptio $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}

		?>

		<h3><?php print $language; ?></h3>

		<form method="post" action="language_edit_check.php">
		  <input type="hidden" name="language_id" value="<?php print $langage_id; ?>">
		  <dt>国名</dt>
		  <dd><input type="text" name="language" style="width:500px" value="<?php print $language; ?>"></dd>
		  <dt>国旗</dt>
		  <dd><input type="text" name="national_flag" style="width:500px" value="<?php print $national_flag; ?>"></dd>

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