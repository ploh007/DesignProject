float [][] fft(float [] x, int n, int s, int start)
{
  float [][] result;
  
  if(n == 1)
  {
    result = new float[1][2];
    result[0][0] = x[start];
    result[0][1] = 0.0f;
  }else{
    result = new float[n][2];
    float [][] bottom = fft(x, n/2, 2*s, start);
    float [][] top = fft(x, n/2, 2*s, start + s);
    
    for(int k=0;k<(n/2);k++)
    {
      int topK = k+(n/2);
      
      float theta = -2*PI*k/n; //calculate theta
      float [] exp = {cos(theta), sin(theta)}; //calculate exponential
      
      float [] expTimesTopK = {exp[0]*top[k][0] - exp[1]*top[k][1], exp[1]*top[k][0] + exp[0]*top[k][1]}; //multiple by top K
      
      float [] temp = bottom[k];
      
      result[k][0] = temp[0] + expTimesTopK[0]; //real part, bottom
      result[k][1] = temp[1] + expTimesTopK[1]; //imaginary part, bottom
      
      result[topK][0] = temp[0] - expTimesTopK[0]; //real part, top
      result[topK][1] = temp[1] - expTimesTopK[1]; //imaginary part, top
    }
  }
  
  return result;
}

float [] fftMagnitude(float [][] fft) {
  float [] magnitudes = new float[fft.length];
  
  for(int i=0;i<fft.length;i++) {
    magnitudes[i] = dist(0, 0, fft[i][0], fft[i][1]);
  }
  
  return magnitudes;
}