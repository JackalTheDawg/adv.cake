<?php

class StringReverse{
    public function reverse(?string $str){
        $reversed = [];

        preg_match_all('/[A-ZА-ЯЁ]/u', $str, $uppers, PREG_OFFSET_CAPTURE);
        preg_match_all('/[\W\s\_]+/u', $str, $matches, PREG_OFFSET_CAPTURE);
    
        $letters = mb_str_split($str);
    
    
        foreach($letters as $index => $letter){
            for($i=0; $i<count($uppers[0]); $i++){
                if($uppers[0][$i][0] === $letter){
                    $uppers[0][$i][1] = $index;
                }
            }
        }
    
        foreach($letters as $index => $letter){
            for($i=0; $i<count($matches[0]); $i++){
                if($matches[0][$i][0] === $letter){
                    $matches[0][$i][1] = $index;
                }
            }
        }
    
    
        $str = mb_strtolower($str);
        $words = preg_split('/[\W\s\_]+/u', $str);
        
        foreach($words as $word){
            $reversed[] = strrev(mb_convert_encoding($word, 'UTF-16BE', 'UTF-8'));
        }
    
        for($i=0; $i<count($reversed); $i++){
            $reversed[$i] = mb_convert_encoding($reversed[$i], 'UTF-8', 'UTF-16LE');
        }
    
        if(!empty($matches[0])){
    
            $border = [
                "start" => 0,
                "end" => strlen($str)-1
            ];
    
            foreach($matches[0] as $match){
                if($match[1] === 0){
                    $border["start"] = 1;
                    $reversed[0] = $match[0];
                }
                elseif($match[1] === $border['end']){
                    $reversed[count($reversed) - 1] = $match[0];
                }
            }
        
            for($i=$border["start"]; $i<count($matches[0]); $i++){
                if($matches[0][$i][1] !== $border["end"]){
                   $reversed[$i] = $reversed[$i].$matches[0][$i][0];
                }
            }
        }
        
        $reversed_string = implode($reversed);
        $symbols = mb_str_split($reversed_string);
    
        if(!empty($uppers[0])){
            
            foreach($uppers[0] as $upper){
                $symbols[$upper[1]] = mb_strtoupper($symbols[$upper[1]]);
            }
        }
    
    
        return implode($symbols);
    }
}


?>