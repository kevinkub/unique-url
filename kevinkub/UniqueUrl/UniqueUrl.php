<?php

namespace kevinkub\UniqueUrl;

class UniqueUrl {
    private $recursion;
    private $chars;
    private $bits;
    private $combinations;
    private $dict = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";

    function __construct($chars, $recursion = 111) {
        $this->recursion = $chars * $chars * $recursion;
        $this->chars = $chars;
        $this->bits = $this->chars * 6;
        $this->combinations = pow(2, $this->bits);
    }

    private function rotateRight($bin) {
        return (($bin & 1 ^ ($bin >> 1) & 1) << ($this->bits-1)) | ($bin >> 1);
    }

    private function rotateLeft($bin) {
        return (($bin << 1) & ($this->combinations-1)) | (($bin & 1) ^ (($bin >> ($this->bits-1)) & 1));
    }

    private function getBlock($bin, $blockno) {
        return (($bin >> $blockno * 6) & bindec('111111'));
    }

    public function encode($number) {
        if($number >= $this->combinations) {
            throw new Exception("Number '{$number}' can not be encoded within {$this->chars} chars.");
        }

        for($i = $this->recursion; $i > 0; $i--) {
            $number = $this->rotateRight($number);
        }
        $output = '';
        for($i = 0; $i < $this->chars; $i++) {
            $output .= $this->dict[$this->getBlock($number, $i)];
        }

        return $output;
    }

    public function decode($input) {
        $number = 0;
        for($i = 0; $i < $this->chars; $i++) {
            $number += strpos($this->dict, $input[$i]) << (6 * $i);
        }
        for($i = $this->recursion; $i > 0; $i--) {
            $number = $this->rotateLeft($number);
        }

        return $number;
    }
}
