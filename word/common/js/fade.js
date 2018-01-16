  var str = "fdb975313579bdf";
  var itv = 250; // 色を変化させる間隔(ミリ秒単位)
  var cnt = 0;
  var opa = 0;

// topのボタン要素
function btn_top() {
  display_top.style.display="block";
  document.getElementById( 'sound_top' ).play() ;
  printword("top");
  fade("display_top", "fade_top_img");
}

// leftのボタン要素
function btn_left() {
  display_left.style.display="block";
  document.getElementById( 'sound_left' ).play() ;
  printword("left");
  fade("display_left", "fade_left_img");
}

// rightのボタン要素
function btn_right() {
  display_right.style.display="block";
  document.getElementById( 'sound_right' ).play() ;
  printword("right");
  fade("display_right", "fade_right_img");
}

// bottomのボタン要素
function btn_bottom() {
  display_bottom.style.display="block";
  document.getElementById( 'sound_bottom' ).play() ;
  printword("bottom")
  fade("display_bottom", "fade_bottom_img");
}

// fade関数
function fade(Word, Img){
  c = str.charAt(cnt++);
  document.getElementById(Word).style.color = "#"+c+c+c+c+c+c;
  document.getElementById(Img).style.filter = "alpha(opacity:"+opa+")";
  document.getElementById(Img).style.opacity = opa/100;
  if(opa < 100){
	opa += 13;
  }else{
	opa -= 13;
  }
  if(cnt < str.length) {
	setTimeout("fade('" +Word+ "' , '" +Img+ "')",itv);
  }
  if(cnt == str.length) {
	cnt = 0;
	document.getElementById(Word).style.display="none";
  }
}

function printword(pos){
  document.getElementById("cen_fir").style.display = "none";
  document.getElementById("cen_top").style.display = "none";
  document.getElementById("cen_lef").style.display = "none";
  document.getElementById("cen_rig").style.display = "none";
  document.getElementById("cen_bot").style.display = "none";
  document.getElementById("cen_" +pos).style.display = "block";
}
