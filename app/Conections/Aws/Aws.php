<?php

namespace App\Conections\Aws;

use Aws\AwsClient;
use Aws\Sdk;

class Aws
{
    private static Sdk $sdk;

    private function __construct() { }

    public static function sdk(): Sdk
    {
        if (!isset(self::$sdk)) {
            self::$sdk = new Sdk([
                'region' => getenv('AWS_DEFAULT_REGION'),
                'version' => 'latest'
            ]);
        }

        return self::$sdk;
    }
}
