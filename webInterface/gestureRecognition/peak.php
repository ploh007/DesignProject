<?php

namespace GestureRecognition;

class Peak
{
    private $orientation;
    private $level;
    private $sampleIndex;
    
    public function __construct($orientation, $level, $sampleIndex)
    {
        $this->orientation = orientation;
        $this->level = level;
        $this->sampleIndex = sampleIndex;
    }
    
    public function getOrientation()
    {
        return $this->orientation;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    
    public function getIndex()
    {
        return $this->sampleIndex;
    }
}
