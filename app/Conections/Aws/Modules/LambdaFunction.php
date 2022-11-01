<?php

namespace App\Conections\Aws\Modules;

use App\Conections\Aws\Aws;
use Aws\Lambda\LambdaClient;
use Aws\Result;

class LambdaFunction
{
    const VAN_DISABLE = 'vanfora';

    private static LambdaClient $client;
    private Result $functionData;

    public function __construct(string $functionName)
    {
        if (!isset(self::$client)) {
            self::$client = Aws::sdk()->createLambda();
        }
        $this->functionData = self::$client->getFunction([
            'FunctionName' => $functionName,
        ]);
    }

    private function setEnv(string $key, string $value)
    {
        self::$client->updateFunctionConfiguration([
            'FunctionName' => $this->getFunctionName(),
            'Environment' => [
                'Variables' => array_merge($this->getEnv(), [$key => $value]),
            ],
        ]);
    }

    private function getFunctionName(): string
    {
        return $this->functionData['Configuration']['FunctionName'];
    }

    private function getEnv(string $varName = ""): array|string
    {
        if (empty($varName)) {
            return $this->functionData['Configuration']['Environment']['Variables'];
        }

        return $this->functionData['Configuration']['Environment']['Variables'][$varName];
    }

    public function vanIsEnable(): bool
    {
        return !($this->getEnv('pasta_van') == self::VAN_DISABLE);
    }

    public function disableVan(): void
    {
        $this->setEnv('pasta_van', self::VAN_DISABLE);
    }

    public function debugIsEnable(): bool
    {
        return $this->getEnv('DEBUG') == '1';
    }

    public function enableIpDebug(string $ipDebug): void
    {
        $this->setEnv('IPS_AUTORIZADOS_DEBUG', $ipDebug);
    }

    public function getIpDebug(): string
    {
        return $this->getEnv('IPS_AUTORIZADOS_DEBUG');
    }

    public function enableDebug(): void
    {
        $this->setEnv('DEBUG', '1');
    }

    public function disableDebug(): void
    {
        $this->setEnv('DEBUG', '0');
    }
}
