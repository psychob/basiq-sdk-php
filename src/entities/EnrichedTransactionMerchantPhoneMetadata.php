<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionMerchantPhoneMetadata
    {
        /** @var string|null */
        public $local;

        /** @var string|null */
        public $international;

        /**
         * EnrichedTransactionMerchantPhoneMetadata constructor.
         *
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->local = $data['local'] ?? null;
            $this->international = $data['international'] ?? null;
        }

        /**
         * @return string|null
         */
        public function getLocal(): ?string
        {
            return $this->local;
        }

        /**
         * @return string|null
         */
        public function getInternational(): ?string
        {
            return $this->international;
        }
    }
