import java.util.LinkedList;

public class Comparator {

  private LinkedList<Sample> sampleDatabase;
  private double threshold;

  public Comparator(double threshold) {
    this.threshold = threshold;
    sampleDatabase = new LinkedList<Sample>();

    //load data from json files
  }

  public String getGesture(double [] fft) {
    for(Sample sample : sampleDatabase) {
      double distance = distance(sample.getFft(), fft);

      if(distance < threshold) {
        return sample.getGesture();
      }
    }

    return "NOGESTURE"; //no match return "NOGESTURE"
  }

  private double distance(double [] x, double [] y) {

    double distance = 0;

    for(int i=0;i<x.length;i++) {
      distance += Math.pow(x[i] - y[i], 2);
    }

    return Math.sqrt(distance);
  }
}
