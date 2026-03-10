<?php

use Laravel\Mcp\Facades\Mcp;
use App\Mcp\Servers\KedaiServer;

Mcp::web('mcp/kedai', KedaiServer::class);

// Mcp::web('/mcp/demo', \App\Mcp\Servers\PublicServer::class);
