<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class EnrichedTransactionCategoryMetadata
    {
        /** @var EnrichedTransactionCategoryClassMetadata|null */
        public $class;

        /** @var EnrichedTransactionCategoryClassMetadata|null */
        public $group;

        /** @var EnrichedTransactionCategoryClassMetadata|null */
        public $subdivision;

        /** @var EnrichedTransactionCategoryClassMetadata|null */
        public $division;

        public function __construct(array $data)
        {
            $this->class = new EnrichedTransactionCategoryClassMetadata($data['class']);
            $this->group = new EnrichedTransactionCategoryClassMetadata($data['group']);
            $this->subdivision = new EnrichedTransactionCategoryClassMetadata($data['subdivision']);
            $this->division = new EnrichedTransactionCategoryClassMetadata($data['division']);
        }

        /**
         * @return EnrichedTransactionCategoryClassMetadata|null
         */
        public function getClass(): ?EnrichedTransactionCategoryClassMetadata
        {
            return $this->class;
        }

        /**
         * @return EnrichedTransactionCategoryClassMetadata|null
         */
        public function getGroup(): ?EnrichedTransactionCategoryClassMetadata
        {
            return $this->group;
        }

        /**
         * @return EnrichedTransactionCategoryClassMetadata|null
         */
        public function getSubdivision(): ?EnrichedTransactionCategoryClassMetadata
        {
            return $this->subdivision;
        }

        /**
         * @return EnrichedTransactionCategoryClassMetadata|null
         */
        public function getDivision(): ?EnrichedTransactionCategoryClassMetadata
        {
            return $this->division;
        }
    }
