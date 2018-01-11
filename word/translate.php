<!DOCTYPE html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>多言語学習アプリ</title>
	<meta name="description" content="こんにちは！（多言語学習アプリ）のページです">

	<link rel="stylesheet" href="common/css/normalize.css">
	<link rel="stylesheet" href="common/css/style.css">

	<script type="text/javascript" src="common/js/fade.js"></script>

  </head>

  <body>
	<div id="page">
	  <header id="pageHead">
		<h1 id="siteTitle">多言語翻訳アプリ</h1>
		<p id="subtitle">状況にあわせたことばをいろんな言語で表示するアプリです。</p>
		<nav class="globalNavi">
		  <ul>
		  <li><a href="#">ホーム</a></li>
		  <?php
		  $situation=$_POST['situation'];
		  $situation_key=$_POST['situation_key'];
		  $word=$_POST['word'];
		  $word_key=$_POST['word_key'];
		  $situation_img=$_POST['situation_img'];
		  require('common/php/situation_data.php');
		  require('common/php/word_data.php');
		  ?>
		  </ul>
		</nav>
	  </header>

	<p class="topicPath"><a href="index.php">ホーム</a> &gt; <a href="javascript:wordlist_path.submit()"><?php print $situation; ?></a> &gt;<?php print $word; ?>！</p>
	<?php print '<form method="post" name="wordlist_path" action="wordlist.php">';
	print '<input type="hidden" name="situation" value='.$situation.'>';
	print '<input type="hidden" name="situation_key" value='.$situation_key.'>';
	print '<input type="hidden" name="situation_img" value='.$situation_img.'>';
	print '</form>';
	?>

	  <div id="pageBody">
		<div id="pageBodyMain">

			<figure class="relative">
			  <img src="img/translate/collorfull-circle.png" alt="" width="500" height="500">

		<?php
		try
		{
		/*---テーブルからデータの取り出し---*/
		$dsn='mysql:dbname=translate;host=localhost';
		$user='root';
		$password='';
		$dbh=new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql = 'SELECT * FROM language';
		$stmt = $dbh->query($sql);
		$stmt->execute();
		$count=$stmt->rowCount(); //テーブルに登録している国の数

		/*---翻訳部分の各位置に値を入れる---*/
		if(isset($_POST['country'])){
			$top_id = $_POST['country'];
			$right_id = $_POST['top_id'];
			$left_id = $_POST['bottom_id'];
			$bottom_id = $_POST['right_id'];
			$point = $_POST['point'];
			for($a=5; $a<=$count; $a++){
			  if($a==$point){
				${"cou".$a} = $_POST['left_id'];
			  }else if($a < $point){
				${"cou".$a} = $_POST[$a];
			  }else{
				$b=$a-1;
				${"cou".$a} = $_POST[$b];
			  }
			}

		}else{
		  $top_id=1;
		  $right_id=2;
		  $bottom_id=3;
		  $left_id=4;
		  for($a=5; $a<=$count; $a++){
			${"cou".$a}=$a;
		  }
		}
		/*---終了(翻訳部分の各位置に値を入れる)---*/

		/*---言語選択の配置別データ取り出し---*/
		for($a=5;$a<=$count;$a++){
		  $sql='SELECT NATIONAL_FLAG FROM language WHERE LANGUAGE_ID=? OR LANGUAGE=?';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=${"cou".$a};
		  $data[1]=999999999999999;
		  $stmt->execute($data);

		  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

		  ${"couflag".$a}=$rec['NATIONAL_FLAG'];
		}
		/*---終了(言語選択の配置別データ取り出し)---*/

		/*---位置別のデータ取り出し---*/
		for($a=0; $a<4; $a++){

		/*---取り出すデータの位置情報を決定---*/
		  switch($a){
			case '0':
			  $pos="top";
			  break;
			case '1':
			  $pos="right";
			  break;
			case '2':
			  $pos="left";
			  break;
			case '3':
			  $pos="bottom";
			  break;
		  }
		/*---終了(取り出すデータの位置情報を決定)---*/

		  $sql='SELECT SITUATION_ID,LANGUAGE_ID,WORD,SOUND,TRANSLATE_WORD,SYMBOL FROM word WHERE LANGUAGE_ID=? AND WORD_KEY=?';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=${$pos."_id"};
		  $data[1]=$word_key;
		  $stmt->execute($data);

		  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

		  $word=$rec['WORD'];
		  ${$pos."_language"}=$rec['LANGUAGE_ID'];
		  ${$pos."_translate"}=$rec['TRANSLATE_WORD'];
		  ${$pos."_sound"}=$rec['SOUND'];
		  ${$pos."_symbol"}=$rec['SYMBOL'];

		  $sql='SELECT LANGUAGE,NATIONAL_FLAG FROM language WHERE LANGUAGE_ID=? OR LANGUAGE=?';
		  $stmt=$dbh->prepare($sql);
		  $data[0]=${$pos."_language"};
		  $data[1]=999999999999;
		  $stmt->execute($data);

		  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

		  ${$pos."_country"}=$rec['LANGUAGE'];
		  ${$pos."_flag"}=$rec['NATIONAL_FLAG'];

		  print '<div class="absolute-'.$pos.'">';
		  print '<img src="img/translate/human.png" alt="" class="human" width="100" height="100" onclick="btn_'.$pos.'()">';
		  print '<img src="img/translate/world/'.${$pos."_flag"}.'" alt="" class="country" width="70" height="35" onclick="btn_'.$pos.'()">';
		  if($pos=="top"){
			print '<h2 class="string">NEW</h2>';
		  }
		  print '<div class="display_'.$pos.'" id="display_'.$pos.'">';
		  print '<img src="img/translate/comment.png" id="fade_'.$pos.'_img" alt="" class="wordbox" width="150" height="80">';
		  print '<figcaption class="word"><p>'.${$pos."_translate"}.'</p></figcaption>';
		  print '</div>';
		  print '<audio id="sound_'.$pos.'" preload="auto">';
		  print '<source src="sound/'.$top_sound.'" type="audio/wav">';
		  print '</audio>';
		  print '</div>';
		}
		/*---終了(位置別のデータ取り出し)---*/

		$dbh=null;
		}
		/*---終了(データの取り出し)---*/

		catch(Exception $e)
		{
			print 'ただいま障害により大変ご迷惑をおかけしております。';
			exit();
		}
		?>
			  <div class="absolute-center">
				<p id="cen_fir">クリックした国の<br><strong>「<?php print $word; ?>」</strong><br>を表示します。</p>
				<div id="cen_top" class="center">
				  <p class="cen_country"><?php print $top_country; ?></p>
				  <p class="cen_word"><?php print $word; ?></p>
				  <p class="cen_sym">[発音]<?php print $top_symbol; ?></p>
				</div>
				<div id="cen_lef" class="center">
				  <p class="cen_country"><?php print $left_country; ?></p>
				  <p class="cen_word"><?php print $word; ?></p>
				  <p class="cen_sym">[発音]<?php print $left_symbol; ?></p>
				</div>
				<div id="cen_rig" class="center">
				  <p class="cen_country"><?php print $right_country; ?></p>
				  <p class="cen_word"><?php print $word; ?></p>
				  <p class="cen_sym">[発音]<?php print $right_symbol; ?></p>
				</div>
				<div id="cen_bot" class="center">
				  <p class="cen_country"><?php print $bottom_country; ?></p>
				  <p class="cen_word"><?php print $word; ?></p>
				  <p class="cen_sym">[発音]<?php print $bottom_symbol; ?></p>
				</div>
			  </div>
			</figure>

		</div>

		<div id="pageBodySub">
		  <nav class="choice">
			<h2>言語選択</h2>
			<ul class="Laria">
			<?php
			$x=round(($count-4)/2); //選択国数を２で割って整数化(切り捨て)
			  for($a=1; $a<=$x; $a++){
				$ch=$a+4; //表示位置
				$b=${"cou".$ch};
				$point = $ch;
				print '<form method="post" action="translate.php">';
				print '<input type="hidden" name="top_id" value="'.$top_id.'">';
				print '<input type="hidden" name="right_id" value="'.$right_id.'">';
				print '<input type="hidden" name="left_id" value="'.$left_id.'">';
				print '<input type="hidden" name="bottom_id" value="'.$bottom_id.'">';
				print '<input type="hidden" name="country" value="'.$b.'">';
				print '<input type="hidden" name="point" value="'.$point.'">';
				print '<input type="hidden" name="situation" value='.$situation.'>';
				print '<input type="hidden" name="situation_key" value='.$situation_key.'>';
				print '<input type="hidden" name="word" value='.$word.'>';
				print '<input type="hidden" name="word_key" value='.$word_key.'>';
				print '<input type="hidden" name="situation_img" value='.$situation_img.'>';
				for($c=5; $c<$count; $c++){
				  $de=$c;
				  if($ch<=$de)  $de++;
				  print '<input type="hidden" name="'.$c.'" value="'.${"cou".$de}.'">';
				}
				print '<input type="image" src="img/translate/world/'.${"couflag".$ch}.'" alt="" width="50" height="35">';
				print'</form>';
			  }
			?>
						</ul>
						<ul class="Raria">
			<?php
			$x=round(($count-4)/2-0.5); //選択国数を２で割って整数化(切り上げ)
			  for($a=1; $a<=$x; $a++){
				$ch=$a+4+$x;
				$b=${"cou".$ch};
				$point = $ch;
				print '<form method="post" action="translate.php">';
				print '<input type="hidden" name="top_id" value="'.$top_id.'">';
				print '<input type="hidden" name="right_id" value="'.$right_id.'">';
				print '<input type="hidden" name="left_id" value="'.$left_id.'">';
				print '<input type="hidden" name="bottom_id" value="'.$bottom_id.'">';
				print '<input type="hidden" name="country" value="'.$b.'">';
				print '<input type="hidden" name="point" value="'.$point.'">';
				print '<input type="hidden" name="situation" value='.$situation.'>';
				print '<input type="hidden" name="situation_key" value='.$situation_key.'>';
				print '<input type="hidden" name="word" value='.$word.'>';
				print '<input type="hidden" name="word_key" value='.$word_key.'>';
				print '<input type="hidden" name="situation_img" value='.$situation_img.'>';
				for($c=5; $c<$count; $c++){
				  $de=$c;
				  if($ch<=$de)  $de++;
				  print '<input type="hidden" name="'.$c.'" value="'.${"cou".$de}.'">';
				}
				print '<input type="image" src="img/translate/world/'.${"couflag".$ch}.'" alt="" width="50" height="35">';
				print'</form>';
			  }
			?>
			</ul>

			<h2>関連ワード</h2>
			<ul>
			<?php

			if($mw==0){
			  print '関連ワードがまだありません';
			}
			for($no=0; $no<$mw; $no++){
			  if(${"wordURL".$no}!=null){
				print '<li class="situation"><form method="post" name="translate" action="translate.php">';
				print '<input type="hidden" name="situation" value='.$situation.'>';
				print '<input type="hidden" name="situation_key" value='.$situation_key.'>';
				print '<input type="hidden" name="word" value='.${"word".$no}.'>';
				print '<input type="hidden" name="word_key" value='.${"word_key".$no}.'>';
				print '<input type="hidden" name="situation_img" value='.$situation_img.'>';
				print '<a href="javascript:translate['.$no.'].submit()">'.${"word".$no}.'</a>';
				print '</form></li>';
			  }
			}
			?>
			</ul>
		  </nav>

		</div>
	  </div>


	  <footer id="pageFoot">
		<p id="copyright"><small>Copyright&copy; 2017 @makino_yu All Rights Reserved.</small></p>
	  </footer>
	
	</div>

  </body>
</html>