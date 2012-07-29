<?php

namespace SpeckMultisite\Service;

use Zend\Session\Container as SessionContainer,
    Zend\Http\PhpEnvironment\Response as HttpResponse,
    Zend\EventManager\StaticEventManager;
use Zend\Stdlib\RequestInterface;

class DomainResolver
{
    const DOMAIN_UNRESOLVED = 'UNRESOLVED';
    const DOMAIN_UNKNOWN = 'UNKNOWN';

    /**
     * Array that maps url, to site id's
     * @var array
     */
    protected $domainMap = array();

    /**
     * Identifier for the resolved domain
     *
     * @var string
     */
    protected $resolvedDomain = null;

    /**
     * Resolves on which siteDomain we currently are viewing
     */
    public function resolveSiteDomain(RequestInterface $request)
    {
        if (!method_exists($request, 'getUri')) {
            return;
        }

        $host = $request->getUri()->getHost();

        if (!in_array($host, array_keys($this->domainMap)))
            $this->resolvedDomain = self::DOMAIN_UNKNOWN;
        else
            $this->resolvedDomain = strtoupper ($this->domainMap[$host]);
    }

    public function setDomainMap(\Zend\Config\Config $domainMap)
    {
        $this->domainMap = $domainMap->toArray();
    }

    public function getDomain()
    {
        return $this->resolvedDomain ?: self::DOMAIN_UNRESOLVED;
    }

}
