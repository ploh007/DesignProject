import processing.serial.*;

final int lf = 10;    // Linefeed in ASCII
String data = null;
Serial arduinoPort;  // The serial port

float [][] accelerationHistory = new float [500][3];

int oldHead = 0;
int head = 0; //head of circular buffer
int state = 0;
int timer=0;

final float THRESHOLD = 1000;
final int WAITING = 0;
final int CAPTURING = 1;

void setup() {
  size(500, 600);
  
  arduinoPort = new Serial(this, Serial.list()[32], 9600);
  arduinoPort.clear();
  data = arduinoPort.readStringUntil(lf);
  data = null;
}

void draw() {
  background(255);
  
  while (arduinoPort.available() > 0) {
    data = arduinoPort.readStringUntil(lf);
    if (data != null) {
      oldHead = head;
      head = (head + 1) % 500; //wrap circular buffer
      
      String [] xyz = data.replace("\n", "").split(","); //strip newline, split by comma
      float x = float(xyz[0]);
      float y = float(xyz[1]);
      float z = float(xyz[2]);
      
      float [] accelerationVector = {x, y, z}; //generate acceleration vector
      accelerationHistory[head] = accelerationVector;
    }
  } 
  
  float [] oldAccelerationVector = accelerationHistory[oldHead]; //get old acceleration vector
  float [] accelerationVector = accelerationHistory[head];
  
  stroke(0);
  if((distanceSquared(accelerationVector, oldAccelerationVector) > THRESHOLD) && state == WAITING) //movement detected
  {
    println(distanceSquared(accelerationVector, oldAccelerationVector));
    state = CAPTURING;
    fill(0, 255, 0);
    ellipse(10, 10, 20, 20);
    timer = 50;
  }else if(state == CAPTURING){
    timer--;
    if(timer <= 0)
    {
      state = WAITING;
    }
    fill(0, 255, 0);
    ellipse(10, 10, 20, 20);
  }else{
    state = WAITING;
    fill(255, 0, 0);
    ellipse(10, 10, 20, 20);
  }
  
  drawGraph(accelerationHistory);
}

float distanceSquared(float [] x, float [] y)
{
  return (x[0]-y[0])*(x[0]-y[0]) + (x[1]-y[1])*(x[1]-y[1]) + (x[2]-y[2])*(x[2]-y[2]);
}

void drawGraph(float [][] dataArray)
{
  color [] colors = {#FF0000, #00FF00, #0000FF}; 
  
  for(int i=499;i>=0;i--)
  {
    for(int j=0;j<3;j++)
    {     
      int index = (head - (500 - i));
      if(index < 0){
        index += 500;
      }
      stroke(colors[j]);
      line(i, 100 + 200*j - dataArray[index][j], i, 100 + 200*j);
    }
  }
}