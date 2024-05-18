<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;

/**
 * @OA\Info(title="Blog Api", version="1.0")
 */

abstract class Controller
{
    use ApiResponse;
}
