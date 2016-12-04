<?php

namespace Presskit\Value;

use Presskit\Value\Text;

class TrailerLocation
{
    private $format;
    private $path;

    public function __construct($format, $path)
    {
        $this->format = new Text(strtolower($format));
        $this->path = new Text($path);
    }

    public function __toString()
    {
        if ((string) $this->format !== '' && (string) $this->path !== '') {
            if ((string) $this->format === 'youtube') {
                return 'https://www.youtube.com/watch?v=' . $this->path;
            } else if ((string) $this->format === 'vimeo') {
                return 'https://vimeo.com/' . $this->path;
            } else if ((string) $this->format === 'mov') {
                return $this->path . '.mov';
            } else if ((string) $this->format === 'mp4') {
                return $this->path . '.mp4';
            } else {
                return $this->format . ' (' . $this->path . ')';
            }
        }

        return '';
    }

    public function format()
    {
        if ((string) $this->format !== '' || (string) $this->path !== '') {
            return $this->format;
        }

        return '';
    }

    public function path()
    {
        if ((string) $this->format !== '' || (string) $this->path !== '') {
            return $this->path;
        }

        return '';
    }
}
