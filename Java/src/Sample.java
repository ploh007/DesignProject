public class Sample {

  private double [] fft;
  private String gesture;

  public Sample(double [] fft, String gesture) {
    this.fft = fft;
    this.gesture = gesture;
  }

  public double [] getFft() {
    return fft;
  }

  public String getGesture() {
    return gesture;
  }
}
