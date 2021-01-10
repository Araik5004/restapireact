<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{

	 public function testGetCompanyByInn()
	 {

			$response = $this->call('GET', '/api/companies', ["inn" => "test_inn"]);

			$response->assertStatus(200);
	 }

}
