<?php

namespace Faker\Provider\ne_NP;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = ['gmail.com', 'yahoo.com', 'hotmail.com'];
    protected static $tld = ['com', 'com', 'com', 'net', 'org'];

    protected static $emailFormats = [
        '{{userName}}@{{domainName}}',
        '{{userName}}@{{domainName}}',
        '{{userName}}@{{freeEmailDomain}}',
        '{{userName}}@{{domainName}}.np',
        '{{userName}}@{{domainName}}.np',
        '{{userName}}@{{domainName}}.np',
    ];

    protected static $urlFormats = [
        'https://www.{{domainName}}.np/',
        'https://www.{{domainName}}.np/',
        'https://{{domainName}}.np/',
        'https://{{domainName}}.np/',
        'https://www.{{domainName}}.np/{{slug}}',
        'https://www.{{domainName}}.np/{{slug}}.html',
        'https://{{domainName}}.np/{{slug}}',
        'https://{{domainName}}.np/{{slug}}',
        'https://{{domainName}}/{{slug}}.html',
        'https://www.{{domainName}}/',
        'https://{{domainName}}/',
    ];
}
