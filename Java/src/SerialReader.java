import java.io.BufferedReader;
import java.io.InputStreamReader;
import gnu.io.CommPortIdentifier; 
import gnu.io.SerialPort;
import gnu.io.SerialPortEvent; 
import gnu.io.SerialPortEventListener; 
import java.util.Enumeration;


public class SerialReader implements SerialPortEventListener, Runnable {
	
	private SerialPort serialPort;
	
	private static final String PORT_NAMES[] = { 
			"COM7", // Windows
			"/dev/ttyUSB0",  // Linux
	};

	private BufferedReader input;
	
	private static final int TIME_OUT = 2000;
	private static final int DATA_RATE = 115200;
	
	private static final int CALIBRATION = 0;
	private static final int NOT_CALIBRATION = 1;
	
	private static final int DATA_X = 0;
	private static final int DATA_Y = 1;
	private static final int DATA_Z = 2;
	private static final int JERK_VECTOR = 3;
	
	private int mode;
	private int serialReadState = DATA_X;
	
	private double [] dataX = null;
	private double [] dataY = null;
	private double [] dataZ = null;
	private double [] jerkVector = null;
	
	private Comparator comparator;
	private SampleDao sampleDao;
	
	public SerialReader(int mode, Comparator comparator, SampleDao sampleDao) {
		this.mode = mode;
		this.comparator = comparator;
		this.sampleDao = sampleDao;
		

		CommPortIdentifier portId = null;
		Enumeration<CommPortIdentifier> portEnum = CommPortIdentifier.getPortIdentifiers();
		
		while (portEnum.hasMoreElements()) {
			CommPortIdentifier currPortId = (CommPortIdentifier) portEnum.nextElement();
			for (String portName : PORT_NAMES) {
				if (currPortId.getName().equals(portName)) {
					portId = currPortId;
					break;
				}
			}
		}
		
		if (portId == null) {
			System.out.println("Could not find COM port.");
			return;
		}

		try {
			serialPort = (SerialPort) portId.open(this.getClass().getName(), TIME_OUT);

			// set port parameters
			serialPort.setSerialPortParams(DATA_RATE, SerialPort.DATABITS_8, SerialPort.STOPBITS_1, SerialPort.PARITY_NONE);

			input = new BufferedReader(new InputStreamReader(serialPort.getInputStream()));

			serialPort.addEventListener(this);
			serialPort.notifyOnDataAvailable(true);
		} catch (Exception e) {
			System.err.println(e.toString());
		}
		
		System.out.println("Initialized serial port reader!");
	}

	public synchronized void close() {
		if (serialPort != null) {
			serialPort.removeEventListener();
			serialPort.close();
		}
	}
	
	public synchronized void serialEvent(SerialPortEvent oEvent) {
		if (oEvent.getEventType() == SerialPortEvent.DATA_AVAILABLE) {
			try {
				String inputLine = input.readLine();
				System.out.println(inputLine);
				
				if(serialReadState == DATA_X) {
					
					serialReadState = DATA_Y;
					dataX = Utils.stringArrayToDoubleArray(inputLine.split(","));
					
				}else if(serialReadState == DATA_Y) {
					
					serialReadState = DATA_Z;
					dataY = Utils.stringArrayToDoubleArray(inputLine.split(","));
					
				}else if(serialReadState ==  DATA_Z) {
					
					serialReadState = JERK_VECTOR;
					dataZ = Utils.stringArrayToDoubleArray(inputLine.split(","));
					
				}else if(serialReadState == JERK_VECTOR) {
					
					serialReadState = DATA_X;
					jerkVector  = Utils.stringArrayToDoubleArray(inputLine.split(","));
					
					if(mode == CALIBRATION) {
						sampleDao.writeSamples(Fft.fft(dataX), Fft.fft(dataY), Fft.fft(dataZ), jerkVector);
					}else{
						
						double [] fft = Utils.combineSampleArrays(Fft.fft(dataX), Fft.fft(dataY), Fft.fft(dataZ));
						
						System.out.println(comparator.getGesture(fft, jerkVector));
					}
				}else{
					serialReadState = DATA_X;
				}				
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
	}
	
	
	public void run() {
	}
}