import java.util.LinkedList;
import java.io.*;

public class Comparator {

  private LinkedList<Sample> sampleDatabase;
  private double threshold;

  public Comparator(double threshold) {
    this.threshold = threshold;
    sampleDatabase = new LinkedList<Sample>();

    try(FileReader fr = new FileReader("samples.json");
        BufferedReader br = new BufferedReader(fr);) {

      String line;

      while((line = br.readLine()) != null) {
        
        String [] rawSample = line.split(":");
        String gesture = rawSample[0];

        String [] rawFft = rawSample[1].split(",");
        double [] fft = new double[rawFft.length];

        for(int i=0;i<rawFft.length;i++) {
          fft[i] = Double.parseDouble(rawFft[i]);
        }

        Sample sample = new Sample(fft, gesture);
        sampleDatabase.add(sample);
        System.out.println("Added new sample: " + sample.getGesture());
      }
    }catch(FileNotFoundException e){
      System.out.println("Encountered a FileNotFoundException while reading json file.");
    }catch(IOException e) {
      System.out.println("Encountered an IOException while reading json file.");
    }
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
