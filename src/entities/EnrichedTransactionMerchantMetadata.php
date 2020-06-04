<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionMerchantMetadata
    {
        /** @var string|null */
        public $businessName;

        /** @var string|null */
        public $website;

        /** @var EnrichedTransactionMerchantPhoneMetadata */
        public $phoneNumber;

        /**
         * EnrichedTransactionMerchantMetadata constructor.
         *
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->businessName = $data['businessName'];
            $this->website = $data['website'];
            $this->phoneNumber = new EnrichedTransactionMerchantPhoneMetadata($data['phoneNumber']);
        }

        /**
         * @return string|null
         */
        public function getBusinessName(): ?string
        {
            return $this->businessName;
        }

        /**
         * @return string|null
         */
        public function getWebsite(): ?string
        {
            return $this->website;
        }

        /**
         * @return EnrichedTransactionMerchantPhoneMetadata
         */
        public function getPhoneNumber(): EnrichedTransactionMerchantPhoneMetadata
        {
            return $this->phoneNumber;
        }
    }
