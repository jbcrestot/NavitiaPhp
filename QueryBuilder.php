<?php

namespace CanalTP\NavitiaPhp;

class QueryBuilder
{
    /**
     * @var string
     */
    private $coverage = null;

    /**
     * @var string
     */
    private $api = null;

    /**
     * @param string $coverage
     *
     * @return self
     */
    public function coverage($coverage)
    {
        $this->coverage = $coverage;

        return $this;
    }

    /**
     * @param string $api
     *
     * @return self
     */
    public function api($api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        $path = [];
        $args = [];

        if (null !== $this->coverage) {
            $path []= 'coverage';
            $path []= $this->coverage;
        }

        if (null !== $this->api) {
            $path []= $this->api;
        }

        $uri = implode('/', $path);

        if (count($args) > 0) {
            $uri .= '?';
            $uri .= http_build_query($args);
        }

        return $uri;
    }
}
