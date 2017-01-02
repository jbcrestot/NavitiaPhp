<?php

namespace CanalTP\NavitiaPhp;

class QueryBuilder
{
    /**
     * @var string
     */
    const ALL_COVERAGES = '';

    /**
     * @var string
     */
    private $coverage = null;

    /**
     * @var string
     */
    private $path = null;

    /**
     * @var string[]
     */
    private $params = [];

    /**
     * @param string $coverage
     *
     * @return self
     */
    public function coverage($coverage = self::ALL_COVERAGES)
    {
        $this->coverage = $coverage;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function path($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return self
     */
    public function param($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        $path = [];

        if (null !== $this->coverage) {
            $path []= 'coverage';

            if (self::ALL_COVERAGES !== $this->coverage) {
                $path []= $this->coverage;
            }
        }

        if (null !== $this->path) {
            $path []= $this->path;
        }

        $uri = implode('/', $path);

        if (count($this->params) > 0) {
            $uri .= '?';
            $uri .= http_build_query($this->params);
        }

        return $uri;
    }
}
