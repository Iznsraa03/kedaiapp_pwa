<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;

class NewsService
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchNewsContent(string $url): ?array
    {
        try {
            $response = $this->httpClient->get($url);
            $html = $response->getBody()->getContents();

            $dom = new DOMDocument();
            // Suppress warnings about malformed HTML
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

            $xpath = new DOMXPath($dom);

            $title = $this->extractTitle($xpath);
            $description = $this->extractDescription($xpath);
            $image = $this->extractImage($xpath, $url);
            $content = $this->extractContent($xpath);

            if ($title && $content) {
                return [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'short_description' => $description,
                    'content' => $content,
                    'image_url' => $image,
                    'source_url' => $url,
                    'published_at' => now(), // You might want to try to extract this from the page too
                ];
            }
        } catch (RequestException $e) {
            // Handle HTTP errors
            \Log::error("Failed to fetch news from {$url}: " . $e->getMessage());
        } catch (\Exception $e) {
            // Handle other parsing errors
            \Log::error("Error parsing news from {$url}: " . $e->getMessage());
        }

        return null;
    }

    protected function extractTitle(DOMXPath $xpath): ?string
    {
        // Try Open Graph title
        $ogTitle = $xpath->query("//meta[@property='og:title']/@content")->item(0);
        if ($ogTitle) {
            return trim($ogTitle->nodeValue);
        }

        // Try title tag
        $titleTag = $xpath->query("//title")->item(0);
        if ($titleTag) {
            return trim($titleTag->nodeValue);
        }

        return null;
    }

    protected function extractDescription(DOMXPath $xpath): ?string
    {
        // Try Open Graph description
        $ogDescription = $xpath->query("//meta[@property='og:description']/@content")->item(0);
        if ($ogDescription) {
            return trim($ogDescription->nodeValue);
        }

        // Try meta description
        $metaDescription = $xpath->query("//meta[@name='description']/@content")->item(0);
        if ($metaDescription) {
            return trim($metaDescription->nodeValue);
        }

        return null;
    }

    protected function extractImage(DOMXPath $xpath, string $baseUrl): ?string
    {
        // Try Open Graph image
        $ogImage = $xpath->query("//meta[@property='og:image']/@content")->item(0);
        if ($ogImage) {
            return $this->absoluteUrl($ogImage->nodeValue, $baseUrl);
        }

        // Try the first significant image in the body
        $bodyImage = $xpath->query("//body//img[not(ancestor::header) and not(ancestor::footer) and not(ancestor::nav) and @src][1]/@src")->item(0);
        if ($bodyImage) {
            return $this->absoluteUrl($bodyImage->nodeValue, $baseUrl);
        }

        return null;
    }

    protected function extractContent(DOMXPath $xpath): ?string
    {
        // A more robust content extraction would involve identifying common article containers.
        // This is a basic attempt to get text content from common elements.
        $content = '';

        // Prioritize article tag
        $articleNodes = $xpath->query("//article");
        if ($articleNodes->length > 0) {
            foreach ($articleNodes as $node) {
                $content .= $dom->saveHTML($node);
            }
            return trim($content);
        }

        // Fallback to div/p with common article classes (example)
        $potentialContentNodes = $xpath->query(
            "//div[contains(@class, 'content') or contains(@class, 'article') or contains(@class, 'post')]//p | " .
            "//p[string-length(.) > 100]"
        );
        foreach ($potentialContentNodes as $node) {
            $content .= $dom->saveHTML($node);
        }

        return trim($content) ?: null;
    }

    protected function absoluteUrl(string $url, string $baseUrl): string
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        // Handle relative URLs
        return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }
}
