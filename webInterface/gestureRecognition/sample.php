<?php

public class Sample {

  private $fft;
  private $dataX;
  private $dataY;
  private $dataZ;
  private $orientation;

  private $peakListX;
  private $peakListY;
  private $peakListZ;
  
  private $jerkVector;
  private $gesture;

  public function Sample($dataX, $dataY, $dataZ, $jerkVector, $gesture) {
    $this->dataX = $dataX;
    $this->dataY = $dataY;
    $this->dataZ = $dataZ;
    $this->orientation =  Utils::getOrientationVector($dataX, $dataY, $dataZ);

    $this->peakListX = Utils::getPeakList($dataX);
    $this->peakListY = Utils::getPeakList($dataY);
    $this->peakListZ = Utils::getPeakList($dataZ);

    $this->fft = Utils::combineSampleArrays(Fft::fft($dataX), Fft::fft($dataY), Fft::fft($dataZ));

    $this->jerkVector = $jerkVector;
    $this->gesture = $gesture;
  }


    public function getFft() {
    return $fft;
  }
  
  public function getJerkVector() {
      return $jerkVector;
  }

  public function getGesture() {
    return $gesture;
  }
  
  public function getDataX() {
      return $dataX;
  }
  
  public function getDataY() {
      return $dataY;
  }
  
  public function getDataZ() {
      return $dataZ;
  }
  
  public function getPeakListX() {
      return $peakListX;
  }
  
  public function getPeakListY() {
      return $peakListY;
  }
  
  public function getPeakListZ() {
      return $peakListZ;
  }
  
  public function getOrientation() {
      return $orientation;
  }
}