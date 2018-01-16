import java.net.*;
import java.io.*;
import javax.swing.*;
import java.lang.*;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.util.*;

public class MyClient extends JFrame implements MouseListener,MouseMotionListener {
	private JButton buttonArray[][], button[][],bs;//�{�^���p�̔z��
	private int myColor;
	private int myTurn;
	private ImageIcon myIcon, yourIcon, blueIcon, numberIcon, gameIcon;
	private Container c;
	private ImageIcon blackIcon, whiteIcon, boardIcon, myname, enemyname, myname_turn, enemyname_turn, bbs;
	private ImageIcon number_0, vs, number_2;
	PrintWriter out;//�o�͗p�̃��C�^�[
	JTextField tfKeyin;//���b�Z�[�W���͗p�e�L�X�g�t�B�[���h
	JTextArea taMain;//�e�L�X�g�G���A
	String myName;//���O��ۑ�
	int cc, con = 0;
	int rm=0;
	int re=0;

	public MyClient() {
		//���O�̓��̓_�C�A���O���J��
		String myName = JOptionPane.showInputDialog(null,"���O����͂��Ă�������","���O�̓���",JOptionPane.QUESTION_MESSAGE);
		if(myName.equals("")){
			myName = "No name";//���O���Ȃ��Ƃ��́C"No name"�Ƃ���
		}

		//�T�[�o�[��IP�A�h���X�̓��̓_�C�A���O
		String adress = JOptionPane.showInputDialog(null,"IP�A�h���X����͂��Ă�������","IP�A�h���X�̓���",JOptionPane.QUESTION_MESSAGE);
		if(adress.equals("")){
			adress = "localhost";
		}
		
		//�E�B���h�E���쐬����
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);//�E�B���h�E�����Ƃ��ɁC����������悤�ɐݒ肷��
		setTitle("game");//�E�B���h�E�̃^�C�g����ݒ肷��
		setSize(700, 630);//�E�B���h�E�̃T�C�Y��ݒ肷��
		c = getContentPane();//�t���[���̃y�C�����擾����

		//�A�C�R���̐ݒ�
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
		
		c.setLayout(null);//�������C�A�E�g�̐ݒ���s��Ȃ�
		//�{�^���̐���
		buttonArray = new JButton[8][8];//�{�^���̔z����T�쐬����[0]����[4]�܂Ŏg����
		for(int i=0;i<8;i++){
			for(int j=0;j<8;j++){
				if((i==3&&j==3)||(i==4&&j==4)){
					buttonArray[i][j] = new JButton(whiteIcon);
				}else if((i==3&&j==4)||(i==4&&j==3)){
					buttonArray[i][j] = new JButton(blackIcon);
				}else{
					buttonArray[i][j] = new JButton(boardIcon);//�{�^���ɃA�C�R����ݒ肷��
				}
				c.add(buttonArray[i][j]);//�y�C���ɓ\��t����
				buttonArray[i][j].setBounds(i*45+10,j*45+220,45,45);//�{�^���̑傫���ƈʒu��ݒ肷��D(x���W�Cy���W,x�̕�,y�̕��j
				buttonArray[i][j].addMouseListener(this);//�{�^�����}�E�X�ł�������Ƃ��ɔ�������悤�ɂ���
				buttonArray[i][j].addMouseMotionListener(this);//�{�^�����}�E�X�œ��������Ƃ����Ƃ��ɔ�������悤�ɂ���
				buttonArray[i][j].setActionCommand(Integer.toString(i+j*8));//�{�^���ɔz��̏���t������i�l�b�g���[�N����ăI�u�W�F�N�g�����ʂ��邽�߁j
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
		
		//�`���b�g��ʂ��쐬����
		tfKeyin = new JTextField("",42);//���͗p�̃e�L�X�g�t�B�[���h���쐬
		c.add(tfKeyin);//�R���e�i�ɒǉ�
		bs = new JButton(bbs);
		c.add(bs);//�{�^�����R���e�i�ɒǉ�
		tfKeyin.setBounds(390, 400, 200, 20);
		bs.setBounds(600, 400, 50, 20);
		bs.addMouseListener(this);//�{�^�����������Ƃ��̓��삷��悤�ɂ���
		taMain = new JTextArea(20,50);//�`���b�g�̏o�͗p�̃t�B�[���h���쐬
		c.add(taMain);//�R���e�i�ɒǉ�
		taMain.setBounds(390, 430, 270, 130);
		taMain.setEditable(false);//�ҏW�s�ɂ���
		
		//�T�[�o�ɐڑ�����
		Socket socket = null;
		try {
			//"localhost"�́C���������ւ̐ڑ��Dlocalhost��ڑ����IP Address�i"133.42.155.201"�`���j�ɐݒ肷��Ƒ���PC�̃T�[�o�ƒʐM�ł���
			//10000�̓|�[�g�ԍ��DIP Address�Őڑ�����PC�����߂āC�|�[�g�ԍ��ł���PC�㓮�삷��v���O��������肷��
			socket = new Socket(adress, 10000);

		} catch (UnknownHostException e) {
			System.err.println("�z�X�g�� IP �A�h���X������ł��܂���: " + e);
		} catch (IOException e) {
			 System.err.println("�G���[���������܂���: " + e);
		}
		
		MesgRecvThread mrt = new MesgRecvThread(socket, myName);//��M�p�̃X���b�h���쐬����
		mrt.start();//�X���b�h�𓮂����iRun�������j
	}
		
	//���b�Z�[�W��M�̂��߂̃X���b�h
	public class MesgRecvThread extends Thread {
		
		Socket socket;
		String myName;
		
		public MesgRecvThread(Socket s, String n){
			socket = s;
			myName = n;
		}
		
		//�ʐM�󋵂��Ď����C��M�f�[�^�ɂ���ē��삷��
		public void run() {
			try{
				InputStreamReader sisr = new InputStreamReader(socket.getInputStream());
				BufferedReader br = new BufferedReader(sisr);
				out = new PrintWriter(socket.getOutputStream(), true);
				out.println(myName);//�ڑ��̍ŏ��ɖ��O�𑗂�
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
					String inputLine = br.readLine();//�f�[�^����s�������ǂݍ���ł݂�
					if (inputLine != null) {//�ǂݍ��񂾂Ƃ��Ƀf�[�^���ǂݍ��܂ꂽ���ǂ������`�F�b�N����
						//System.out.println(inputLine);//�f�o�b�O�i����m�F�p�j�ɃR���\�[���ɏo�͂���
						String[] inputTokens = inputLine.split(" ");	//���̓f�[�^����͂��邽�߂ɁA�X�y�[�X�Ő؂蕪����
						String cmd = inputTokens[0];//�R�}���h�̎��o���D�P�ڂ̗v�f�����o��
						
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
								taMain.append(inputTokens[1]+"\n");//���b�Z�[�W�̓��e���o�͗p�e�L�X�g�ɒǉ�����
							}
							else{
								break;
							}
						}
						
						if(cmd.equals("Click")){//cmd�̕�����"Click"�����������ׂ�D��������true�ƂȂ�						
							int theBnum = Integer.parseInt(inputTokens[1]);//�{�^���̖��O�𐔒l�ɕϊ�����
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
				System.err.println("�G���[���������܂���: " + e);
			}
		}
	}

	public static void main(String[] args) {
		MyClient net = new MyClient();
		net.setVisible(true);
	}
  	
	public void mouseClicked(MouseEvent e) {//�{�^�����N���b�N�����Ƃ���
		//System.out.println("�N���b�N");
		JButton theButton = (JButton)e.getComponent();//�N���b�N�����I�u�W�F�N�g�𓾂�D�^���Ⴄ�̂ŃL���X�g����
		String theArrayIndex = theButton.getActionCommand();//�{�^���̔z��̔ԍ������o��

		Icon theIcon = theButton.getIcon();//theIcon�ɂ́C���݂̃{�^���ɐݒ肳�ꂽ�A�C�R��������
		//System.out.println(theIcon);//�f�o�b�O�i�m�F�p�j�ɁC�N���b�N�����A�C�R���̖��O���o�͂���
		
		if(theIcon == bbs){
			String msg = "coment"+" "+tfKeyin.getText()+" "+myColor;//���͂����e�L�X�g�𓾂�
			tfKeyin.setText("");//tfKeyin��Text���N���A����
			if(msg.length()>0){//���͂������b�Z�[�W�̒������O�Ŗ�����΁C
				out.println(msg);
				out.flush();
			}
		}
		
		if((myTurn+con) % 2 == myColor){
			if(theIcon == blueIcon){

				int index = Integer.parseInt(theArrayIndex);
			
				if(judgeButton(index)){
				//�u����
				String msg = "Click"+" "+theArrayIndex +" "+myColor+" "+myTurn;
		
				out.println(msg);//���M�f�[�^���o�b�t�@�ɏ����o��
				out.flush();//���M�f�[�^���t���b�V���i�l�b�g���[�N��ɂ͂��o���j����
		
				repaint();//��ʂ̃I�u�W�F�N�g��`�悵����
				} else {
				//�u���Ȃ�
				System.out.println("�����ɂ͔z�u�ł��܂���");
				}
				
			}
		}
	}
	
	public void mouseEntered(MouseEvent e) {//�}�E�X���I�u�W�F�N�g�ɓ������Ƃ��̏���
		//System.out.println("�}�E�X��������");
	}
	
	public void mouseExited(MouseEvent e) {//�}�E�X���I�u�W�F�N�g����o���Ƃ��̏���
		//System.out.println("�}�E�X�E�o");
	}
	
	public void mousePressed(MouseEvent e) {//�}�E�X�ŃI�u�W�F�N�g���������Ƃ��̏����i�N���b�N�Ƃ̈Ⴂ�ɒ��Ӂj
		//System.out.println("�}�E�X��������");
	}
	
	public void mouseReleased(MouseEvent e) {//�}�E�X�ŉ����Ă����I�u�W�F�N�g�𗣂����Ƃ��̏���
		//System.out.println("�}�E�X�������");
	}
	
	public void mouseDragged(MouseEvent e) {//�}�E�X�ŃI�u�W�F�N�g�Ƃ��h���b�O���Ă���Ƃ��̏���
		//System.out.println("�}�E�X���h���b�O");
	}

	public void mouseMoved(MouseEvent e) {//�}�E�X���I�u�W�F�N�g��ňړ������Ƃ��̏���
		//System.out.println("�}�E�X�ړ�");
		int theMLocX = e.getX();//�}�E�X��x���W�𓾂�
		int theMLocY = e.getY();//�}�E�X��y���W�𓾂�
		//System.out.println(theMLocX+","+theMLocY);//�R���\�[���ɏo�͂���
	}
	
	public boolean judgeButton(int index){
		boolean flag = false;
        int x = index%8;
	    int y = index/8;
		int i,j;
		Icon IJicon;
		
		//�F�X�ȏ�������flag��true�ɂ��邩���f����
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
		
		//�F�X�ȏ�������flag��true�ɂ��邩���f����
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
		
		//�F�X�ȏ�������flag��true�ɂ��邩���f����
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
