<?php
namespace randomhost\Steam;

/**
 * Provides methods for retrieving data from the Steam Web API.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class API
{
    /**
     * Steam WebAPI Url
     *
     * @var string
     */
    const URL = 'https://api.steampowered.com';

    /**
     * Steam WepAPI response format.
     *
     * @var string
     */
    const FORMAT = 'json';

    /**
     * Error code for invalid API responses.
     *
     * @var int
     */
    const ERROR_BAD_RESPONSE = 502;

    /**
     * Error code for API timeout errors.
     *
     * @var int
     */
    const ERROR_TIMEOUT = 504;

    /**
     * Error code for API lookup methods which did not yield any results.
     *
     * @var int
     */
    const ERROR_NOT_FOUND = 404;

    /**
     * Memcached key prefix.
     *
     * @var string
     */
    const MEMCACHED_KEY_PREFIX = 'PHP_Steam_Signature_';

    /**
     * Steam Web API key.
     *
     * @var string
     */
    protected $key = '';

    /**
     * \Memcached instance.
     *
     * @var null|\Memcached
     */
    protected $memcached = null;

    /**
     * Toggles Memcached usage.
     *
     * @var bool
     */
    protected $memcachedUsage = true;

    /**
     * Constructor for this class.
     *
     * @param string     $key       Steam WebAPI key.
     * @param \Memcached $memcached Optional: \Memcached instance to be used for
     *                              caching data.
     */
    public function __construct($key, \Memcached $memcached = null)
    {
        $this->setKey($key);

        if (!is_null($memcached)) {
            $this->setMemcached($memcached);
        }
    }

    /**
     * Sets the Steam Web API key.
     *
     * @param string $key Steam Web API key.
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Returns the Steam Web API key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Injects a \Memcached instance to be used for caching data.
     *
     * @param \Memcached $memcached \Memcached instance to be used for caching data.
     *
     * @return $this
     */
    public function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;

        return $this;
    }

    /**
     * Returns the \Memcached instance to be used for caching data.
     *
     * @return \Memcached|null
     */
    public function getMemcached()
    {
        return $this->memcached;
    }

    /**
     * Sets whether a given \Memcached instance should be used or not.
     *
     * @param bool $enable true: use Memcached, false: do not use Memcached
     *
     * @return $this
     */
    public function setMemcachedUsage($enable)
    {
        $this->memcachedUsage = (bool)$enable;

        return $this;
    }

    /**
     * Returns whether a given \Memcached instance should be used or not.
     *
     * @return boolean
     */
    public function getMemcachedUsage()
    {
        return $this->memcachedUsage;
    }

    /**
     * Resolves the given vanity URL into a 64-Bit Steam ID.
     *
     * @param string $vanityUrl Vanity URL.
     *
     * @return string
     * @throws \InvalidArgumentException Thrown if the vanity URL was not valid.
     * @throws \RuntimeException Thrown in case of connection or parsing errors.
     */
    public function resolveVanityUrl($vanityUrl)
    {
        $mcKey = 'vanityUrl_' . $vanityUrl;

        $steamId = $this->getMemcachedValue($mcKey);

        if (!is_null($steamId)) {
            return $steamId;
        }

        $requestUrl = $this->buildRequestUrl(
            'ISteamUser',
            'ResolveVanityURL',
            1,
            array('vanityurl' => $vanityUrl)
        );
        $data = $this->request($requestUrl);
        if (!isset($data->steamid)) {
            if (isset($data->message) && $data->message === 'No match') {
                throw new \InvalidArgumentException(
                    sprintf(
                        'The specified profile "%s" could not be found',
                        $vanityUrl
                    ),
                    self::ERROR_NOT_FOUND
                );
            }
            throw new \RuntimeException(
                sprintf(
                    'Steam Web API JSON response does not include a steamid ' .
                    'field: %s',
                    var_export($data, true)
                ),
                self::ERROR_BAD_RESPONSE
            );
        }
        $steamId = (string)$data->steamid;

        $this->setMemcachedValue($mcKey, $steamId, 60 * 60 * 24 * 15);

        return $steamId;
    }

    /**
     * Fetches player summary data.
     *
     * @param string $steamId A 64 bit Steam community ID.
     *
     * @return \stdClass
     * @throws \InvalidArgumentException Thrown if the Steam ID was not valid.
     * @throws \RuntimeException Thrown in case of connection or parsing errors.
     */
    public function fetchPlayerSummary($steamId)
    {
        $mcKey = 'playerSummary_' . $steamId;

        $playerSummary = $this->getMemcachedValue($mcKey);

        if (is_null($playerSummary)) {
            $requestUrl = $this->buildRequestUrl(
                'ISteamUser',
                'GetPlayerSummaries',
                2,
                array('steamids' => $steamId)
            );
            $data = $this->request($requestUrl);
            if (empty($data->players[0])) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'The specified Steam ID "%s" could not be found',
                        $steamId
                    ),
                    self::ERROR_NOT_FOUND
                );
            }

            $playerSummary = $data->players[0];

            $this->setMemcachedValue($mcKey, $playerSummary, 5 * 60);
        }
        return $playerSummary;
    }

    /**
     * Appends configured prefixes and returns the Memcached key to be used.
     *
     * @param string $key Non prefixed Memcached key.
     *
     * @return string
     */
    protected function getMemcachedKey($key)
    {
        return self::MEMCACHED_KEY_PREFIX . $key;
    }

    /**
     * Returns the item that was previously stored under the key.
     *
     * If no data is stored, null is returned.
     *
     * @param string $key Key of the item to retrieve.
     *
     * @return null|mixed
     */
    protected function getMemcachedValue($key)
    {
        if (is_null($this->memcached) || !$this->getMemcachedUsage()) {
            return null;
        }

        $data = $this->memcached->get($this->getMemcachedKey($key));

        if ($this->memcached->getResultCode() !== \Memcached::RES_SUCCESS) {
            return null;
        }

        return $data;
    }

    /**
     * Stores the value under the specified key.
     *
     * @param string $key  Key under which to store the value.
     * @param mixed  $data Value to store.
     * @param int    $ttl  Expiration time (default: 0).
     *
     * @return bool
     */
    protected function setMemcachedValue($key, $data, $ttl)
    {
        if (is_null($this->memcached) || !$this->getMemcachedUsage()) {
            return true;
        }

        return $this->memcached->set($this->getMemcachedKey($key), $data, $ttl);
    }

    /**
     * Performs a request to the Steam WebAPI and returns the result.
     *
     * @param string $interface Steam WebAPI interface name.
     * @param string $method    Steam WebAPI method name.
     * @param int    $version   Steam WebAPI method version.
     * @param array  $params    Steam WebAPI method parameters.
     *
     * @return string
     */
    protected function buildRequestUrl(
        $interface,
        $method,
        $version,
        array $params
    ) {
        return sprintf(
            '%1$s/%2$s/%3$s/v%4$u/?format=%5$s&key=%6$s&%7$s',
            self::URL,
            $interface,
            $method,
            str_pad($version, 4, '0', STR_PAD_LEFT),
            self::FORMAT,
            $this->key,
            http_build_query($params)
        );
    }

    /**
     * Performs a HTTP request with the given URL and returns the result.
     *
     * @param string $url Request URL.
     *
     * @return \stdClass
     * @throws \RuntimeException Thrown in case of connection or parsing errors.
     */
    protected function request($url)
    {
        $data = @file_get_contents($url);
        if (empty($data)) {
            if (empty($http_response_header)) {
                throw new \RuntimeException(
                    'Could not connect to Steam Web API',
                    self::ERROR_TIMEOUT
                );
            }
            preg_match(
                '/^.* (\d{3}) (.*)$/',
                $http_response_header[0],
                $httpStatus
            );
            throw new \RuntimeException(
                sprintf(
                    'Steam Web API returned HTTP status %u %s',
                    $httpStatus[1],
                    $httpStatus[0]
                ),
                self::ERROR_BAD_RESPONSE
            );
        }

        $result = json_decode($data);
        if (is_null($result)) {
            throw new \RuntimeException(
                sprintf(
                    'Steam Web API JSON response could not be decoded: %s',
                    $data
                ),
                self::ERROR_BAD_RESPONSE
            );
        }

        if (!isset($result->response)) {
            throw new \RuntimeException(
                sprintf(
                    'Steam Web API JSON response does not include a response ' .
                    'field: %s',
                    var_export($result, true)
                ),
                self::ERROR_BAD_RESPONSE
            );
        }

        return $result->response;
    }
}
