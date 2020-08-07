<?php

namespace App;

use Exception;

/**
 * Shopify API Class
 * @package App\Shopify
 */
class ShopifyApi
{
    protected $shop       = '';
    protected $api_key    = '';
    protected $password   = '';
    protected $secret     = '';
    protected $url_format = 'https://apikey:password@hostname/admin/api/2020-07/resource.json';

    /**
     * Api constructor. Configures with parameters from .env file
     * These values are intentionally not committed to the repo
     */
    public function __construct()
    {
        $this->shop     = env('SHOPIFY_SHOP');
        $this->api_key  = env('SHOPIFY_API_KEY');
        $this->password = env('SHOPIFY_PASSWORD');
        $this->secret   = env('SHOPIFY_SHARED_SECRET');
    }

    /**
     * Generates an API URL given a resource and query parameters
     *
     * @param string $resource
     * @param array|null $data
     * @return string|string[]
     */
    protected function getUrl(string $resource, array $data = null)
    {
        $url = $this->url_format;
        $url = str_replace('apikey', $this->api_key, $url);
        $url = str_replace('password', $this->password, $url);
        $url = str_replace('hostname', $this->shop . '.myshopify.com', $url);
        $url = str_replace('resource', $resource, $url);

        if ($data) {
            $url .= '?' . http_build_query($data);
        }

        return $url;
    }

    /**
     * Check to see if the requested resource is implemented by the API
     *
     * @param string $resource
     * @return bool
     */
    protected function isResourceSupported(string $resource)
    {
        $resources = ['orders'];

        return in_array($resource, $resources);
    }

    /**
     * Makes an API request to Shopify
     *
     * @param string $method
     * @param string $resource
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function request(string $method, string $resource, array $data = [])
    {
        // Guard for invalid resource requests
        if (!$this->isResourceSupported($resource)) {
            throw new Exception("The resource '$resource' is not supported");
        }

        // Guard for invalid methods
        if (!in_array($method, ['POST', 'GET'])) {
            throw new Exception("Invalid method provided. Valid methods are GET or POST. Received $method");
        }

        // Initiate the CURL Request
        $curl = curl_init();

        if ('GET' == $method) {

            curl_setopt($curl, CURLOPT_URL, $this->getUrl($resource, $data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        } elseif ('POST' == $method) {

            $postData = json_encode($data);

            curl_setopt($curl, CURLOPT_URL, $this->getUrl($resource));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
        }

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        // Check for errors in the response
        if (isset($response->errors)) {
            throw new Exception($response->errors);
        }

        return $response;
    }

    /**
     * Get the orders from the Shopify API
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function getOrders(array $data = [])
    {
        $url = "orders";
        $response = $this->request('GET', $url, $data);

        return $response->orders;
    }
}
