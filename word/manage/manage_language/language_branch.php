<?php

if(isset($_POST['disp'])==true)
{
	if(isset($_POST['language_id'])==false)
	{
		header('Location: ../manage_ng.php');
	}
	else
	{
		$language_id=$_POST['language_id'];
		header('Location: language_edit.php?language_id='.$language_id);
	}
}

if(isset($_POST['add'])==true)
{
	header('Location: language_add.html');
}

if(isset($_POST['delete'])==true)
{
	if(isset($_POST['language_id'])==false)
	{
		header('Location:../manage_ng.php');
	}else{
	$language_id=$_POST['language_id'];
	header('Location: language_delete.php?language_id='.$language_id);
	}
}

?>
