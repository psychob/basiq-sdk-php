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
        public $log;

        /**
         * EnrichedTransactionLocationGeometryMetadata constructor.
         *
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->lat = $data['lat'];
            $this->log = $data['log'];
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
        public function getLog(): string
        {
            return $this->log;
        }
    }
