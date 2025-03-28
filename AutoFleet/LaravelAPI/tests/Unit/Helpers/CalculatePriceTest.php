<?php

namespace Tests\Unit\Helpers;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Helpers\CalculatePrice;
use App\Services\CarServices;
//use PHPUnit\Framework\TestCase;
use Mockery;
use Tests\TestCase; 

use Illuminate\Contracts\Routing\ResponseFactory;


class CalculatePriceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_booking_price_calculation()
    {


        $carServiceMock = Mockery::mock(CarServices::class);
        $carMock = Mockery::mock();
        $carMock->price_per_day = 50;

        $carServiceMock->shouldReceive('getCarById')
            ->with(1)
            ->andReturn($carMock);   

        $calculatePriceInstance = new CalculatePrice($carServiceMock);


        $from = '2025-02-02 10:00'; 
        $to = '2025-02-0 10:00';   
        $priceData = $calculatePriceInstance->BookingPrice($from, $to, 1);

        $response = $priceData->getData();

        $this->assertEquals('100.00', $response->total_price);


        $this->assertEquals(50, $carMock->price_per_day); 

    }





    public function test_invalid_from_date_format()
    {
        // Mock the CarServices dependency
        $carServiceMock = Mockery::mock(CarServices::class);
        $carServiceMock->shouldReceive('getCarById')->never(); // Ensure it's not called

        // Create the CalculatePrice instance
        $calculatePrice = new CalculatePrice($carServiceMock);

        // Test with an invalid 'from' date
        $from = 'invalid-date';
        $to = '2025-03-03 10:00';

        $response = $calculatePrice->BookingPrice($from, $to, 1);

        // Assert that the response status is 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->status());

        // Assert the error message
        $this->assertStringContainsString('Invalid "from" date format', json_decode($response->getContent())->message);
    }







    public function test_invalid_to_date_format()
    {
        // Mock the CarServices dependency
        $carServiceMock = Mockery::mock(CarServices::class);
        $carServiceMock->shouldReceive('getCarById')->never(); // Ensure it's not called

        // Create the CalculatePrice instance
        $calculatePrice = new CalculatePrice($carServiceMock);

        // Test with an invalid 'to' date
        $from = '2025-03-01 10:00';
        $to = 'invalid-date';

        $response = $calculatePrice->BookingPrice($from, $to, 1);

        // Assert that the response status is 422 (Unprocessable Entity)
        $this->assertEquals(422, $response->status());

        // Assert the error message
        $this->assertStringContainsString('Invalid "to" date format', json_decode($response->getContent())->message);
    }
}
