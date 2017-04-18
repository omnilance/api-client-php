<?php
include_once "api.php";

use Omnilance\Api;

$config = require 'config.php';

function ErrorReport($error)
{
    return "Error: code={$error->code}, message={$error->msg}";
}

$api = new Api($config["apikey"], $url = "https://test-api.omnilance.com", $version = '2.0');


// List domain for registration

$domain = 'test.epp.ua';

// Check domain available
$response = $api->DomainCheck($domain);
echo sprintf("Check Domain: %s\n", $domain);

if ($response->status === false) {
    //An error occurred while checking domain
    print sprintf("   %s\n", ErrorReport($response));

} elseif ($response->avail === false) {
    //The domain is not available for registration
    echo "   Not available\n";
} else {
    echo "   Available\n";
}


//Information about contact
$client_contact = [
    "name" => "Name contact",
    "company" => "Company name",
    "address" => "Address contact",
    "city" => "City contact",
    "region" => "Region contact",
    "zip" => 80000,
    "country" => "UA",
    "phone" => "380.631234567",
    "fax" => "380.631234567",
    "mail" => "email@example.com",
    "id" => "omni777",
];

$new_contact = [
    "name" => "New contact name",
    "company" => "New Company name",
    "address" => "New Address",
    "city" => "New york city",
    "region" => "New Region contact",
    "zip" => 99999,
    "country" => "UA",
    "phone" => "380.630000000",
    "fax" => "380.630000000",
    "mail" => "new_email@example.com",
];


//Check contact availability
$responseContactCheck = $api->ContactCheck($client_contact["id"]);

if (!empty($responseContactCheck->error)) {
	echo "    Contact error\n";
    ErrorReport($responseContactCheck->error);
} else {
    if ($responseContactCheck->avail == 1) {//The contact is available to create
        $responseContactAdd = $api->ContactAdd($client_contact["id"], $client_contact);//Create contact
        if (!empty($responseContactAdd->error)) {
            ErrorReport($responseContactAdd->error);
        }
    }

    $responseDomainAdd = $api->DomainAdd($domain, array(
        "period" => 1,
        "ns" => array(
            "ns1.rx-name.ua",
            "ns2.rx-name.ua",
            "ns3.rx-name.ua"
        ),
        "license" => 1,
        "contact_registrant" => $client_contact["id"],
        "contact_admin" => $client_contact["id"],
        "contact_tech" => $client_contact["id"],
        "contact_billing" => $client_contact["id"],
    ));
    if (!empty($responseDomainAdd->error)) {
        ErrorReport($responseDomainAdd->error);
    } else {
        echo "  Domain $domain add success\n";
    }

}

$responseContactInfo = $api->ContactInfo($client_contact['id']);
if (!empty($responseContactInfo->error)) {
    ErrorReport($responseContactInfo->error);
} else {
    print_r($responseContactInfo);
}

$responseContactUpdate = $api->ContactUpdate($client_contact['id'], $new_contact);
if (!empty($responseContactUpdate->error)) {
    ErrorReport($responseContactUpdate->error);
} else {
    echo "  Contact update\n";
}

$responseDomainUpdate = $api->DomainUpdate($domain, array(
    'ns' => array(
        "add" => array(
            "ns1.rx-name.ua",
            "ns2.rx-name.ua",
            "ns3.rx-name.ua"
        ),
        'del' => array(
            "ns1.rx-name.ua",
            "ns2.rx-name.ua",
            "ns3.rx-name.ua"
        )
    )
));
if (!empty($responseDomainUpdate->error)) {
    ErrorReport($responseDomainUpdate->error);
} else {
    echo "    Domain update success\n";
}

$hosts = array(
    'ns1', 'ns2', 'ns3'
);
$hostAdd = array(
    'ip' => array(
        array("type" => 'v4',"ip"   => '193.29.220.26'),
        array("type" => 'v6',"ip"   => '2001:4130:20::26'),
    )
);

foreach ($hosts as $host) {
    $responseHostCheck = $api->HostCheck($host, $domain);
    if ($responseHostCheck->status) {
        $responseHostAdd = $api->HostAdd($host, $domain, $hostAdd);
        if (!empty($responseHostAdd->error)) {
            ErrorReport($responseHostAdd->error);
        } else {
            echo "    Host add success\n";
        }
    }
}
foreach ($hosts as $host) {
    $responseHostCheck = $api->HostCheck($host, $domain);
    if ($responseHostCheck->status) {
        $responseHostDelete = $api->HostDelete($host, $domain);
        if (!empty($responseHostDelete->error)) {
            ErrorReport($responseHostDelete->error);
        } else {
            echo "  Host deleted success\n";
        }
    }
}

$date_current = $api->DomainInfo($domain)->data->date_end;
$date_end = intval(explode('-', $date_current)[0]) + 1;
$date_end .= '-' . explode('-', $date_current)[1] . '-' . explode('-', $date_current)[2];
$responseDomainRenew = $api->DomainRenew($domain, array(
    "current_expiry_date" => explode(' ', $date_current)[0],
    "period" => 1,
    "domain" => $domain,
    "date_end" => $date_end,
));
if (!empty($responseDomainRenew->error)) {
    ErrorReport($responseDomainRenew->error);
} else {
    echo "  Domain renew success\n";
}

$responseDomainDelete = $api->DomainDelete($domain);
if (!empty($responseDomainDelete->error)) {
    ErrorReport($responseDomainDelete->error);
} else {
    echo "  Domain was deleted\n";
}
