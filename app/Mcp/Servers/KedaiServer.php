<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;
use Laravel\Mcp\Server\Tool;

#[Name('Kedai Server')]
#[Version('0.0.1')]
#[Instructions('Instructions describing how to use the server and its features.')]
class KedaiServer extends Server
{
    protected array $tools = [
        Tool::make(
            name: 'getKedaiInfo',
            description: 'Mendapatkan informasi dasar tentang kedai'
        )->handler(function () {
            return [
                'nama' => 'Kedai Apps',
                'status' => 'aktif',
                'version' => '1.0'
            ];
        }),
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
