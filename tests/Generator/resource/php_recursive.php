<?php

namespace PSX\Generation;

/**
 * @AdditionalProperties(@Schema(anyOf={@Ref("PSX\Generation\Json_schema"), @Schema(type="array", title="stringArray", items=@Schema(type="string"), minItems=1, uniqueItems=true)}))
 */
class ObjectId extends \ArrayObject
{
}
/**
 * @AdditionalProperties(@Ref("PSX\Generation\Json_schema"))
 */
class ObjectId extends \ArrayObject
{
}
/**
 * @Title("json schema")
 * @Description("Core schema meta-schema")
 */
class Json_schema
{
    /**
     * @Key("id")
     * @Type("string")
     * @Format("uri")
     */
    protected $id;
    /**
     * @Key("$schema")
     * @Type("string")
     * @Format("uri")
     */
    protected $_schema;
    /**
     * @Key("title")
     * @Type("string")
     */
    protected $title;
    /**
     * @Key("description")
     * @Type("string")
     */
    protected $description;
    /**
     * @Key("default")
     */
    protected $default;
    /**
     * @Key("multipleOf")
     * @Type("number")
     * @Minimum(0)
     * @ExclusiveMinimum(true)
     */
    protected $multipleOf;
    /**
     * @Key("maximum")
     * @Type("number")
     */
    protected $maximum;
    /**
     * @Key("exclusiveMaximum")
     * @Type("boolean")
     */
    protected $exclusiveMaximum;
    /**
     * @Key("minimum")
     * @Type("number")
     */
    protected $minimum;
    /**
     * @Key("exclusiveMinimum")
     * @Type("boolean")
     */
    protected $exclusiveMinimum;
    /**
     * @Key("maxLength")
     * @Title("positiveInteger")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxLength;
    /**
     * @Key("minLength")
     * @Title("positiveIntegerDefault0")
     * @AllOf(@Schema(type="integer", title="positiveInteger", minimum=0), @Schema())
     */
    protected $minLength;
    /**
     * @Key("pattern")
     * @Type("string")
     * @Format("regex")
     */
    protected $pattern;
    /**
     * @Key("additionalItems")
     * @AnyOf(@Schema(type="boolean"), @Ref("PSX\Generation\Json_schema"))
     */
    protected $additionalItems;
    /**
     * @Key("items")
     * @AnyOf(@Ref("PSX\Generation\Json_schema"), @Schema(type="array", title="schemaArray", items=@Ref("PSX\Generation\Json_schema"), minItems=1))
     */
    protected $items;
    /**
     * @Key("maxItems")
     * @Title("positiveInteger")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxItems;
    /**
     * @Key("minItems")
     * @Title("positiveIntegerDefault0")
     * @AllOf(@Schema(type="integer", title="positiveInteger", minimum=0), @Schema())
     */
    protected $minItems;
    /**
     * @Key("uniqueItems")
     * @Type("boolean")
     */
    protected $uniqueItems;
    /**
     * @Key("maxProperties")
     * @Title("positiveInteger")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxProperties;
    /**
     * @Key("minProperties")
     * @Title("positiveIntegerDefault0")
     * @AllOf(@Schema(type="integer", title="positiveInteger", minimum=0), @Schema())
     */
    protected $minProperties;
    /**
     * @Key("required")
     * @Title("stringArray")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @UniqueItems(true)
     * @MinItems(1)
     */
    protected $required;
    /**
     * @Key("additionalProperties")
     * @AnyOf(@Schema(type="boolean"), @Ref("PSX\Generation\Json_schema"))
     */
    protected $additionalProperties;
    /**
     * @Key("definitions")
     * @Ref("PSX\Generation\ObjectId")
     */
    protected $definitions;
    /**
     * @Key("properties")
     * @Ref("PSX\Generation\ObjectId")
     */
    protected $properties;
    /**
     * @Key("patternProperties")
     * @Ref("PSX\Generation\ObjectId")
     */
    protected $patternProperties;
    /**
     * @Key("dependencies")
     * @Ref("PSX\Generation\ObjectId")
     */
    protected $dependencies;
    /**
     * @Key("enum")
     * @Type("array")
     * @UniqueItems(true)
     * @MinItems(1)
     */
    protected $enum;
    /**
     * @Key("type")
     * @AnyOf(@Schema(enum={"array", "boolean", "integer", "null", "number", "object", "string"}, title="simpleTypes"), @Schema(type="array", items=@Schema(enum={"array", "boolean", "integer", "null", "number", "object", "string"}, title="simpleTypes"), minItems=1, uniqueItems=true))
     */
    protected $type;
    /**
     * @Key("allOf")
     * @Title("schemaArray")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    protected $allOf;
    /**
     * @Key("anyOf")
     * @Title("schemaArray")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    protected $anyOf;
    /**
     * @Key("oneOf")
     * @Title("schemaArray")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    protected $oneOf;
    /**
     * @Key("not")
     * @Ref("PSX\Generation\Json_schema")
     */
    protected $not;
    /**
     * @param string $id
     */
    public function setId(?string $id)
    {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getId() : ?string
    {
        return $this->id;
    }
    /**
     * @param string $_schema
     */
    public function set_schema(?string $_schema)
    {
        $this->_schema = $_schema;
    }
    /**
     * @return string
     */
    public function get_schema() : ?string
    {
        return $this->_schema;
    }
    /**
     * @param string $title
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }
    /**
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    /**
     * @param string $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }
    /**
     * @return string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
    /**
     * @param  $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }
    /**
     * @return 
     */
    public function getDefault()
    {
        return $this->default;
    }
    /**
     * @param float $multipleOf
     */
    public function setMultipleOf(?float $multipleOf)
    {
        $this->multipleOf = $multipleOf;
    }
    /**
     * @return float
     */
    public function getMultipleOf() : ?float
    {
        return $this->multipleOf;
    }
    /**
     * @param float $maximum
     */
    public function setMaximum(?float $maximum)
    {
        $this->maximum = $maximum;
    }
    /**
     * @return float
     */
    public function getMaximum() : ?float
    {
        return $this->maximum;
    }
    /**
     * @param bool $exclusiveMaximum
     */
    public function setExclusiveMaximum(?bool $exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
    /**
     * @return bool
     */
    public function getExclusiveMaximum() : ?bool
    {
        return $this->exclusiveMaximum;
    }
    /**
     * @param float $minimum
     */
    public function setMinimum(?float $minimum)
    {
        $this->minimum = $minimum;
    }
    /**
     * @return float
     */
    public function getMinimum() : ?float
    {
        return $this->minimum;
    }
    /**
     * @param bool $exclusiveMinimum
     */
    public function setExclusiveMinimum(?bool $exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
    /**
     * @return bool
     */
    public function getExclusiveMinimum() : ?bool
    {
        return $this->exclusiveMinimum;
    }
    /**
     * @param int $maxLength
     */
    public function setMaxLength(?int $maxLength)
    {
        $this->maxLength = $maxLength;
    }
    /**
     * @return int
     */
    public function getMaxLength() : ?int
    {
        return $this->maxLength;
    }
    /**
     * @param int& $minLength
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
    }
    /**
     * @return int&
     */
    public function getMinLength()
    {
        return $this->minLength;
    }
    /**
     * @param string $pattern
     */
    public function setPattern(?string $pattern)
    {
        $this->pattern = $pattern;
    }
    /**
     * @return string
     */
    public function getPattern() : ?string
    {
        return $this->pattern;
    }
    /**
     * @param  $additionalItems
     */
    public function setAdditionalItems($additionalItems)
    {
        $this->additionalItems = $additionalItems;
    }
    /**
     * @return 
     */
    public function getAdditionalItems()
    {
        return $this->additionalItems;
    }
    /**
     * @param  $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
    /**
     * @return 
     */
    public function getItems()
    {
        return $this->items;
    }
    /**
     * @param int $maxItems
     */
    public function setMaxItems(?int $maxItems)
    {
        $this->maxItems = $maxItems;
    }
    /**
     * @return int
     */
    public function getMaxItems() : ?int
    {
        return $this->maxItems;
    }
    /**
     * @param int& $minItems
     */
    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;
    }
    /**
     * @return int&
     */
    public function getMinItems()
    {
        return $this->minItems;
    }
    /**
     * @param bool $uniqueItems
     */
    public function setUniqueItems(?bool $uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;
    }
    /**
     * @return bool
     */
    public function getUniqueItems() : ?bool
    {
        return $this->uniqueItems;
    }
    /**
     * @param int $maxProperties
     */
    public function setMaxProperties(?int $maxProperties)
    {
        $this->maxProperties = $maxProperties;
    }
    /**
     * @return int
     */
    public function getMaxProperties() : ?int
    {
        return $this->maxProperties;
    }
    /**
     * @param int& $minProperties
     */
    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;
    }
    /**
     * @return int&
     */
    public function getMinProperties()
    {
        return $this->minProperties;
    }
    /**
     * @param array<string> $required
     */
    public function setRequired(?array $required)
    {
        $this->required = $required;
    }
    /**
     * @return array<string>
     */
    public function getRequired() : ?array
    {
        return $this->required;
    }
    /**
     * @param  $additionalProperties
     */
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = $additionalProperties;
    }
    /**
     * @return 
     */
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }
    /**
     * @param ObjectId $definitions
     */
    public function setDefinitions(?ObjectId $definitions)
    {
        $this->definitions = $definitions;
    }
    /**
     * @return ObjectId
     */
    public function getDefinitions() : ?ObjectId
    {
        return $this->definitions;
    }
    /**
     * @param ObjectId $properties
     */
    public function setProperties(?ObjectId $properties)
    {
        $this->properties = $properties;
    }
    /**
     * @return ObjectId
     */
    public function getProperties() : ?ObjectId
    {
        return $this->properties;
    }
    /**
     * @param ObjectId $patternProperties
     */
    public function setPatternProperties(?ObjectId $patternProperties)
    {
        $this->patternProperties = $patternProperties;
    }
    /**
     * @return ObjectId
     */
    public function getPatternProperties() : ?ObjectId
    {
        return $this->patternProperties;
    }
    /**
     * @param ObjectId $dependencies
     */
    public function setDependencies(?ObjectId $dependencies)
    {
        $this->dependencies = $dependencies;
    }
    /**
     * @return ObjectId
     */
    public function getDependencies() : ?ObjectId
    {
        return $this->dependencies;
    }
    /**
     * @param array $enum
     */
    public function setEnum(?array $enum)
    {
        $this->enum = $enum;
    }
    /**
     * @return array
     */
    public function getEnum() : ?array
    {
        return $this->enum;
    }
    /**
     * @param  $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @return 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param array<Json_schema> $allOf
     */
    public function setAllOf(?array $allOf)
    {
        $this->allOf = $allOf;
    }
    /**
     * @return array<Json_schema>
     */
    public function getAllOf() : ?array
    {
        return $this->allOf;
    }
    /**
     * @param array<Json_schema> $anyOf
     */
    public function setAnyOf(?array $anyOf)
    {
        $this->anyOf = $anyOf;
    }
    /**
     * @return array<Json_schema>
     */
    public function getAnyOf() : ?array
    {
        return $this->anyOf;
    }
    /**
     * @param array<Json_schema> $oneOf
     */
    public function setOneOf(?array $oneOf)
    {
        $this->oneOf = $oneOf;
    }
    /**
     * @return array<Json_schema>
     */
    public function getOneOf() : ?array
    {
        return $this->oneOf;
    }
    /**
     * @param Json_schema $not
     */
    public function setNot(?Json_schema $not)
    {
        $this->not = $not;
    }
    /**
     * @return Json_schema
     */
    public function getNot() : ?Json_schema
    {
        return $this->not;
    }
}