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
		try{

		$language_id=$_GET['language_id'];

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql='SELECT LANGUAGE FROM language WHERE LANGUAGE_ID=?';
		$stmt=$dbh->prepare($sql);
		$data[]=$language_id;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$language=$rec['LANGUAGE'];

		$dbh=null;

		}
		catch(Exceptio $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}

		?>

		<h2>言語削除</h2>
		</nav>

		<div class="text-center">
		  <ul>
			<li>国名：　<?php print $language;?></li>
		  </ul>

		  <p>この言語を削除してよろしいですか？</p>

		  <form method="post" action="language_delete_done.php">
		  <input type="hidden" name="language_id" value="<?php print $language_id; ?>">
		  <input type="button" onclick="history.back()" value="戻る">
		  <input type="submit" value="OK">
		  </form>
		</div>
	  </div>


	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>