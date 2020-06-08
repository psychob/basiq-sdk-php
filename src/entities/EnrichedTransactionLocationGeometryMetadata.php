<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionLocationGeometryMetadata
    {
        /** @var string */
        public $lat;

        /** @var string */
        public $lng;

        /**
         * EnrichedTransactionLocationGeometryMetadata constructor.
         *
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->lat = $data['lat'];
            $this->lng = $data['lng'];
        }

        /**
         * @return string
         */
        public function getLat(): string
        {
            return $this->lat;
        }

        /**
         * @return string
         */
        public function getLng(): string
        {
            return $this->lng;
        }
    }
