<?php
/* 一意なID、たとえば 4b3403665fea6 */
printf("uniqid(): %s\r\n", uniqid());

//printf '<img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chl=uniqid()" alt="QRコード">';
/* IDに接頭辞をつけることもできます。これは次のように書くのと
 * 同じです
 *
 * $uniqid = $prefix . uniqid();
 * $uniqid = uniqid($prefix);
 */
printf("uniqid('php_'): %s\r\n", uniqid('php_'));

/* more_entropy パラメータも使えます。Cygwin などのシステムで
 * 必要となるでしょう。これは、uniqid() が生成する値をたとえば
 * 4b340550242239.64159797 のような形式にします。
 */
printf("uniqid('', true): %s\r\n", uniqid('', true));

$a=uniqid();
print $a;
print '<img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chl='.$a.'" alt="QRコード">';
?>

<img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chl=http://allabout.co.jp/" alt="QRコード">
