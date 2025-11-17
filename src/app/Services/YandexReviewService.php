<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\YandexSetting;

class YandexReviewService
{
    public function getReviewsForUser($userId): array
    {
        $setting = YandexSetting::where('user_id', $userId)->first();

        if (!$setting) {
            return ['error' => 'Яндекс ссылка не найдена'];
        }

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        ])->get($setting->org_url);

        $htmlContent = $response->body();

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($htmlContent);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        $reviews = $xpath->query("//div[contains(@class, 'business-review-view')]");

        $reviewsData = [];
        $count = 0;

        foreach ($reviews as $review) {
            if ($count >= 10) {
                break;
            }

            $authorNode = $xpath->query(".//span[@itemprop='name']", $review)->item(0);
            $author = $authorNode ? $authorNode->textContent : 'Неизвестно';

            $ratingNode = $xpath->query(".//meta[@itemprop='ratingValue']", $review)->item(0);
            $rating = $ratingNode ? $ratingNode->getAttribute('content') : 'Нет рейтинга';

            $reviewTextNode = $xpath->query(".//div[contains(@class, 'business-review-view__body')]", $review)->item(0);
            $reviewText = $reviewTextNode ? $reviewTextNode->textContent : 'Нет текста отзыва';

            if ($reviewText === 'Нет текста отзыва') {
                continue;
            }
            $reviewsData[] = [
                'author' => trim($author),
                'rating' => trim($rating),
                'review_text' => trim($reviewText),
            ];

            $count++;
        }

        return $reviewsData;
    }
}
