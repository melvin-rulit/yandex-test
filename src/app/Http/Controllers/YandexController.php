<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateYandexSettingsRequest;
use App\Http\Resources\YandexSettingResource;
use App\Models\YandexSetting;
use App\Services\YandexReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YandexController extends Controller
{
    public function __construct(protected YandexReviewService $yandexService){}

    public function settings(Request $request): YandexSettingResource
    {
        $user = auth()->user();
        $settings = $user->yandexSetting;

        return new YandexSettingResource($settings);
    }

    public function update(UpdateYandexSettingsRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = Auth::user();
        $settings = $user->yandexSetting;

        if ($settings) {
            $settings->update([
                'org_url' => $validated['org_url'],
            ]);
        } else {
            $settings = new YandexSetting();
            $settings->user_id = $user->id;
            $settings->org_url = $validated['org_url'];
            $settings->save();
        }

        return response()->json([
            'org_url' => $settings->org_url
        ]);
    }
}
