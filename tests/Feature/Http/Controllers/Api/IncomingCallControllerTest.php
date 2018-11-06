<?php


namespace Tests\Feature\Http\Controllers;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use InternalApi\PbxSchemeServiceApi\PbxSchemeServiceApi;
use InternalApi\PhoneNumberServiceApi\PhoneNumberServiceApi;
use Tests\TestCase;

class IncomingCallControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function testCallSetUp()
    {
        $response = $this->json(
            'POST', '/api/v1/call-setup', [
                      'did_number' => '+820305554',
                      'caller_id'  => '+79141821917',
                  ]
        );
        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'scheme' => [
                    'id',
                    'nodes'          => [
                        [
                            'id',
                        ],
                    ],
                    'node_relations' => [
                        [
                            'id'
                        ]
                    ],
                ],
            ]
        );
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
