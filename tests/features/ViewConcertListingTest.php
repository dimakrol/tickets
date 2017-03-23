<?php
use App\Concert;
use Carbon\Carbon;
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
    public function user_can_view_a_published_concert_listing()
    {
        $concert = factory(Concert::class)->states('published')->create([
            'date' => Carbon::parse('2016-12-13 20:00:00'),
        ]);

        $response = $this->get('/concerts/' . $concert->id);

        $response->assertSee('The Red Chord');
        $response->assertSee('Some cool subtitle');
        $response->assertSee('December 13, 2016');
        $response->assertSee('8:00pm');
        $response->assertSee('32.50');
        $response->assertSee('The Mosh Pit');
        $response->assertSee('123 Example');
        $response->assertSee('Bludville');
        $response->assertSee('ON');
        $response->assertSee('1796');
        $response->assertSee('For tickets, call (555) 555-5555.');

    }

    /** @test */
    function user_cannot_view_unpublished_concert_listings()
    {
        $concert = factory(Concert::class)->states('unpublished')->create();

        $response = $this->get('/concerts/' . $concert->id);
//
        $response->assertStatus(404);
    }


}