import java.net.*;
import java.io.*;
import javax.swing.*;
import java.lang.*;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.util.*;

public class MyClient extends JFrame implements MouseListener,MouseMotionListener {
	private JButton buttonArray[][], button[][],bs;//ボタン用の配列
	private int myColor;
	private int myTurn;
	private ImageIcon myIcon, yourIcon, blueIcon, numberIcon, gameIcon;
	private Container c;
	private ImageIcon blackIcon, whiteIcon, boardIcon, myname, enemyname, myname_turn, enemyname_turn, bbs;
	private ImageIcon number_0, vs, number_2;
	PrintWriter out;//出力用のライター
	JTextField tfKeyin;//メッセージ入力用テキストフィールド
	JTextArea taMain;//テキストエリア
	String myName;//名前を保存
	int cc, con = 0;
	int rm=0;
	int re=0;

	public MyClient() {
		//名前の入力ダイアログを開く
		String myName = JOptionPane.showInputDialog(null,"名前を入力してください","名前の入力",JOptionPane.QUESTION_MESSAGE);
		if(myName.equals("")){
			myName = "No name";//名前がないときは，"No name"とする
		}

		//サーバーのIPアドレスの入力ダイアログ
		String adress = JOptionPane.showInputDialog(null,"IPアドレスを入力してください","IPアドレスの入力",JOptionPane.QUESTION_MESSAGE);
		if(adress.equals("")){
			adress = "localhost";
		}
		
		//ウィンドウを作成する
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);//ウィンドウを閉じるときに，正しく閉じるように設定する
		setTitle("game");//ウィンドウのタイトルを設定する
		setSize(700, 630);//ウィンドウのサイズを設定する
		c = getContentPane();//フレームのペインを取得する

		//アイコンの設定
		whiteIcon = new ImageIcon("image/frame/white-panda.jpg");
		blackIcon = new ImageIcon("image/frame/black-panda.jpg");
		boardIcon = new ImageIcon("image/frame/GreenFrame.jpg");
		blueIcon = new ImageIcon("image/frame/blue.jpg");
		myname = new ImageIcon("image/face/white-panda-sleep.jpg");
		myname_turn = new ImageIcon("image/face/white-panda.jpg");
		enemyname = new ImageIcon("image/face/black-panda-sleep.jpg");
		enemyname_turn = new ImageIcon("image/face/black-panda.jpg");
		bbs = new ImageIcon("image/send.jpg");
		number_0 = new ImageIcon("image/number/0.jpg");
		vs = new ImageIcon("image/number/---.jpg");
		gameIcon = new ImageIcon("image/top/game-name.jpg");
		number_2 = new ImageIcon("image/number/2.jpg");
		
		c.setLayout(null);//自動レイアウトの設定を行わない
		//ボタンの生成
		buttonArray = new JButton[8][8];//ボタンの配列を５個作成する[0]から[4]まで使える
		for(int i=0;i<8;i++){
			for(int j=0;j<8;j++){
				if((i==3&&j==3)||(i==4&&j==4)){
					buttonArray[i][j] = new JButton(whiteIcon);
				}else if((i==3&&j==4)||(i==4&&j==3)){
					buttonArray[i][j] = new JButton(blackIcon);
				}else{
					buttonArray[i][j] = new JButton(boardIcon);//ボタンにアイコンを設定する
				}
				c.add(buttonArray[i][j]);//ペインに貼り付ける
				buttonArray[i][j].setBounds(i*45+10,j*45+220,45,45);//ボタンの大きさと位置を設定する．(x座標，y座標,xの幅,yの幅）
				buttonArray[i][j].addMouseListener(this);//ボタンをマウスでさわったときに反応するようにする
				buttonArray[i][j].addMouseMotionListener(this);//ボタンをマウスで動かそうとしたときに反応するようにする
				buttonArray[i][j].setActionCommand(Integer.toString(i+j*8));//ボタンに配列の情報を付加する（ネットワークを介してオブジェクトを識別するため）
			}
		}
		
		button = new JButton[8][8];
		button[0][0] = new JButton(myname);
		c.add(button[0][0]);
		button[0][0].setBounds(390, 220, 120, 120);
		
		button[0][1] = new JButton(enemyname);
		c.add(button[0][1]);
		button[0][1].setBounds(540, 220, 120, 120);
		
		button[1][0] = new JButton(number_0);
		c.add(button[1][0]);
		button[1][0].setBounds(420, 350, 30, 30);
		
		button[1][1] = new JButton(number_2);
		c.add(button[1][1]);
		button[1][1].setBounds(450, 350, 30, 30);
		
		button[1][2] = new JButton(number_0);
		c.add(button[1][2]);
		button[1][2].setBounds(570, 350, 30, 30);
		
		button[1][3] = new JButton(number_2);
		c.add(button[1][3]);
		button[1][3].setBounds(600, 350, 30, 30);
		
		button[1][4] = new JButton(vs);
		c.add(button[1][4]);
		button[1][4].setBounds(520, 350, 15, 30);
		
		button[2][0] = new JButton(gameIcon);
		c.add(button[2][0]);
		button[2][0].setBounds(10, 10, 650, 200);
		
		//チャット画面を作成する
		tfKeyin = new JTextField("",42);//入力用のテキストフィールドを作成
		c.add(tfKeyin);//コンテナに追加
		bs = new JButton(bbs);
		c.add(bs);//ボタンをコンテナに追加
		tfKeyin.setBounds(390, 400, 200, 20);
		bs.setBounds(600, 400, 50, 20);
		bs.addMouseListener(this);//ボタンを押したときの動作するようにする
		taMain = new JTextArea(20,50);//チャットの出力用のフィールドを作成
		c.add(taMain);//コンテナに追加
		taMain.setBounds(390, 430, 270, 130);
		taMain.setEditable(false);//編集不可にする
		
		//サーバに接続する
		Socket socket = null;
		try {
			//"localhost"は，自分内部への接続．localhostを接続先のIP Address（"133.42.155.201"形式）に設定すると他のPCのサーバと通信できる
			//10000はポート番号．IP Addressで接続するPCを決めて，ポート番号でそのPC上動作するプログラムを特定する
			socket = new Socket(adress, 10000);

		} catch (UnknownHostException e) {
			System.err.println("ホストの IP アドレスが判定できません: " + e);
		} catch (IOException e) {
			 System.err.println("エラーが発生しました: " + e);
		}
		
		MesgRecvThread mrt = new MesgRecvThread(socket, myName);//受信用のスレッドを作成する
		mrt.start();//スレッドを動かす（Runが動く）
	}
		
	//メッセージ受信のためのスレッド
	public class MesgRecvThread extends Thread {
		
		Socket socket;
		String myName;
		
		public MesgRecvThread(Socket s, String n){
			socket = s;
			myName = n;
		}
		
		//通信状況を監視し，受信データによって動作する
		public void run() {
			try{
				InputStreamReader sisr = new InputStreamReader(socket.getInputStream());
				BufferedReader br = new BufferedReader(sisr);
				out = new PrintWriter(socket.getOutputStream(), true);
				out.println(myName);//接続の最初に名前を送る
				String myNumberStr = br.readLine();
				
				int myNumberInt = Integer.parseInt(myNumberStr);
				
				if(myNumberInt % 2 == 0){
					myColor = 0;
					myIcon = blackIcon;
					yourIcon = whiteIcon;
				}else{
					myColor = 1;
					myIcon = whiteIcon;
					yourIcon = blackIcon;
				}
				
				myTurn = 0;
				
				if(myTurn % 2 == myColor){
					taMain.append("my color is black!!\n");
					button[0][0].setIcon(myname);
					button[0][1].setIcon(enemyname_turn);
					for(int i=0;i<8;i++){
						for(int j=0;j<8;j++){
							Icon searchIcon = buttonArray[i][j].getIcon();
							if(searchIcon.equals(yourIcon)){
								finishJudge(i,j);											
							}
						}
					}
				}else{
					taMain.append("my color is white!!\n");
					button[0][0].setIcon(myname);
					button[0][1].setIcon(enemyname_turn);
				}
				
				
				while(true) {
					String inputLine = br.readLine();//データを一行分だけ読み込んでみる
					if (inputLine != null) {//読み込んだときにデータが読み込まれたかどうかをチェックする
						//System.out.println(inputLine);//デバッグ（動作確認用）にコンソールに出力する
						String[] inputTokens = inputLine.split(" ");	//入力データを解析するために、スペースで切り分ける
						String cmd = inputTokens[0];//コマンドの取り出し．１つ目の要素を取り出す
						
						if(cmd.equals("FLIP")){
							int x = Integer.parseInt(inputTokens[1]);
							int y = Integer.parseInt(inputTokens[2]);
							int ButtonColor = Integer.parseInt(inputTokens[3]);
							if(ButtonColor == myColor){
								buttonArray[x][y].setIcon(myIcon);
							}else{
								buttonArray[x][y].setIcon(yourIcon);
							}
						}
						
						if(cmd.equals("coment")){
							int comena = Integer.parseInt(inputTokens[2]);
							if (inputTokens[1] != null) {
								if(comena == myColor){
									taMain.append("my coment>");
								}else{
									taMain.append("enemy coment>");
								}
								taMain.append(inputTokens[1]+"\n");//メッセージの内容を出力用テキストに追加する
							}
							else{
								break;
							}
						}
						
						if(cmd.equals("Click")){//cmdの文字と"Click"が同じか調べる．同じ時にtrueとなる						
							int theBnum = Integer.parseInt(inputTokens[1]);//ボタンの名前を数値に変換する
							int ButtonColor = Integer.parseInt(inputTokens[2]);
							int Turn = Integer.parseInt(inputTokens[3]);
							rm = 0;
							re = 0;
							myTurn = ++Turn;
							
							for(int i=0;i<8;i++){
								for(int j=0;j<8;j++){
									Icon searchIcon = buttonArray[i][j].getIcon();
									if(searchIcon.equals(blueIcon)){
										buttonArray[i][j].setIcon(boardIcon);
									}
								}
							}
							
							if(ButtonColor == myColor){
								buttonArray[theBnum%8][theBnum/8].setIcon(myIcon);
							}else{
								buttonArray[theBnum%8][theBnum/8].setIcon(yourIcon);
							}
							
							if((myTurn+con) % 2 == myColor){
								for(int i=0;i<8;i++){
									for(int j=0;j<8;j++){
										Icon searchIcon = buttonArray[i][j].getIcon();
										if(searchIcon.equals(myIcon)){
											rm++;	
										}else if(searchIcon.equals(yourIcon)){
											re++;
										}
										if(searchIcon.equals(yourIcon)){
											finishJudge(i,j);								
										}
									}
								}
								if((myTurn+con) % 2 == 0){
									numberIcon = new ImageIcon("image/number/"+(re/10)+".jpg");
									button[1][0].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(re%10)+".jpg");
									button[1][1].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(rm/10)+".jpg");
									button[1][2].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(rm%10)+".jpg");
									button[1][3].setIcon(numberIcon);
								}else{
									numberIcon = new ImageIcon("image/number/"+(rm/10)+".jpg");
									button[1][0].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(rm%10)+".jpg");
									button[1][1].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(re/10)+".jpg");
									button[1][2].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(re%10)+".jpg");
									button[1][3].setIcon(numberIcon);
								}								
							}else{
								for(int i=0;i<8;i++){
									for(int j=0;j<8;j++){

										Icon result = buttonArray[i][j].getIcon();
										if(result.equals(myIcon)){
											rm++;	
										}else if(result.equals(yourIcon)){
											re++;
										}
									}
								}
								if((myTurn+con) % 2 == 0){
									numberIcon = new ImageIcon("image/number/"+(rm/10)+".jpg");
									button[1][0].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(rm%10)+".jpg");
									button[1][1].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(re/10)+".jpg");
									button[1][2].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(re%10)+".jpg");
									button[1][3].setIcon(numberIcon);
								}else{
									numberIcon = new ImageIcon("image/number/"+(re/10)+".jpg");
									button[1][0].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(re%10)+".jpg");
									button[1][1].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(rm/10)+".jpg");
									button[1][2].setIcon(numberIcon);
									numberIcon = new ImageIcon("image/number/"+(rm%10)+".jpg");
									button[1][3].setIcon(numberIcon);
								}
								
							}
							
							if((myTurn+con) % 2 == 0){
								cc++;
								for(int i=0;i<8;i++){
									for(int j=0;j<8;j++){
										Icon fin = buttonArray[i][j].getIcon();
										if(fin.equals(whiteIcon)){
											if(judge(i,j, 0)){
												cc = 0;
											}
										}
									}
								}
							}else{
								cc++;
								for(int i=0;i<8;i++){
									for(int j=0;j<8;j++){
										Icon fin = buttonArray[i][j].getIcon();
										if(fin.equals(blackIcon)){
											if(judge(i, j, 1)){
												cc = 0;
											}
										}
									}
								}
							}
							
							if(cc == 1){
								cc++;
								con++;
								if((myTurn+con) % 2 == myColor){
									if((myTurn+con) < 60){
										taMain.append("enemy passd enemy's turn!\n");
									}
									for(int i=0;i<8;i++){
										for(int j=0;j<8;j++){
											Icon searchIcon = buttonArray[i][j].getIcon();
											if(searchIcon.equals(yourIcon)){
												if(finishJudge(i,j)){
												cc = 0;
												}												
											}
										}
									}
								}else if((myTurn+con) % 2 == 0){
									if((myTurn+con) < 60){
										taMain.append("you can't put on yourIcon\n");
									}
									for(int i=0;i<8;i++){
										for(int j=0;j<8;j++){
											Icon fin = buttonArray[i][j].getIcon();
											if(fin.equals(whiteIcon)){
												if(judge(i, j, 0)){
													cc = 0;
												}
											}
										}
									}
								}else if((myTurn+con) % 2 == 1){
									if((myTurn+con) < 60){
										taMain.append("you can't put on yourIcon\n");
									}
									for(int i=0;i<8;i++){
										for(int j=0;j<8;j++){
											Icon fin = buttonArray[i][j].getIcon();
											if(fin.equals(blackIcon)){
												if(judge(i, j, 1)){
													cc=0;
												}
											}
										}
									}
								}
							}
							
							if(cc == 2){
								finishsh();
							}
							
							if((myTurn+con) % 2 == 1){	
								button[0][0].setIcon(myname_turn);
								button[0][1].setIcon(enemyname);
							}else{
								button[0][0].setIcon(myname);
								button[0][1].setIcon(enemyname_turn);
			
							}
						}
					}else{
						break;
					}
				
				}
				socket.close();
			} catch (IOException e) {
				System.err.println("エラーが発生しました: " + e);
			}
		}
	}

	public static void main(String[] args) {
		MyClient net = new MyClient();
		net.setVisible(true);
	}
  	
	public void mouseClicked(MouseEvent e) {//ボタンをクリックしたときの
		//System.out.println("クリック");
		JButton theButton = (JButton)e.getComponent();//クリックしたオブジェクトを得る．型が違うのでキャストする
		String theArrayIndex = theButton.getActionCommand();//ボタンの配列の番号を取り出す

		Icon theIcon = theButton.getIcon();//theIconには，現在のボタンに設定されたアイコンが入る
		//System.out.println(theIcon);//デバッグ（確認用）に，クリックしたアイコンの名前を出力する
		
		if(theIcon == bbs){
			String msg = "coment"+" "+tfKeyin.getText()+" "+myColor;//入力したテキストを得る
			tfKeyin.setText("");//tfKeyinのTextをクリアする
			if(msg.length()>0){//入力したメッセージの長さが０で無ければ，
				out.println(msg);
				out.flush();
			}
		}
		
		if((myTurn+con) % 2 == myColor){
			if(theIcon == blueIcon){

				int index = Integer.parseInt(theArrayIndex);
			
				if(judgeButton(index)){
				//置ける
				String msg = "Click"+" "+theArrayIndex +" "+myColor+" "+myTurn;
		
				out.println(msg);//送信データをバッファに書き出す
				out.flush();//送信データをフラッシュ（ネットワーク上にはき出す）する
		
				repaint();//画面のオブジェクトを描画し直す
				} else {
				//置けない
				System.out.println("そこには配置できません");
				}
				
			}
		}
	}
	
	public void mouseEntered(MouseEvent e) {//マウスがオブジェクトに入ったときの処理
		//System.out.println("マウスが入った");
	}
	
	public void mouseExited(MouseEvent e) {//マウスがオブジェクトから出たときの処理
		//System.out.println("マウス脱出");
	}
	
	public void mousePressed(MouseEvent e) {//マウスでオブジェクトを押したときの処理（クリックとの違いに注意）
		//System.out.println("マウスを押した");
	}
	
	public void mouseReleased(MouseEvent e) {//マウスで押していたオブジェクトを離したときの処理
		//System.out.println("マウスを放した");
	}
	
	public void mouseDragged(MouseEvent e) {//マウスでオブジェクトとをドラッグしているときの処理
		//System.out.println("マウスをドラッグ");
	}

	public void mouseMoved(MouseEvent e) {//マウスがオブジェクト上で移動したときの処理
		//System.out.println("マウス移動");
		int theMLocX = e.getX();//マウスのx座標を得る
		int theMLocY = e.getY();//マウスのy座標を得る
		//System.out.println(theMLocX+","+theMLocY);//コンソールに出力する
	}
	
	public boolean judgeButton(int index){
		boolean flag = false;
        int x = index%8;
	    int y = index/8;
		int i,j;
		Icon IJicon;
		
		//色々な条件からflagをtrueにするか判断する
		for(i=-1; i<=1 && x+i<8; i++){
			for(j=-1; j<=1 && y+j<8; j++){
				if(x+i<0)i++;
				if(y+j<0)j++;
				IJicon = buttonArray[x+i][y+j].getIcon();
				if(IJicon.equals(yourIcon)){
					int flip = flipButton(x,y,i,j);
					if(flip>=0){
						int dx = i;
						int dy = j;
					
						for(int k = 0; k < flip; dx+=i, dy+=j, k++){
							int msgx = x+dx;
							int msgy = y+dy;
							
							String msg = "FLIP"+" "+msgx+" "+msgy+" "+myColor;
							out.println(msg);
							out.flush();
						}
					flag = true;
					}
				}
			}
		}
		
		return flag;
	}
	
	public int flipButton(int x, int y, int i, int j){
		int flipNum = 0;
		Icon search;
		int sx = x+i;
		int sy = y+j;
		
		for(; ; sx+=i, sy+=j){
			if(sx>7 || sy>7 || sx<0 || sy<0){
				return -1;
			}
			search = buttonArray[sx][sy].getIcon();
			if(search.equals(yourIcon)){
				flipNum++;
			}else if(search.equals(myIcon)){
				return flipNum;
			}else{
				return -1;
			}
		}
	}
	
	public boolean finishJudge(int i, int j){
		boolean flag = false;
		Icon IJicon;
		int dx, dy;
		
		//色々な条件からflagをtrueにするか判断する
		for(dx=-1; dx<=1 && dx+i<8; dx++){
			for(dy=-1; dy<=1 && dy+j<8; dy++){
				if(dx+i<0)dx++;
				if(dy+j<0)dy++;
				IJicon = buttonArray[dx+i][dy+j].getIcon();
				if(IJicon.equals(boardIcon)){
					int flip = flipButton(dx+i,dy+j,-dx,-dy);
					if(flip>=0){
						buttonArray[i+dx][j+dy].setIcon(blueIcon);
						flag = true;
					}
				}
			}
		}
		
		return flag;
	}
	
	public boolean judge(int i, int j, int color){
		boolean flag = false;
		Icon IJicon;
		int dx, dy;
		
		//色々な条件からflagをtrueにするか判断する
		for(dx=-1; dx<=1 && dx+i<8; dx++){
			for(dy=-1; dy<=1 && dy+j<8; dy++){
				if(dx+i<0)dx++;
				if(dy+j<0)dy++;
				IJicon = buttonArray[dx+i][dy+j].getIcon();
				if(IJicon.equals(boardIcon)|| IJicon.equals(blueIcon)){
					int flip = flipColor(dx+i,dy+j,-dx,-dy, color);
					if(flip>=0){
						flag = true;
					}
				}
			}
		}
		
		return flag;
	}
	
	public int flipColor(int x, int y, int i, int j, int color){
		int flipNum = 0;
		Icon search;
		int sx = x+i;
		int sy = y+j;
		ImageIcon flipc, nonflipc;
		
		if(color == 0){
			flipc = whiteIcon;
			nonflipc = blackIcon;
		}else{
			flipc = blackIcon;
			nonflipc = whiteIcon;
		}
		
		for(; ; sx+=i, sy+=j){
			if(sx>7 || sy>7 || sx<0 || sy<0){
				return -1;
			}
			search = buttonArray[sx][sy].getIcon();
			if(search.equals(flipc)){
				flipNum++;
			}else if(search.equals(nonflipc)){
				return flipNum;
			}else{
				return -1;
			}
		}
	}
	
	public int finishsh(){
		int rm = 0;
		int re = 0;

		taMain.append("finish!!\n");
		
		for(int i=0;i<8;i++){
			for(int j=0;j<8;j++){
				Icon result = buttonArray[i][j].getIcon();
				if(result.equals(myIcon)){
					rm++;	
				}else if(result.equals(yourIcon)){
					re++;
				}
			}
		}
		if((myTurn+con) % 2 == myColor){
			numberIcon = new ImageIcon("image/number/"+(rm/10)+".jpg");
			button[1][0].setIcon(numberIcon);
			numberIcon = new ImageIcon("image/number/"+(rm%10)+".jpg");
			button[1][1].setIcon(numberIcon);
			numberIcon = new ImageIcon("image/number/"+(re/10)+".jpg");
			button[1][2].setIcon(numberIcon);
			numberIcon = new ImageIcon("image/number/"+(re%10)+".jpg");
			button[1][3].setIcon(numberIcon);
			if(rm>re){
				Icon whitewin = new ImageIcon("image/top/white-win.jpg");
				button[2][0].setIcon(whitewin);
			}else if(rm<re){
				Icon whitelose = new ImageIcon("image/top/white-lose.jpg");
				button[2][0].setIcon(whitelose);
			}else{
				Icon whitedraw = new ImageIcon("image/top/white-draw.jpg");
				button[2][0].setIcon(whitedraw);
			}
		}else{
			numberIcon = new ImageIcon("image/number/"+(re/10)+".jpg");
			button[1][0].setIcon(numberIcon);
			numberIcon = new ImageIcon("image/number/"+(re%10)+".jpg");
			button[1][1].setIcon(numberIcon);
			numberIcon = new ImageIcon("image/number/"+(rm/10)+".jpg");
			button[1][2].setIcon(numberIcon);
			numberIcon = new ImageIcon("image/number/"+(rm%10)+".jpg");
			button[1][3].setIcon(numberIcon);
			if(rm>re){
				Icon blackwin = new ImageIcon("image/top/black-win.jpg");
				button[2][0].setIcon(blackwin);
			}else if(rm<re){
				Icon blacklose = new ImageIcon("image/top/black-lose.jpg");
				button[2][0].setIcon(blacklose);	
			}else{
				Icon blackdraw = new ImageIcon("image/top/black-draw.jpg");
				button[2][0].setIcon(blackdraw);
			}
		}			
		return 0;
	}
}
