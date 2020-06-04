<?php

namespace Tramite\Worker\Explorer\QueryList;

class GithubSpider
{
    public $url = false;

    public function __construct()
    {

    }

    public static function login()
    {
        // Get the QueryList instance
        $ql = QueryList::getInstance();
        // Get the login form
        $form = $ql->get('https://github.com/login')->find('form');

        // Fill in the GitHub username and password
        $form->find('input[name=login]')->val('your github username or email');
        $form->find('input[name=password]')->val('your github password');

        // Serialize the form data
        $fromData = $form->serializeArray();
        $postData = [];
        foreach ($fromData as $item) {
            $postData[$item['name']] = $item['value'];
        }

        // Submit the login form
        $actionUrl = 'https://github.com'.$form->attr('action');
        $ql->post($actionUrl, $postData);
        // To determine whether the login is successful
        // echo $ql->getHtml();
        $userName = $ql->find('.header-nav-current-user>.css-truncate-target')->text();
        if($userName) {
            echo 'Login successful ! Welcome:'.$userName;
        }else{
            echo 'Login failed !';
        }
    }

}
