<?php

namespace Objement\DialFireApi\Services;

use Exception;
use Objement\DialFireApi\HttpJsonRequester;
use Objement\DialFireApi\ServiceInterface;
use const Objement\DialFireApi\API_BASE_URL;

class CampaignService implements ServiceInterface
{
    /**
     * @var HttpJsonRequester
     */
    private $httpJsonRequester;

    public function __construct(string $apiToken, string $campaignId)
    {
        $this->httpJsonRequester = new HttpJsonRequester(API_BASE_URL.'campaigns/'.$campaignId.'/', $apiToken);
    }

    /**
     * Retrieve a list of all available tasks
     * GET /api/campaigns/{campaign_id}/tasks/
     * @return object
     * @throws Exception
     */
    function getTasks(): object
    {
        return $this->httpJsonRequester->get('tasks/');
    }

    /**
     * Retrieve a file from the campaignresources folder
     * GET /api/campaigns/{campaign_id}/resources/{_any_}
     * @param string $resourceName Name of the resource
     * @return object
     * @throws Exception
     */
    function getResource(string $resourceName): object
    {
        return $this->httpJsonRequester->get($resourceName);
    }

    /**
     * delete a file from the campaign resources folder
     * DELETE /api/campaigns/{campaign_id}/resources/{_any_}
     * @param string $resourceName Name of the resource
     * @return object
     * @throws Exception
     */
    function deleteResource(string $resourceName): object
    {
        return $this->httpJsonRequester->delete($resourceName);
    }

    /**
     * upload a file to the campaign resources folder
     * PUT /api/campaigns/{campaign_id}/resources/{_any_}
     * @param string $resourceName Name of the resource
     * @param mixed $resourceContent The content of the resource
     * @return object
     * @throws Exception
     */
    function putResource(string $resourceName, $resourceContent): object
    {
        return $this->httpJsonRequester->put('resources/'.$resourceName, $resourceContent);
    }

    /**
     * Create a new contact record
     * POST /api/campaigns/{campaign_id}/tasks/{task_name}/contacts/create
     * @param string $taskName The name of the task (Kampagnenstufe)
     * @param array $contactData An assoziative array that contains the fields with values to be set to the new contact.
     * @return object
     * @throws Exception
     */
    function createContact(string $taskName, array $contactData): object
    {
        return $this->httpJsonRequester->post('tasks/'.$taskName.'/contacts/create', $contactData);
    }

    /**
     * Update existing contact record
     * POST /api/campaigns/{campaign_id}/contacts/{contact_id}/update
     * @param int $contactId
     * @param array $contactData An assoziative array that contains the fields with values to be set to the new contact.
     * @return object
     * @throws Exception
     */
    function updateContact(int $contactId, array $contactData): object
    {
        return $this->httpJsonRequester->put('contacts/'.$contactId.'/create', $contactData);
    }

    /**
     * Get detailed view of contact record including task log
     * GET /api/campaigns/{campaign_id}/contacts/{contact_id}/flat_view
     * @param int $contactId
     * @return object
     * @throws Exception
     */
    function getContactFlatView(int $contactId): object
    {
        return $this->httpJsonRequester->get('contacts/'.$contactId.'/flat_view');
    }

    /**
     * Bulk import or bulk update contact records
     * POST /api/campaigns/{campaign_id}/contacts/import
     * @param array $contactsCsv A CSV string with lines, each containing the data of a contact. When the $id is given, the contact will be updated else created.
     * @return object
     * @throws Exception
     */
    function importContacts(string $contactsCsv): object
    {
        return $this->httpJsonRequester->post('contacts/import', $contactsCsv, HttpJsonRequester::PAYLOAD_TYPE_CSV);
    }

    /**
     * List available exports of an export task
     * GET /api/campaigns/{campaign_id}/tasks/{task_name}/exports/
     * @param string $taskName
     * @return object
     * @throws Exception
     */
    function getListOfTaskExports(string $taskName): object
    {
        return $this->httpJsonRequester->get('tasks/'.$taskName.'/exports/');
    }

    /**
     * starts up the export process
     * POST /api/campaigns/{campaign_id}/tasks/{task_name}/exports/run
     * @param string $taskName
     * @return object
     * @throws Exception
     */
    function runExport(string $taskName): object
    {
        return $this->httpJsonRequester->post('tasks/'.$taskName.'/exports/run', []);
    }

    /**
     * Poll for an export in progress to complete
     * GET /api/campaigns/{campaign_id}/tasks/{task_name}/exports/{export_id}/render/file
     * @param string $taskName
     * @param int $exportId The export Id (retrieve by using ->runExport(...))
     * @return object
     * @throws Exception
     */
    function getExport(string $taskName, int $exportId): object
    {
        return $this->httpJsonRequester->get('tasks/'.$taskName.'/exports/'.$exportId.'/render/file');
    }

    /**
     * Import Do-Not-Call list
     * @param $doNotCallList $exportId An flat array of assoziative arrays, each containing the data of a contact. When the $id is given, the contact will be updated else created.
     * @return object
     * @throws Exception
     */
    function importDoNotCallList(array $doNotCallList): object
    {
        return $this->httpJsonRequester->post('imports/donotcall', $doNotCallList);
    }

    /**
     * Get the flat view for a whole batch of contact records
     * POST /api/campaigns/{campaign_id}/contacts/flat_view
     * @return object
     * @throws Exception
     */
    function getContactListFlatView(): object
    {
        return $this->httpJsonRequester->get('contacts/flat_view');
    }

    /**
     * Deletes the complete Do-Not-Call list
     * POST /api/campaigns/{campaign_id}/donotcall/delete
     * @return object
     * @throws Exception
     */
    function deleteDoNotCallList(): object
    {
        return $this->httpJsonRequester->post('donotcall/delete', '');
    }

    /**
     * Export Do-Not-Call list
     * GET /api/campaigns/{campaign_id}/donotcall/
     * @return object
     * @throws Exception
     */
    function getDoNotCallList(): object
    {
        return $this->httpJsonRequester->get('donotcall/');
    }

    /**
     * Check Do-Not-Call list
     * POST /api/campaigns/{campaign_id}/donotcall/test
     * @return object
     * @throws Exception
     */
    function testDoNotCallList(): object
    {
        return $this->httpJsonRequester->post('donotcall/test', '');
    }

    /**
     * Search for contacts inside a campaign.
     * POST /api/campaigns/{campaign_id}/contacts/filter
     * @param int $cursor To iterate ALL contacts from campaign use this parameter and put in the cursorvalue you got in response to the previous call.
     * @param int $limit Limit the response size.
     * @param array $filterData Assoziative array with key=fieldname and value=filter value. Valid operators are: "*", "GT", "GE", "LT", "LE"
     * @return object
     * @throws Exception
     */
    function filterContacts(int $cursor, int $limit, array $filterData): object
    {
        return $this->httpJsonRequester->post('contacts/filter', $filterData);
    }

    /**
     * Returns description for report
     * GET /api/campaigns/{campaign_id}/reports/{template_name}/metadata/{locale}
     * @param string $templateName
     * @param string $locale
     * @return object
     * @throws Exception
     */
    function getReportMetadata(string $templateName, string $locale): object
    {
        return $this->httpJsonRequester->get('reports/'.$templateName.'/metadata/'.$locale);
    }

    /**
     * generate report
     * GET /api/campaigns/{campaign_id}/reports/{template_name}/report/{locale}
     * @param string $templateName
     * @param string $locale
     * @return object
     * @throws Exception
     */
    function getReport(string $templateName, string $locale): object
    {
        return $this->httpJsonRequester->get('reports/'.$templateName.'/report/'.$locale);
    }
}

