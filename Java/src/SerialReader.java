import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.URI;
import java.net.URISyntaxException;

import gnu.io.CommPortIdentifier; 
import gnu.io.SerialPort;
import gnu.io.SerialPortEvent; 
import gnu.io.SerialPortEventListener; 
import java.util.Enumeration;


public class SerialReader implements SerialPortEventListener, Runnable {

	private SerialPort serialPort;

	private static final String PORT_NAMES[] = { 
			"COM9", // Windows
			//			"/dev/ttyUSB0",  // Linux
	};

	private BufferedReader input;
	private OutputStream output;

	private static final int TIME_OUT = 2000;
	private static final int DATA_RATE = 115200;

	private static final int CALIBRATION = 0;
	private static final int USER = 1;
	private static final int RAW = 2;

	private static final int DATA_X = 0;
	private static final int DATA_Y = 1;
	private static final int DATA_Z = 2;
	private static final int JERK_VECTOR = 3;

	private int mode;

	private int modeString;

	private int serialReadState = DATA_X;

	private double [] dataX = null;
	private double [] dataY = null;
	private double [] dataZ = null;
	private double [] jerkVector = null;

	private Comparator comparator;
	private SampleDao sampleDao;

	private WebsocketClientEndpoint websocket;

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

			serialPort.disableReceiveTimeout();
			serialPort.enableReceiveThreshold(1);

			// set port parameters
			serialPort.setSerialPortParams(DATA_RATE, SerialPort.DATABITS_8, SerialPort.STOPBITS_1, SerialPort.PARITY_NONE);

			input = new BufferedReader(new InputStreamReader(serialPort.getInputStream()));
			output = serialPort.getOutputStream();


			serialPort.addEventListener(this);
			serialPort.notifyOnDataAvailable(true);
		} catch (Exception e) {
			System.err.println(e.toString());
		}

		System.out.println("Initialized serial port reader!");

		try {

			// open websocket
			websocket = new WebsocketClientEndpoint(new URI("ws://localhost:8080"));

			// add listener
			websocket.addMessageHandler(new WebsocketClientEndpoint.MessageHandler() {
				public void handleMessage(String message) {
					if(message.equals("GETMODE")){
						if(getMode() == 0) {
							websocket.sendMessage("ARDUINOMODECALIB");
						} else if (getMode() == 1){
							websocket.sendMessage("ARDUINOMODEUSER");
						} else if (getMode() == 2){
							websocket.sendMessage("ARDUINOMODERAW");
						}
					} else if (message.equals("SETMODERAW")){
						writeData("R");
						websocket.sendMessage("ARDUINOMODERAW");
						setMode(RAW);
					} else if (message.equals("SETMODEUSER")){
						writeData("U");
						websocket.sendMessage("ARDUINOMODEUSER");
						setMode(USER);
					} else if (message.equals("SETMODECALIB")){
						writeData("C");
						websocket.sendMessage("ARDUINOMODECALIB");
						setMode(CALIBRATION);
					}

				}
			});

		} catch (URISyntaxException ex) {
			System.err.println("URISyntaxException exception: " + ex.getMessage());
		}


		System.out.println("Initialized websocket!");

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

				String inputLine;

				double sumX, sumY, sumZ =0;
				double avgX = 0, avgY=0, avgZ =0;

				while((inputLine = input.readLine()) != null){
					System.out.println(inputLine);

					if(inputLine.trim().equals("TOOLOW")) {
						//					websocket.sendMessage("Hello");
						if(mode == CALIBRATION){
							websocket.sendMessage("ARDUINOCALIBFAIL");
						} else if (mode == USER){
							websocket.sendMessage("ARDUINONOGESTURE");
						}


					} else {
						if(mode == RAW){
							websocket.sendMessage(inputLine);
						} else {

							if(serialReadState == DATA_X) {

								serialReadState = DATA_Y;
								dataX = Utils.stringArrayToDoubleArray(inputLine.split(","));

								sumX = 0;

								for(int i=0; i<dataX.length; i++){
									sumX = sumX + dataX[i];
								}

								avgX = sumX/dataX.length;


							}else if(serialReadState == DATA_Y) {

								serialReadState = DATA_Z;
								dataY = Utils.stringArrayToDoubleArray(inputLine.split(","));

								sumY = 0;

								for(int i=0; i<dataY.length; i++){
									sumY = sumY + dataY[i];
								}

								avgY = sumY/dataY.length;

							}else if(serialReadState ==  DATA_Z) {

								serialReadState = JERK_VECTOR;
								dataZ = Utils.stringArrayToDoubleArray(inputLine.split(","));
								sumZ = 0;

								for(int i=0; i<dataZ.length; i++){
									sumZ = sumZ + dataZ[i];
								}

								avgZ = sumZ/dataZ.length;

							}else if(serialReadState == JERK_VECTOR) {

								serialReadState = DATA_X;
								//								jerkVector  = Utils.stringArrayToDoubleArray(inputLine.split(","));

								if(mode == CALIBRATION) {
									//								sampleDao.writeSamples(Fft.fft(dataX), Fft.fft(dataY), Fft.fft(dataZ), jerkVector);
									websocket.sendMessage("ARDUINOCALIBSUCCESS");
								}else if (mode == USER){

									// LEFT OR RIGHT GESTURE
									if((-20 < avgX  && avgX <20) && (avgY < -5)){
										int maxIndex = 0;
										for (int i = 1; i < dataZ.length; i++){
											double newnumber = dataZ[i];
											if ((newnumber > dataZ[maxIndex])){
												maxIndex = i;
											}
										}

										int minIndex = 0;
										for (int i = 1; i < dataZ.length; i++){
											double newnumber = dataZ[i];
											if ((newnumber < dataZ[minIndex])){
												minIndex = i;
											}
										}

										if(minIndex < maxIndex){
											websocket.sendMessage("ARDUINOLEFT");
										} else {
											websocket.sendMessage("ARDUINORIGHT");
										}


									} else if((-5 < avgX  && avgX <5) && (-5 < avgY  && avgY <5)){
										int maxIndex = 0;
										for (int i = 1; i < dataZ.length; i++){
											double newnumber = dataZ[i];
											if ((newnumber > dataZ[maxIndex])){
												maxIndex = i;
											}
										}

										int minIndex = 0;
										for (int i = 1; i < dataZ.length; i++){
											double newnumber = dataZ[i];
											if ((newnumber < dataZ[minIndex])){
												minIndex = i;
											}
										}

										if(minIndex < maxIndex){
											websocket.sendMessage("ARDUINOUP");
										} else {
											websocket.sendMessage("ARDUINODOWN");
										}
									}

									//									double [] fft = Utils.combineSampleArrays(Fft.fft(dataX), Fft.fft(dataY), Fft.fft(dataZ));

									//								System.out.println(comparator.getGesture(fft, jerkVector));



								}
							}else{
								serialReadState = DATA_X;
							}	
						}

					}
				}
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
	}


	public void setMode(int mode) {
		this.mode = mode;



		if(mode == USER) {
			comparator.loadSamples();
		} 
	}

	public int getMode(){
		return this.mode;
	}

	public void writeData(String message){
		try {
			this.output.write(message.getBytes());
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	public void run() {
	}
}