<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdatePropertyAnalyticTypesTest extends TestCase
{
    use RefreshDatabase;

    public function seeder(){
        $this->seed(\PropertiesTableSeeder::class);
        $this->seed(\AnalyticTypesTableSeeder::class);
        $this->seed(\PropertyAnalyticsTableSeeder::class);
    }

    public function test_valid_property_id()
    {

        $this->withoutExceptionHandling();
        $this->seeder();

        $response = $this->put('api/property-analytic-types?property=1&analytic_types=3&value=5');

        $response->assertStatus(200);

        $aResponseData = $response->decodeResponseJson();

        $this->assertTrue($aResponseData['message'] == 'Property Analytic Types Updated', 'Correct Message');

    }

    public function test_invalid_property_id()
    {

        $this->withoutExceptionHandling();
        $this->seeder();

        $this->expectException(ValidationException::class);
        $response = $this->put('api/property-analytic-types?property=150&analytic_types=3&value=5');

    }

    public function test_valid_analytic_types_id()
    {

        $this->withoutExceptionHandling();
        $this->seeder();

        $response = $this->put('api/property-analytic-types?property=1&analytic_types=2&value=5');

        $response->assertStatus(200);

        $aResponseData = $response->decodeResponseJson();

        $this->assertTrue($aResponseData['message'] == 'Property Analytic Types Updated', 'Correct Message');

    }

    public function test_invalid_analytic_types_id()
    {

        $this->withoutExceptionHandling();
        $this->seeder();

        $this->expectException(ValidationException::class);
        $response = $this->put('api/property-analytic-types?property=1&analytic_types=8&value=5');

    }
}
