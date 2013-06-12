<?php
namespace SimpleCache;

class SimpleCache
{
    private $cachePath = "";
    private $cacheDir = "CACHE";
    private $cacheExt = ".cache";
    private $lifetime = 60; // Cache is valid for 60 seconds.

    public function __construct()
    {

    }

    public function create( $name, $data )
    {
        return file_put_contents( $this->cacheName($name), json_encode( $data ) );
    }

    public function read( $name )
    {
        $cache = file_get_contents( $this->cacheName($name) );
        return json_decode( $cache );
    }

    public function isExpired( $name )
    {
        if( $this->cacheExists( $name ) )
        {
            if( $this->cacheAge($name) > $this->lifetime )
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

    private function cacheAge( $name )
    {
        $now = date("U");
        $mtime = filemtime( $this->cacheName($name) );

        return bcsub($now, $mtime);
    }

    private function cacheExists( $name )
    {
        return file_exists( $this->cacheName($name) );
    }

    private function cacheName( $name )
    {
        return $this->cachePath . DIRECTORY_SEPARATOR . $this->cacheDir . DIRECTORY_SEPARATOR . $name . $this->cacheExt;
    }
}