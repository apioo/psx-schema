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

use PSX\Schema\Generator\Xsd;

/**
 * XsdTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class XsdTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Xsd('http://ns.foo.com');
        $result    = $generator->generate($this->getSchema());

        $expect = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:tns="http://ns.foo.com" targetNamespace="http://ns.foo.com" elementFormDefault="qualified">
	<xs:element name="news">
		<xs:complexType>
			<xs:annotation>
				<xs:documentation>An general news entry</xs:documentation>
			</xs:annotation>
			<xs:sequence>
				<xs:element name="config" type="tns:type5525537f7f38b6988025ca659a7b315d" minOccurs="0" maxOccurs="1"/>
				<xs:element name="tags" type="xs:string" minOccurs="1" maxOccurs="6"/>
				<xs:element name="receiver" type="tns:type3b735bb119d1f8f279637029c0d482e1" minOccurs="1" maxOccurs="unbounded"/>
				<xs:element name="resources" type="tns:type0ae50ca2769f912fdb609180fef2ab22" minOccurs="0" maxOccurs="unbounded"/>
				<xs:element name="profileImage" type="xs:base64Binary" minOccurs="0" maxOccurs="1"/>
				<xs:element name="read" type="xs:boolean" minOccurs="0" maxOccurs="1"/>
				<xs:element name="source" type="tns:type4041e76cd4c2d30153165760e80c506e" minOccurs="0" maxOccurs="1"/>
				<xs:element name="author" type="tns:type3b735bb119d1f8f279637029c0d482e1" minOccurs="0" maxOccurs="1"/>
				<xs:element name="meta" type="tns:typea80788599984d8da6729b8be82b7a016" minOccurs="0" maxOccurs="1"/>
				<xs:element name="sendDate" type="xs:date" minOccurs="0" maxOccurs="1"/>
				<xs:element name="readDate" type="xs:dateTime" minOccurs="0" maxOccurs="1"/>
				<xs:element name="expires" type="xs:duration" minOccurs="0" maxOccurs="1"/>
				<xs:element name="price" type="tns:type8e2ea4e7237b6ad8fb37bc0f27114743" minOccurs="1" maxOccurs="1"/>
				<xs:element name="rating" type="tns:typeb65cb4112b8ba274a5567e89d782f452" minOccurs="0" maxOccurs="1"/>
				<xs:element name="content" type="tns:type9c50571703dc940dbc1a7e4e4f27ffe8" minOccurs="1" maxOccurs="1"/>
				<xs:element name="question" type="tns:type4796f0df34ef8cf6e2ca96eac9ceb254" minOccurs="0" maxOccurs="1"/>
				<xs:element name="coffeeTime" type="xs:time" minOccurs="0" maxOccurs="1"/>
				<xs:element name="profileUri" type="xs:anyURI" minOccurs="0" maxOccurs="1"/>
			</xs:sequence>
		</xs:complexType>
	</xs:element>
	<xs:complexType name="type5525537f7f38b6988025ca659a7b315d">
		<xs:sequence>
			<xs:any processContents="lax" minOccurs="0" maxOccurs="unbounded"/>
		</xs:sequence>
	</xs:complexType>
	<xs:complexType name="type3b735bb119d1f8f279637029c0d482e1">
		<xs:annotation>
			<xs:documentation>An simple author element with some description</xs:documentation>
		</xs:annotation>
		<xs:sequence>
			<xs:element name="title" type="tns:type40ae9277cd05f7534cbcb3ed9d9d70b9" minOccurs="1" maxOccurs="1"/>
			<xs:element name="email" type="xs:string" minOccurs="0" maxOccurs="1"/>
			<xs:element name="categories" type="xs:string" minOccurs="0" maxOccurs="8"/>
			<xs:element name="locations" type="tns:type73afba2a3732aa422e2dede6fd26d0cb" minOccurs="0" maxOccurs="unbounded"/>
			<xs:element name="origin" type="tns:type73afba2a3732aa422e2dede6fd26d0cb" minOccurs="0" maxOccurs="1"/>
		</xs:sequence>
	</xs:complexType>
	<xs:simpleType name="type40ae9277cd05f7534cbcb3ed9d9d70b9">
		<xs:restriction base="xs:string">
			<xs:pattern value="[A-z]{3,16}"/>
		</xs:restriction>
	</xs:simpleType>
	<xs:complexType name="type73afba2a3732aa422e2dede6fd26d0cb">
		<xs:annotation>
			<xs:documentation>Location of the person</xs:documentation>
		</xs:annotation>
		<xs:sequence>
			<xs:element name="lat" type="xs:float" minOccurs="0" maxOccurs="1"/>
			<xs:element name="long" type="xs:float" minOccurs="0" maxOccurs="1"/>
			<xs:any processContents="lax" minOccurs="0" maxOccurs="unbounded"/>
		</xs:sequence>
	</xs:complexType>
	<xs:complexType name="type0ae50ca2769f912fdb609180fef2ab22">
		<xs:choice>
			<xs:element name="location" type="tns:type73afba2a3732aa422e2dede6fd26d0cb" minOccurs="0" maxOccurs="1"/>
			<xs:element name="web" type="tns:type55c1692462753300d5eecf90dc979d09" minOccurs="0" maxOccurs="1"/>
		</xs:choice>
	</xs:complexType>
	<xs:complexType name="type55c1692462753300d5eecf90dc979d09">
		<xs:annotation>
			<xs:documentation>An application</xs:documentation>
		</xs:annotation>
		<xs:sequence>
			<xs:element name="name" type="xs:string" minOccurs="0" maxOccurs="1"/>
			<xs:element name="url" type="xs:string" minOccurs="0" maxOccurs="1"/>
			<xs:any processContents="lax" minOccurs="2" maxOccurs="8"/>
		</xs:sequence>
	</xs:complexType>
	<xs:complexType name="type4041e76cd4c2d30153165760e80c506e">
		<xs:choice>
			<xs:element name="author" type="tns:type3b735bb119d1f8f279637029c0d482e1" minOccurs="0" maxOccurs="1"/>
			<xs:element name="web" type="tns:type55c1692462753300d5eecf90dc979d09" minOccurs="0" maxOccurs="1"/>
		</xs:choice>
	</xs:complexType>
	<xs:complexType name="typea80788599984d8da6729b8be82b7a016">
		<xs:annotation>
			<xs:documentation>Some meta data</xs:documentation>
		</xs:annotation>
		<xs:sequence>
			<xs:element name="createDate" type="xs:dateTime" minOccurs="0" maxOccurs="1"/>
			<xs:any processContents="lax" minOccurs="0" maxOccurs="unbounded"/>
		</xs:sequence>
	</xs:complexType>
	<xs:simpleType name="type8e2ea4e7237b6ad8fb37bc0f27114743">
		<xs:restriction base="xs:float">
			<xs:maxInclusive value="100"/>
			<xs:minInclusive value="1"/>
		</xs:restriction>
	</xs:simpleType>
	<xs:simpleType name="typeb65cb4112b8ba274a5567e89d782f452">
		<xs:restriction base="xs:integer">
			<xs:maxInclusive value="5"/>
			<xs:minInclusive value="1"/>
		</xs:restriction>
	</xs:simpleType>
	<xs:simpleType name="type9c50571703dc940dbc1a7e4e4f27ffe8">
		<xs:annotation>
			<xs:documentation>Contains the main content of the news entry</xs:documentation>
		</xs:annotation>
		<xs:restriction base="xs:string">
			<xs:minLength value="3"/>
			<xs:maxLength value="512"/>
		</xs:restriction>
	</xs:simpleType>
	<xs:simpleType name="type4796f0df34ef8cf6e2ca96eac9ceb254">
		<xs:restriction base="xs:string">
			<xs:enumeration value="foo"/>
			<xs:enumeration value="bar"/>
		</xs:restriction>
	</xs:simpleType>
</xs:schema>
XML;

        $this->assertXmlStringEqualsXmlString($expect, $result, $result);
    }

    /**
     * Check whether the generated xsd is valid and we can use it agains some
     * custom xml
     */
    public function testXsd()
    {
        $generator = new Xsd('http://ns.foo.com');
        $result    = $generator->generate($this->getSchema());

        $xml = <<<XML
<news xmlns="http://ns.foo.com">
	<config>
		<tags_1>foo</tags_1>
		<tags_2>bar</tags_2>
		<location_1>
			<lat>13</lat>
			<long>-37</long>
		</location_1>
	</config>
	<tags>foo</tags>
	<tags>bar</tags>
	<receiver>
		<title>bar</title>
	</receiver>
	<resources>
		<web>
			<name>foo</name>
			<url>http://google.com</url>
		</web>
	</resources>
	<resources>
		<location>
			<lat>13</lat>
			<long>-37</long>
		</location>
	</resources>
	<read>1</read>
	<source>
		<web>
			<name>foo</name>
			<url>http://google.com</url>
		</web>
	</source>
	<author>
		<title>test</title>
		<categories>foo</categories>
		<categories>bar</categories>
		<locations>
			<lat>13</lat>
			<long>-37</long>
		</locations>
	</author>
	<sendDate>2014-07-22</sendDate>
	<readDate>2014-07-22T22:47:00</readDate>
	<expires>P1M</expires>
	<price>13.37</price>
	<rating>4</rating>
	<content>foobar</content>
	<coffeeTime>16:00:00</coffeeTime>
</news>
XML;

        $dom = new \DOMDocument();
        $dom->loadXML($xml);

        $this->assertTrue($dom->schemaValidateSource($result));
    }

    /**
     * Test whether the generated XSD follows the schema XSD
     */
    public function testXsdSchema()
    {
        $generator = new Xsd('http://ns.foo.com');
        $result    = $generator->generate($this->getSchema());

        $dom = new \DOMDocument();
        $dom->loadXML($result);

        $this->assertTrue($dom->schemaValidate(__DIR__ . '/schema.xsd'));
    }
}
