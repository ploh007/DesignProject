class Fft {

  private int sampleSize;

  public Fft(int sampleSize) {
    this.sampleSize = sampleSize;
  }

  public double [] fft(double [] samples) {
    double [][] complexFft = complexFft(samples, sampleSize, 1, 0);
    double [] fftMagnitudes = new double[complexFft.length];

    for(int i=0;i<samples.length;i++) {
      fftMagnitudes[i] = Math.sqrt(Math.pow(complexFft[i][0], 2) + Math.pow(complexFft[i][1], 2));
    }

    return fftMagnitudes;
  }

  public double [][] complexFft(double [] x, int n, int s, int start)
  {
    double [][] result;

    if(n == 1)
    {
      result = new double[1][2];
      result[0][0] = x[start];
      result[0][1] = 0.0f;
    }else{
      result = new double[n][2];
      double [][] bottom = complexFft(x, n/2, 2*s, start);
      double [][] top = complexFft(x, n/2, 2*s, start + s);

      for(int k=0;k<(n/2);k++)
      {
        int topK = k+(n/2);

        double theta = -2*Math.PI*k/n; //calculate theta
        double [] exp = {Math.cos(theta), Math.sin(theta)}; //calculate exponential

        double [] expTimesTopK = {exp[0]*top[k][0] - exp[1]*top[k][1], exp[1]*top[k][0] + exp[0]*top[k][1]}; //multiple by top K

        double [] temp = bottom[k];

        result[k][0] = temp[0] + expTimesTopK[0]; //real part, bottom
        result[k][1] = temp[1] + expTimesTopK[1]; //imaginary part, bottom

        result[topK][0] = temp[0] - expTimesTopK[0]; //real part, top
        result[topK][1] = temp[1] - expTimesTopK[1]; //imaginary part, top
      }
    }

    return result;
  }
}
