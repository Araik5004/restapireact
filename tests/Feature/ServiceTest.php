<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{

	 public function testGetFirstCompanyInfo()
	 {
			$response = $this->get('/api/services/first/tet_inn');

			$response->assertStatus(200);
	 }

	 public function testGetSecondCompanyInfo()
	 {
			$response = $this->get('/api/services/second/tet_inn');

			$response->assertStatus(200);
	 }

	 public function testGetThirdCompanyInfo()
	 {
			$response = $this->get('/api/services/third/tet_inn');

			$response->assertStatus(200);
	 }

}
