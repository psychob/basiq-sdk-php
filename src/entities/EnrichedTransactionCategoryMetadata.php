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
            // does basiq.io returns enriched data for any other region then anzsic?
            $this->class = $data['anzsic']['class'] ? new EnrichedTransactionCategoryClassMetadata($data['anzsic']['class']) : null;
            $this->group = $data['anzsic']['group'] ? new EnrichedTransactionCategoryClassMetadata($data['anzsic']['group']) : null ;
            $this->subdivision = $data['anzsic']['subdivision'] ? new EnrichedTransactionCategoryClassMetadata($data['anzsic']['subdivision']) : null;
            $this->division = $data['anzsic']['division'] ?  new EnrichedTransactionCategoryClassMetadata($data['anzsic']['division']) : null;
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
