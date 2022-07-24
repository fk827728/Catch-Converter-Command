<?php

namespace Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CsvConverterTest extends KernelTestCase
{
    public function testConvert()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->register('dataInterface', 'App\Util\Data\OrderData');
        $containerBuilder->register('csvConverter', 'App\Util\Converter\CsvConverter');
        
        $dataInterface = $containerBuilder->get('dataInterface');
        $dataInterface->setOrderId(1);
        $dataInterface->setOrderDateTime('Fri, 24 July 2022, 12:00:00');
        $dataInterface->setTotalOrderValue(123);
        $dataInterface->setAverageUnitPrice(12.3);
        $dataInterface->setDistinctUnitCount(5);
        $dataInterface->setTotalUnitsCount(10);
        $dataInterface->setCustomerState('SA');
        $dataInterface->setLatitude(-34.92);
        $dataInterface->setLongitude(138.59);
        
        $csvConverter = $containerBuilder->get('csvConverter');
        $result = $csvConverter->convert($dataInterface);
        
        $this->assertEquals('"1","Fri, 24 July 2022, 12:00:00","123","12.3","5","10","SA","-34.92","138.59"', $result);
    }
}