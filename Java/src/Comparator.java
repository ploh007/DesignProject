import java.util.LinkedList;

public class Comparator {

  private SampleDao sampleDao;
  private LinkedList<Sample> sampleDatabase;
  private double distanceThreshold;
  private double angleThreshold;

  public Comparator(double distanceThreshold, double angleThreshold, SampleDao sampleDao) {
	this.distanceThreshold = distanceThreshold;
    this.angleThreshold = angleThreshold;
    this.sampleDao = sampleDao;
    loadSamples();
  }

  public String getGesture(double [] fft, double [] jerkVector) {
    for(Sample sample : sampleDatabase) {
      double distance = Utils.distance(sample.getFft(), fft);
      System.out.println(distance);
      double angle = Utils.angle(sample.getJerkVector(), jerkVector);
      
      if(distance < distanceThreshold && angle < angleThreshold) {
        return sample.getGesture();
      }
    }

    return "NOGESTURE"; //no match return "NOGESTURE"
  }
  
  public void loadSamples() {
	  sampleDatabase = sampleDao.getSamples();
  }
}
