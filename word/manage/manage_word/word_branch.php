<?php

if(isset($_POST['disp'])==true)
{
	if(isset($_POST['word_key'])==false)
	{
		header('Location: ../manage_ng.php');
	}
	else
	{
		$situation=$_POST['situation'];
		$word_key=$_POST['word_key'];
		header('Location: word_disp.php?word_key='.$word_key.'&situation='.$situation);
	}
}

if(isset($_POST['add'])==true)
{
	$situation=$_POST['situation'];
	header('Location: word_add.php?situation='.$situation);
}

if(isset($_POST['delete'])==true)
{
	if(isset($_POST['word_key'])==false)
	{
		header('Location:../manage_ng.php');
	}else{
	$word_key=$_POST['word_key'];
	header('Location: word_delete.php?word_key='.$word_key);
	}
}

?>
