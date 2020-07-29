<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AddPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_property_response_successful()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/properties', ['suburb' => 'Parramatta',
                                                       'state' => 'NSW',
                                                       'country' => 'Australia']);
        $response->assertStatus(200);

        $aResonseData = $response->decodeResponseJson();

        $this->assertTrue($aResonseData['status']==1, 'Correct Response Code');
        $this->assertTrue($aResonseData['message']=='New Property Added', 'Correct Response Message');
        $this->assertTrue($aResonseData['property']['suburb']=='Parramatta', 'Correct Suburb');
        $this->assertTrue($aResonseData['property']['state'] == 'NSW', 'Correct State Code');
        $this->assertTrue($aResonseData['property']['country'] == 'Australia', 'Correct Country Code');
    }

    public function test_add_property_missing_suburb_response_failed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);
        $response = $this->post('api/properties', ['state' => 'NSW',
                                                       'country' => 'Australia']);

    }

    public function test_add_property_missing_state_response_failed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);
        $response = $this->post('api/properties', ['suburb' => 'Parramatta',
                                                       'country' => 'Australia']);

    }

    public function test_add_property_missing_country_response_failed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);
        $response = $this->post('api/properties', ['suburb' => 'Parramatta',
                                                       'state' => 'NSW',]);

    }
}
