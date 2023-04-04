<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema;

/**
 * This enum describes all available format types which are allowed at TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
enum Format: string
{
    /**
     * A base64 encoded string
     *
     * @see https://www.rfc-editor.org/rfc/rfc4648
     */
    case BINARY = 'base64';

    /**
     * A date without a time-zone in the ISO-8601 calendar system, such as '2007-12-03'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339
     */
    case DATE = 'date';

    /**
     * A date-time without a time-zone in the ISO-8601 calendar system, such as '2007-12-03T10:15:30'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339
     */
    case DATETIME = 'date-time';

    /**
     * A domain string, such as 'google.com' or 'docs.github.com'
     */
    case DOMAIN = 'domain';

    /**
     * A time-based amount of time, such as 'PT34S'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339
     */
    case DURATION = 'duration';

    /**
     * An email string, such as 'christoph.kappestein@gmail.com'
     */
    case EMAIL = 'email';

    /**
     * An integer in the 32 bit range from 0x80000000 to 0x7FFFFFFF
     */
    case INT32 = 'int32';

    /**
     * An integer in the 64 bit range
     */
    case INT64 = 'int64';

    /**
     * An ipv4 string, such as '192.168.0.1'
     */
    case IPV4 = 'ipv4';

    /**
     * An ipv6 string, such as '2a00:1450:4001:829::200e:'
     */
    case IPV6 = 'ipv6';

    /**
     * A date-based amount of time in the ISO-8601 calendar system, such as 'P2Y3M4D'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339
     */
    case PERIOD = 'period';

    /**
     * A time without a time-zone in the ISO-8601 calendar system, such as '10:15:30'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339
     */
    case TIME = 'time';

    /**
     * An uri string, such as 'mailto:John.Doe@example.com'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3986
     */
    case URI = 'uri';

    /**
     * An url string, such as 'https://google.com'
     *
     * @see https://www.rfc-editor.org/rfc/rfc1738
     */
    case URL = 'url';

    /**
     * An urn string, such as 'urn:uuid:f81d4fae-7dec-11d0-a765-00a0c91e6bf6'
     *
     * @see https://www.rfc-editor.org/rfc/rfc8141
     */
    case URN = 'urn';

    /**
     * An uuid string, such as 'f81d4fae-7dec-11d0-a765-00a0c91e6bf6'
     *
     * @see https://www.rfc-editor.org/rfc/rfc4122
     */
    case UUID = 'uuid';
}
