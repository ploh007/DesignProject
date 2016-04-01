public final class Utils {

    public static double distance(double [] x, double [] y) {
    	
    	double distance = 0;

      	for(int i=0;i<x.length;i++) {
    	  distance += Math.pow(x[i] - y[i], 2);
      	}

      	return Math.sqrt(distance);
    }
    
    public static double angle(double [] x, double [] y) {
    	
    	double dotProduct = 0;
    	
    	for(int i=0;i<x.length;i++) {
    		dotProduct += x[i]*y[i];
    	}
    	
    	double angle = Math.acos(dotProduct / (magnitude(x) * magnitude(y)));
    	return angle;
    }
    
    public static double magnitude(double [] x) {
    	
    	double temp = 0;
    	
    	for(int i=0;i<x.length;i++) {
    		temp += Math.pow(x[i], 2);
    	}
    	
    	return Math.sqrt(temp);
    }
    
    public static double [] stringArrayToDoubleArray(String [] doubleStrings) {
    	
    	double [] doubleArray = new double[doubleStrings.length];
    	
        for(int i=0;i<doubleStrings.length;i++) {
          doubleArray[i] = Double.parseDouble(doubleStrings[i]);
        }
        
        return doubleArray;
    }
    
    public static double[] combineSampleArrays(double [] dataX, double [] dataY, double [] dataZ) {
    	
    	int length = dataX.length*3;
    	double [] comparison = new double[length];
    	
    	for(int i=0;i<dataX.length;i++) {
    		comparison[i] = dataX[i];
    		comparison[i+dataX.length] = dataY[i];
    		comparison[i+dataX.length*2] = dataZ[i];
    	}
    	
    	return comparison;
    }
}