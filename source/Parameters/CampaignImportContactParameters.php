<?php

namespace Objement\DialFireApi\Parameters;

class CampaignImportContactParameters extends ParameterBase
{
    const MODE_INSERT = 'insert';
    const MODE_UPDATE = 'update';
    const MODE_SYNCHRONIZE = 'synchronize';
    const MODE_AUTO = 'auto';

    const OVERRIDE_NEVER = 'never';
    const OVERRIDE_ALWAYS = 'always';
    const OVERRIDE_EMPTY = 'empty';

    /**
     * @var string|null
     */
    private $mode;
    /**
     * @var string|null
     */
    private $country;
    /**
     * @var string|null
     */
    private $task;
    /**
     * @var string|null
     */
    private $override;
    /**
     * @var string|null
     */
    private $requestnr;
    /**
     * @var string|null
     */
    private $created;

    /**
     * You can also use fluent setters like:
     * new CampaignImportContactParameters()->setMode(CampaignImportContactParameters::MODE_INSERT)->setOverride(CampaignImportContactParameters::OVERRIDE_ALWAYS);
     * @param string|null $mode default: auto - one of: insert, update, synchronize, auto - Use constants CampaignImportContactParameters::MODE_*
     * @param string|null $country optional - the country ISO code for parsing local phone numbers if different from tenant settings
     * @param string|null $task the task name the import should go to (if not contained inside the data)
     * @param string|null $override default: never - tells wether an update will occur if the $version field does not match the current version of the record - one of: never, always, empty (update if the $version field is not present or empty)  - Use constants CampaignImportContactParameters::OVERRIDE_*
     * @param string|null $requestnr optional - number of chunk, fill only if you need to chunk the data set
     * @param string|null $created optional - creation date, fill only if you need to chunk the data set
     */
    public function __construct(?string $mode=null, ?string $country=null, ?string $task=null, ?string $override=null, ?string $requestnr=null, ?string $created=null)
    {
        $this->mode = $mode;
        $this->country = $country;
        $this->task = $task;
        $this->override = $override;
        $this->requestnr = $requestnr;
        $this->created = $created;
    }

    /**
     * @return string|null
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * @param string|null $mode
     * @return CampaignImportContactParameters
     */
    public function setMode(?string $mode): CampaignImportContactParameters
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return CampaignImportContactParameters
     */
    public function setCountry(?string $country): CampaignImportContactParameters
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTask(): ?string
    {
        return $this->task;
    }

    /**
     * @param string|null $task
     * @return CampaignImportContactParameters
     */
    public function setTask(?string $task): CampaignImportContactParameters
    {
        $this->task = $task;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOverride(): ?string
    {
        return $this->override;
    }

    /**
     * @param string|null $override
     * @return CampaignImportContactParameters
     */
    public function setOverride(?string $override): CampaignImportContactParameters
    {
        $this->override = $override;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequestnr(): ?string
    {
        return $this->requestnr;
    }

    /**
     * @param string|null $requestnr
     * @return CampaignImportContactParameters
     */
    public function setRequestnr(?string $requestnr): CampaignImportContactParameters
    {
        $this->requestnr = $requestnr;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * @param string|null $created
     * @return CampaignImportContactParameters
     */
    public function setCreated(?string $created): CampaignImportContactParameters
    {
        $this->created = $created;
        return $this;
    }
}