<?php

namespace App\Http\Controllers;

use App\Services\HomeDataService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly HomeDataService $homeDataService)
    {
    }

    public function index(): View
    {
        $data = rescue(
            fn() => $this->homeDataService->getHomeData(),
            fn($e) => tap($this->homeDataService->getEmptyData(),
                fn() => Log::error('Home page error: ' . $e->getMessage())
            )
        );

        return view('home', $data);
    }
}
