<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SummaryTest extends TestCase
{

    use RefreshDatabase;

    public function seeder(){
        $this->seed(\PropertiesTableSeeder::class);
        $this->seed(\AnalyticTypesTableSeeder::class);
        $this->seed(\PropertyAnalyticsTableSeeder::class);
    }

    public function test_invalid_search_param()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/hello/Australia');
        $response->assertStatus(400);

    }

    public function test_invalid_value_for_search_param_suburb()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/suburb/sydney');
        $response->assertStatus(400);
    }

    public function test_invalid_value_for_search_param_state()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/state/Vicx');
        $response->assertStatus(400);
    }

    public function test_invalid_value_for_search_param_country()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/country/Belgium');
        $response->assertStatus(400);
    }

    public function test_valid_search_param_suburb()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/suburb/Geelong');
        $response->assertStatus(200);
    }

    public function test_valid_search_param_state()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/state/Vic');
        $response->assertStatus(200);
    }

    public function test_valid_search_param_country()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/country/Australia');
        $response->assertStatus(200);
    }


    public function test_valid_summary_for_search_param_suburb_value_Geelong()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/suburb/Geelong');

        $response->assertStatus(200);
        $aResponseValue = $response->decodeResponseJson();

        $this->assertTrue($aResponseValue['summary']['minValue'] == 1.07272036989671, 'Correct Min Value');
        $this->assertTrue($aResponseValue['summary']['maxValue'] == 1067, 'Correct Max Value');
        $this->assertTrue($aResponseValue['summary']['medianValue'] == 23, 'Correct Median Value');
        $this->assertTrue($aResponseValue['summary']['propertiesWithValue'] == 100, 'Correct Properties With Value');
        $this->assertTrue($aResponseValue['summary']['propertiesWithoutValue'] == 0, 'Correct Properties With Value');

    }

    public function test_valid_summary_for_search_param_state_value_Vic()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/state/Vic');

        $response->assertStatus(200);
        $aResponseValue = $response->decodeResponseJson();

        $this->assertTrue($aResponseValue['summary']['minValue'] == 0.628650031117029, 'Correct Min Value');
        $this->assertTrue($aResponseValue['summary']['maxValue'] == 1067, 'Correct Max Value');
        $this->assertTrue($aResponseValue['summary']['medianValue'] == 23, 'Correct Median Value');
        $this->assertTrue($aResponseValue['summary']['propertiesWithValue'] == 100, 'Correct Properties With Value');
        $this->assertTrue($aResponseValue['summary']['propertiesWithoutValue'] == 0, 'Correct Properties With Value');

    }

    public function test_valid_summary_for_search_param_country_value_Australia()
    {
        $this->withoutExceptionHandling();
        $this->seeder();
        $response = $this->get('api/summary/country/Australia');

        $response->assertStatus(200);
        $aResponseValue = $response->decodeResponseJson();

        $this->assertTrue($aResponseValue['summary']['minValue'] == 0.628650031117029, 'Correct Min Value');
        $this->assertTrue($aResponseValue['summary']['maxValue'] == 1103, 'Correct Max Value');
        $this->assertTrue($aResponseValue['summary']['medianValue'] == 24, 'Correct Median Value');
        $this->assertTrue($aResponseValue['summary']['propertiesWithValue'] == 100, 'Correct Properties With Value');
        $this->assertTrue($aResponseValue['summary']['propertiesWithoutValue'] == 0, 'Correct Properties With Value');

    }


}
