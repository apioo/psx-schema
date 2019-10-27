/**
 * @Title("TypeSchema")
 * @Description("TypeSchema meta schema which describes a TypeSchema")
 * @Required({"title", "type", "properties"})
 */
class TypeSchema
{
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
     * @Key("type")
     * @Enum({"object"})
     * @Type("string")
     */
    protected $type;
    /**
     * @Key("definitions")
     * @Ref("\Definitions")
     */
    protected $definitions;
    /**
     * @Key("properties")
     * @Ref("\Properties")
     */
    protected $properties;
    /**
     * @Key("required")
     * @Title("stringArray")
     * @Description("Array string values")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @MinItems(1)
     */
    protected $required;
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
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param Definitions $definitions
     */
    public function setDefinitions(?Definitions $definitions)
    {
        $this->definitions = $definitions;
    }
    /**
     * @return Definitions
     */
    public function getDefinitions() : ?Definitions
    {
        return $this->definitions;
    }
    /**
     * @param Properties $properties
     */
    public function setProperties(?Properties $properties)
    {
        $this->properties = $properties;
    }
    /**
     * @return Properties
     */
    public function getProperties() : ?Properties
    {
        return $this->properties;
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
}
/**
 * @Title("definitions")
 * @Description("Schema definitions which can be reused")
 * @AdditionalProperties(@Schema(title="definitionValue", description="Represents a concrete type definition", oneOf={@Schema(title="objectType", description="An object represents either a struct or map type", oneOf={@Schema(title="structType", description="A struct contains a fix set of defined properties", allOf={@Ref("\CommonProperties"), @Ref("\ContainerProperties"), @Ref("\StructProperties")}), @Schema(title="mapType", description="A map contains variable key value entries of a specific type", allOf={@Ref("\CommonProperties"), @Ref("\ContainerProperties"), @Ref("\MapProperties")})}), @Schema(title="arrayType", description="An array contains an ordered list of variable values", allOf={@Ref("\CommonProperties"), @Ref("\ArrayProperties")}), @Schema(title="booleanType", description="Represents a boolean value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\BooleanProperties")}), @Schema(title="numberType", description="Represents a number value (contains also integer)", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\NumberProperties")}), @Schema(title="stringType", description="Represents a string value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\StringProperties")}), @Schema(title="combinationType", description="A combination type is either a intersection or union type", oneOf={@Ref("\AllOfProperties"), @Ref("\OneOfProperties")})}))
 */
class Definitions extends \ArrayObject
{
}
/**
 * @Title("commonProperties")
 * @Description("Common properties which can be used at any schema")
 */
class CommonProperties
{
    /**
     * @Key("title")
     * @Description("Distinct word which represents this schema")
     * @Type("string")
     */
    protected $title;
    /**
     * @Key("description")
     * @Description("General description of this schema, should not contain any new lines.")
     * @Type("string")
     */
    protected $description;
    /**
     * @Key("type")
     * @Description("JSON type of the property")
     * @Enum({"object", "array", "boolean", "integer", "number", "string"})
     * @Type("string")
     */
    protected $type;
    /**
     * @Key("nullable")
     * @Description("Indicates whether it is possible to use a null value")
     * @Type("boolean")
     */
    protected $nullable;
    /**
     * @Key("deprecated")
     * @Description("Indicates whether this schema is deprecated")
     * @Type("boolean")
     */
    protected $deprecated;
    /**
     * @Key("readonly")
     * @Description("Indicates whether this schema is readonly")
     * @Type("boolean")
     */
    protected $readonly;
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
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param bool $nullable
     */
    public function setNullable(?bool $nullable)
    {
        $this->nullable = $nullable;
    }
    /**
     * @return bool
     */
    public function getNullable() : ?bool
    {
        return $this->nullable;
    }
    /**
     * @param bool $deprecated
     */
    public function setDeprecated(?bool $deprecated)
    {
        $this->deprecated = $deprecated;
    }
    /**
     * @return bool
     */
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
    }
    /**
     * @param bool $readonly
     */
    public function setReadonly(?bool $readonly)
    {
        $this->readonly = $readonly;
    }
    /**
     * @return bool
     */
    public function getReadonly() : ?bool
    {
        return $this->readonly;
    }
}
/**
 * @Title("containerProperties")
 * @Description("Properties specific for a container")
 * @Required({"type"})
 */
class ContainerProperties
{
    /**
     * @Key("type")
     * @Enum({"object"})
     * @Type("string")
     */
    protected $type;
    /**
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
    }
}
/**
 * @Title("structProperties")
 * @Description("Struct specific properties")
 * @Required({"properties"})
 */
class StructProperties
{
    /**
     * @Key("properties")
     * @Ref("\Properties")
     */
    protected $properties;
    /**
     * @Key("required")
     * @Title("stringArray")
     * @Description("Array string values")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @MinItems(1)
     */
    protected $required;
    /**
     * @param Properties $properties
     */
    public function setProperties(?Properties $properties)
    {
        $this->properties = $properties;
    }
    /**
     * @return Properties
     */
    public function getProperties() : ?Properties
    {
        return $this->properties;
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
}
/**
 * @Title("mapProperties")
 * @Description("Map specific properties")
 * @Required({"additionalProperties"})
 */
class MapProperties
{
    /**
     * @Key("additionalProperties")
     * @Title("propertyValue")
     * @Description("Allowed values of an object property")
     * @OneOf(@Schema(title="booleanType", description="Represents a boolean value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\BooleanProperties")}), @Schema(title="numberType", description="Represents a number value (contains also integer)", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\NumberProperties")}), @Schema(title="stringType", description="Represents a string value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\StringProperties")}), @Schema(title="arrayType", description="An array contains an ordered list of variable values", allOf={@Ref("\CommonProperties"), @Ref("\ArrayProperties")}), @Schema(title="combinationType", description="A combination type is either a intersection or union type", oneOf={@Ref("\AllOfProperties"), @Ref("\OneOfProperties")}), @Ref("\ReferenceType"))
     */
    protected $additionalProperties;
    /**
     * @Key("maxProperties")
     * @Title("positiveInteger")
     * @Description("Positive integer value")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxProperties;
    /**
     * @Key("minProperties")
     * @Title("positiveInteger")
     * @Description("Positive integer value")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $minProperties;
    /**
     * @param CommonProperties&ScalarProperties&BooleanProperties|CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|CommonProperties&ArrayProperties|AllOfProperties|OneOfProperties|ReferenceType $additionalProperties
     */
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = $additionalProperties;
    }
    /**
     * @return CommonProperties&ScalarProperties&BooleanProperties|CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|CommonProperties&ArrayProperties|AllOfProperties|OneOfProperties|ReferenceType
     */
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
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
     * @param int $minProperties
     */
    public function setMinProperties(?int $minProperties)
    {
        $this->minProperties = $minProperties;
    }
    /**
     * @return int
     */
    public function getMinProperties() : ?int
    {
        return $this->minProperties;
    }
}
/**
 * @Title("arrayProperties")
 * @Description("Array properties")
 * @Required({"type", "items"})
 */
class ArrayProperties
{
    /**
     * @Key("type")
     * @Enum({"array"})
     * @Type("string")
     */
    protected $type;
    /**
     * @Key("items")
     * @Title("arrayValue")
     * @Description("Allowed values of an array item")
     * @OneOf(@Schema(title="booleanType", description="Represents a boolean value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\BooleanProperties")}), @Schema(title="numberType", description="Represents a number value (contains also integer)", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\NumberProperties")}), @Schema(title="stringType", description="Represents a string value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\StringProperties")}), @Schema(title="combinationType", description="A combination type is either a intersection or union type", oneOf={@Ref("\AllOfProperties"), @Ref("\OneOfProperties")}), @Ref("\ReferenceType"))
     */
    protected $items;
    /**
     * @Key("maxItems")
     * @Title("positiveInteger")
     * @Description("Positive integer value")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxItems;
    /**
     * @Key("minItems")
     * @Title("positiveInteger")
     * @Description("Positive integer value")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $minItems;
    /**
     * @Key("uniqueItems")
     * @Type("boolean")
     */
    protected $uniqueItems;
    /**
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param CommonProperties&ScalarProperties&BooleanProperties|CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|AllOfProperties|OneOfProperties|ReferenceType $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
    /**
     * @return CommonProperties&ScalarProperties&BooleanProperties|CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|AllOfProperties|OneOfProperties|ReferenceType
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
     * @param int $minItems
     */
    public function setMinItems(?int $minItems)
    {
        $this->minItems = $minItems;
    }
    /**
     * @return int
     */
    public function getMinItems() : ?int
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
}
/**
 * @Title("scalarProperties")
 */
class ScalarProperties
{
    /**
     * @Key("format")
     * @Description("Describes the specific format of this type i.e. date-time or int64")
     * @Type("string")
     */
    protected $format;
    /**
     * @Key("enum")
     * @Title("enumValue")
     * @Description("A list of possible enumeration values")
     * @OneOf(@Schema(type="array", title="stringArray", description="Array string values", items=@Schema(type="string"), minItems=1), @Schema(type="array", title="numberArray", description="Array number values", items=@Schema(type="number"), minItems=1))
     */
    protected $enum;
    /**
     * @Key("default")
     * @Title("scalarValue")
     * @Description("Represents a scalar value")
     * @OneOf(@Schema(type="string"), @Schema(type="number"), @Schema(type="boolean"))
     */
    protected $default;
    /**
     * @param string $format
     */
    public function setFormat(?string $format)
    {
        $this->format = $format;
    }
    /**
     * @return string
     */
    public function getFormat() : ?string
    {
        return $this->format;
    }
    /**
     * @param array<string>|array<float> $enum
     */
    public function setEnum($enum)
    {
        $this->enum = $enum;
    }
    /**
     * @return array<string>|array<float>
     */
    public function getEnum()
    {
        return $this->enum;
    }
    /**
     * @param string|float|bool $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }
    /**
     * @return string|float|bool
     */
    public function getDefault()
    {
        return $this->default;
    }
}
/**
 * @Title("booleanProperties")
 * @Description("Boolean properties")
 * @Required({"type"})
 */
class BooleanProperties
{
    /**
     * @Key("type")
     * @Enum({"boolean"})
     * @Type("string")
     */
    protected $type;
    /**
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
    }
}
/**
 * @Title("numberProperties")
 * @Description("Number properties")
 * @Required({"type"})
 */
class NumberProperties
{
    /**
     * @Key("type")
     * @Enum({"number", "integer"})
     * @Type("string")
     */
    protected $type;
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
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
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
}
/**
 * @Title("stringProperties")
 * @Description("String properties")
 * @Required({"type"})
 */
class StringProperties
{
    /**
     * @Key("type")
     * @Enum({"string"})
     * @Type("string")
     */
    protected $type;
    /**
     * @Key("maxLength")
     * @Title("positiveInteger")
     * @Description("Positive integer value")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $maxLength;
    /**
     * @Key("minLength")
     * @Title("positiveInteger")
     * @Description("Positive integer value")
     * @Type("integer")
     * @Minimum(0)
     */
    protected $minLength;
    /**
     * @Key("pattern")
     * @Type("string")
     * @Format("regex")
     */
    protected $pattern;
    /**
     * @param string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
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
     * @param int $minLength
     */
    public function setMinLength(?int $minLength)
    {
        $this->minLength = $minLength;
    }
    /**
     * @return int
     */
    public function getMinLength() : ?int
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
}
/**
 * @Title("allOfProperties")
 * @Description("Combination keyword to represent an intersection type")
 * @Required({"allOf"})
 */
class AllOfProperties
{
    /**
     * @Key("description")
     * @Type("string")
     */
    protected $description;
    /**
     * @Key("allOf")
     * @Description("Combination values")
     * @Type("array")
     * @Items(@Schema(title="ofValue", description="Allowed values in a combination schema", oneOf={@Schema(title="numberType", description="Represents a number value (contains also integer)", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\NumberProperties")}), @Schema(title="stringType", description="Represents a string value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\StringProperties")}), @Schema(title="booleanType", description="Represents a boolean value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\BooleanProperties")}), @Ref("\ReferenceType")}))
     */
    protected $allOf;
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
     * @param array<CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|CommonProperties&ScalarProperties&BooleanProperties|ReferenceType> $allOf
     */
    public function setAllOf(?array $allOf)
    {
        $this->allOf = $allOf;
    }
    /**
     * @return array<CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|CommonProperties&ScalarProperties&BooleanProperties|ReferenceType>
     */
    public function getAllOf() : ?array
    {
        return $this->allOf;
    }
}
/**
 * @Title("oneOfProperties")
 * @Description("Combination keyword to represent an union type")
 * @Required({"oneOf"})
 */
class OneOfProperties
{
    /**
     * @Key("description")
     * @Type("string")
     */
    protected $description;
    /**
     * @Key("discriminator")
     * @Ref("\Discriminator")
     */
    protected $discriminator;
    /**
     * @Key("oneOf")
     * @Description("Combination values")
     * @Type("array")
     * @Items(@Schema(title="ofValue", description="Allowed values in a combination schema", oneOf={@Schema(title="numberType", description="Represents a number value (contains also integer)", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\NumberProperties")}), @Schema(title="stringType", description="Represents a string value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\StringProperties")}), @Schema(title="booleanType", description="Represents a boolean value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\BooleanProperties")}), @Ref("\ReferenceType")}))
     */
    protected $oneOf;
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
     * @param Discriminator $discriminator
     */
    public function setDiscriminator(?Discriminator $discriminator)
    {
        $this->discriminator = $discriminator;
    }
    /**
     * @return Discriminator
     */
    public function getDiscriminator() : ?Discriminator
    {
        return $this->discriminator;
    }
    /**
     * @param array<CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|CommonProperties&ScalarProperties&BooleanProperties|ReferenceType> $oneOf
     */
    public function setOneOf(?array $oneOf)
    {
        $this->oneOf = $oneOf;
    }
    /**
     * @return array<CommonProperties&ScalarProperties&NumberProperties|CommonProperties&ScalarProperties&StringProperties|CommonProperties&ScalarProperties&BooleanProperties|ReferenceType>
     */
    public function getOneOf() : ?array
    {
        return $this->oneOf;
    }
}
/**
 * @Title("properties")
 * @Description("Properties of a schema")
 * @AdditionalProperties(@Schema(title="propertyValue", description="Allowed values of an object property", oneOf={@Schema(title="booleanType", description="Represents a boolean value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\BooleanProperties")}), @Schema(title="numberType", description="Represents a number value (contains also integer)", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\NumberProperties")}), @Schema(title="stringType", description="Represents a string value", allOf={@Ref("\CommonProperties"), @Ref("\ScalarProperties"), @Ref("\StringProperties")}), @Schema(title="arrayType", description="An array contains an ordered list of variable values", allOf={@Ref("\CommonProperties"), @Ref("\ArrayProperties")}), @Schema(title="combinationType", description="A combination type is either a intersection or union type", oneOf={@Ref("\AllOfProperties"), @Ref("\OneOfProperties")}), @Ref("\ReferenceType")}))
 */
class Properties extends \ArrayObject
{
}
/**
 * @Title("referenceType")
 * @Description("Represents a reference to another schema")
 * @Required({"$ref"})
 */
class ReferenceType
{
    /**
     * @Key("$ref")
     * @Description("To disallow nesting we can reference only at the definitions layer")
     * @Type("string")
     * @Pattern("^#/definitions/([A-Za-z0-9]+)$")
     */
    protected $_ref;
    /**
     * @param string $_ref
     */
    public function set_ref(?string $_ref)
    {
        $this->_ref = $_ref;
    }
    /**
     * @return string
     */
    public function get_ref() : ?string
    {
        return $this->_ref;
    }
}
/**
 * @Title("discriminator")
 * @Description("Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description")
 * @Required({"propertyName"})
 */
class Discriminator
{
    /**
     * @Key("propertyName")
     * @Description("The name of the property in the payload that will hold the discriminator value")
     * @Type("string")
     */
    protected $propertyName;
    /**
     * @Key("mapping")
     * @Ref("\DiscriminatorMapping")
     */
    protected $mapping;
    /**
     * @param string $propertyName
     */
    public function setPropertyName(?string $propertyName)
    {
        $this->propertyName = $propertyName;
    }
    /**
     * @return string
     */
    public function getPropertyName() : ?string
    {
        return $this->propertyName;
    }
    /**
     * @param DiscriminatorMapping $mapping
     */
    public function setMapping(?DiscriminatorMapping $mapping)
    {
        $this->mapping = $mapping;
    }
    /**
     * @return DiscriminatorMapping
     */
    public function getMapping() : ?DiscriminatorMapping
    {
        return $this->mapping;
    }
}
/**
 * @Title("discriminatorMapping")
 * @Description("An object to hold mappings between payload values and schema names or references")
 * @AdditionalProperties(@Schema(type="string"))
 */
class DiscriminatorMapping extends \ArrayObject
{
}