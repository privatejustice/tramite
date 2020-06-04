<?php

namespace Tramite\Worker\Explorer\QueryList;

class GoogleSearch
{
    public $url = false;

    public function __construct()
    {

    }

    public static function search($search)
    {
        $data = QueryList::get('https://www.google.co.jp/search?q='.$search)
            // Set the crawl rules
            ->rules(
                [ 
                'title'=>array('h3','text'),
                'link'=>array('h3>a','href')
                ]
            )
            ->query()->getData();
                /*Array
                (
                    [0] => Array
                        (
                            [title] => Angular - QueryList
                            [link] => https://angular.io/api/core/QueryList
                        )
                    [1] => Array
                        (
                            [title] => QueryList | @angular/core - Angularリファレンス - Web Creative Park
                            [link] => http://www.webcreativepark.net/angular/querylist/
                        )
                    [2] => Array
                        (
                            [title] => QueryListにQueryを追加したり、追加されたことを感知する | TIPS ...
                            [link] => http://www.webcreativepark.net/angular/querylist_query_add_subscribe/
                        )
                        //...
                )   */
        return $data->all();
    }

}
