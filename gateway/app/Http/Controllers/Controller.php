<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Tag(name: 'user', description: 'User related operations')]
#[OA\Info(
    version: '1.0',
    title: 'Example API',
    description: 'Example info',
    contact: new OA\Contact(name: 'Swagger API Team'),
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'API server',
)]
/*#[OA\SecurityScheme(
    securityScheme: "bearer",
    type: "http",
    name: "Authorization",
    in: "header"
)]*/
abstract class Controller
{
    //
}
