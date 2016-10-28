<?php 

class Peak {

	private $orientation;
	private $level;
	private $sampleIndex;
	
	public function Peak($orientation, $level, $sampleIndex) {
		$this->orientation = orientation;
		$this->level = level;
		$this->sampleIndex = sampleIndex;
	}
	
	public function getOrientation() {
		$orientation;
	}
	
	public function getLevel() {
		$level;
	}
	
	public function getIndex() {
		$sampleIndex;
	}
}