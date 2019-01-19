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
        $playbackNodeId = $this->faker->uuid;
        $dialNodeId     = $this->faker->uuid;

        $data = [
            'nodes'          => [
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
                    'type'         => 'direct',
                    'from_node_id' => $playbackNodeId,
                    'to_node_id'   => $dialNodeId,
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