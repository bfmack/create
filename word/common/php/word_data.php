<?php
$dsn='mysql:dbname=translate;host=localhost';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

$sql = 'SELECT MAX(WORD_KEY) AS max FROM word';
$stmt = $dbh->query($sql);
$stmt->execute();
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$max=$rec['max'];

$a=0;
$mw=0; //maxword

while($a<$max){
  $sql='SELECT WORD,TRANSLATE_WORD FROM word WHERE WORD_KEY=? AND SITUATION_ID=?';
  $stmt=$dbh->prepare($sql);
  $data[0]=++$a;
  $data[1]=$situation_key;
  $stmt->execute($data);

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

  if($rec==true){
	${"word".$mw}=$rec['WORD'];
	${"word_img".$mw}=$rec['TRANSLATE_WORD'];
	${"word_key".$mw}=$a;
	$mw++;
  }
}

$dbh=null;
?>
