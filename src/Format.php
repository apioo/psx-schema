<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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
     * A time without a time-zone in the ISO-8601 calendar system, such as '10:15:30'
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339
     */
    case TIME = 'time';
}
