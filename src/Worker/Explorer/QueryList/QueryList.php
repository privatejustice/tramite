<?php

namespace Tramite\Worker\Explorer\QueryList;

class QueryList
{
    public $url = false;

    public function __construct()
    {

    }

    public function hahha()
    {
        $ql = QueryList::get('https://www.google.co.jp/search?q=QueryList');

        $ql->find('title')->text(); //The page title
        $ql->find('meta[name=keywords]')->content; //The page keywords

        $ql->find('h3>a')->texts(); //Get a list of search results titles
        $ql->find('h3>a')->attrs('href'); //Get a list of search results links

        $ql->find('img')->src; //Gets the link address of the first image
        $ql->find('img:eq(1)')->src; //Gets the link address of the second image
        $ql->find('img')->eq(2)->src; //Gets the link address of the third image
        // Loop all the images
        $ql->find('img')->map(
            function ($img) {
                echo $img->alt;  //Print the alt attribute of the image
            }
        );

        $ql->find('#head')->append('<div>Append content</div>')->find('div')->htmls();
        $ql->find('.two')->children('img')->attrs('alt'); // Get the class is the "two" element under all img child nodes
        // Loop class is the "two" element under all child nodes
        $data = $ql->find('.two')->children()->map(
            function ($item) {
                // Use "is" to determine the node type
                if($item->is('a')) {
                    return $item->text();
                }elseif($item->is('img')) {
                    return $item->alt;
                }
            }
        );

        // $ql->find('a')->attr('href', 'newVal')->removeClass('className')->html('newHtml')->...
        // $ql->find('div > p')->add('div > ul')->filter(':has(a)')->find('p:first')->nextAll()->andSelf()->...
        // $ql->find('div.old')->replaceWith( $ql->find('div.new')->clone())->appendTo('.trash')->prepend('Deleted')->...
    }

}