<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\services;

    use Basiq\entities\EnrichedTransactionMetadata;
    use Basiq\Entities\Job;
    use Basiq\Utilities\ResponseParser;

    class EnrichService extends Service
    {
        public function enrich(
            string $q,
            string $institution,
            string $country,
            ?string $mcc = null,
            ?string $accountType = null,
            ?string $amount = null
        ): EnrichedTransactionMetadata {
            $data = [
                'q' => $q,
                'institution' => $institution,
                'country' => $country,
                'mcc' => $mcc,
                'accountType' => $accountType,
                'amount' => $amount,
            ];

            $data = array_filter($data, function ($value): bool {
                return !empty($value);
            });

            $response = $this->session->apiClient->get(sprintf('enrich?%s', http_build_query($data)), [
                "headers" => [
                    "Content-type" => "application/json",
                    "Authorization" => "Bearer ".$this->session->getAccessToken()
                ],
            ]);

            $body = ResponseParser::parse($response);

            return new EnrichedTransactionMetadata($body['body']);
        }
    }
