<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionLocationMetadata
    {
        /** @var string|null */
        public $routeNo;

        /** @var string|null */
        public $route;

        /** @var string|null */
        public $postalCode;

        /** @var string|null */
        public $suburb;

        /** @var string|null */
        public $state;

        /** @var string|null */
        public $country;

        /** @var string|null */
        public $formattedAddress;

        /** @var EnrichedTransactionLocationGeometryMetadata */
        public $geometry;

        public function __construct(array $data)
        {
            $this->routeNo = $data['routeNo'] ?? null;
            $this->route = $data['route'] ?? null;
            $this->postalCode = $data['postalCode'] ?? null;
            $this->suburb = $data['suburb'] ?? null;
            $this->state = $data['state'] ?? null;
            $this->country = $data['country'] ?? null;
            $this->formattedAddress = $data['formattedAddress'] ?? null;
            $this->geometry = new EnrichedTransactionLocationGeometryMetadata($data['geometry']);
        }

        /**
         * @return string|null
         */
        public function getRouteNo(): ?string
        {
            return $this->routeNo;
        }

        /**
         * @return string|null
         */
        public function getRoute(): ?string
        {
            return $this->route;
        }

        /**
         * @return string|null
         */
        public function getPostalCode(): ?string
        {
            return $this->postalCode;
        }

        /**
         * @return string|null
         */
        public function getSuburb(): ?string
        {
            return $this->suburb;
        }

        /**
         * @return string|null
         */
        public function getState(): ?string
        {
            return $this->state;
        }

        /**
         * @return string|null
         */
        public function getCountry(): ?string
        {
            return $this->country;
        }

        /**
         * @return string|null
         */
        public function getFormattedAddress(): ?string
        {
            return $this->formattedAddress;
        }

        /**
         * @return EnrichedTransactionLocationGeometryMetadata
         */
        public function getGeometry(): EnrichedTransactionLocationGeometryMetadata
        {
            return $this->geometry;
        }
    }
