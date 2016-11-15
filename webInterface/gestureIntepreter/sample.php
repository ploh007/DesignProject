<?php

namespace GestureRecognition;

use GestureRecognition\Utils;

class Sample
{
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

    public function __construct($dataX, $dataY, $dataZ, $jerkVector, $gesture)
    {
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

    public function getFft()
    {
        return $this->fft;
    }

    public function getJerkVector()
    {
        return $this->$jerkVector;
    }

    public function getGesture()
    {
        return $this->$gesture;
    }

    public function getDataX()
    {
        return $this->$dataX;
    }

    public function getDataY()
    {
        return $this->$dataY;
    }

    public function getDataZ()
    {
        return $this->$dataZ;
    }

    public function getPeakListX()
    {
        return $this->$peakListX;
    }

    public function getPeakListY()
    {
        return $this->$peakListY;
    }

    public function getPeakListZ()
    {
        return $this->$peakListZ;
    }

    public function getOrientation()
    {
        return $this->$orientation;
    }
}
