class Main {
  public static void main(String [] args) {
   
    SampleDao sampleDao = new SampleDao(); //create sample dao
    
    //Comparator comp = new Comparator(2000, Math.PI, sampleDao.getSamples()); //comparator object 
    
    Thread test = new Thread(new SerialTest(null, sampleDao)); //start monitoring serial port
    test.start();
  }
}
