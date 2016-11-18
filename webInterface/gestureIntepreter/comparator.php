<?php

namespace GestureRecognition;

class Comparator
{

  private $sampleDao;
  private $distanceThreshold = 2500;
  private $peakErrorThreshold = 10;
  private $angleThreshold = M_PI/4.0;
  private $gestureSamplesArray;

  public function __construct($gestureSamplesArray) {
	$this->gestureSamplesArray = $gestureSamplesArray;
    // $this->sampleDao = $sampleDao;
    // loadSamples();
  }

  public function getGesture($dataX, $dataY, $dataZ) {
	// echo("**************************************************************");
	// echo("Beginning gesture recognition");
	// echo("**************************************************************");
	// echo("DataX: " + Utils::doubleArrayToString($dataX));
	// echo("DataY: " + Utils::doubleArrayToString($dataY));
	// echo("DataZ: " + Utils::doubleArrayToString($dataZ));

	$fft = Utils::combineSampleArrays(Fft::fft($dataX), Fft::fft($dataY), Fft::fft($dataZ));
	
	// echo("Performed gesture fft: " + Utils::doubleArrayToString($fft));
	
	$orientation = Utils::getOrientationVector($dataX, $dataY, $dataZ);
	// echo("Performed gesture orientation: " + Utils::doubleArrayToString($orientation));
	
	$capturedPeakListX = Utils::getPeakList($dataX);
	$capturedPeakListY = Utils::getPeakList($dataY);
	$capturedPeakListZ = Utils::getPeakList($dataZ);
	
	// echo("Performed gesture peak list X: " + Utils::peakListToString($capturedPeakListX));
	// echo("Performed gesture peak list y: " + Utils::peakListToString($capturedPeakListY));
	// echo("Performed gesture peak list z: " + Utils::peakListToString($capturedPeakListZ));

	$sampleDatabase = $this->gestureSamplesArray;

    foreach ($sampleDatabase as $sample) {
      $fftError = Utils::rootMeanSquaredError($fft, $sample->getFft());
      // echo("FFT error: " + $fftError);
      
      $peakErrorX = $this->getPeakError($capturedPeakListX, $sample->getPeakListX());
      $peakErrorY = $this->getPeakError($capturedPeakListY, $sample->getPeakListY());
      $peakErrorZ = $this->getPeakError($capturedPeakListZ, $sample->getPeakListZ());
      
      // echo("Sample peak list X: " + Utils::peakListToString($sample->getPeakListX()));
      // echo("Sample peak list Y: " + Utils::peakListToString($sample->getPeakListY()));
      // echo("Sample peak list Z: " + Utils::peakListToString($sample->getPeakListZ()));
      return $peakErrorX.$peakErrorY.$peakErrorZ;
     //  $angle = Utils::angle($orientation, $sample->getOrientation());
     //  // echo("Angle between sample and performed gesture: " + $angle);
      
     //  if($peakErrorX > 0 || $peakErrorY > 0 || $peakErrorZ > 0) {	      
    	// if($fftError < $this->distanceThreshold && $peakErrorX < $this->peakErrorThreshold && $peakErrorY < $this->peakErrorThreshold && $peakErrorZ < $this->peakErrorThreshold) {
    	//   if($angle < $this->angleThreshold) { 		
    	//     // echo("Successfully recognized gesture: " + $sample->getGesture());
	    //     return $sample->getGesture();
    	//   }
     //    }
     //  }
    }

    return "NOGESTURE"; //no match return "NOGESTURE"
  }
  
  public function getPeakError($listx, $listy) {
	  if(count($listx) == count($listy)) {
		  
		  $peakDistanceX = 0;
		  $peakDistanceY = 0;

		  for($i=0;$i<count($listx)-1;$i++) {
			  $xPeak = $listx[$i];
			  $yPeak = $listy[$i];
			  
			  if($xPeak->getOrientation() != $yPeak->getOrientation()) {
				  return -1;
			  }else{
				  $peakDistanceX += $listx[$i+1]->getIndex() - $xPeak->getIndex();
				  $peakDistanceY += $listy[$i+1]->getIndex() - $yPeak->getIndex();
			  }
		  }
		  
		  $peakError = pow(($peakDistanceX - $peakDistanceY), 2);
		  return $peakError;
	  }
	  
	  return -1;
  }
  
  public function loadSamples() {
	  $sampleDatabase = $sampleDao->getSamples();
  }
}