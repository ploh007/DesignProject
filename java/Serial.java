import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import gnu.io.CommPortIdentifier; 
import gnu.io.SerialPort;
import gnu.io.SerialPortEvent; 
import gnu.io.SerialPortEventListener; 
import java.util.Enumeration;

public class Serial implements SerialPortEventListener {

	SerialPort serialPort;
	
	private static final String PORT_NAMES[] = {"COM7"};
	private static final int TIME_OUT = 2000;
	private static final int DATA_RATE = 9600;
	
	private BufferedReader input;
	private OutputStream output;
	private CommPortIdentifier portId = null;
	private String filepath = "C:\\wamp\\www\\DesignProject\\filename.txt";
	
	public static void main(String[] args) throws Exception {
		Serial main = new Serial();
		main.initializePortID();
		main.open();
		
		Thread t = new Thread() {
			public void run() {
				try {
					Thread.sleep(1000000);
				} catch (InterruptedException ie) {
					ie.printStackTrace();
				}
			}
		};
		t.start();
	}
	
	// Initialize the port id
	public void initializePortID() {
		Enumeration portEnum = CommPortIdentifier.getPortIdentifiers();
		while (portEnum.hasMoreElements()) {
			CommPortIdentifier currPortId = (CommPortIdentifier) portEnum.nextElement();
			for (String portName : PORT_NAMES) {
				if (currPortId.getName().equals(portName)) {
					portId = currPortId;
					break;
				}
			}
		}
	}
	
	// Opens the connection with the port
	public void open() {
		if(portId != null){
			try {
				serialPort = (SerialPort) portId.open(this.getClass().getName(), TIME_OUT);
				serialPort.setSerialPortParams(DATA_RATE,
						SerialPort.DATABITS_8,
						SerialPort.STOPBITS_1,
						SerialPort.PARITY_NONE);
	
				input = new BufferedReader(new InputStreamReader(serialPort.getInputStream()));
				output = serialPort.getOutputStream();
				serialPort.addEventListener(this);
				serialPort.notifyOnDataAvailable(true);
	
			} catch (Exception e) {
				System.err.println(e.toString());
			}
		} else {
			System.out.println("Could not find any initialized Ports.");
		}
	}
	
	// Closes the connection with the port
	public synchronized void close() {
		if (serialPort != null) {
			serialPort.removeEventListener();
			serialPort.close();
		}
	}
	
	// Executes when data is available on the serial port connection
	public synchronized void serialEvent(SerialPortEvent oEvent) {
		if (oEvent.getEventType() == SerialPortEvent.DATA_AVAILABLE) {
			try {
				writeToFile(input.readLine());
			} catch (Exception e) {
				System.err.println(e.toString());
			}
		}
	}
	
	// Writes the data to an output file
	public void writeToFile(String data){
		try {
			File file = new File(filepath);
			FileWriter fw = new FileWriter(file.getAbsoluteFile());
			BufferedWriter bw = new BufferedWriter(fw);
			if (!file.exists()) {
				file.createNewFile();
			}
			bw.write(data);
			bw.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
}