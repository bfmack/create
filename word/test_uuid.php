<?php
/* ��ӂ�ID�A���Ƃ��� 4b3403665fea6 */
printf("uniqid(): %s\r\n", uniqid());

//printf '<img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chl=uniqid()" alt="QR�R�[�h">';
/* ID�ɐړ��������邱�Ƃ��ł��܂��B����͎��̂悤�ɏ����̂�
 * �����ł�
 *
 * $uniqid = $prefix . uniqid();
 * $uniqid = uniqid($prefix);
 */
printf("uniqid('php_'): %s\r\n", uniqid('php_'));

/* more_entropy �p�����[�^���g���܂��BCygwin �Ȃǂ̃V�X�e����
 * �K�v�ƂȂ�ł��傤�B����́Auniqid() ����������l�����Ƃ���
 * 4b340550242239.64159797 �̂悤�Ȍ`���ɂ��܂��B
 */
printf("uniqid('', true): %s\r\n", uniqid('', true));

$a=uniqid();
print $a;
print '<img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chl='.$a.'" alt="QR�R�[�h">';
?>

<img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chl=http://allabout.co.jp/" alt="QR�R�[�h">
