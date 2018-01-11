<!DOCTYPE html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>多言語学習アプリ</title>
	<meta name="description" content="多言語学習アプリのページです">

	<link rel="stylesheet" href="../../common/css/normalize.css">
	<link rel="stylesheet" href="../../common/css/style.css">

  </head>

  <body>

	<div id="page">
	  <header id="pageHead">
		<h1 id="siteTitle">多言語翻訳アプリ(管理画面)</h1>
		<p id="subtitle">言語を管理する画面です。</p>
	  </header>

	  <div id="pageBody">
		  <nav class="mainNavi">
		  <h2 class="text-center">登録言語一覧</h2>
			<?php
			try{

			  $dsn='mysql:dbname=translate;host=localhost';
			  $user='root';
			  $password='';
			  $dbh=new PDO($dsn,$user,$password);
			  $dbh->query('SET_NAMES utf8');

			  $sql = 'SELECT * FROM language';
			  $stmt = $dbh->query($sql);
			  $stmt->execute();
			  $count=$stmt->rowCount(); //テーブルに登録している国の数

			  print '<form method="post" action="language_branch.php">';
			  $a=0;
			  $b=0;
			  while($count>$b){
				$sql='SELECT LANGUAGE FROM language WHERE LANGUAGE_ID=?';
				$stmt=$dbh->prepare($sql);
				$data[0]=++$a;
				$stmt->execute($data);

				$rec=$stmt->fetch(PDO::FETCH_ASSOC);
				if($rec==true){
				  print '<p style="margin-left:425px;"><input type="radio" name="language_id" value="'.$a.'">'.$rec['LANGUAGE'].'<br>';
				  $b++;
				}
			  }
			  $dbh=null;
			}
			catch(Exception $e)
			{
			  print 'ただいま障害により大変ご迷惑をおかけしております。';
			  exit();
			}
			?>

			<input type="submit" name="disp" value="参照">
			<input type="submit" name="add" value="追加">
			<input type="submit" name="delete" value="削除"></p>
			<p class="text-right"><input type="button" onclick="history.back()" value="戻る"></p>
			</form>
			

		  </nav>
	  </div>


	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>