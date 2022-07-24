<?php

namespace Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OrderFileConverterServiceTest extends KernelTestCase
{
    public function testConvertOrderObjectToOrderData()
    { 
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->register('dataInterface', 'App\Util\Data\OrderData');
        $containerBuilder->register('parameterBagInterface', 'Symfony\Component\DependencyInjection\ParameterBag\ParameterBag')
            ->addArgument(['google_map_api_key' => 'test']);
        $containerBuilder->register('geocodingService', 'App\Util\Service\GeocodingService')
            ->addArgument(new Reference('parameterBagInterface')); 
        $containerBuilder->register('orderFileConverterService', 'App\Util\Service\OrderFileConverterService')
            ->addArgument(new Reference('dataInterface'))->addArgument(new Reference('geocodingService'));
            
        $orderFileConverterService = $containerBuilder->get('orderFileConverterService');
        $orderString = '{"order_id":1033,"order_date":"Sun, 10 Mar 2019 06:30:02 +0000",
            "customer":{"customer_id":7652056,"first_name":"Electa",
            "last_name":"Okuneva","email":"electa.okuneva@example.com",
            "phone":"4471.8531","shipping_address":{"street":"39 WILLIAMSON AVENUE",
            "postcode":"3041","suburb":"STRATHMORE","state":"VICTORIA"}},
            "items":[{"quantity":6,"unit_price":59.95,"product":{"product_id":3680410,
            "title":"JETS Women\'s E/F Cup Underwire One Piece - Teal","subtitle":null,
            "image":"https://s.catch.com.au/images/product/0018/18211/5c820ebd01823684832373.jpg",
            "thumbnail":"https://s.catch.com.au/images/product/0018/18211/5c820ebd01823684832373_w200.jpg",
            "category":["FASHION APPAREL","APPAREL - WOMENS","SWIMWEAR","ONE PIECE"],
            "url":"https://www.catch.com.au/product/jets-womens-e-f-cup-underwire-one-piece-teal-3680410",
            "upc":"9326659633583","gtin14":null,"created_at":"2019-02-07 16:54:39","brand":{"id":197636,"name":"Jets"}}},
            {"quantity":1,"unit_price":14.99,"product":{"product_id":3823397,
            "title":"HIIT: High Intensity Intercourse Training Book","subtitle":null,
            "image":"https://s.catch.com.au/images/product/0019/19294/5cb50f537178e963271063.jpg",
            "thumbnail":"https://s.catch.com.au/images/product/0019/19294/5cb50f537178e963271063_w200.jpg",
            "category":["ADULT","ACCESSORIES","BOOKS","BOOKS ADULT"],
            "url":"https://www.catch.com.au/product/hiit-high-intensity-intercourse-training-book-3823397",
            "upc":"9781529102819","gtin14":null,"created_at":"2019-03-20 12:59:14","brand":{"id":4085,"name":"Penguin"}}}],
            "discounts":[{"type":"DOLLAR","value":6,"priority":1},{"type":"PERCENTAGE","value":8,"priority":2}],
            "shipping_price":10.99}';
        $dataInterface = $orderFileConverterService->convertOrderObjectToOrderData(json_decode($orderString));
          
        $this->assertEquals($dataInterface->getOrderId(), 1033); 
        $this->assertEquals($dataInterface->getOrderDateTime(), '"Sun, 10 Mar 2019 06:30:02 +0000"'); 
        $this->assertEquals($dataInterface->getTotalOrderValue(), 339.19); 
        $this->assertEquals($dataInterface->getAverageUnitPrice(), 48.46); 
        $this->assertEquals($dataInterface->getDistinctUnitCount(), 2); 
        $this->assertEquals($dataInterface->getTotalUnitsCount(), 7); 
        $this->assertEquals($dataInterface->getCustomerState(), '"VICTORIA"'); 
        $this->assertEquals($dataInterface->getLatitude(), 0); 
        $this->assertEquals($dataInterface->getLongitude(), 0); 
    }
}