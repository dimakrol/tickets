<?php
use App\Concert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 20.03.17
 * Time: 14:30
 */
class ViewConcertListingTest extends Tests\TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_a_concert_listing()
    {
        $concert = App\Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'Some cool subtitle',
            'date' => Carbon\Carbon::parse('December 13, 2106 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example',
            'city' => 'Bludville',
            'state' => 'ON',
            'zip' => '1796',
            'additional_information' => 'For tickets, call (555) 555-5555.'
        ]);

        $response = $this->get('/concerts/' . $concert->id);

        $response->assertSee('The Red Chord');
        $response->assertSee('Some cool subtitle');
        $response->assertSee('December 13, 2106');
        $response->assertSee('8:00pm');
        $response->assertSee('32.50');
        $response->assertSee('The Mosh Pit');
        $response->assertSee('123 Example');
        $response->assertSee('Bludville');
        $response->assertSee('ON');
        $response->assertSee('1796');
        $response->assertSee('For tickets, call (555) 555-5555.');

    }
}