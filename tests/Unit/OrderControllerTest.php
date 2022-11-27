<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Mail;
use Tests\BaseTestCase;

/**
 * Class OrderControllerTest
 * @package Tests\Unit
 */
class OrderControllerTest extends BaseTestCase
{
    private function successPayload() : array
    {
        return [
            'products' => [
                [
                    'product_id' => 1,
                    'quantity' => 2
                ]
            ]
        ];
    }

    public function failurePayload() : array
    {
        return [
            'products' => [
                [
                    'product_id' => 1000,
                    'quantity' => 0
                ]
            ]
        ];
    }

    public function testCreateOrderSuccess()
    {
        $payload = $this->successPayload();

        $response = $this->post('/orders', $payload);
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(1, $data['id']);

        //Verify the products of this order
        $this->assertEquals(1, $data['products'][0]['id']);
        $this->assertEquals('Burger', $data['products'][0]['name']);

        //Verify the ingredients consumption update of burger product
        $this->assertEquals(300, $data['products'][0]['ingredients'][0]['amount_consumed']); //As we ordered 2 burgers so 300g of beef should be consumed
        $this->assertEquals(60, $data['products'][0]['ingredients'][1]['amount_consumed']); //As we ordered 2 burgers so 60g of cheese should be consumed
        $this->assertEquals(40, $data['products'][0]['ingredients'][2]['amount_consumed']); //As we ordered 2 burgers so 40g of onion should be consumed



        //We are ordering 24 more burgers which means total 520 grams of onion will be consumed now which is more than 50% of our stock.
        //A warning email will be sent to merchant regarding that ingredient consumption..
        Mail::fake();
        $payload = [
            'products' => [
                [
                    'product_id' => 1,
                    'quantity' => 24
                ]
            ]
        ];

        $response = $this->post('/orders', $payload);
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(2, $data['id']);

        //Verify the products of this order
        $this->assertEquals(1, $data['products'][0]['id']);
        $this->assertEquals('Burger', $data['products'][0]['name']);

        //Verify the ingredients consumption update of burger product
        $this->assertEquals(3900, $data['products'][0]['ingredients'][0]['amount_consumed']); //As we ordered 26 burgers so far, so 3900g of beef should be consumed
        $this->assertEquals(780, $data['products'][0]['ingredients'][1]['amount_consumed']); //As we ordered 26 burgers so far, so 780g of cheese should be consumed
        $this->assertEquals(520, $data['products'][0]['ingredients'][2]['amount_consumed']); //As we ordered 26 burgers so far, so 520g of onion should be consumed
    }

    public function testCreateOrderFailure()
    {
        $payload = $this->failurePayload();

        $response = $this->post('/orders', $payload);
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(['One of the products you mentioned does not exists in the system'], $data['products.0.product_id']);
        $this->assertEquals(['A product must have quantity of at least one'], $data['products.0.quantity']);
    }

    public function testCreateOrderFailureWithNoProducts()
    {
        $response = $this->post('/orders', []);
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(['Please specify valid products in order to place an order'], $data['products']);
    }
}
