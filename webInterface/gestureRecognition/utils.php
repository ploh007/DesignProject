<?php

namespace GestureRecognition;

use GestureRecognition\Peak;

class Utils
{
    /* Peak Value to trigger for calculations */
    public static $PEAK_THRESHOLD = 55;

    public static function getPeakList($arrayX)
    {
        $peakList = new SplDoublyLinkedList();
        $arrayXLength = count($arrayX);
        $adjustedArray = array();
        $average = 0;

        for ($i=0; $i<$arrayXLength; $i++) {
            $average += $arrayX[$i];
            $adjustedArray[$i] = $arrayX[$i];
        }

        $average /= $arrayXLength;

        for ($i=0; $i<$arrayXLength; $i++) {
            $adjustedArray[$i] -= $average;
        }
        
        for ($i=1; $i<count($arrayXLength)-1; $i++) {
            if ($adjustedArray[$i] > $adjustedArray[$i-1] && $adjustedArray[$i] > $adjustedArray[$i+1] && abs($adjustedArray[$i]) > $PEAK_THRESHOLD) { //positive peak
                $peak = new Peak(1, $adjustedArray[$i], $i);
                $peakList->push($peak);
            } else if ($adjustedArray[$i] < $adjustedArray[$i-1] && $adjustedArray[$i] < $adjustedArray[$i+1] && abs($adjustedArray[$i]) > $PEAK_THRESHOLD) { //negative peak
                $peak = new Peak(-1, $adjustedArray[$i], $i);
                $peakList->push($peak);
            }
        }
        
        return $peakList;
    }
    
    public static function distance($arrayX, $arrayY)
    {
        $distance = 0;
        $arrayXLength = count($arrayX);

        for ($i=0; $i<$arrayXLength; $i++) {
            $distance += pow($arrayX[$i] - $arrayY[$i], 2);
        }

        return sqrt($distance);
    }
    
    public static function rootMeanSquaredError($arrayX, $arrayY)
    {
        $distance = 0;
        $arrayXLength = count($arrayX);

        for ($i=0; $i<$arrayXLength; $i++) {
            $distance += pow($arrayX[$i] - $arrayY[$i], 2);
        }

        return sqrt($distance/$arrayXLength);
    }
    
    public static function angle($arrayX, $arrayY)
    {
        $dotProduct = 0;
        $arrayXLength = count($arrayX);
        
        for ($i=0; $i<$arrayXLength; $i++) {
            $dotProduct += $arrayX[$i]*$arrayY[$i];
        }
 
        $angle = acos($dotProduct / (magnitude($arrayX) * magnitude($arrayY)));
        return $angle;
    }
    
    public static function magnitude($arrayX)
    {
        $temp = 0;
        $arrayXLength = count($arrayX);
        
        for ($i=0; $i<$arrayXLength; $i++) {
            $temp += pow($arrayX[$i], 2);
        }
        
        return sqrt($temp);
    }
    
    public static function getOrientationVector($dataX, $dataY, $dataZ)
    {
        $orientation = array();
        
        foreach ($dataX as $val) {
            $orientation[0] += $val;
        }
        
        foreach ($dataY as $val) {
            $orientation[1] += $val;
        }
        
        foreach ($dataZ as $val) {
            $orientation[2] += $val;
        }

        $orientation[0] = $orientation[0]/count($dataX);
        $orientation[1] = $orientation[1]/count($dataY);
        $orientation[2] = $orientation[2]/count($dataZ);
        return $orientation;
    }
    
    public static function stringArrayToDoubleArray($doubleStrings)
    {
        $doubleArray = array();
        $stringsLength= count($doubleStrings);

        for ($i=0; $i<$stringsLength; $i++) {
            $doubleArray[$i] = $doubleStrings[$i];
        }
        
        return $doubleArray;
    }
    
    public static function combineSampleArrays($dataX, $dataY, $dataZ)
    {
        $length = count($dataX)*3;
        $comparison = array();

        for ($i=0; $i<count($dataX); $i++) {
            $comparison[$i] = $dataX[$i];
            $comparison[$i+count($dataX)] = $dataY[$i];
            $comparison[$i+count($dataX)*2] = $dataZ[$i];
        }
        
        return $comparison;
    }
    
    public static function doubleArrayToString($arrayX)
    {
        $output = "";

        foreach ($arrayX as $val) {
            $output += $val + ", ";
        }

        return $output;
    }
    
    public static function peakListToString($peaks)
    {
        $output = "";
        
        foreach ($peaks as $peak) {
            $output += $peak->getIndex();

            if ($peak->getOrientation() == -1) {
                $output += " (down) ,";
            } else {
                $output += " (up) ,";
            }
        }

        return $output;
    }
}
