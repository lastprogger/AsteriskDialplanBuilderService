<?php


namespace Tests\Feature\Service\DialplanBuilders;


use App\Domain\Models\Extension;
use App\Domain\Models\PbxScheme;
use App\Domain\Service\DialplanBuilders\DialplanBuilder;
use App\Domain\Service\DialplanBuilders\DialplanStoreService;
use App\Domain\Service\ExtensionStorageService;
use App\Domain\Service\SwitchPbxSchemeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DialplanBuildAndStoreTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testDialplanBuildAndStoreAssertSuccess()
    {
        $playbackNodeId  = $this->faker->uuid;
        $playbackNodeId2 = $this->faker->uuid;
        $playbackNodeId3 = $this->faker->uuid;
        $playbackNodeId4 = $this->faker->uuid;
        $dialNodeId      = $this->faker->uuid;
        $calendarlNodeId = $this->faker->uuid;
        $dialCondlNodeId = $this->faker->uuid;

        $data = [
            'company_id' => $this->faker->uuid,
            'pbx_scheme_id' => $this->faker->uuid,
            'pbx_id' => $this->faker->uuid,
            'nodes'          => [
                [
                    'id' => $calendarlNodeId,
                    'data' => [
                        [
                            'time' => '00:00-23:59',
                            'weekDays' => 'mon-fri'
                        ]
                    ],
                    'node_type' => [
                        'name' => 'calendar',
                        'type' => 'condition'
                    ]
                ],
                [
                    'id' => $dialCondlNodeId,
                    'data' => [
                        [

                        ]
                    ],
                    'node_type' => [
                        'name' => 'dial_condition',
                        'type' => 'condition'
                    ]
                ],
                [
                    'id'        => $playbackNodeId,
                    'data'      => [
                        'filename' => 'helloworld',
                    ],
                    'node_type' => [
                        'name' => 'Playback',
                        'type' => 'action',
                    ],
                ],
                [
                    'id'        => $playbackNodeId2,
                    'data'      => [
                        'filename' => 'helloworld',
                    ],
                    'node_type' => [
                        'name' => 'Playback',
                        'type' => 'action',
                    ],
                ],
                [
                    'id'        => $playbackNodeId3,
                    'data'      => [
                        'filename' => 'monkeys',
                    ],
                    'node_type' => [
                        'name' => 'Playback',
                        'type' => 'action',
                    ],
                ],
                [
                    'id'        => $playbackNodeId4,
                    'data'      => [
                        'filename' => 'helloworld',
                    ],
                    'node_type' => [
                        'name' => 'Playback',
                        'type' => 'action',
                    ],
                ],
                [
                    'id'        => $dialNodeId,
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
                    'type'         => 'positive',
                    'from_node_id' => $calendarlNodeId,
                    'to_node_id'   => $playbackNodeId,
                ],
                [
                    'type'         => 'negative',
                    'from_node_id' => $calendarlNodeId,
                    'to_node_id'   => $playbackNodeId2,
                ],
                [
                    'type'         => 'direct',
                    'from_node_id' => $playbackNodeId,
                    'to_node_id'   => $dialNodeId,
                ],
                [
                    'type'         => 'direct',
                    'from_node_id' => $dialNodeId,
                    'to_node_id'   => $dialCondlNodeId,
                ],
                [
                    'type'         => 'negative',
                    'from_node_id' => $dialCondlNodeId,
                    'to_node_id'   => $playbackNodeId3,
                ],
                [
                    'type'         => 'positive',
                    'from_node_id' => $dialCondlNodeId,
                    'to_node_id'   => $playbackNodeId4,
                ],
            ],
        ];

        $dialplanBuilder = new DialplanBuilder($data);
        $dialplan        = $dialplanBuilder->build();

        $store = new DialplanStoreService(
            new SwitchPbxSchemeService(new ExtensionStorageService()), new ExtensionStorageService()
        );
        $store->storeDialplan($this->faker->uuid, $this->faker->uuid, $this->faker->uuid, $dialplan);

        $this->assertNotNull(Extension::where('app', 'Playback')->first());
        $this->assertNotNull(Extension::where('app', 'Dial')->first());
        $this->assertNotNull(Extension::where('app', 'GoTo')->first());
        $this->assertNotNull(Extension::where('app', 'NoOp')->first());

        $pbxScheme = PbxScheme::query()->first();

        $this->assertNotNull($pbxScheme);
    }
}