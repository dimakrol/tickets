<?php

/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 20.03.17
 * Time: 14:30
 */
class ViewConcertListingTest extends Tests\TestCase
{
    /** @test */
    public function user_can_view_a_concert_listing()
    {
        $concert = Concert::create([
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



        $this->visit('/concerts/'.$concert->id);



        $this->see('The Red Chord');
        $this->see('Some cool subtitle');
        $this->see('December 13, 2106');
        $this->see('8:00pm');
        $this->see('32.50');
        $this->see('The Mosh Pit');
        $this->see('123 Example');
        $this->see('Bludville');
        $this->see('ON');
        $this->see('1796');
        $this->see('For tickets, call (555) 555-5555.');
    }
}