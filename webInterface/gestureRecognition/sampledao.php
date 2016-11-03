<?php

namespace GestureRecognition;

class SampleDao
{

    public function getSamples()
    {
        $samples = new SplDoublyLinkedList();

        try {
            $fr = new FileReader("samples.txt");
            $br = new BufferedReader($fr);
            $line;

            while (($line = $br.readLine()) != null) {
                $rawSample = $line.split(":");
                $gesture = $rawSample[0];

                $rawDataX = $rawSample[1].split(",");
                $dataX = Utils::stringArrayToDoubleArray($rawDataX);

                $rawDataY = $rawSample[2].split(",");
                $dataY = Utils::stringArrayToDoubleArray($rawDataY);

                $rawDataZ = $rawSample[3].split(",");
                $dataZ = Utils::stringArrayToDoubleArray($rawDataZ);

                $jerkVector = null;

                if (count($rawSample) == 5) {
                    $rawJerkVector = $rawSample[4].split(",");
                    $jerkVector = Utils::stringArrayToDoubleArray($rawJerkVector);
                }

                $sample = new Sample($dataX, $dataY, $dataZ, $jerkVector, $gesture);
                $samples.add($sample);

                echo("Added new sample: " + $sample.getGesture());
            }
        } catch (FileNotFoundException $e) {
            echo("Encountered a FileNotFoundException while reading fft file.");
        } catch (IOException $e) {
            echo("Encountered an IOException while reading fft file.");
        }

        return $samples;
    }
    
    public function writeSamples($gestureName, $dataX, $dataY, $dataZ, $jerkVector)
    {
        
        try {
            $writer = new PrintWriter(new FileOutputStream("samples.fft", true));
            $outputString = $gestureName;
                    
            for ($i=0; $i<count($dataX); $i++) {
                $outputString += $dataX[$i];

                if ($i < count($dataX)-1) {
                    $outputString += ",";
                } else {
                    $outputString += ":";
                }
            }
            
            for ($i=0; $i<count($dataY); $i++) {
                $outputString += $dataY[$i];

                if ($i < count($dataY)-1) {
                    $outputString += ",";
                } else {
                    $outputString += ":";
                }
            }
            
            for ($i=0; $i<count($dataZ); $i++) {
                $outputString += $dataZ[$i];

                if ($i < count($dataZ)-1) {
                    $outputString += ",";
                } else {
                    $outputString += ":";
                }
            }
            
            $outputString += ":";
            
            for ($i=0; $i<count($jerkVector); $i++) {
                $outputString += $jerkVector[$i] + ",";
            }

            $writer.println($outputString);
            $writer.flush();
        } catch (FileNotFoundException $e) {
            $e.printStackTrace();
        }
    }
}
