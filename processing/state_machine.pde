public void updateStateMachine() {
 stroke(0);
  if((jerkMagnitude > THRESHOLD) && state == WAITING) //movement detected
  {
    println(jerkMagnitude);
    state = CAPTURING;
    fill(0, 255, 0);
    ellipse(10, 10, 20, 20);
    timer = 32;
  }else if(state == CAPTURING){
    timer--;
    
    if(timer <= 0)
    {
      state = WAITING;
      
      for(int i=0;i<64;i++)
      {
        int index = head - 64 + i;
        if(index < 0) {
          index = 500 + index;
        }
        captureDataX[i] = accelerationHistory[0][index];
        captureDataY[i] = accelerationHistory[1][index];
        captureDataZ[i] = accelerationHistory[2][index];
      }
      
      fftDataX = fftMagnitude(fft(captureDataX, 64, 1, 0));
      fftDataY = fftMagnitude(fft(captureDataY, 64, 1, 0));
      fftDataZ = fftMagnitude(fft(captureDataZ, 64, 1, 0));
      saveFFT(fftDataX, fftDataY, fftDataZ);
    }
    fill(0, 255, 0);
    ellipse(10, 10, 20, 20);
  }else{
    state = WAITING;
    fill(255, 0, 0);
    ellipse(10, 10, 20, 20);
  }
}