class Main {
  public static void main(String [] args) {
	  
	int operatingMode = Integer.parseInt(args[0]); //run configuration
   
    SampleDao sampleDao = new SampleDao(); //create sample dao
    
    Comparator comp = new Comparator(2500, Math.PI/2, sampleDao.getSamples()); //comparator object 
    
    Thread test = new Thread(new SerialReader(operatingMode, comp, sampleDao)); //start monitoring serial port
    test.start();
  }
}
