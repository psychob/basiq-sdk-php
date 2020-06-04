<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionCategoryClassMetadata
    {
        /** @var string|null */
        public $code;

        /** @var string|null */
        public $title;

        /**
         * EnrichedTransactionCategoryClassMetadata constructor.
         *
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->code = $data['code'] ?? null;
            $this->title = $data['title'] ?? null;
        }

        /**
         * @return string|null
         */
        public function getCode(): ?string
        {
            return $this->code;
        }

        /**
         * @return string|null
         */
        public function getTitle(): ?string
        {
            return $this->title;
        }
    }
