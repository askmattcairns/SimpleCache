<?php
namespace SimpleCache;

class SimpleCache
{
    private $cacheFileName = null;
    private $cachePath = "";
    private $cacheDir = "CACHE";
    private $cacheExt = ".cache";
    private $lifetime = 60; // Cache is valid for 60 seconds.

    public function __construct($cacheFileName)
    {
        $this->cacheFileName = $cacheFileName;
    }

    public function create( $data )
    {
        return file_put_contents( $this->cacheName(), json_encode( $data ) );
    }

    public function read()
    {
        $cache = file_get_contents( $this->cacheName() );
        return json_decode( $cache );
    }

    public function isExpired()
    {
        if( $this->cacheExists() )
        {
            if( $this->cacheAge() > $this->lifetime )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
            return true;

    }

    public function setLifetime( $val ) {
        $this->lifetime = $val;
    }

    public function setCachePath( $val )
    {
        $this->cachePath = $val;
    }

    private function cacheAge()
    {
        $now = date("U");
        $mtime = filemtime( $this->cacheName() );

        return bcsub($now, $mtime);
    }

    private function cacheExists()
    {
        return file_exists( $this->cacheName() );
    }

    private function cacheName()
    {
        return $this->cachePath . DIRECTORY_SEPARATOR . $this->cacheDir . DIRECTORY_SEPARATOR . $this->cacheFileName . $this->cacheExt;
    }
}