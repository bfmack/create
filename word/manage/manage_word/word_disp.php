<!DOCTYPE html>
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
		$situation=$_GET['situation'];

		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql='SELECT WORD FROM word WHERE WORD_KEY=?';
		$stmt=$dbh->prepare($sql);
		$data[0]=$word_key;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);

		$word=$rec['WORD'];
		print '<h2>言葉一覧('.$word.')</h2>';

		$sql = 'SELECT * FROM language';
		$stmt = $dbh->query($sql);
		$stmt->execute();
		$count=$stmt->rowCount(); //テーブルに登録している国の数

		$a=0;
		while($count>$a){
		  $a++;
		  $sql='SELECT SOUND,TRANSLATE_WORD,SYMBOL FROM word WHERE WORD_KEY=? AND LANGUAGE_ID=?';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=$word_key;
		  $data[1]=$a;
		  $stmt->execute($data);

		  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

		  $translate=$rec['TRANSLATE_WORD'];
		  $symbol=$rec['SYMBOL'];
		  $sound=$rec['SOUND'];

		  $sql='SELECT LANGUAGE FROM language WHERE LANGUAGE_ID=? OR LANGUAGE=?';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=$a;
		  $data[1]=$a;
		  $stmt->execute($data);

		  $rec=$stmt->fetch(PDO::FETCH_ASSOC);
		  $language=$rec['LANGUAGE'];

		  if($translate==false){
			print '<p>＊'.$language.'の「'.$word.'」はまだ登録されていません。</p>';
			print '<div class="text-right">';
			print '<form method="post" action="langword_add.php">';
			print '<input type="hidden" name="situation" value="'.$situation.'">';
			print '<input type="hidden" name="word_key" value="'.$word_key.'">';
			print '<input type="hidden" name="language" value="'.$language.'">';
			print '<input type="hidden" name="word_lang" value="'.$a.'">';
			print '<input type="hidden" name="word" value="'.$word.'">';
			print '<input type="submit" value="追加">';
			print '</form>';
			print '</div>';
		  }else{
			print '<table>';
			  print '<tr><th>'.$language.'</th></tr>';
			  print '<tr><td>翻訳言語</td><td>'.$translate.'</td></tr>';
			  print '<tr><td>翻訳</td><td>'.$symbol.'</td></tr>';
			  if($sound != NULL) print '<tr><td>音声データ</td><td>'.$sound.'</td></tr>';
			print '</table>';

			print '<div class="text-right">';
			  print '<form method="post" action="langword_edit.php">';
				print '<input type="hidden" name="word_key" value="'.$word_key.'">';
				print '<input type="hidden" name="language" value="'.$language.'">';
				print '<input type="hidden" name="word_lang" value="'.$a.'">';
				print '<input type="hidden" name="word" value="'.$word.'">';
				print '<input type="submit" value="修正">';
			  print '</form>';
			  print '<form method="post" action="langword_delete.php">';
				print '<input type="hidden" name="word_key" value="'.$word_key.'">';
				print '<input type="hidden" name="language" value="'.$language.'">';
				print '<input type="hidden" name="word_lang" value="'.$a.'">';
				print '<input type="hidden" name="word" value="'.$word.'">';
				print '<input type="submit" value="削除">';
			  print '</form>';
			print '</div>';
		  }
		  print '<hr>';
		}

		$dbh=null;
		}
		catch(Exceptio $e)
		{
		  print 'ただいま障害により大変ご迷惑をおかけしております。';
		  exit();
		}
		?>

		<form>
		  <input type="button" onclick="history.back()" value="戻る">
		</form>
		</nav>
	  </div>


	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>