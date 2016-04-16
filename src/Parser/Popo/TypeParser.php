<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Schema\Parser\Popo;

use InvalidArgumentException;

/**
 * Parses the type string
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeParser
{
    /**
     * @var string
     */
    protected $baseType;

    /**
     * @var string
     */
    protected $typeHint;

    /**
     * @var array
     */
    protected $subTypes;

    public function __construct($baseType, $typeHint, array $subTypes = array())
    {
        $this->baseType = $baseType;
        $this->typeHint = $typeHint;
        $this->subTypes = $subTypes;
    }

    /**
     * @return string
     */
    public function getBaseType()
    {
        return $this->baseType;
    }

    /**
     * @param string $baseType
     */
    public function setBaseType($baseType)
    {
        $this->baseType = $baseType;
    }

    /**
     * @return string
     */
    public function getTypeHint()
    {
        return $this->typeHint;
    }

    /**
     * @param string $typeHint
     */
    public function setTypeHint($typeHint)
    {
        $this->typeHint = $typeHint;
    }

    /**
     * @return array
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    /**
     * @param array $subTypes
     */
    public function setSubTypes($subTypes)
    {
        $this->subTypes = $subTypes;
    }

    public static function parse($type)
    {
        // remove all white spaces
        $type = preg_replace('/\s+/', '', $type);

        preg_match('/^([A-z0-9\\\\]+)(\(([A-z0-9\\\\]+)\))?(\<(.*)\>)?$/', $type, $matches);

        $baseType = isset($matches[1]) ? ltrim($matches[1], '\\') : null;
        $typeHint = isset($matches[3]) ? ltrim($matches[3], '\\') : null;
        $subTypes = isset($matches[5]) ? $matches[5] : null;

        // if we have a class name its a complex type
        if (strpos($baseType, '\\') !== false) {
            $typeHint = $baseType;
            $baseType = 'complex';
        }

        return new self(
            strtolower($baseType),
            $typeHint,
            self::parseSubType($subTypes)
        );
    }
    
    protected static function parseSubType($data)
    {
        $subTypes = [];

        if (!empty($data)) {
            $parts = self::explode(',', $data);

            foreach ($parts as $value) {
                $kv = self::explode('=', trim($value));
                if (count($kv) > 1) {
                    $key = isset($kv[0]) ? trim($kv[0]) : null;
                    $val = isset($kv[1]) ? trim($kv[1]) : null;
                    $subTypes[$key] = ltrim($val, '\\');
                } else {
                    $subTypes[] = ltrim($kv[0], '\\');
                }
                
            }
        }

        return $subTypes;
    }

    /**
     * Explodes data after a specific sign but ignores all content which is 
     * inside < and >
     * 
     * @param string $sign
     * @param string $data
     * @return array
     */
    protected static function explode($sign, $data)
    {
        // split parts
        $len   = strlen($data);
        $level = 0;
        $index = 0;
        $parts = [];

        for ($i = 0; $i < $len; $i++) {
            if ($data[$i] === '<') {
                $level++;
            } elseif ($data[$i] === '>') {
                $level++;
            }

            if ($data[$i] === $sign && $level === 0) {
                $parts[] = substr($data, $index, $i - $index);
                $index = $i + 1;
            }
        }

        $last = substr($data, $index);
        
        if (!empty($last)) {
            $parts[] = $last;
        }

        return $parts;
    }
}
