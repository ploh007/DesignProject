public class Sample {

  private double [] fft;
  private double [] jerkVector;
  private String gesture;

  public Sample(double [] fft, double [] jerkVector, String gesture) {
    this.fft = fft;
    this.jerkVector = jerkVector;
    this.gesture = gesture;
  }

  public double [] getFft() {
    return fft;
  }
  
  public double [] getJerkVector() {
	  return jerkVector;
  }

  public String getGesture() {
    return gesture;
  }
}
