<?php


public class SerialReader implements SerialPortEventListener, Runnable {

	private SerialPort serialPort;

	private static final String PORT_NAMES[] = { 
			//"COM8", // Windows
			"/dev/ttyUSB0",  // Linux
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

	private int serialReadState = DATA_X;

	private double [] dataX = null;
	private double [] dataY = null;
	private double [] dataZ = null;
	private double [] jerkVector = null;

	private Comparator comparator;
	private SampleDao sampleDao;
	
	private String gesture = "";

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
		} catch (Exception $e) {
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
					} else if (message.contains("SETMODECALIB")){ //message should be in the form of SETMODECALIB:<GESTURE_NAME>
						gesture = message.split(":")[1]; //extract gesture name from gesture
						writeData("C");
						websocket.sendMessage("ARDUINOMODECALIB");
						setMode(CALIBRATION);
					}
				}
			});

		} catch (URISyntaxException $ex) {
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

				while((inputLine = input.readLine()) != null){  //new input from arduino

					if(inputLine.trim().equals("TOOLOW")) {
						if(mode == CALIBRATION){ //if gesture was too weak...
							websocket.sendMessage("ARDUINOCALIBFAIL"); //then indicate calibration failed when in calibration mode
						} else if (mode == USER){
							websocket.sendMessage("ARDUINONOGESTURE"); //or send NOGESTURE if in user mode
						}

					} else {
						if(mode == RAW){ //In raw data streaming mode, just send the received string over the web socket
							websocket.sendMessage(inputLine);
						} else {

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
									sampleDao.writeSamples(gesture, dataX, dataY, dataZ, jerkVector);
									websocket.sendMessage("ARDUINOCALIBSUCCESS");
								}else if (mode == USER){

									String gesture = comparator.getGesture(dataX, dataY, dataZ, jerkVector);
									websocket.sendMessage(gesture);
								}
							}else{ //got into an unexpected state, go back the the starting state
								serialReadState = DATA_X;
							}	
						}

					}
				}
			} catch (Exception $e) {
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
		} catch (IOException $e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	public void run() {
	}
}