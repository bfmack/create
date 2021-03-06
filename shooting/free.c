#include <stdio.h>
#include <stdlib.h>
#include <GL/glut.h>
#include <time.h>
#include <math.h>

#define W 6                        /* 地面の幅の２分の１　 */
#define D 9                        /* 地面の長さの２分の１ */
double v, a;   /* 速度と角速度 */
const double t = 0.0001; /* 時間間隔 */
int cx, cy; /* マウスのボタンを押した位置*/
int bv = 0; /* ボールが発射しているかどうか */
int tx, tz; /*　ターゲットの位置 */
int count = 0; /* ターゲットに当てた回数　*/
double tr = 0.0;
double tb = 0.0;
double tg = 0.0;
time_t start;
static GLdouble px = 0.0, pz = 0.0;                       /* 車の位置　 */
static GLdouble qx, qz;  /* ボールの位置　*/ 
static GLdouble r = 180.0;                                  /* 車の方向　 */

/*
 * 地面を描く
 */
static void myGround(double height)
{
   const static GLfloat ground[][4] = {
    { 0.6, 0.6, 0.6, 1.0 },
    { 0.3, 0.3, 0.3, 1.0 }
  };

  int i, j;
  
  glBegin(GL_QUADS);
  glNormal3d(0.0, 1.0, 0.0);
  for (j = -D; j < D; ++j) {
    for (i = -W; i < W; ++i) {
      glMaterialfv(GL_FRONT, GL_DIFFUSE, ground[(i + j) & 1]);
      glVertex3d((GLdouble)i, height, (GLdouble)j);
      glVertex3d((GLdouble)i, height, (GLdouble)(j + 1));
      glVertex3d((GLdouble)(i + 1), height, (GLdouble)(j + 1));
      glVertex3d((GLdouble)(i + 1), height, (GLdouble)j);
    }
  }
  glEnd();
}

/*
 * 画面表示
 */
static void display(void)
{
  const static GLfloat white[] = { 0.8, 0.8, 0.8, 1.0 };    /* 球の色 */
  const static GLfloat lightpos[] = { 3.0, 4.0, 5.0, 1.0 }; /* 光源の位置 */ 
  GLfloat target[] = { tr, tb, tg, 1.0 };  
  const static GLfloat yellow[] = { 0.8, 0.8, 0.2, 1.0 };   /* 車の色　　 */


  int s; /* 乱数の初期化　*/
  int pm; /* ターゲットの位置の正負　*/

  if(bv == 0){
  px += v * t * sin(r * M_PI / 180.0);
  pz += v * t * cos(r * M_PI / 180.0);
  r = 50 * a * t + r;
  }else if(bv == -1){
    qx += 0.1 * sin(r * M_PI / 180.0);
    qz += 0.1 * cos(r * M_PI / 180.0);
  }else if(bv == -2){
  }else if(bv == -3){
    px = 0.0, pz = 0.0;
    r = 180.0;  
  } 

  if(count == 0){
    start = time(NULL);
  }

  if(count % 2 == 0){
    srand((unsigned)time( NULL ));
    s = rand();
    tx = s % W;
    s = rand();
    pm = s % 2;
    if(pm == 0){
      tx = -tx;
    }
    
    s = rand();
    tz = s % D;
    s = rand();
    pm = s % 2;
    if(pm == 0){
      tz = -tz;
    }
    count++;
  }
  

  /* 画面クリア */
  glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);

  /* モデルビュー変換行列の初期化 */
  glLoadIdentity();

  /* 光源の位置を設定 */
  glLightfv(GL_LIGHT0, GL_POSITION, lightpos);

  /* 視点の移動（物体の方を奥に移す）*/
  glTranslated(0.0, 0.0, -25.0);
  glRotated(30.0, 1.0, 0.0, 0.0);

  /* シーンの描画 */
  myGround(0.0);  
  glPushMatrix();
  glTranslated(px, 1.0, pz);
  glRotated(r - 90.0, 0.0, 1.0, 0.0);
  glMaterialfv(GL_FRONT, GL_DIFFUSE, yellow);
  glutSolidTeapot(1.0);
  glPopMatrix();

  glPushMatrix();
  glTranslated(tx, 1.0, tz);
  glRotated(0.0, 0.0, 1.0, 0.0);
  glMaterialfv(GL_FRONT, GL_DIFFUSE, target);
  glutSolidCube(1.0);
  glPopMatrix(); 
  glFlush();
 
  if(qx < tx + 0.5 && qx > tx - 0.5 && qz < tz + 0.5 && qz > tz - 0.5){
    bv = -2;
    tr = tr + 0.1;
    tb = tb + 0.1;
    tg = tg + 0.1;
    count++;
    if(count >= 16){
      printf("clear\n");
      printf("time:%.1f秒\n", difftime(time(NULL), start));
      exit(0);
    }
  }else if(bv == -1){
    glPushMatrix();
    glTranslated(qx, 1.0, qz);
    glRotated(r - 90.0, 0.0, 1.0, 0.0);
    glMaterialfv(GL_FRONT, GL_DIFFUSE, white);
    glutSolidSphere(0.3, 16, 8);
    glPopMatrix();
  }
  
    glutSwapBuffers();
}

static void resize(int w, int h)
{
  /* ウィンドウ全体をビューポートにする */
  glViewport(0, 0, w, h);

  /* 透視変換行列の指定 */
  glMatrixMode(GL_PROJECTION);

  /* 透視変換行列の初期化 */
  glLoadIdentity();
  gluPerspective(30.0, (double)w / (double)h, 1.0, 100.0);

  /* モデルビュー変換行列の指定 */
  glMatrixMode(GL_MODELVIEW);
}

void idle(void)
{
  glutPostRedisplay();
}

static void keyboard(unsigned char key, int x, int y)
{
  /* ESC か q をタイプしたら終了 */
  if (key == '\033' || key == 'q') {
    exit(0);
  }
  if (key == 's'){
    bv = -3;
    glutIdleFunc(idle);
  }
  if (key == 'a'){
    bv = -1;
    qx = px;
    qz = pz;
    glutIdleFunc(idle); 
  }
}

void mouse(int button, int state, int x, int y)
{
  // マウスボタンを押した位置を覚えておく
  cx = x;
  cy = y;

  switch(button){
  case GLUT_LEFT_BUTTON:
    if (state == GLUT_DOWN) {
      bv = 0;
      glutIdleFunc(idle); 
    }
    else {
      glutIdleFunc(0);
    }
    break;
  case GLUT_RIGHT_BUTTON:
    if (state == GLUT_DOWN){
      bv = -1;
      qx = px;
      qz = pz;
      glutIdleFunc(idle);
    }
    else{
      glutIdleFunc(idle);
    }
    break;
  default:
    bv = 0;
    break;
  }
}

void motion(int x, int y)
{
  // 速度と方向を求める
  v = 2 * cy - 2 * y;
  a = cx - x;
}

static void init(void)
{
  /* 初期設定 */
  glClearColor(1.0, 1.0, 1.0, 1.0);
  glEnable(GL_DEPTH_TEST);
  glDisable(GL_CULL_FACE);
  glEnable(GL_LIGHTING);
  glEnable(GL_LIGHT0);
}

int main(int argc, char *argv[])
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_RGBA | GLUT_DEPTH | GLUT_DOUBLE);
  glutCreateWindow(argv[0]);
  glutDisplayFunc(display);
  glutReshapeFunc(resize);
  glutMouseFunc(mouse);
  glutMotionFunc(motion);
  glutKeyboardFunc(keyboard);
  init();
  glutMainLoop();
  return 0;
}
