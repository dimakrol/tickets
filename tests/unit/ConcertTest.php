<?php

namespace Tests\Unit;

use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConcertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_get_formatted_date()
    {
        $concert = Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'Some cool subtitle',
            'date' => Carbon::parse('2016-12-01 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example',
            'city' => 'Bludville',
            'state' => 'ON',
            'zip' => '1796',
            'additional_information' => 'For tickets, call (555) 555-5555.'
        ]);

        $date = $concert->formatted_date;

        $this->assertEquals('December 1, 2016', $date);
    }
}
