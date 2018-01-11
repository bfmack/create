<?php
$dsn='mysql:dbname=translate;host=localhost';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

/* ---シチュエーションテーブルからのデータ取り出し--- */
for($no=1;;$no++){
  $sql='SELECT SITUATION,SITUATION_KEY,SITUATION_PATH FROM situation WHERE SITUATION_KEY=?';
  $stmt=$dbh->prepare($sql);
  $data[0]=$no;
  $stmt->execute($data);

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

  $nn=$no-1;

  ${"situation".$nn}=$rec['SITUATION'];
  ${"situation_key".$nn}=$rec['SITUATION_KEY'];
  ${"situation_img".$nn}=$rec['SITUATION_PATH'];
  if($rec==null) break;
}

for($no=0; ${"situation".$no} != NULL; $no++){
  print '<li><form method="post" name="wordlist" action="wordlist.php">';
  print '<input type="hidden" name="situation" value='.${"situation".$no}.'>';
  print '<input type="hidden" name="situation_key" value='.${"situation_key".$no}.'>';
  print '<input type="hidden" name="situation_img" value='.${"situation_img".$no}.'>';
  print '<a href="javascript:wordlist['.$no.'].submit()">'.${"situation".$no}.'</a>';
  print '</form></li>';
}
/* ---終了--- */

$dbh=null;
?>