<?php

declare(strict_types=1);

namespace randomhost\Steam;

/**
 * Provides methods for retrieving data from the Steam Web API.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class API
{
    /**
     * Error code for invalid API responses.
     *
     * @var int
     */
    public const ERROR_BAD_RESPONSE = 502;

    /**
     * Error code for API timeout errors.
     *
     * @var int
     */
    public const ERROR_TIMEOUT = 504;

    /**
     * Error code for API lookup methods which did not yield any results.
     *
     * @var int
     */
    public const ERROR_NOT_FOUND = 404;

    /**
     * Steam WebAPI Url.
     *
     * @var string
     */
    private const URL = 'https://api.steampowered.com';

    /**
     * Steam WepAPI response format.
     *
     * @var string
     */
    private const FORMAT = 'json';

    /**
     * Memcached key prefix.
     *
     * @var string
     */
    private const MEMCACHED_KEY_PREFIX = 'PHP_Steam_Signature_';

    /**
     * Steam Web API key.
     */
    protected string $key = '';

    /**
     * \Memcached instance.
     */
    protected ?\Memcached $memcached = null;

    /**
     * Toggles Memcached usage.
     */
    protected bool $memcachedUsage = true;

    /**
     * Constructor for this class.
     *
     * @param string          $key       Steam WebAPI key.
     * @param null|\Memcached $memcached Optional: \Memcached instance to be used
     *                                   for caching data.
     */
    public function __construct(string $key, ?\Memcached $memcached = null)
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
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Returns the Steam Web API key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Injects a \Memcached instance to be used for caching data.
     *
     * @param \Memcached $memcached \Memcached instance to be used for caching data.
     */
    public function setMemcached(\Memcached $memcached): self
    {
        $this->memcached = $memcached;

        return $this;
    }

    /**
     * Returns the \Memcached instance to be used for caching data.
     */
    public function getMemcached(): ?\Memcached
    {
        return $this->memcached;
    }

    /**
     * Sets whether a given \Memcached instance should be used or not.
     *
     * @param bool $enable true: use Memcached, false: do not use Memcached
     */
    public function setMemcachedUsage(bool $enable): self
    {
        $this->memcachedUsage = $enable;

        return $this;
    }

    /**
     * Returns whether a given \Memcached instance should be used or not.
     */
    public function getMemcachedUsage(): bool
    {
        return $this->memcachedUsage;
    }

    /**
     * Resolves the given vanity URL into a 64-Bit Steam ID.
     *
     * @param string $vanityUrl Vanity URL.
     *
     * @throws \InvalidArgumentException Thrown if the vanity URL was not valid.
     * @throws \RuntimeException         Thrown in case of connection or parsing errors.
     */
    public function resolveVanityUrl(string $vanityUrl): string
    {
        $mcKey = 'vanityUrl_'.$vanityUrl;

        $steamId = $this->getMemcachedValue($mcKey);

        if (!is_null($steamId)) {
            return $steamId;
        }

        $requestUrl = $this->buildRequestUrl(
            'ISteamUser',
            'ResolveVanityURL',
            1,
            ['vanityurl' => $vanityUrl]
        );
        $data = $this->request($requestUrl);
        if (!isset($data->steamid)) {
            if (isset($data->message) && 'No match' === $data->message) {
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
                    'Steam Web API JSON response does not include a steamid '.
                    'field: %s',
                    var_export($data, true)
                ),
                self::ERROR_BAD_RESPONSE
            );
        }
        $steamId = (string) $data->steamid;

        $this->setMemcachedValue($mcKey, $steamId, 60 * 60 * 24 * 15);

        return $steamId;
    }

    /**
     * Fetches player summary data.
     *
     * @param string $steamId A 64 bit Steam community ID.
     *
     * @throws \InvalidArgumentException Thrown if the Steam ID was not valid.
     * @throws \RuntimeException         Thrown in case of connection or parsing errors.
     */
    public function fetchPlayerSummary(string $steamId): ?\stdClass
    {
        $mcKey = 'playerSummary_'.$steamId;

        $playerSummary = $this->getMemcachedValue($mcKey);

        if (is_null($playerSummary)) {
            $requestUrl = $this->buildRequestUrl(
                'ISteamUser',
                'GetPlayerSummaries',
                2,
                ['steamids' => $steamId]
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
     */
    protected function getMemcachedKey(string $key): string
    {
        return self::MEMCACHED_KEY_PREFIX.$key;
    }

    /**
     * Returns the item that was previously stored under the key.
     *
     * If no data is stored, null is returned.
     *
     * @param string $key Key of the item to retrieve.
     */
    protected function getMemcachedValue(string $key): mixed
    {
        if (is_null($this->memcached) || !$this->getMemcachedUsage()) {
            return null;
        }

        $data = $this->memcached->get($this->getMemcachedKey($key));

        if (\Memcached::RES_SUCCESS !== $this->memcached->getResultCode()) {
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
     */
    protected function setMemcachedValue(string $key, mixed $data, int $ttl): bool
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
     */
    protected function buildRequestUrl(string $interface, string $method, int $version, array $params): string
    {
        return sprintf(
            '%1$s/%2$s/%3$s/v%4$u/?format=%5$s&key=%6$s&%7$s',
            self::URL,
            $interface,
            $method,
            str_pad((string) $version, 4, '0', STR_PAD_LEFT),
            self::FORMAT,
            $this->key,
            http_build_query($params)
        );
    }

    /**
     * Performs an HTTP request with the given URL and returns the result.
     *
     * @param string $url Request URL.
     *
     * @throws \RuntimeException Thrown in case of connection or parsing errors.
     */
    protected function request(string $url): \stdClass
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
                    'Steam Web API JSON response does not include a response '.
                    'field: %s',
                    var_export($result, true)
                ),
                self::ERROR_BAD_RESPONSE
            );
        }

        return $result->response;
    }
}
