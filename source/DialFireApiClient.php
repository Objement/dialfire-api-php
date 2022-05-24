<?php

/**
 * Original API documentation can be found here: http://apidoc.dialfire.com/
 */

namespace Objement\DialFireApi;

use Objement\DialFireApi\Services\CampaignService;
use Objement\DialFireApi\Services\TenantService;

const API_BASE_URL = 'https://api.dialfire.com/api/';

class DialFireApiClient {

    private $cachedServices = [];
    /**
     * @var string
     */
    private $apiToken;
    /**
     * @var HttpJsonRequester
     */
    private $httpJsonRequester;

    private function getCampaignService($campaignId) {
        if (!isset($this->cachedServices['campaign']))
            $this->cachedServices['campaign'] = new CampaignService($this->apiToken, $campaignId);

        return $this->cachedServices['campaign'];
    }

    private function getTenantService($tenantId) {
        if (!isset($this->cachedServices['tenant']))
            $this->cachedServices['tenant'] = new TenantService($this->apiToken, $tenantId);

        return $this->cachedServices['tenant'];
    }

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @param $campaignId
     * @return mixed|CampaignService
     */
    public function campaign($campaignId) {
        return $this->getCampaignService($campaignId);
    }

    /**
     * @param $tenantId
     * @return mixed|TenantService
     */
    public function tenant($tenantId) {
        return $this->getTenantService($tenantId);
    }
}
