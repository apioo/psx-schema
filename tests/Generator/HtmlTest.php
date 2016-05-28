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
        $result    = $generator->generate($this->getSchema());

        $expect = <<<'HTML'
<div>
	<div id="psx-type-12b3526ee773c0681e998e7d564de460" class="psx-complex-type">
		<h1>news</h1>
		<div class="psx-type-description">An general news entry</div>
		<table class="table psx-type-properties">
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="40%" />
				<col width="20%" />
			</colgroup>
			<thead>
				<tr>
					<th>Property</th>
					<th>Type</th>
					<th>Description</th>
					<th>Constraints</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">config</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-complex">
							<a href="#psx-type-72828040aecd82459c3636a4226e81fc">config</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">tags</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-array">Array&lt;<span class="psx-property-type psx-property-type-string">String</span>&gt;</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
						<dl class="psx-property-constraint">
							<dt>Minimum</dt>
							<dd>
								<span class="psx-constraint-minimum">1</span>
							</dd>
							<dt>Maximum</dt>
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
						<span class="psx-property-type psx-property-type-array">Array&lt;<span class="psx-property-type psx-property-type-complex">
								<a href="#psx-type-4770be5abc2aedca274241c166226fc7">author</a>
							</span>&gt;</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
						<dl class="psx-property-constraint">
							<dt>Minimum</dt>
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
						<span class="psx-property-type psx-property-type-array">Array&lt;<span class="psx-property-type psx-property-type-choice">
								<span class="psx-property-type psx-property-type-complex">
									<a href="#psx-type-b33b896fd4135c2882510d8949e883cf">location</a>
								</span>|<span class="psx-property-type psx-property-type-complex">
									<a href="#psx-type-57c64cac92e27c1db99e6a6793546e12">web</a>
								</span>
							</span>&gt;</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">profileImage</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-binary">
							<a href="http://tools.ietf.org/html/rfc4648" title="RFC4648">Base64</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">read</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-boolean">Boolean</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">source</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-choice">
							<span class="psx-property-type psx-property-type-complex">
								<a href="#psx-type-4770be5abc2aedca274241c166226fc7">author</a>
							</span>|<span class="psx-property-type psx-property-type-complex">
								<a href="#psx-type-57c64cac92e27c1db99e6a6793546e12">web</a>
							</span>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">author</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-complex">
							<a href="#psx-type-4770be5abc2aedca274241c166226fc7">author</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">meta</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-complex">
							<a href="#psx-type-68a5de1071c84dc3c357e50c05e674fa">meta</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">sendDate</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-date">
							<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Date</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">readDate</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-datetime">
							<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">expires</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-duration">
							<span title="ISO 8601">Duration</span>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-required">price</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-float">Float</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
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
						<span class="psx-property-type psx-property-type-integer">Integer</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
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
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description">Contains the main content of the news entry</span>
					</td>
					<td>
						<dl class="psx-property-constraint">
							<dt>Minimum</dt>
							<dd>
								<span class="psx-constraint-minimum">3</span>
							</dd>
							<dt>Maximum</dt>
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
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
						<dl class="psx-property-constraint">
							<dt>Enumeration</dt>
							<dd>
								<span class="psx-constraint-enumeration">
									<ul class="psx-property-enumeration">
										<li>
											<span class="psx-constraint-enumeration-value">foo</span>
										</li>
										<li>
											<span class="psx-constraint-enumeration-value">bar</span>
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
						<span class="psx-property-type psx-property-type-time">
							<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Time</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">profileUri</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-uri">
							<a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="psx-type-72828040aecd82459c3636a4226e81fc" class="psx-complex-type">
		<h1>config</h1>
		<table class="table psx-type-properties">
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="40%" />
				<col width="20%" />
			</colgroup>
			<thead>
				<tr>
					<th>Property</th>
					<th>Type</th>
					<th>Description</th>
					<th>Constraints</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">*</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description">Additional properties must be of this type</span>
					</td>
					<td/>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="psx-type-4770be5abc2aedca274241c166226fc7" class="psx-complex-type">
		<h1>author</h1>
		<div class="psx-type-description">An simple author element with some description</div>
		<table class="table psx-type-properties">
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="40%" />
				<col width="20%" />
			</colgroup>
			<thead>
				<tr>
					<th>Property</th>
					<th>Type</th>
					<th>Description</th>
					<th>Constraints</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span class="psx-property-name psx-property-required">title</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
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
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description">We will send no spam to this addresss</span>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">categories</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-array">Array&lt;<span class="psx-property-type psx-property-type-string">String</span>&gt;</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td>
						<dl class="psx-property-constraint">
							<dt>Maximum</dt>
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
						<span class="psx-property-type psx-property-type-array">Array&lt;<span class="psx-property-type psx-property-type-complex">
								<a href="#psx-type-b33b896fd4135c2882510d8949e883cf">location</a>
							</span>&gt;</span>
					</td>
					<td>
						<span class="psx-property-description">Array of locations</span>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">origin</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-complex">
							<a href="#psx-type-b33b896fd4135c2882510d8949e883cf">location</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="psx-type-b33b896fd4135c2882510d8949e883cf" class="psx-complex-type">
		<h1>location</h1>
		<div class="psx-type-description">Location of the person</div>
		<table class="table psx-type-properties">
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="40%" />
				<col width="20%" />
			</colgroup>
			<thead>
				<tr>
					<th>Property</th>
					<th>Type</th>
					<th>Description</th>
					<th>Constraints</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">lat</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-float">Float</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">long</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-float">Float</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td colspan="4">
						<span class="psx-property-description">Additional properties are allowed</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="psx-type-57c64cac92e27c1db99e6a6793546e12" class="psx-complex-type">
		<h1>web</h1>
		<div class="psx-type-description">An application</div>
		<table class="table psx-type-properties">
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="40%" />
				<col width="20%" />
			</colgroup>
			<thead>
				<tr>
					<th>Property</th>
					<th>Type</th>
					<th>Description</th>
					<th>Constraints</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">name</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">url</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">*</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description">Additional properties must be of this type</span>
					</td>
					<td/>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="psx-type-68a5de1071c84dc3c357e50c05e674fa" class="psx-complex-type">
		<h1>meta</h1>
		<div class="psx-type-description">Some meta data</div>
		<table class="table psx-type-properties">
			<colgroup>
				<col width="20%" />
				<col width="20%" />
				<col width="40%" />
				<col width="20%" />
			</colgroup>
			<thead>
				<tr>
					<th>Property</th>
					<th>Type</th>
					<th>Description</th>
					<th>Constraints</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">createDate</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-datetime">
							<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">^tags_\d$</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-string">String</span>
					</td>
					<td>
						<span class="psx-property-description"/>
					</td>
					<td/>
				</tr>
				<tr>
					<td>
						<span class="psx-property-name psx-property-optional">^location_\d$</span>
					</td>
					<td>
						<span class="psx-property-type psx-property-type-complex">
							<a href="#psx-type-b33b896fd4135c2882510d8949e883cf">location</a>
						</span>
					</td>
					<td>
						<span class="psx-property-description">Location of the person</span>
					</td>
					<td/>
				</tr>
			</tbody>
		</table>
	</div>
</div>
HTML;

        $this->assertXmlStringEqualsXmlString($expect, '<div>' . $result . '</div>', $result);
    }
}
