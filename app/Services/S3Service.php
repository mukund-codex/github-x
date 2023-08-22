<?php

namespace App\Services;

use App\Enums\S3Enum;
use Aws\S3\S3Client;

class S3Service
{
    private S3Client $client;
    private string $bucket;
    private int $expiryTime;

    public function __construct()
    {
        $this->client = new S3Client([
            'version' => 'latest',
            'region' => config('aws.region'),
            'credentials' => [
                'key' => config('aws.access_key'),
                'secret' => config('aws.secret_key'),
            ],
        ]);
        $this->bucket = config('aws.bucket');
        $this->expiryTime = config('aws.expiry_time');
    }

    public function preSignedGetRequest(string $file): string
    {
        return $this->getSignedRequest($file, S3Enum::GET);
    }

    public function preSignedPutRequest(string $file): string
    {
        return $this->getSignedRequest($file, S3Enum::PUT);
    }

    public function preSignedPostRequest(string $file): string
    {
        return $this->getSignedRequest($file, S3Enum::POST);
    }

    private function getSignedRequest(string $file, S3Enum $type): string
    {
        $command = $this->client->getCommand($type->value, [
            'Bucket' => $this->bucket,
            'Key' => $file,
            'MetaData' => [],
        ]);

        $request = $this->client->createPresignedRequest($command, "+$this->expiryTime minutes");

        return $request->getUri();
    }
}
