<?php
namespace Omnilance;

class Api
{

    private $url = "https://api.omnilance.com";
    private $api_version = '2.0';
    private $apikey;

    public function __construct($apikey, $url = Null, $version = Null)
    {
        $this->apikey = $apikey;
        if (!empty($url))
            $this->url = $url;

        if (!empty($version))
            $this->api_version = $version;
    }

    /**
     * @param $cmd
     * @param array $data
     * @param string $request_type
     * @return mixed
     */
    private function Request($cmd, $data = [], $request_type = 'GET')
    {
        $url = implode('/', [$this->url, "v" . $this->api_version, $cmd]);

        $defaults = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $request_type,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => ["X-Token: {$this->apikey}"]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        if (!$result = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);

        $response = json_decode($result);
        return $response;
    }

    /**
     * @param $customer_data
     * @return mixed
     */
    public function CustomerAdd($customer_data)
    {
        $response = $this->Request("customer", $customer_data, "POST");
        return $response;
    }

    /**
     * @param $customer_id
     * @param $data
     * @return mixed
     */
    public function CustomerUpdate($customer_id, $data)
    {
        $response = $this->Request("customer/$customer_id", $data, 'PUT');
        return $response;
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function CustomerInfo($customer_id)
    {
        $response = $this->Request("customer/$customer_id");
        return $response;
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function CustomerDelete($customer_id)
    {
        $response = $this->Request("customer/$customer_id", [], "DELETE");
        return $response;
    }

    /**
     * @param $domain
     * @return mixed
     */
    public function DomainCheck($domain)
    {
        $response = $this->Request("domain/$domain/check");
        return $response;
    }

    /**
     * @param $domain
     * @param $domain_info
     * @return mixed
     */
    public function DomainAdd($domain, $domain_info)
    {
        $response = $this->Request("domain/$domain", $domain_info, 'POST');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainUpdate($domain, $data = [])
    {
        $response = $this->Request("domain/$domain", $data, 'PUT');
        return $response;
    }

    /**
     * @param $domain
     * @return mixed
     */
    public function DomainInfo($domain)
    {
        $response = $this->Request("domain/$domain");
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainRenew($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/renew', $data, 'PUT');
        return $response;
    }

    /*
    // Start Transfer
    */
    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainTransferRequest($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/transfer', $data, 'POST');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainTransferQuery($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/transfer', $data, 'GET');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainTransferCancel($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/transfer', 'DELETE');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainTransferApprove($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/transfer/approve', 'PUT');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainTransferReject($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/transfer/reject', 'PUT');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainRestore($domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/restore', $data, 'PUT');
        return $response;
    }

    /**
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function DomainDelete($domain, $data = [])
    {
        $response = $this->Request("domain/$domain",  $data, 'DELETE');

        return $response;
    }

    /**
     * @param $contact_id
     * @return mixed
     */
    public function ContactCheck($contact_id)
    {
        $response = $this->Request("contact/$contact_id/check");
        return $response;
    }

    /**
     * @param $contact_id
     * @param $contact_info
     * @return mixed
     */
    public function ContactAdd($contact_id, $contact_info)
    {
        $response = $this->Request("contact/$contact_id", $contact_info, 'POST');
        return $response;
    }

    /**
     * @param $contact_id
     * @return mixed
     */
    public function ContactInfo($contact_id)
    {
        $response = $this->Request("contact/$contact_id");
        return $response;
    }

    /**
     * @param $contact_id
     * @param array $data
     * @return mixed
     */
    public function ContactUpdate($contact_id, $data = [])
    {
        $response = $this->Request("contact/$contact_id", $data, 'PUT');
        return $response;
    }

    /**
     * @param $contact_id
     * @return mixed
     */
    public function ContactDelete($contact_id)
    {
        $response =  $this->Request("contact/$contact_id",[],'DELETE');
        return $response;
    }

    /**
     * @param $hostName
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function HostCheck($hostName, $domain, $data = [])
    {
        $response =  $this->Request("domain/$domain" . '/host/' . $hostName . '/check', $data);
        return $response;
    }

    /**
     * @param $hostName
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function HostAdd($hostName, $domain, $data = [])
    {
        $response =  $this->Request("domain/$domain" . '/host/' . $hostName, $data, 'POST');
        return $response;
    }

    /**
     * @param $hostName
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function HostInfo($hostName, $domain, $data = [])
    {
        $response =  $this->Request("domain/$domain" . '/host/' . $hostName, $data);
        return $response;
    }

    /**
     * @param $hostName
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function HostDelete($hostName, $domain, $data = [])
    {
        $response =  $this->Request("domain/$domain" . '/host/' . $hostName, $data, 'DELETE');
        return $response;
    }

    /**
     * @param $hostName
     * @param $domain
     * @param array $data
     * @return mixed
     */
    public function HostUpdate($hostName, $domain, $data = [])
    {
        $response = $this->Request("domain/$domain" . '/host/'. $hostName, $data, 'PUT');
        return $response;
    }
}
