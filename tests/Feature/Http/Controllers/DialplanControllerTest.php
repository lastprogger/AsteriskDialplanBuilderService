<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\Models\Extension;
use App\Domain\Models\ExtensionsStorage;
use App\Domain\Models\PbxScheme;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DialplanControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testCreateDialplan()
    {
        $node1       = $this->faker->uuid;
        $node2       = $this->faker->uuid;
        $pbxId       = $this->faker->uuid;
        $pbxSchemeId = $this->faker->uuid;

        $data = [
            'company_id'     => $this->faker->uuid,
            'pbx_scheme_id'  => $pbxSchemeId,
            'pbx_id'         => $pbxId,
            'nodes'          => [
                [
                    'id'        => $node1,
                    'data'      => [
                        'filename' => 'helloworld',
                    ],
                    'node_type' => [
                        'name' => 'Playback',
                        'type' => 'action',
                    ],
                ],
                [
                    'id'        => $node2,
                    'data'      => [
                        'endpoint'      => '305',
                        'music_on_hold' => 'default',
                    ],
                    'node_type' => [
                        'name' => 'Dial',
                        'type' => 'action',
                    ],
                ],
            ],
            'node_relations' => [
                [
                    'type'         => 'direct',
                    'from_node_id' => $node1,
                    'to_node_id'   => $node2,
                ],
            ],
        ];

        $response = $this->json('POST', '/api/v1/dialplan', $data);

        $response->isOk();
        $response->assertJson(
            [
                'data' => [],
                'meta' => [
                    'code' => 200,
                    'message' => 'ok'
                ]
            ]
        );

        $this->assertNotNull(Extension::where('app', 'Playback')->first());
        $this->assertNotNull(Extension::where('app', 'Dial')->first());
        $this->assertNotNull(Extension::where('app', 'GoTo')->first());
        $this->assertNotNull(Extension::where('app', 'NoOp')->first());

        $pbxScheme = PbxScheme::where('pbx_id', $pbxId)->first();

        $reservedExtensions = ExtensionsStorage::query()->where('free', false)->get();

        $this->assertCount(2, $reservedExtensions, 'Count of reserved extensions is not assert');

        $this->assertNotNull($pbxScheme);

    }
}