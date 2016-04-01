import processing.serial.*;

final int lf = 10;    // Linefeed in ASCII
String data = null;
Serial arduinoPort;  // The serial port

float [][] accelerationHistory = new float [3][500];

int oldHead = 0;
int head = 0; //head of circular buffer
int state = 0;
int timer=0;

final float THRESHOLD = 80;
final int WAITING = 0;
final int CAPTURING = 1;

float [] captureDataX = new float [64];
float [] captureDataY = new float [64];
float [] captureDataZ = new float [64];

float [] fftDataX = new float[64];
float [] fftDataY = new float[64];
float [] fftDataZ = new float[64];

int fftIndex = 0;

float jerkMagnitude = 0;

void setup() {
  size(700, 600);
  arduinoPort = new Serial(this, Serial.list()[32], 9600);
  arduinoPort.clear();
  data = arduinoPort.readStringUntil(lf);
  data = null;
}

void draw() {
  background(255);
  
  while (arduinoPort.available() > 0) { //wait for serial data
    data = arduinoPort.readStringUntil(lf);
    
    if (data != null) {
      
      String [] xyz = data.replace("\n", "").split(","); //strip newline, split by comma
      float x = float(xyz[0]);
      float y = float(xyz[1]);
      float z = float(xyz[2]);
      
      updateAccelerationHistory(x, y, z);
      updateStateMachine();
    }
  } 
  
  drawGraph(accelerationHistory);
  drawFft(fftDataX, 0);
  drawFft(fftDataY, 1);
  drawFft(fftDataZ, 2);
}