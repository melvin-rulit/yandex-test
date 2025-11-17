<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateYandexSettingsRequest;
use App\Http\Resources\YandexReviewResource;
use App\Http\Resources\YandexSettingResource;
use App\Models\YandexSetting;
use App\Services\YandexReviewService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected YandexReviewService $reviewService;

    public function __construct(YandexReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    public function getReviewsForUser(Request $request): JsonResponse
    {
        $reviews = $this->reviewService->getReviewsForUser(Auth::id());

        return response()->json($reviews);
    }
}

