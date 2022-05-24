<?php

namespace Objement\DialFireApi\Services;

use Exception;
use Objement\DialFireApi\HttpJsonRequester;
use Objement\DialFireApi\ServiceInterface;
use const Objement\DialFireApi\API_BASE_URL;

class TenantService implements ServiceInterface
{
    /**
     * @var HttpJsonRequester
     */
    private $httpJsonRequester;

    public function __construct(string $apiToken, string $tenantId)
    {
        $this->httpJsonRequester = new HttpJsonRequester(API_BASE_URL.'tenants/'.$tenantId.'/', $apiToken);
    }

    /**
     * A list of campaigns for a tenant along with access tokens to each campaign
     * GET /api/tenants/{tenantId}/campaigns/get
     * @return object
     * @throws Exception
     */
    function getCampaigns(): object
    {
        return $this->httpJsonRequester->get('campaigns/get');
    }

    /**
     * Delete an existing user
     * DELETE /api/tenants/{tenantId}/users/{userId}
     * @param string $userId
     * @return object
     * @throws Exception
     */
    function deleteUser(string $userId): object
    {
        return $this->httpJsonRequester->delete('users/'.$userId);
    }

    /**
     * Get an existing user
     * GET /api/tenants/{tenantId}/users/{userId}
     * @param string $userId
     * @return object
     * @throws Exception
     */
    function getUser(string $userId): object
    {
        return $this->httpJsonRequester->get('users/'.$userId);
    }

    /**
     * Remove user from a team
     * DELETE /api/tenants/{tenantId}/users/{userId}/teams/{teamId}
     * @param string $userId
     * @param string $teamId
     * @return object
     * @throws Exception
     */
    function deleteUserFromTeam(string $userId, string $teamId): object
    {
        return $this->httpJsonRequester->delete('users/'.$userId.'/teams/'.$teamId);
    }

    /**
     * Add user to team
     * POST /api/tenants/{tenantId}/users/{userId}/teams/{teamId}
     * @param string $userId
     * @param string $teamId
     * @return object
     * @throws Exception
     */
    function addUserToTeam(string $userId, string $teamId): object
    {
        return $this->httpJsonRequester->post('users/'.$userId.'/teams/'.$teamId, '');
    }

    /**
     * Get all users of a tenant
     * GET /api/tenants/{tenantId}/users/list
     * @return object
     * @throws Exception
     */
    function getUserList(): object
    {
        return $this->httpJsonRequester->get('users/list');
    }

    /**
     * Update an existing user
     * POST /api/tenants/{tenantId}/users/{userId}/update
     * @param string $userId
     * @param array $userData
     * @return object
     * @throws Exception
     */
    function updateUser(string $userId, array $userData): object
    {
        return $this->httpJsonRequester->post('users/'.$userId.'/update', $userData);
    }

    /**
     * Create a new user
     * POST /api/tenants/{tenantId}/users/create
     * @param array $userData
     * @return object
     * @throws Exception
     */
    function addUser(array $userData): object
    {
        return $this->httpJsonRequester->post('users/create', $userData);
    }

    /**
     * Import Do-Not-Call list
     * POST /api/tenants/{tenantId}/imports/donotcall
     * @param array $doNotCallList
     * @return object
     * @throws Exception
     */
    function importDoNotCall(array $doNotCallList): object
    {
        return $this->httpJsonRequester->post('imports/donotcall', $doNotCallList);
    }

    /**
     * Get line stats
     * GET /api/tenants/{tenantId}/lines/stats
     * @return object
     * @throws Exception
     */
    function getLineStats(): object
    {
        return $this->httpJsonRequester->get('lines/stats');
    }

    /**
     * List inbound calls of specific line
     * GET /api/tenants/{tenantId}/lines/{lineId}/calls/
     * @param string $lineId
     * @return object
     * @throws Exception
     */
    function getLineInboundCalls(string $lineId): object
    {
        return $this->httpJsonRequester->get('lines/'.$lineId.'/calls/');
    }

    /**
     * List inbound lines
     * GET /api/tenants/{tenantId}/lines/
     * @return object
     * @throws Exception
     */
    function getInboundLines(): object
    {
        return $this->httpJsonRequester->get('lines/');
    }

    /**
     * List inbound lines
     * POST /api/tenants/{tenantId}/lines/{lineId}/callback
     * @param string $lineId
     * @return object
     * @throws Exception
     */
    function getLineCallback(string $lineId): object
    {
        return $this->httpJsonRequester->get('lines/'.$lineId.'/callback');
    }
}