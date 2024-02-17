<?php

namespace CommonPHP\Tests\DatabaseEngine;

use ArrayIterator;
use CommonPHP\DatabaseEngine\Result;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    private Result $result;
    protected function setUp(): void
    {
        $this->result = new Result(new TypeConversionProvider(), 5, new ArrayIterator([
            ['id' => 1, 'name' => 'John Smith'],
            ['id' => 2, 'name' => 'Jane Doe'],
            ['id' => 3, 'name' => 'Mickey Mouse'],
            ['id' => 4, 'name' => 'Lorna Dune'],
            ['id' => 5, 'name' => 'John Wick']
        ]));
    }

    /*public function testRead()
    {

    }*/

    public function testGetValue()
    {
        //$val = $this->result->getValue('id', \DateTime::class);

    }

    /*public function testGetRowCount()
    {

    }

    public function testGetColumnNames()
    {

    }

    public function testGetColumnCount()
    {

    }

    public function testGetNameOf()
    {

    }

    public function testGetOrdinalOf()
    {

    }*/
}
