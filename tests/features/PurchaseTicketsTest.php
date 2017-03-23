<?php

namespace Tests\Feature\features;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Concert;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PurchaseTicketsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    private function orderTickets($concert, $params)
    {
        return $this->json('POST', "/concerts/{$concert->id}/orders", $params);
    }

    private function assertValidationError($response,$field)
    {
        $response->assertStatus(422);
        $this->assertArrayHasKey($field, $response->decodeResponseJson());
    }

    /** @test */
    public function customer_can_purchase_concert_tickets()
    {
        $concert = factory(Concert::class)->create(['ticket_price' => 3250]);

        $response = $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(201);

        $this->assertEquals(3250 * 3, $this->paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals(3, $order->tickets->count());
    }

    /** @test */
    public function an_order_is_not_created_if_payment_fails()
    {
        $concert = factory(Concert::class)->create(['ticket_price' => 3250]);

        $response = $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => 'invalid-payment_token',
        ]);

        $response->assertStatus(422);
        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNull($order);
    }

    /** @test */
    public function email_is_required_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->create();

        $response = $this->orderTickets($concert, [
            'ticket_quantity' => 3,
            'payment_token' =>  $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function email_must_be_valid_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->create();

        $response = $this->orderTickets($concert, [
            'email' => 'not-valid-email',
            'ticket_quantity' => 3,
            'payment_token' =>  $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function ticket_quantity_is_required_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->create();

        $response = $this->orderTickets($concert, [
            'email' => 'not-valid-email',
            'payment_token' =>  $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError($response, 'ticket_quantity');
    }

    /** @test */
    public function ticket_quantity_must_be_at_least_1_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->create();

        $response = $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'ticket_quantity' => 0,
            'payment_token' =>  $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError($response, 'ticket_quantity');
    }

    /** @test */
    public function payment_token_is_required_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->create();

        $response = $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'ticket_quantity' => 0,
        ]);

        $this->assertValidationError($response, 'payment_token');
    }
}
