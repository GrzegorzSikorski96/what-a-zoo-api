<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use Behat\Gherkin\Node\TableNode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        Assert::assertEquals($statusCode, $this->response->getStatusCode());
    }

    /**
     * @Given response success field should be :value
     * @param string $value
     * @return void
     */
    public function responseSuccessFieldShouldBe(string $value): void
    {
        Assert::assertEquals($this->getBoolean($value), $this->getResponseContent()['success']);
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
        Assert::assertNotEmpty($this->getResponseContent()['data'][$field]);
    }

    /**
     * @Given response message field should be :message
     * @param string $message
     */
    public function responseMessageFieldShouldBe(string $message): void
    {
        Assert::assertEquals(__('messages.' . $message), $this->getResponseContent()['message']);
    }

    /**
     * @Given authenticated by email :email and password :password
     * @param string $email
     * @param string $password
     */
    public function authenticatedByEmailAndPassword(string $email, string $password): void
    {
        $jwtToken = auth()->attempt(['email' => $email, 'password' => $password]);

        $this->request->headers->add(['Authorization' => 'Bearer ' . $jwtToken]);
    }
}
