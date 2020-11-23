<?php
declare(strict_types = 1);
namespace App\Lib\Configuration;

use Exception;

class Configuration
{
    /** @var array<array> */
    private $configuration;

    /** @var string */
    private $segment;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->configuration = $this->parseIniFile($path);
        $this->setSegment((string)array_key_first($this->configuration));
    }

    /**
     * Parses ini file
     *
     * @param string $path
     * @return array<array>
     */
    private function parseIniFile(string $path):array
    {
        $configuration = parse_ini_file($path, true, INI_SCANNER_RAW) ?: [];

        return $configuration;
    }

    /**
     * Returns segment form configuration file
     *
     * @param string $segment
     * @return array<string>
     */
    public function getSegment(string $segment):array
    {
        if (!(array_key_exists($segment, $this->configuration))) {
            throw new Exception('Segment ' . $segment . 'not exists!');
        }

        return $this->configuration[$segment];
    }

    /**
     * Returns configuration by providet key
     *
     * @param string $key
     * @return string
     */
    public function get(string $key):string
    {
        $configuration = $this->getSegment($this->segment);
        if (!(array_key_exists($key, $configuration))) {
            throw new \Exception('Key ' . $key . 'not exists!');
        }

        return $configuration[$key];
    }

    /**
     * Sets default segment
     *
     * @param string $segment
     * @return void
     */
    public function setSegment(string $segment):void
    {
        if (!array_key_exists($segment, $this->configuration)) {
            throw new Exception('Segment ' . $segment . ' not exists!');
        }

        $this->segment = $segment;
    }
}
