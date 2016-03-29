import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
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
	        
	        String [] rawJerkVector = rawSample[2].split(",");
	        double [] jerkVector = Utils.stringArrayToDoubleArray(rawJerkVector);
	
	        Sample sample = new Sample(fft, jerkVector, gesture);
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
	
	public void writeSamples(double [] fftX, double [] fftY, double [] fftZ, double [] jerkVector) {
		
		try (PrintWriter writer = new PrintWriter("samples.fft");){
			String outputString = "";
					
			for(int i=0;i<fftX.length;i++) {
				outputString += fftX[i] + ",";
			}
			
			outputString += ":";
			
			for(int i=0;i<fftY.length;i++) {
				outputString += fftY[i] + ",";
			}
			
			outputString += ":";
			
			for(int i=0;i<fftZ.length;i++) {
				outputString += fftZ[i] + ",";
			}
			
			outputString += ":";
			
			for(int i=0;i<jerkVector.length;i++) {
				outputString += jerkVector[i];
			}
			writer.println(outputString);
			writer.flush();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
	}
}
