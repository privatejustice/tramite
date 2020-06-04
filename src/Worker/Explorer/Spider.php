<?php

namespace Tramite\Worker\Explorer;

use Tramite\Models\Digital\Infra\Domain;
use Tramite\Models\Digital\Internet\Url;
use Tramite\Models\Digital\Internet\UrlLink;

/**
 * Spider Class
 *
 * @class   Spider
 * @package crawler
 */
class Spider
{

    protected $url = false;

    protected $domain = false;

    protected $crawler = false;

    protected $follow = false;
    
    public function __construct($url, $follow = true)
    {
        if ($url instanceof Domain) {
            $this->domain = $url;
            $url = $this->domain->getRootPage();
        }

        $this->url = $url;
        $this->follow = $follow;
        $this->crawler = $this->getCrawler();
    }

    public function execute()
    {
        return $this->explore($this->url);
    }

    protected function getCrawler()
    {
        return new Crawler();
    }
    
    /**
     * Explorarrrrrrrr
     */
    protected function explore(Url $actualUrl)
    {
        /**
         * $output['html'] = curl_exec($ch);
        $output['md5'] = md5($output['html']);
        $output['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        $output['reported_size'] = curl_getinfo($ch,CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $output['actual_size'] = curl_getinfo($ch,CURLINFO_SIZE_DOWNLOAD);
        $output['type'] = curl_getinfo($ch,CURLINFO_CONTENT_TYPE);
        $output['modified']
         */
        $page = $this->crawler->curlPage($actualUrl);
        $title = $this->crawler->getTitleFromHtml($page['html']);
        $othersLinks = $this->crawler->getLinks($page['html']);

        if (is_string($actualUrl)) {
            $actualUrl = $this->saveUrl(
                \Validate\Url::cleanLink($actualUrl, $actualUrl),
                count($othersLinks),
                $crawl_tag
            );
        }

        foreach($othersLinks as $indice=>$link) {
            $othersLinks[$indice] = \Validate\Url::cleanLink($link, $actualUrl->url);
            
            $this->saveLink(
                $actualUrl,
                $this->returnOrCreateUrl($othersLinks[$indice])
            );
        }

        if (!$this->follow) {
            return true;
        }

        return $this->exploreInLot($othersLinks);
    }

    /**
     * Segue e explora os outros links tambem !
     */
    public function exploreInLot(array $othersLinks, $followOtherDomain = false)
    {
        foreach($othersLinks as $indice=>$link) {
            if ($followOtherDomain || !\Validate\Url::outOfDomain($link, $this->domain->url)) {
                $this->explore($link);
            }
        }

        return true;
    }

    /**
     * Returns filesize in human readable terms
     *
     * Inspired by code available at http://stackoverflow.com/questions/1222245/calculating-script-memory-usages-in-php
     * Code distributed under CC-Wiki License (http://creativecommons.org/licenses/by-sa/2.5/) 
     *
     * @params int $size filesize in bytes
     */
    public function fileSize($size)
    {
        $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
    }



    /*
    * Data storage and retrieval functions
    */

    /**
     * Adds a URL to the URLs table upon discovery in a link
     *
     * @params string $link URL to add
     * @params int $clicks number of clicks from initial page
     * @return bool true on sucess, false on fail
     */
    protected function saveUrl($urlLink,$clicks = null,$crawl_tag = null)
    {
        return Url::create(
            [
            'url' => urldecode($urlLink),
            'clicks' => $clicks,
            'crawl_tag' => $crawl_tag
            ]
        );
    }

    /**
     * Adds a link to the links table
     *
     * @params int $form ID of linking page
     * @params int $to ID of target page
     * @return int|bool LinkID on sucess, false on fail
     */
    protected function saveLink($from, $to)
    {
        if ($from == $to) {
            return false;
        }
        if ($from->id == $to->id) {
            return false;
        }
        return UrlLink::create(
            [
                'from_bot_internet_url_id' => $from->id,
                'to_bot_internet_url_id' => $to->id
            ]
        );
    }

    /**
     * Grab all links on a given page, optionally for a specific depth
     *
     * @params int $pageID pageID
     * @params int $click optionally the number of clicks from the homepage to restrict results
     * @return array Multidimensional array keyed by target pageID with page data
     */
    protected function getLinks($pageID,$click = '')
    {
        $links = UrlLink::where(
            [
            'from'=>$pageID
            ]
        )->get();

        foreach ($links as $link){
            $output[$link->to->id] = $this->getPage($link->to);
        }

        return $output;
    }

    /**
     * Shorthand MySQL protected function to count links in or out of a given page
     *
     * @params int $pageID subject page
     * @params string $direction Direction to retrieve (either "to" or "from")
     * @return int Number of links
     */
    protected function countLinks($pageID,$direction)
    {
        return UrlLink::where(
            [
            $direction => $pageID
            ]
        )->count();
    }

    /**
     * Shorthand MySQL protected function to get a particular page's row
     *
     * @params int $pageId target page
     * @return array Associative array of page data
     */
    protected function getPage($pageId)
    {
        return Url::find($pageId);
    }


    /**
     * Shorthand MySQL protected function to to get the first 100 uncrawled URLs 
     *
     * @return array Associative array of uncrawled URLs & page data
     */
    protected function uncrawledUrls($crawlTag)
    {
        return Url::where(
            [
            'crawled' => 0,
            'crawl_tag' => $crawlTag
            ]
        )->limit(100)->get();
    }

    /**
     * Checks to see if a given URL is already in the pages table
     *
     * @params string $link URL to check
     * @return bool true if URL exists, false if not found
     */
    protected function returnOrCreateUrl($urlLink, $clicks = null,$crawlTag = null)
    {
        $url = $this->haveUrl($urlLink, $clicks, $crawlTag);
        if (!$url) {
            return $this->saveUrl($urlLink, $clicks, $crawlTag);
        }
        return $url;
    }

    /**
     * Checks to see if a given URL is already in the pages table
     *
     * @params string $link URL to check
     * @return bool true if URL exists, false if not found
     */
    protected function haveUrl($url, $crawlTag = false)
    {
        $url = Url::where(
            [
            'url' => $url
            ]
        )->get();
        if (!$url || sizeof($url)==0) { return false;
        } else { return $url->first();
        }
    }
}
