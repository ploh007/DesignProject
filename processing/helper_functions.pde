public void updateAccelerationHistory(float x, float y, float z) {
  
  float oldX = accelerationHistory[0][head];
  float oldY = accelerationHistory[1][head];
  float oldZ = accelerationHistory[2][head];
  
  oldHead = head;
  head = (head + 1) % 500; //wrap circular buffer
  
  accelerationHistory[0][head] = x;
  accelerationHistory[1][head] = y;
  accelerationHistory[2][head] = z;
 
  jerkMagnitude = dist(x, y, z, oldX, oldY, oldZ);
}

public void saveFFT(float [] x, float [] y, float [] z) {
  String [] fft = new String[1];
  fft[0] ="";
  
  for(int i=1;i<x.length/2;i++) {
    fft[0] += x[i] + ",";
  }
  
  for(int i=1;i<y.length/2;i++) {
    fft[0] += y[i] + ",";
  }
 
  for(int i=1;i<z.length/2;i++) {
    fft[0] += z[i] + ",";
  }
  
  fft[0] += "\n";
  saveStrings("/home/jordan/fft" + fftIndex + ".log", fft);
  
  fftIndex++;
}

public float distance(float [] x, float [] y) {
  float distance = 0;
  for(int i=0;i<x.length;i++)
  {
    distance += sq(x[i] - y[i]);
  }
  return sqrt(distance);
}