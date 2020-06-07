<?php
    //
    // basiq-sdk-php
    // (c) 2020 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2020 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Basiq\entities;

    class Institution extends Entity
    {
        /** @var string */
        public $name;
        /** @var string */
        public $shortName;
        /** @var string */
        public $institutionType;
        public $country;
        public $serviceName;
        public $serviceType;
        public $loginIdCaption;
        public $passwordCaption;
        public $tier;
        public $authorization;
        public $features;
        public $forgottenPasswordUrl;
        public $stage;
        public $status;
        public $stats;
        public $logo;

        /**
         * Institution constructor.
         *
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->name = $data['name'];
            $this->shortName = $data['shortName'];
            $this->institutionType = $data['institutionType'];
            $this->country = $data['country'];
            $this->serviceName = $data['serviceName'];
            $this->serviceType = $data['serviceType'];
            $this->loginIdCaption = $data['loginIdCaption'];
            $this->passwordCaption = $data['passwordCaption'];
            $this->tier = $data['tier'];
            $this->authorization = $data['authorization'];
            $this->features = $data['features'];
            $this->forgottenPasswordUrl = $data['forgottenPasswordUrl'];
            $this->stage = $data['stage'];
            $this->status = $data['status'];
            $this->stats = $data['stats'];
            $this->logo = $data['logo'];
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getShortName(): string
        {
            return $this->shortName;
        }

        /**
         * @return string
         */
        public function getInstitutionType(): string
        {
            return $this->institutionType;
        }

        /**
         * @return mixed
         */
        public function getCountry()
        {
            return $this->country;
        }

        /**
         * @return mixed
         */
        public function getServiceName()
        {
            return $this->serviceName;
        }

        /**
         * @return mixed
         */
        public function getServiceType()
        {
            return $this->serviceType;
        }

        /**
         * @return mixed
         */
        public function getLoginIdCaption()
        {
            return $this->loginIdCaption;
        }

        /**
         * @return mixed
         */
        public function getPasswordCaption()
        {
            return $this->passwordCaption;
        }

        /**
         * @return mixed
         */
        public function getTier()
        {
            return $this->tier;
        }

        /**
         * @return mixed
         */
        public function getAuthorization()
        {
            return $this->authorization;
        }

        /**
         * @return mixed
         */
        public function getFeatures()
        {
            return $this->features;
        }

        /**
         * @return mixed
         */
        public function getForgottenPasswordUrl()
        {
            return $this->forgottenPasswordUrl;
        }

        /**
         * @return mixed
         */
        public function getStage()
        {
            return $this->stage;
        }

        /**
         * @return mixed
         */
        public function getStatus()
        {
            return $this->status;
        }

        /**
         * @return mixed
         */
        public function getStats()
        {
            return $this->stats;
        }

        /**
         * @return mixed
         */
        public function getLogo()
        {
            return $this->logo;
        }
    }
