/**
 * @Description("Common properties which can be used at any schema")
 */
class CommonProperties
{
    /**
     * @var string
     * @Description("Distinct word which represents this schema")
     */
    protected $title;
    /**
     * @var string
     * @Description("General description of this schema, should not contain any new lines.")
     */
    protected $description;
    /**
     * @var string
     * @Description("JSON type of the property")
     * @Enum({"object", "array", "boolean", "integer", "number", "string"})
     */
    protected $type;
    /**
     * @var bool
     * @Description("Indicates whether it is possible to use a null value")
     */
    protected $nullable;
    /**
     * @var bool
     * @Description("Indicates whether this schema is deprecated")
     */
    protected $deprecated;
    /**
     * @var bool
     * @Description("Indicates whether this schema is readonly")
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
class ScalarProperties
{
    /**
     * @var string
     * @Description("Describes the specific format of this type i.e. date-time or int64")
     */
    protected $format;
    /**
     * @var StringArray|NumberArray
     * @Description("A list of possible enumeration values")
     */
    protected $enum;
    /**
     * @var string|float|bool
     * @Description("Represents a scalar value")
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
     * @param StringArray|NumberArray $enum
     */
    public function setEnum($enum)
    {
        $this->enum = $enum;
    }
    /**
     * @return StringArray|NumberArray
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
 * @extends \PSX\Record\Record<PropertyValue>
 * @Description("Properties of a schema")
 */
class Properties extends \PSX\Record\Record
{
}
/**
 * @Description("Properties specific for a container")
 * @Required({"type"})
 */
class ContainerProperties
{
    /**
     * @var string
     * @Enum({"object"})
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
 * @Description("Struct specific properties")
 * @Required({"properties"})
 */
class StructProperties
{
    /**
     * @var Properties
     */
    protected $properties;
    /**
     * @var array<string>
     * @Description("Array string values")
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
 * @Description("Map specific properties")
 * @Required({"additionalProperties"})
 */
class MapProperties
{
    /**
     * @var BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType
     * @Description("Allowed values of an object property")
     */
    protected $additionalProperties;
    /**
     * @var int
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $maxProperties;
    /**
     * @var int
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $minProperties;
    /**
     * @param BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType $additionalProperties
     */
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = $additionalProperties;
    }
    /**
     * @return BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType
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
 * @Description("Array properties")
 * @Required({"type", "items"})
 */
class ArrayProperties
{
    /**
     * @var string
     * @Enum({"array"})
     */
    protected $type;
    /**
     * @var BooleanType|NumberType|StringType|ReferenceType|GenericType
     * @Description("Allowed values of an array item")
     */
    protected $items;
    /**
     * @var int
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $maxItems;
    /**
     * @var int
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $minItems;
    /**
     * @var bool
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
     * @param BooleanType|NumberType|StringType|ReferenceType|GenericType $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
    /**
     * @return BooleanType|NumberType|StringType|ReferenceType|GenericType
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
 * @Description("Boolean properties")
 * @Required({"type"})
 */
class BooleanProperties
{
    /**
     * @var string
     * @Enum({"boolean"})
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
 * @Description("Number properties")
 * @Required({"type"})
 */
class NumberProperties
{
    /**
     * @var string
     * @Enum({"number", "integer"})
     */
    protected $type;
    /**
     * @var float
     * @Minimum(0)
     * @ExclusiveMinimum(true)
     */
    protected $multipleOf;
    /**
     * @var float
     */
    protected $maximum;
    /**
     * @var bool
     */
    protected $exclusiveMaximum;
    /**
     * @var float
     */
    protected $minimum;
    /**
     * @var bool
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
 * @Description("String properties")
 * @Required({"type"})
 */
class StringProperties
{
    /**
     * @var string
     * @Enum({"string"})
     */
    protected $type;
    /**
     * @var int
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $maxLength;
    /**
     * @var int
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $minLength;
    /**
     * @var string
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
 * @extends \PSX\Record\Record<string>
 * @Description("An object to hold mappings between payload values and schema names or references")
 */
class DiscriminatorMapping extends \PSX\Record\Record
{
}
/**
 * @Description("Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description")
 * @Required({"propertyName"})
 */
class Discriminator
{
    /**
     * @var string
     * @Description("The name of the property in the payload that will hold the discriminator value")
     */
    protected $propertyName;
    /**
     * @var DiscriminatorMapping
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
 * @Description("An intersection type combines multiple schemas into one")
 * @Required({"allOf"})
 */
class AllOfProperties
{
    /**
     * @var string
     */
    protected $description;
    /**
     * @var array<OfValue>
     * @Description("Combination values")
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
     * @param array<OfValue> $allOf
     */
    public function setAllOf(?array $allOf)
    {
        $this->allOf = $allOf;
    }
    /**
     * @return array<OfValue>
     */
    public function getAllOf() : ?array
    {
        return $this->allOf;
    }
}
/**
 * @Description("An union type can contain one of the provided schemas")
 * @Required({"oneOf"})
 */
class OneOfProperties
{
    /**
     * @var string
     */
    protected $description;
    /**
     * @var Discriminator
     */
    protected $discriminator;
    /**
     * @var array<OfValue>
     * @Description("Combination values")
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
     * @param array<OfValue> $oneOf
     */
    public function setOneOf(?array $oneOf)
    {
        $this->oneOf = $oneOf;
    }
    /**
     * @return array<OfValue>
     */
    public function getOneOf() : ?array
    {
        return $this->oneOf;
    }
}
/**
 * @extends \PSX\Record\Record<ReferenceType>
 */
class TemplateProperties extends \PSX\Record\Record
{
}
/**
 * @Description("Represents a reference to another schema")
 * @Required({"$ref"})
 */
class ReferenceType
{
    /**
     * @var string
     * @Key("$ref")
     * @Description("Reference to the schema under the definitions key")
     */
    protected $ref;
    /**
     * @var TemplateProperties
     * @Key("$template")
     * @Description("Optional concrete schema definitions which replace generic template types")
     */
    protected $template;
    /**
     * @param string $ref
     */
    public function setRef(?string $ref)
    {
        $this->ref = $ref;
    }
    /**
     * @return string
     */
    public function getRef() : ?string
    {
        return $this->ref;
    }
    /**
     * @param TemplateProperties $template
     */
    public function setTemplate(?TemplateProperties $template)
    {
        $this->template = $template;
    }
    /**
     * @return TemplateProperties
     */
    public function getTemplate() : ?TemplateProperties
    {
        return $this->template;
    }
}
/**
 * @Description("Represents a generic type")
 * @Required({"$generic"})
 */
class GenericType
{
    /**
     * @var string
     * @Key("$generic")
     */
    protected $generic;
    /**
     * @param string $generic
     */
    public function setGeneric(?string $generic)
    {
        $this->generic = $generic;
    }
    /**
     * @return string
     */
    public function getGeneric() : ?string
    {
        return $this->generic;
    }
}
/**
 * @extends \PSX\Record\Record<DefinitionValue>
 * @Description("Schema definitions which can be reused")
 */
class Definitions extends \PSX\Record\Record
{
}
/**
 * @extends \PSX\Record\Record<string>
 * @Description("Contains external definitions which are imported. The imported schemas can be used via the namespace")
 */
class Import extends \PSX\Record\Record
{
}
/**
 * @Title("TypeSchema")
 * @Description("TypeSchema meta schema which describes a TypeSchema")
 * @Required({"title", "type", "properties"})
 */
class TypeSchema
{
    /**
     * @var Import
     * @Key("$import")
     */
    protected $import;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     * @Enum({"object"})
     */
    protected $type;
    /**
     * @var Definitions
     */
    protected $definitions;
    /**
     * @var Properties
     */
    protected $properties;
    /**
     * @var array<string>
     * @Description("Array string values")
     * @MinItems(1)
     */
    protected $required;
    /**
     * @param Import $import
     */
    public function setImport(?Import $import)
    {
        $this->import = $import;
    }
    /**
     * @return Import
     */
    public function getImport() : ?Import
    {
        return $this->import;
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