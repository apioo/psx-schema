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

namespace PSX\Schema\Tests\Generator;

use PSX\Schema\Generator\Html;

/**
 * HtmlTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class HtmlTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Html();
        $actual    = $generator->generate($this->getSchema());

        $expect = <<<'HTML'
<?xml version="1.0"?>
<div>
  <div class="psx-object" id="psx_model_News">
    <h1>news</h1>
    <div class="psx-object-description">An general news entry</div>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"config"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Config">config</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"tags"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"receiver"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Author">author</a>)</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"resources"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">Mixed</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"profileImage"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc4648" title="RFC4648">Base64</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"read"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Boolean</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"source"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"author"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Author">author</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"meta"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Meta">meta</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"sendDate"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Date</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"readDate"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"expires"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="https://en.wikipedia.org/wiki/ISO_8601#Durations" title="ISO8601">Duration</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"price"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Number</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"rating"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Integer</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"content"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"question"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"coffeeTime"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Time</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"profileUri"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">config</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Config">config</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">tags</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
              <dt>MaxItems</dt>
              <dd>
                <span class="psx-constraint-maximum">6</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">receiver</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Author">author</a>)</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">resources</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">Mixed</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">profileImage</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc4648" title="RFC4648">Base64</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">read</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Boolean</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">source</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>OneOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Author">author</a>)</span>
                  </li>
                  <li>
                    <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Web">web</a>)</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">author</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Author">author</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description">An simple author element with some description</div>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">meta</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Meta">meta</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description">Some meta data</div>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">sendDate</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Date</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">readDate</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">expires</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="https://en.wikipedia.org/wiki/ISO_8601#Durations" title="ISO8601">Duration</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">price</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Number</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
              <dt>Maximum</dt>
              <dd>
                <span class="psx-constraint-maximum">100</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">rating</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Integer</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
              <dt>Maximum</dt>
              <dd>
                <span class="psx-constraint-maximum">5</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">content</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description">Contains the main content of the news entry</div>
            <dl class="psx-property-constraint">
              <dt>MinLength</dt>
              <dd>
                <span class="psx-constraint-minimum">3</span>
              </dd>
              <dt>MaxLength</dt>
              <dd>
                <span class="psx-constraint-maximum">512</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">question</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Enum</dt>
              <dd>
                <span class="psx-constraint-enum">
                  <ul class="psx-property-enum">
                    <li>
                      <span class="psx-constraint-enum-value">foo</span>
                    </li>
                    <li>
                      <span class="psx-constraint-enum-value">bar</span>
                    </li>
                  </ul>
                </span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">coffeeTime</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Time</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">profileUri</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="psx_model_Config">
    <h1>config</h1>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"*"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="psx_model_Author">
    <h1>author</h1>
    <div class="psx-object-description">An simple author element with some description</div>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"title"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"email"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"categories"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"locations"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Location">location</a>)</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"origin"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Location">location</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">title</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Pattern</dt>
              <dd>
                <span class="psx-constraint-pattern">[A-z]{3,16}</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">email</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description">We will send no spam to this addresss</div>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">categories</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MaxItems</dt>
              <dd>
                <span class="psx-constraint-maximum">8</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">locations</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Location">location</a>)</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description">Array of locations</div>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">origin</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Location">location</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description">Location of the person</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="psx_model_Location">
    <h1>location</h1>
    <div class="psx-object-description">Location of the person</div>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"lat"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Number</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"long"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Number</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"*"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">lat</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Number</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">long</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Number</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td>
            <span class="psx-property-description">Additional properties are allowed</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="psx_model_Web">
    <h1>web</h1>
    <div class="psx-object-description">An application</div>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"name"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"url"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"*"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">name</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-required">url</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="psx_model_Meta">
    <h1>meta</h1>
    <div class="psx-object-description">Some meta data</div>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"createDate"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"^tags_\d$"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"^location_\d$"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Location">location</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">createDate</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">^tags_\d$</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">^location_\d$</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Location">location</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description">Location of the person</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
HTML;

        $this->assertXmlStringEqualsXmlString($expect, '<div>' . $actual . '</div>', $actual);
    }
}
