<?php

use PHPUnit\Framework\TestCase;
require_once './ReverseClass.php';

class UnitTest extends TestCase{
    public static array $strings = [
        "stroka", "Stroka", "stRo-kA", "st  rO??k!a",
        'кириллица','Кириллица', 'кириЛлица!', 'кир Ил=и,ца', '?Кирил.лица',
        '419', '419 781', '8-800'
    ];
    public static array $scallars = [
        419,
        4.19,
        true
    ];


    public function testEmpty() : void
    {
        $result = (new StringReverse) -> reverse(null);
        $this -> assertEquals($result, '');
    }

    public function testUnequals(): void{
        foreach(self::$strings as $str){
            $reversed = (new StringReverse) -> reverse($str);
            $is_equal = $reversed === $str ? true : false;
            $this -> assertFalse($is_equal);
        }
    }

    public function testScallars(): void{
        foreach(self::$scallars as $type){
            $result = (new StringReverse) -> reverse($type);
            $this -> assertTrue(is_string($result));
        }
    }

    public function testArray(){
        $this->expectException(\Throwable::class);
        $result = (new StringReverse) -> reverse([]);
    }

    public function testEquals():void{
        foreach(self::$strings as $str){
            $reversed = (new StringReverse) -> reverse($str);
            $unreverse = (new StringReverse) -> reverse($reversed);
            $this -> assertSame($str, $unreverse);
        }
    }

}


?>