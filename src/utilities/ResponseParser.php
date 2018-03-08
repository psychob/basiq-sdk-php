<?php

namespace Basiq\Utilities;

use Basiq\Exceptions\HttpResponseException;

class ResponseParser {

    public static function parse(\Psr\Http\Message\ResponseInterface $response)
    {
        $contents = $response->getBody()->__toString();
        $body = json_decode($contents, true);

        if ($body === null) {
            $GLOBALS["log"]->error($contents);
            throw new HttpResponseException("Invalid response received from server. Check log for the response");
        }

        if ($response->getStatusCode() > 299) {
            if (isset($body["data"])) {
                $error = array_reduce($body["data"], function ($sum, $error) {
                    return $sum .= $error["detail"];
                }, "");
            } else if (isset($body["errorMessage"])) {
                $error = $body["errorMessage"];
            } else {
                $error = "Unexpected error from server";
            }
            $GLOBALS["log"]->error($error . ". Response body: ". $contents);
            throw new HttpResponseException($error . ". Check the error log for the entire response");
        }


        return $body;
    }

}