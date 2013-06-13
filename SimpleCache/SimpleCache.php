<?php
namespace SimpleCache;

class SimpleCache
{
    private $fileName = null;
    private $path = ""; // most have trailing slash
    private $dir = "CACHE";
    private $ext = ".cache";
    private $lifetime = 60; // Cache is valid for 60 seconds.

    public function __construct( $fileName )
    {
        $this->fileName = $fileName;
    }

    public function write( $data )
    {
        if( is_array( $data ) or is_object( $data ) )
            $data = json_encode( $data );

        return file_put_contents( $this->name(), $data );
    }

    public function read()
    {
        $cache = file_get_contents( $this->name() );
        if( $data = json_decode( $cache ) )
            return $data;
        else
            return $cache;
    }

    public function isExpired()
    {
        if( $this->lifetime == 0 )
        {
            return false;
        }
        else
        {
            if( $this->exists() )
            {
                if( $this->age() > $this->lifetime )
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

    }

    public function setLifetime( $val ) {
        $this->lifetime = $val;
    }

    public function setPath( $val )
    {
        $this->path = $val;
    }

    private function age()
    {
        $now = date("U");
        $mtime = filemtime( $this->name() );

        return bcsub($now, $mtime);
    }

    public function exists()
    {
        return file_exists( $this->name() );
    }

    private function name()
    {
        return $this->path . $this->dir . DIRECTORY_SEPARATOR . $this->fileName . $this->ext;
    }
}