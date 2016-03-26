import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.LinkedList;

public class SampleDao {

	public LinkedList<Sample> getSamples() {
			
		LinkedList<Sample> samples = new LinkedList<Sample>();
	
	    try(FileReader fr = new FileReader("samples.fft");
	        BufferedReader br = new BufferedReader(fr);) {
	
	      String line;
	
	      while((line = br.readLine()) != null) {
	
	        String [] rawSample = line.split(":");
	        String gesture = rawSample[0];
	
	        String [] rawFft = rawSample[1].split(",");
	        double [] fft = Utils.stringArrayToDoubleArray(rawFft);
	
	        Sample sample = new Sample(fft, gesture);
	        samples.add(sample);
	        System.out.println("Added new sample: " + sample.getGesture());
	      }
	    }catch(FileNotFoundException e){
	      System.out.println("Encountered a FileNotFoundException while reading fft file.");
	    }catch(IOException e) {
	      System.out.println("Encountered an IOException while reading fft file.");
	    }
	    
	    return samples;
	}
}
