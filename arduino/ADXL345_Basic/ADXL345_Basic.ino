//Add the SPI library so we can communicate with the ADXL345 sensor
#include <SPI.h>

//Assign the Chip Select signal to pin 10.
int CS=10;

//This is a list of some of the registers available on the ADXL345.
//To learn more about these and the rest of the registers on the ADXL345, read the datasheet!
char POWER_CTL = 0x2D;	//Power Control Register
char DATA_FORMAT = 0x31;
char DATAX0 = 0x32;	//X-Axis Data 0
char DATAX1 = 0x33;	//X-Axis Data 1
char DATAY0 = 0x34;	//Y-Axis Data 0
char DATAY1 = 0x35;	//Y-Axis Data 1
char DATAZ0 = 0x36;	//Z-Axis Data 0
char DATAZ1 = 0x37;	//Z-Axis Data 1

//This buffer will hold values read from the ADXL345 registers.
unsigned char values[10];
//These variables will be used to hold the x,y and z axis accelerometer values.
int x,y,z;

float capturedJerkVector[3];

int dataBuffer [3][64];
int bufferHead = 0;

int BUFFER_SIZE = 64;
int THRESHOLD = 100;
int CALIBRATION_THRESHOLD = 40;

int WAITING = 0;
int CAPTURING = 1;

int CALIBRATION_MODE = 0;
int USER_MODE = 1;
int RAW_DATA_MODE = 2;

int tooLowCounter;

int mode = 0;
int captureState = 0;
int counter = 0;


void setup(){
  //Initiate an SPI communication instance.
  SPI.begin();
  //Configure the SPI connection for the ADXL345.
  SPI.setDataMode(SPI_MODE3);
  //Create a serial connection to display the data on the terminal.
  Serial.begin(115200);

  //Set up the Chip Select pin to be an output from the Arduino.
  pinMode(CS, OUTPUT);
  //Before communication starts, the Chip Select pin needs to be set high.
  digitalWrite(CS, HIGH);

  //Put the ADXL345 into +/- 16G range by writing the value 0x01 to the DATA_FORMAT register.
  writeRegister(DATA_FORMAT, 0x02);
  //Put the ADXL345 into Measurement Mode by writing 0x08 to the POWER_CTL register.
  writeRegister(POWER_CTL, 0x08);  //Measurement mode
}

void loop(){
  //Reading 6 bytes of data starting at register DATAX0 will retrieve the x,y and z acceleration values from the ADXL345.
  //The results of the read operation will get stored to the values[] buffer.
  readRegister(DATAX0, 6, values);

  //The ADXL345 gives 10-bit acceleration values, but they are stored as bytes (8-bits). To get the full value, two bytes must be combined for each axis.
  //The X value is stored in values[0] and values[1].
  x = ((int)values[1]<<8)|(int)values[0];
  //The Y value is stored in values[2] and values[3].
  y = ((int)values[3]<<8)|(int)values[2];
  //The Z value is stored in values[4] and values[5].
  z = ((int)values[5]<<8)|(int)values[4];

  dataBuffer[0][bufferHead] = x;
  dataBuffer[1][bufferHead] = y;
  dataBuffer[2][bufferHead] = z;
  
  float jerkMagnitude = getJerkMagnitude();
  
  if(mode == CALIBRATION_MODE) {
    
    if(captureState == WAITING && jerkMagnitude > THRESHOLD) {
      tooLowCounter = 0;
      captureState = CAPTURING;
      counter = 31;
      getJerkVector(capturedJerkVector);
    }else if(captureState == CAPTURING) {
      tooLowCounter = 0;
      if(counter <= 0) {
        captureState = WAITING;
        printDataString();
      }
      counter--;
    }else if(jerkMagnitude < THRESHOLD && jerkMagnitude > CALIBRATION_THRESHOLD) {
      tooLowCounter = 1;
    }
    
    if(tooLowCounter > 0 && tooLowCounter <= 32) {
      tooLowCounter++;
    }else if(tooLowCounter > 32) {
      Serial.println("TOOLOW");
      tooLowCounter = 0;
    }
    
  }else if(mode == USER_MODE) {
    
    if(captureState == WAITING && jerkMagnitude > THRESHOLD) {
      captureState = CAPTURING;
      counter = 31;
      getJerkVector(capturedJerkVector);
    }else if(captureState == CAPTURING) {
      if(counter <= 0) {
        captureState = WAITING;
        printDataString();
      }
      counter--;
    }
    
  }else if(mode == RAW_DATA_MODE) {
    Serial.println(String(x) + "," + String(y) + "," + String(z));
  }
  
  updateBufferHead();
  
  delay(20);
}

void updateBufferHead() {
  bufferHead = (bufferHead + 1) % BUFFER_SIZE;
}


//compute jerk vector
void getJerkVector(float *jerkVector) {
  
  for(int i=0;i<3;i++) {
    
    int previousBufferHead = bufferHead-1;
    if(previousBufferHead < 0) {
      previousBufferHead += BUFFER_SIZE;
    }
    
    jerkVector[i] = (dataBuffer[i][bufferHead] - dataBuffer[i][previousBufferHead]);
  }
}

//computes jerk magnitude
float getJerkMagnitude() {
  
  float jerkVector[3];
  getJerkVector(jerkVector);
  
  float jerkMagnitude = 0;
  
  for(int i=0;i<3;i++) {
    jerkMagnitude += sq(jerkVector[i]);
  }
  
  jerkMagnitude = sqrt(jerkMagnitude);
  
  return jerkMagnitude;
}

void serialEvent() {
  while (Serial.available()) {
    char inChar = (char)Serial.read();
    if(inChar == 'C') {
      mode = CALIBRATION_MODE;
      Serial.println("C");
    }else if(inChar == 'U') {
      mode = USER_MODE;
      Serial.println("U");
    }else if(inChar == 'R') {
      mode = RAW_DATA_MODE;
      Serial.println("R");
    } else if(inChar == 'P') {
      // Request ping for arduino device controller ID
      Serial.println("101");
    }
  }
}

void printDataString() {
  
  for(int i=0;i<3;i++) {
    String dataString = "";
    for(int j=0;j<BUFFER_SIZE;j++)
    {
      int bufferIndex = bufferHead-j;
      if(bufferIndex < 0) {
        bufferIndex += BUFFER_SIZE;
      }
      
      if(j != BUFFER_SIZE - 1) {
        dataString += String(dataBuffer[i][bufferIndex]) + ",";
      }else{
        dataString += String(dataBuffer[i][bufferIndex]);
      } 
      
    }
    Serial.println(dataString);
  }
  Serial.flush();
  Serial.println(String(capturedJerkVector[0]) + "," + String(capturedJerkVector[1]) + "," + String(capturedJerkVector[2]));
}

//This function will write a value to a register on the ADXL345.
//Parameters:
//  char registerAddress - The register to write a value to
//  char value - The value to be written to the specified register.
void writeRegister(char registerAddress, char value){
  //Set Chip Select pin low to signal the beginning of an SPI packet.
  digitalWrite(CS, LOW);
  //Transfer the register address over SPI.
  SPI.transfer(registerAddress);
  //Transfer the desired register value over SPI.
  SPI.transfer(value);
  //Set the Chip Select pin high to signal the end of an SPI packet.
  digitalWrite(CS, HIGH);
}

//This function will read a certain number of registers starting from a specified address and store their values in a buffer.
//Parameters:
//  char registerAddress - The register addresse to start the read sequence from.
//  int numBytes - The number of registers that should be read.
//  char * values - A pointer to a buffer where the results of the operation should be stored.
void readRegister(char registerAddress, int numBytes, unsigned char * values){
  //Since we're performing a read operation, the most significant bit of the register address should be set.
  char address = 0x80 | registerAddress;
  //If we're doing a multi-byte read, bit 6 needs to be set as well.
  if(numBytes > 1)address = address | 0x40;

  //Set the Chip select pin low to start an SPI packet.
  digitalWrite(CS, LOW);
  //Transfer the starting register address that needs to be read.
  SPI.transfer(address);
  //Continue to read registers until we've read the number specified, storing the results to the input buffer.
  for(int i=0; i<numBytes; i++){
    values[i] = SPI.transfer(0x00);
  }
  //Set the Chips Select pin high to end the SPI packet.
  digitalWrite(CS, HIGH);
}
