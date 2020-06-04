<?php

namespace Tramite\Worker\Explorer\SpatieCrawler;

/**
 * https://github.com/spatie/crawler
 */

use Spatie\Crawler\Crawler;

abstract class SpatieCrawler
{
    public function getCrawler()
    {
        return Crawler::create()->ignoreRobots()->setConcurrency(1)
        // Stop in 5 urls
            ->setMaximumCrawlCount(5)
        // Maxim REsponse e Delay 
            ->setMaximumResponseSize(1024 * 1024 * 3)->setDelayBetweenRequests(150);
    }
    public function execute($url)
    {

        $this->crawler = $this->getCrawler()
            ->setCrawlObserver(CrawlObserver)
            ->startCrawling($url);
    }

    public function executeMultipleObservers()
    {
        $this->crawler = $this->getCrawler()
            ->setCrawlObservers(
                [
                CrawlObserver,
                CrawlObserver,
                // ...
                ]
            )
            ->startCrawling($url);

            //or

            // Crawler::create()
            // ->addCrawlObserver(<class that extends \Spatie\Crawler\CrawlObserver>)
            // ->addCrawlObserver(<class that extends \Spatie\Crawler\CrawlObserver>)
            // ->addCrawlObserver(<class that extends \Spatie\Crawler\CrawlObserver>)
            // ->startCrawling($url);
    }

    public function executeJavascript()
    {
        $this->crawler->executeJavaScript();
    }

    protected function getAllLinks($html)
    {
        $domCrawler = new DomCrawler($html);
    
        return collect(
            $domCrawler->filterXpath('//a')
                ->extract(['href'])
        )
            ->map(
                function ($url) {
                    return Url::create($url);
                }
            );
    }

    protected function normalizeUrl(Url $url)
    {
        if ($url->isRelative()) {
            $url->setScheme($this->baseUrl->scheme)
                ->setHost($this->baseUrl->host);
        }
        if ($url->isProtocolIndependent()) {
            $url->setScheme($this->baseUrl->scheme);
        }
        return $url->removeFragment();
    }


    /**
     * Crawl all links in the given html.
     *
     * @param string $html
     */
    protected function crawlAllLinks($html)
    {
        $allLinks = $this->getAllLinks($html);

        collect($allLinks)
            ->filter(
                function (Url $url) {
                    return !$url->isEmailUrl();
                }
            )
            ->map(
                function (Url $url) {
                    return $this->normalizeUrl($url);
                }
            )
            ->filter(
                function (Url $url) {
                    return $this->crawlProfile->shouldCrawl($url);
                }
            )
            ->each(
                function (Url $url) {
                    $this->crawlUrl($url);
                }
            );
    }
}