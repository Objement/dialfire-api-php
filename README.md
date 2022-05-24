# DialFire API Client Library for PHP
A small library to simply access the DialFire API using PHP.

## About DialFire and their API
DialFire is the product of a German company which provides a call center software as a web application. I am not linked
to this company in any manner.

They provide an API to automate changes. You can find the documentation here:
http://apidoc.dialfire.com/

## Usage

### Install
You can either download the source code from GitHub or use the preferred way by using Composer.

#### Composer

````composer install objement/dialfire-api-php````

### Usage example

````php
// Set up client
const API_KEY = 'secret_api_token';
$dialFireApiClient = new DialFireApiClient(API_KEY);

// Get instance of required service, e.g. Campaign service
const CAMPAIGN_ID = 'C4MP41N1D';
$campaignService = $dialFireApiClient->campaign(CAMPAIGN_ID);

// Add a contact
$result = $campaignService->createContact('anrufen_stufe', [
    '$phone' => '+490000000',
    'vorname'=> 'Max',
    'nachname'=> 'Mustermann'
]);
````

