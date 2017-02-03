<?php

namespace PubNub\Exceptions;


class PubNubServerException extends PubNubException
{
    /** @var  int */
    private $statusCode;

    /** @var  string */
    private $rawBody;

    /** @var  mixed Already json_decoded object (if possible) */
    private $body;

    protected $message = "Server responded with an error";

    protected function updateMessage()
    {
        $this->message = "Server responded with an error";

        if ($this->statusCode > 0) {
            $this->message .= " and the status code is " . $this->statusCode;
        }
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        $this->updateMessage();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $rawBody
     * @return $this
     */
    public function setRawBody($rawBody)
    {
        $this->rawBody = $rawBody;
        $parsedBody = json_decode($rawBody);

        if (json_last_error()) {
            $this->body = $rawBody;
        } else {
            $this->body = $parsedBody;
        }

        return $this;
    }
}
