<?php

namespace Fleek;

use Fleek\Auth\AuthInterface;

class Fleek
{
    /**
     * libvirt resource
     *
     * @var resource
     */
    private $resource;

    /**
     * Connect
     *
     * @param AuthInterface $auth
     */
    public function connect(AuthInterface $auth)
    {
        $this->resource = $auth->authenticate();
    }

    /**
     * Is Connected
     *
     * @return bool
     */
    public function isConnected()
    {
        return (is_resource($this->resource) ? true : false);
    }

    /**
     * Domain Manager
     *
     * @param $domain
     * @return Domain
     * @throws \Exception
     */
    public function getDomainManager($domain)
    {
        if (!is_resource($domain)) {
            $domain = $this->getDomainResource($domain);
        }
        return new Domain($domain);
    }

    /**
     * Domain Resource
     *
     * @param $domain
     * @return resource
     * @throws \Exception
     */
    public function getDomainResource($domain)
    {
        $domain = libvirt_domain_lookup_by_name($this->resource, $domain);
        if(is_resource($domain))
            return $domain;
        $domain = libvirt_domain_lookup_by_uuid_string($this->resource, $domain);
        if(is_resource($domain))
            return $domain;
        throw new \Exception("Domain does not exist: " . libvirt_get_last_error());
    }

    /**
     * Get Domains
     *
     * @return array
     */
    public function getDomains()
    {
        return libvirt_list_domains($this->resource);
    }

    public function getDomainXML($domain)
    {
        return libvirt_domain_get_xml_desc($domain, null);
    }

    /**
     * Gets the libvirt client version
     *
     * @return array
     */
    public function version()
    {
        return libvirt_version();
    }
}