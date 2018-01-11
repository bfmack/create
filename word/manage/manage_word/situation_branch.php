<?php

if(isset($_POST['disp'])==true)
{
	if(isset($_POST['situation'])==false)
	{
		header('Location: ../manage_ng.php');
	}
	else
	{
		$situation=$_POST['situation'];
		header('Location: manage_word.php?situation='.$situation);
	}
}

if(isset($_POST['add'])==true)
{
	header('Location: situation_add.html');
}

if(isset($_POST['delete'])==true)
{
	if(isset($_POST['situation'])==false)
	{
		header('Location:../manage_ng.php');
	}else
	{
	$situation=$_POST['situation'];
	header('Location: situation_delete.php?situation='.$situation);
	}
}

?>
