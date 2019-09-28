<?php

namespace PSX\Generation;

/**
 * @AdditionalProperties(@Schema(anyOf={@Ref("PSX\Generation\Json_schema"), @Schema(type="array", items=@Schema(type="string"), minItems=1, uniqueItems=true)}))
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
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxLength;
    /**
     * @Key("minLength")
     * @AllOf(@Schema(type="integer", minimum=0), @Schema())
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
     * @AnyOf(@Ref("PSX\Generation\Json_schema"), @Schema(type="array", items=@Ref("PSX\Generation\Json_schema"), minItems=1))
     */
    protected $items;
    /**
     * @Key("maxItems")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxItems;
    /**
     * @Key("minItems")
     * @AllOf(@Schema(type="integer", minimum=0), @Schema())
     */
    protected $minItems;
    /**
     * @Key("uniqueItems")
     * @Type("boolean")
     */
    protected $uniqueItems;
    /**
     * @Key("maxProperties")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxProperties;
    /**
     * @Key("minProperties")
     * @AllOf(@Schema(type="integer", minimum=0), @Schema())
     */
    protected $minProperties;
    /**
     * @Key("required")
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
     * @AnyOf(@Schema(enum={"array", "boolean", "integer", "null", "number", "object", "string"}), @Schema(type="array", items=@Schema(enum={"array", "boolean", "integer", "null", "number", "object", "string"}), minItems=1, uniqueItems=true))
     */
    protected $type;
    /**
     * @Key("allOf")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    protected $allOf;
    /**
     * @Key("anyOf")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    protected $anyOf;
    /**
     * @Key("oneOf")
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
    public function setId(?string $id)
    {
        $this->id = $id;
    }
    public function getId() : ?string
    {
        return $this->id;
    }
    public function set_schema(?string $_schema)
    {
        $this->_schema = $_schema;
    }
    public function get_schema() : ?string
    {
        return $this->_schema;
    }
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }
    public function getTitle() : ?string
    {
        return $this->title;
    }
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setDefault($default)
    {
        $this->default = $default;
    }
    public function getDefault()
    {
        return $this->default;
    }
    public function setMultipleOf(?float $multipleOf)
    {
        $this->multipleOf = $multipleOf;
    }
    public function getMultipleOf() : ?float
    {
        return $this->multipleOf;
    }
    public function setMaximum(?float $maximum)
    {
        $this->maximum = $maximum;
    }
    public function getMaximum() : ?float
    {
        return $this->maximum;
    }
    public function setExclusiveMaximum(?bool $exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
    public function getExclusiveMaximum() : ?bool
    {
        return $this->exclusiveMaximum;
    }
    public function setMinimum(?float $minimum)
    {
        $this->minimum = $minimum;
    }
    public function getMinimum() : ?float
    {
        return $this->minimum;
    }
    public function setExclusiveMinimum(?bool $exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
    public function getExclusiveMinimum() : ?bool
    {
        return $this->exclusiveMinimum;
    }
    public function setMaxLength(?int $maxLength)
    {
        $this->maxLength = $maxLength;
    }
    public function getMaxLength() : ?int
    {
        return $this->maxLength;
    }
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
    }
    public function getMinLength()
    {
        return $this->minLength;
    }
    public function setPattern(?string $pattern)
    {
        $this->pattern = $pattern;
    }
    public function getPattern() : ?string
    {
        return $this->pattern;
    }
    public function setAdditionalItems($additionalItems)
    {
        $this->additionalItems = $additionalItems;
    }
    public function getAdditionalItems()
    {
        return $this->additionalItems;
    }
    public function setItems($items)
    {
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setMaxItems(?int $maxItems)
    {
        $this->maxItems = $maxItems;
    }
    public function getMaxItems() : ?int
    {
        return $this->maxItems;
    }
    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;
    }
    public function getMinItems()
    {
        return $this->minItems;
    }
    public function setUniqueItems(?bool $uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;
    }
    public function getUniqueItems() : ?bool
    {
        return $this->uniqueItems;
    }
    public function setMaxProperties(?int $maxProperties)
    {
        $this->maxProperties = $maxProperties;
    }
    public function getMaxProperties() : ?int
    {
        return $this->maxProperties;
    }
    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;
    }
    public function getMinProperties()
    {
        return $this->minProperties;
    }
    public function setRequired(?array $required)
    {
        $this->required = $required;
    }
    public function getRequired() : ?array
    {
        return $this->required;
    }
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = $additionalProperties;
    }
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }
    public function setDefinitions(?ObjectId $definitions)
    {
        $this->definitions = $definitions;
    }
    public function getDefinitions() : ?ObjectId
    {
        return $this->definitions;
    }
    public function setProperties(?ObjectId $properties)
    {
        $this->properties = $properties;
    }
    public function getProperties() : ?ObjectId
    {
        return $this->properties;
    }
    public function setPatternProperties(?ObjectId $patternProperties)
    {
        $this->patternProperties = $patternProperties;
    }
    public function getPatternProperties() : ?ObjectId
    {
        return $this->patternProperties;
    }
    public function setDependencies(?ObjectId $dependencies)
    {
        $this->dependencies = $dependencies;
    }
    public function getDependencies() : ?ObjectId
    {
        return $this->dependencies;
    }
    public function setEnum(?array $enum)
    {
        $this->enum = $enum;
    }
    public function getEnum() : ?array
    {
        return $this->enum;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setAllOf(?array $allOf)
    {
        $this->allOf = $allOf;
    }
    public function getAllOf() : ?array
    {
        return $this->allOf;
    }
    public function setAnyOf(?array $anyOf)
    {
        $this->anyOf = $anyOf;
    }
    public function getAnyOf() : ?array
    {
        return $this->anyOf;
    }
    public function setOneOf(?array $oneOf)
    {
        $this->oneOf = $oneOf;
    }
    public function getOneOf() : ?array
    {
        return $this->oneOf;
    }
    public function setNot(?Json_schema $not)
    {
        $this->not = $not;
    }
    public function getNot() : ?Json_schema
    {
        return $this->not;
    }
}
