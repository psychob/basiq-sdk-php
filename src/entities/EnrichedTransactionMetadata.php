<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionMetadata
    {
        /** @var EnrichedTransactionMerchantMetadata|null */
        public $merchant;

        /** @var EnrichedTransactionLocationMetadata|null */
        public $location;

        /** @var EnrichedTransactionCategoryMetadata|null */
        public $category;

        public function __construct(array $data)
        {
            if ($data['merchant'] !== null) {
                $this->merchant = new EnrichedTransactionMerchantMetadata($data['merchant']);
            }

            if ($data['location'] !== null) {
                $this->location = new EnrichedTransactionLocationMetadata($data['location']);
            }

            if ($data['category'] !== null) {
                $this->category = new EnrichedTransactionCategoryMetadata($data['category']);
            }
        }

        public function isEmpty(): bool
        {
            return $this->merchant === null && $this->location === null && $this->category === null;
        }

        /**
         * @return EnrichedTransactionMerchantMetadata|null
         */
        public function getMerchant(): ?EnrichedTransactionMerchantMetadata
        {
            return $this->merchant;
        }

        /**
         * @return EnrichedTransactionLocationMetadata|null
         */
        public function getLocation(): ?EnrichedTransactionLocationMetadata
        {
            return $this->location;
        }

        /**
         * @return EnrichedTransactionCategoryMetadata|null
         */
        public function getCategory(): ?EnrichedTransactionCategoryMetadata
        {
            return $this->category;
        }
    }
