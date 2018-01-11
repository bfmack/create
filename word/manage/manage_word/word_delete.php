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

		$word_key=$_GET['word_key'];

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql='SELECT WORD FROM word WHERE WORD_KEY=?';
		$stmt=$dbh->prepare($sql);
		$data[]=$word_key;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$word=$rec['WORD'];

		$dbh=null;

		}
		catch(Exceptio $e){
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}

		?>

		<h2>言葉削除</h2>
		</nav>

		<div class="text-center">
		  <ul>
			<li>言葉：　<?php print $word;?></li>
		  </ul>

		  <p>この言葉をすべて削除してよろしいですか？</p>

		  <form method="post" action="word_delete_done.php">
		  <input type="hidden" name="word_key" value="<?php print $word_key; ?>">
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