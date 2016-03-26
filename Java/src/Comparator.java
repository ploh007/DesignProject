import java.util.LinkedList;

public class Comparator {

  private LinkedList<Sample> sampleDatabase;
  private double distanceThreshold;
  private double angleThreshold;

  public Comparator(double distanceThreshold, double angleThreshold, LinkedList<Sample> sampleDatabase) {
	this.distanceThreshold = distanceThreshold;
    this.angleThreshold = angleThreshold;
    this.sampleDatabase = sampleDatabase;
  }

  public String getGesture(double [] fft, double [] jerkVector) {
    for(Sample sample : sampleDatabase) {
      double distance = Utils.distance(sample.getFft(), fft);
      double angle = Utils.angle(sample.getJerkVector(), jerkVector);
      
      if(distance < distanceThreshold && angle < angleThreshold) {
        return sample.getGesture();
      }
    }

    return "NOGESTURE"; //no match return "NOGESTURE"
  }
}
