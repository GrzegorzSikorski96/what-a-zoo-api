<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use Behat\Gherkin\Node\TableNode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;

/**
 * Trait Requesting
 * @package BehatTests\helpers
 */
trait Requesting
{
    /** @var Request */
    private $request;
    /** @var Response */
    private $response;

    /**
     * @Given I send request to :url
     * @Given I send request to :url using :method method
     * @param string $url
     * @param string $method
     * @return void
     */
    public function iSendRequestToUrlUsingMethod(string $url, string $method = 'GET'): void
    {
        $this->request = Request::create($url, $method);
    }

    /**
     * @Given request is sent
     * @return void
     * @throws Exception
     */
    public function requestIsSent(): void
    {
        $this->response = app()->handle($this->request);
    }

    /**
     * @Given the response status code should be :statusCode
     * @param int $statusCode
     * @return void
     */
    public function theResponseStatusCodeShouldBe(int $statusCode): void
    {
        if ($this->response->getStatusCode() == 500) {
            dd($this->response);
        }
        Assert::assertEquals($statusCode, $this->response->getStatusCode());
    }

    /**
     * @param string $value
     * @return bool
     */
    private function getBoolean(string $value): bool
    {
        return $value == 'true';
    }

    /**
     * @Given request data is:
     * @param TableNode $table
     * @return void
     */
    public function requestDataIs(TableNode $table): void
    {
        foreach ($table->getHash() as $row) {
            if (preg_match('/(id)/', $row['key'])) {
                $row['value'] = intval($row['value']);
            }

            $this->request[$row['key']] = $row['value'];
        }
    }

    /**
     * @return array
     */
    public function getResponseContent(): array
    {
        return json_decode($this->response->getContent(), true);
    }

    /**
     * @Given response :field field should not be empty
     * @param string $field
     * @return void
     */
    public function responseFieldShouldNotBeEmpty(string $field): void
    {
        Assert::assertNotEmpty(Arr::get($this->getResponseContent(), $field));
    }

    /**
     * @Given response message should be :message
     * @param string $message
     */
    public function responseMessageFieldShouldBe(string $message): void
    {
        Assert::assertEquals(__('messages.' . $message), Arr::get($this->getResponseContent(), 'message'));
    }

    /**
     * @Given response :field field type should be array
     * @param string $field
     * @return void
     */
    public function responseFieldShouldBeArray(string $field): void
    {
        Assert::assertIsArray(Arr::get($this->getResponseContent(), $field));
    }

    /**
     * @Given response :field field should be :value
     * @param string $field
     * @param string $value
     * @return void
     */
    public function responseFieldShouldBe(string $field, string $value): void
    {
        if ($value == 'true' || $value == 'false') {
            Assert::assertEquals($this->getBoolean($value), Arr::get($this->getResponseContent(), $field));
        } elseif ($value == 'null') {
            Assert::assertEquals(null, Arr::get($this->getResponseContent(), $field));
        } elseif ($value == 'array') {
            Assert::assertIsArray(Arr::get($this->getResponseContent(), $field));
        } else {
            Assert::assertEquals($value, Arr::get($this->getResponseContent(), $field));
        }
    }
}
