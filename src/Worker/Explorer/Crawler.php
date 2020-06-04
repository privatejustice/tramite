<?php

namespace Tramite\Worker\Explorer;

/**
 * Crawler Class
 *
 * @class   Crawler
 * @package crawler
 */
class Crawler
{

    public static $USER_AGENT = 'Mozilla/5.0 (FCC New Media Web Crawler)';

    public $excludedArray = [];

    public $domainArray = [];

    /**
     * Curl and Parsing Functions
     */
    
    /**
     * cURL Function which returns HTML and page info as array
     *
     * @params string $url URL to cURL
     * @return array Associative array of results
     */
    public function curlPage($url)
    {
        if (is_object($url)) {
            $url = $url->url;
        }
        $ch = curl_init($url);
        $options = array(
                CURLOPT_HEADER => false,
                CURLOPT_COOKIEJAR => 'cookie.txt',
                CURLOPT_COOKIEFILE    => 'cookie.txt',
                CURLOPT_USERAGENT => self::$USER_AGENT,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FILETIME => true,
                CURLOPT_TIMEOUT => 15
                );
        curl_setopt_array($ch, $options);
        $output['html'] = curl_exec($ch);
        $output['md5'] = md5($output['html']);
        $output['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $output['reported_size'] = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $output['actual_size'] = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
        $output['type'] = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $output['modified'] = curl_getinfo($ch, CURLINFO_FILETIME);    
        curl_close($ch);
        return $output;
    }

    /**
     * Function to parse page for title tags
     *
     * @params string $data HTML of page
     * @return string|bool title of page of null if not found
     */
    public function getTitleFromHtml($data)
    {
        if (preg_match('#<title>(.*)</title>#is', $data, $title)) { return trim($title[1]);
        } else { return null;
        }
    }

    /**
     * Function to parse page for links
     *
     * @params string $data HTML of target page
     * @return array Numeric array of links on page (URLs only)
     */
    public function getLinks($data)
    {
        $regexp = "<a\s[^>]*href=([\"|']??)([^\"' >]*?)\\1[^>]*>(.*)<\/a>";
        if(preg_match_all("/$regexp/siU", $data, $matches)) { return $matches[2];
        } else { return array();
        }
    }
}