<?php

namespace GestureRecognition;

class Fft
{
    public static function fft($samples)
    {
        // Multidimensional Array
        $complexFft = Fft::complexFft($samples, count($samples), 1, 0);
        $fftMagnitudes = array();

        for ($i=0; $i<count($samples); $i++) {
            $fftMagnitudes[$i] = sqrt(pow($complexFft[$i][0], 2) + pow($complexFft[$i][1], 2));
        }

        return $fftMagnitudes;
    }

    public static function complexFft($arrayX, $n, $s, $start)
    {
        $result;

        if ($n == 1) {
            $result = array(array());
            $result[0][0] = $arrayX[$start];
            $result[0][1] = 0.0;
        } else {
            $result = array(array());
            $bottom = Fft::complexFft($arrayX, $n/2, 2*$s, $start);
            $top = Fft::complexFft($arrayX, $n/2, 2*$s, $start + $s);

            for ($k=0; $k<($n/2); $k++) {
                $topK = $k+($n/2);

                $theta = -2*pi()*$k/$n; //calculate theta
                $exp = array(cos($theta), sin($theta)); //calculate exponential

                $expTimesTopK = array($exp[0]*$top[$k][0] - $exp[1]*$top[$k][1], $exp[1]*$top[$k][0] + $exp[0]*$top[$k][1]); //multiple by top K

                $temp = $bottom[$k];

                $result[$k][0] = $temp[0] + $expTimesTopK[0]; //real part, bottom
                $result[$k][1] = $temp[1] + $expTimesTopK[1]; //imaginary part, bottom

                $result[$topK][0] = $temp[0] - $expTimesTopK[0]; //real part, top
                $result[$topK][1] = $temp[1] - $expTimesTopK[1]; //imaginary part, top
            }
        }

        return $result;
    }
}
