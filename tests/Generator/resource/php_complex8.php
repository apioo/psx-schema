/**
 * @Description("Common properties which can be used at any schema")
 */
class CommonProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Description("Distinct word which represents this schema")
     */
    protected $title;
    /**
     * @var string|null
     * @Description("General description of this schema, should not contain any new lines.")
     */
    protected $description;
    /**
     * @var string|null
     * @Description("JSON type of the property")
     * @Enum({"object", "array", "boolean", "integer", "number", "string"})
     */
    protected $type;
    /**
     * @var bool|null
     * @Description("Indicates whether it is possible to use a null value")
     */
    protected $nullable;
    /**
     * @var bool|null
     * @Description("Indicates whether this schema is deprecated")
     */
    protected $deprecated;
    /**
     * @var bool|null
     * @Description("Indicates whether this schema is readonly")
     */
    protected $readonly;
    /**
     * @param string|null $title
     */
    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }
    /**
     * @return string|null
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    /**
     * @param string|null $description
     */
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    /**
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param bool|null $nullable
     */
    public function setNullable(?bool $nullable) : void
    {
        $this->nullable = $nullable;
    }
    /**
     * @return bool|null
     */
    public function getNullable() : ?bool
    {
        return $this->nullable;
    }
    /**
     * @param bool|null $deprecated
     */
    public function setDeprecated(?bool $deprecated) : void
    {
        $this->deprecated = $deprecated;
    }
    /**
     * @return bool|null
     */
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
    }
    /**
     * @param bool|null $readonly
     */
    public function setReadonly(?bool $readonly) : void
    {
        $this->readonly = $readonly;
    }
    /**
     * @return bool|null
     */
    public function getReadonly() : ?bool
    {
        return $this->readonly;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('title' => $this->title, 'description' => $this->description, 'type' => $this->type, 'nullable' => $this->nullable, 'deprecated' => $this->deprecated, 'readonly' => $this->readonly), static function ($value) : bool {
            return $value !== null;
        });
    }
}

class ScalarProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Description("Describes the specific format of this type i.e. date-time or int64")
     */
    protected $format;
    /**
     * @var StringArray|NumberArray|null
     * @Description("A list of possible enumeration values")
     */
    protected $enum;
    /**
     * @var string|float|bool|null
     * @Description("Represents a scalar value")
     */
    protected $default;
    /**
     * @param string|null $format
     */
    public function setFormat(?string $format) : void
    {
        $this->format = $format;
    }
    /**
     * @return string|null
     */
    public function getFormat() : ?string
    {
        return $this->format;
    }
    /**
     * @param StringArray|NumberArray|null $enum
     */
    public function setEnum(StringArray|NumberArray|null $enum) : void
    {
        $this->enum = $enum;
    }
    /**
     * @return StringArray|NumberArray|null
     */
    public function getEnum() : StringArray|NumberArray|null
    {
        return $this->enum;
    }
    /**
     * @param string|float|bool|null $default
     */
    public function setDefault(string|float|bool|null $default) : void
    {
        $this->default = $default;
    }
    /**
     * @return string|float|bool|null
     */
    public function getDefault() : string|float|bool|null
    {
        return $this->default;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('format' => $this->format, 'enum' => $this->enum, 'default' => $this->default), static function ($value) : bool {
            return $value !== null;
        });
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
class ContainerProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Enum({"object"})
     */
    protected $type;
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('type' => $this->type), static function ($value) : bool {
            return $value !== null;
        });
    }
}
/**
 * @Description("Struct specific properties")
 * @Required({"properties"})
 */
class StructProperties implements \JsonSerializable
{
    /**
     * @var Properties|null
     */
    protected $properties;
    /**
     * @var array<string>|null
     * @Description("Array string values")
     * @MinItems(1)
     */
    protected $required;
    /**
     * @param Properties|null $properties
     */
    public function setProperties(?Properties $properties) : void
    {
        $this->properties = $properties;
    }
    /**
     * @return Properties|null
     */
    public function getProperties() : ?Properties
    {
        return $this->properties;
    }
    /**
     * @param array<string>|null $required
     */
    public function setRequired(?array $required) : void
    {
        $this->required = $required;
    }
    /**
     * @return array<string>|null
     */
    public function getRequired() : ?array
    {
        return $this->required;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('properties' => $this->properties, 'required' => $this->required), static function ($value) : bool {
            return $value !== null;
        });
    }
}

/**
 * @Description("Map specific properties")
 * @Required({"additionalProperties"})
 */
class MapProperties implements \JsonSerializable
{
    /**
     * @var BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null
     * @Description("Allowed values of an object property")
     */
    protected $additionalProperties;
    /**
     * @var int|null
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $maxProperties;
    /**
     * @var int|null
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $minProperties;
    /**
     * @param BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null $additionalProperties
     */
    public function setAdditionalProperties(BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null $additionalProperties) : void
    {
        $this->additionalProperties = $additionalProperties;
    }
    /**
     * @return BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null
     */
    public function getAdditionalProperties() : BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null
    {
        return $this->additionalProperties;
    }
    /**
     * @param int|null $maxProperties
     */
    public function setMaxProperties(?int $maxProperties) : void
    {
        $this->maxProperties = $maxProperties;
    }
    /**
     * @return int|null
     */
    public function getMaxProperties() : ?int
    {
        return $this->maxProperties;
    }
    /**
     * @param int|null $minProperties
     */
    public function setMinProperties(?int $minProperties) : void
    {
        $this->minProperties = $minProperties;
    }
    /**
     * @return int|null
     */
    public function getMinProperties() : ?int
    {
        return $this->minProperties;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('additionalProperties' => $this->additionalProperties, 'maxProperties' => $this->maxProperties, 'minProperties' => $this->minProperties), static function ($value) : bool {
            return $value !== null;
        });
    }
}

/**
 * @Description("Array properties")
 * @Required({"type", "items"})
 */
class ArrayProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Enum({"array"})
     */
    protected $type;
    /**
     * @var BooleanType|NumberType|StringType|ReferenceType|GenericType|null
     * @Description("Allowed values of an array item")
     */
    protected $items;
    /**
     * @var int|null
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $maxItems;
    /**
     * @var int|null
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $minItems;
    /**
     * @var bool|null
     */
    protected $uniqueItems;
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param BooleanType|NumberType|StringType|ReferenceType|GenericType|null $items
     */
    public function setItems(BooleanType|NumberType|StringType|ReferenceType|GenericType|null $items) : void
    {
        $this->items = $items;
    }
    /**
     * @return BooleanType|NumberType|StringType|ReferenceType|GenericType|null
     */
    public function getItems() : BooleanType|NumberType|StringType|ReferenceType|GenericType|null
    {
        return $this->items;
    }
    /**
     * @param int|null $maxItems
     */
    public function setMaxItems(?int $maxItems) : void
    {
        $this->maxItems = $maxItems;
    }
    /**
     * @return int|null
     */
    public function getMaxItems() : ?int
    {
        return $this->maxItems;
    }
    /**
     * @param int|null $minItems
     */
    public function setMinItems(?int $minItems) : void
    {
        $this->minItems = $minItems;
    }
    /**
     * @return int|null
     */
    public function getMinItems() : ?int
    {
        return $this->minItems;
    }
    /**
     * @param bool|null $uniqueItems
     */
    public function setUniqueItems(?bool $uniqueItems) : void
    {
        $this->uniqueItems = $uniqueItems;
    }
    /**
     * @return bool|null
     */
    public function getUniqueItems() : ?bool
    {
        return $this->uniqueItems;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('type' => $this->type, 'items' => $this->items, 'maxItems' => $this->maxItems, 'minItems' => $this->minItems, 'uniqueItems' => $this->uniqueItems), static function ($value) : bool {
            return $value !== null;
        });
    }
}

/**
 * @Description("Boolean properties")
 * @Required({"type"})
 */
class BooleanProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Enum({"boolean"})
     */
    protected $type;
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('type' => $this->type), static function ($value) : bool {
            return $value !== null;
        });
    }
}
/**
 * @Description("Number properties")
 * @Required({"type"})
 */
class NumberProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Enum({"number", "integer"})
     */
    protected $type;
    /**
     * @var float|null
     * @Minimum(0)
     * @ExclusiveMinimum(true)
     */
    protected $multipleOf;
    /**
     * @var float|null
     */
    protected $maximum;
    /**
     * @var bool|null
     */
    protected $exclusiveMaximum;
    /**
     * @var float|null
     */
    protected $minimum;
    /**
     * @var bool|null
     */
    protected $exclusiveMinimum;
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param float|null $multipleOf
     */
    public function setMultipleOf(?float $multipleOf) : void
    {
        $this->multipleOf = $multipleOf;
    }
    /**
     * @return float|null
     */
    public function getMultipleOf() : ?float
    {
        return $this->multipleOf;
    }
    /**
     * @param float|null $maximum
     */
    public function setMaximum(?float $maximum) : void
    {
        $this->maximum = $maximum;
    }
    /**
     * @return float|null
     */
    public function getMaximum() : ?float
    {
        return $this->maximum;
    }
    /**
     * @param bool|null $exclusiveMaximum
     */
    public function setExclusiveMaximum(?bool $exclusiveMaximum) : void
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
    /**
     * @return bool|null
     */
    public function getExclusiveMaximum() : ?bool
    {
        return $this->exclusiveMaximum;
    }
    /**
     * @param float|null $minimum
     */
    public function setMinimum(?float $minimum) : void
    {
        $this->minimum = $minimum;
    }
    /**
     * @return float|null
     */
    public function getMinimum() : ?float
    {
        return $this->minimum;
    }
    /**
     * @param bool|null $exclusiveMinimum
     */
    public function setExclusiveMinimum(?bool $exclusiveMinimum) : void
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
    /**
     * @return bool|null
     */
    public function getExclusiveMinimum() : ?bool
    {
        return $this->exclusiveMinimum;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('type' => $this->type, 'multipleOf' => $this->multipleOf, 'maximum' => $this->maximum, 'exclusiveMaximum' => $this->exclusiveMaximum, 'minimum' => $this->minimum, 'exclusiveMinimum' => $this->exclusiveMinimum), static function ($value) : bool {
            return $value !== null;
        });
    }
}

/**
 * @Description("String properties")
 * @Required({"type"})
 */
class StringProperties implements \JsonSerializable
{
    /**
     * @var string|null
     * @Enum({"string"})
     */
    protected $type;
    /**
     * @var int|null
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $maxLength;
    /**
     * @var int|null
     * @Description("Positive integer value")
     * @Minimum(0)
     */
    protected $minLength;
    /**
     * @var string|null
     */
    protected $pattern;
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param int|null $maxLength
     */
    public function setMaxLength(?int $maxLength) : void
    {
        $this->maxLength = $maxLength;
    }
    /**
     * @return int|null
     */
    public function getMaxLength() : ?int
    {
        return $this->maxLength;
    }
    /**
     * @param int|null $minLength
     */
    public function setMinLength(?int $minLength) : void
    {
        $this->minLength = $minLength;
    }
    /**
     * @return int|null
     */
    public function getMinLength() : ?int
    {
        return $this->minLength;
    }
    /**
     * @param string|null $pattern
     */
    public function setPattern(?string $pattern) : void
    {
        $this->pattern = $pattern;
    }
    /**
     * @return string|null
     */
    public function getPattern() : ?string
    {
        return $this->pattern;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('type' => $this->type, 'maxLength' => $this->maxLength, 'minLength' => $this->minLength, 'pattern' => $this->pattern), static function ($value) : bool {
            return $value !== null;
        });
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
class Discriminator implements \JsonSerializable
{
    /**
     * @var string|null
     * @Description("The name of the property in the payload that will hold the discriminator value")
     */
    protected $propertyName;
    /**
     * @var DiscriminatorMapping|null
     */
    protected $mapping;
    /**
     * @param string|null $propertyName
     */
    public function setPropertyName(?string $propertyName) : void
    {
        $this->propertyName = $propertyName;
    }
    /**
     * @return string|null
     */
    public function getPropertyName() : ?string
    {
        return $this->propertyName;
    }
    /**
     * @param DiscriminatorMapping|null $mapping
     */
    public function setMapping(?DiscriminatorMapping $mapping) : void
    {
        $this->mapping = $mapping;
    }
    /**
     * @return DiscriminatorMapping|null
     */
    public function getMapping() : ?DiscriminatorMapping
    {
        return $this->mapping;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('propertyName' => $this->propertyName, 'mapping' => $this->mapping), static function ($value) : bool {
            return $value !== null;
        });
    }
}
/**
 * @Description("An intersection type combines multiple schemas into one")
 * @Required({"allOf"})
 */
class AllOfProperties implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $description;
    /**
     * @var array<OfValue>|null
     * @Description("Combination values")
     */
    protected $allOf;
    /**
     * @param string|null $description
     */
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    /**
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
    /**
     * @param array<OfValue>|null $allOf
     */
    public function setAllOf(?array $allOf) : void
    {
        $this->allOf = $allOf;
    }
    /**
     * @return array<OfValue>|null
     */
    public function getAllOf() : ?array
    {
        return $this->allOf;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('description' => $this->description, 'allOf' => $this->allOf), static function ($value) : bool {
            return $value !== null;
        });
    }
}

/**
 * @Description("An union type can contain one of the provided schemas")
 * @Required({"oneOf"})
 */
class OneOfProperties implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $description;
    /**
     * @var Discriminator|null
     */
    protected $discriminator;
    /**
     * @var array<OfValue>|null
     * @Description("Combination values")
     */
    protected $oneOf;
    /**
     * @param string|null $description
     */
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    /**
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
    /**
     * @param Discriminator|null $discriminator
     */
    public function setDiscriminator(?Discriminator $discriminator) : void
    {
        $this->discriminator = $discriminator;
    }
    /**
     * @return Discriminator|null
     */
    public function getDiscriminator() : ?Discriminator
    {
        return $this->discriminator;
    }
    /**
     * @param array<OfValue>|null $oneOf
     */
    public function setOneOf(?array $oneOf) : void
    {
        $this->oneOf = $oneOf;
    }
    /**
     * @return array<OfValue>|null
     */
    public function getOneOf() : ?array
    {
        return $this->oneOf;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('description' => $this->description, 'discriminator' => $this->discriminator, 'oneOf' => $this->oneOf), static function ($value) : bool {
            return $value !== null;
        });
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
class ReferenceType implements \JsonSerializable
{
    /**
     * @var string|null
     * @Key("$ref")
     * @Description("Reference to the schema under the definitions key")
     */
    protected $ref;
    /**
     * @var TemplateProperties|null
     * @Key("$template")
     * @Description("Optional concrete schema definitions which replace generic template types")
     */
    protected $template;
    /**
     * @param string|null $ref
     */
    public function setRef(?string $ref) : void
    {
        $this->ref = $ref;
    }
    /**
     * @return string|null
     */
    public function getRef() : ?string
    {
        return $this->ref;
    }
    /**
     * @param TemplateProperties|null $template
     */
    public function setTemplate(?TemplateProperties $template) : void
    {
        $this->template = $template;
    }
    /**
     * @return TemplateProperties|null
     */
    public function getTemplate() : ?TemplateProperties
    {
        return $this->template;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('$ref' => $this->ref, '$template' => $this->template), static function ($value) : bool {
            return $value !== null;
        });
    }
}

/**
 * @Description("Represents a generic type")
 * @Required({"$generic"})
 */
class GenericType implements \JsonSerializable
{
    /**
     * @var string|null
     * @Key("$generic")
     */
    protected $generic;
    /**
     * @param string|null $generic
     */
    public function setGeneric(?string $generic) : void
    {
        $this->generic = $generic;
    }
    /**
     * @return string|null
     */
    public function getGeneric() : ?string
    {
        return $this->generic;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('$generic' => $this->generic), static function ($value) : bool {
            return $value !== null;
        });
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
class TypeSchema implements \JsonSerializable
{
    /**
     * @var Import|null
     * @Key("$import")
     */
    protected $import;
    /**
     * @var string|null
     */
    protected $title;
    /**
     * @var string|null
     */
    protected $description;
    /**
     * @var string|null
     * @Enum({"object"})
     */
    protected $type;
    /**
     * @var Definitions|null
     */
    protected $definitions;
    /**
     * @var Properties|null
     */
    protected $properties;
    /**
     * @var array<string>|null
     * @Description("Array string values")
     * @MinItems(1)
     */
    protected $required;
    /**
     * @param Import|null $import
     */
    public function setImport(?Import $import) : void
    {
        $this->import = $import;
    }
    /**
     * @return Import|null
     */
    public function getImport() : ?Import
    {
        return $this->import;
    }
    /**
     * @param string|null $title
     */
    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }
    /**
     * @return string|null
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    /**
     * @param string|null $description
     */
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    /**
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
    /**
     * @param string|null $type
     */
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }
    /**
     * @param Definitions|null $definitions
     */
    public function setDefinitions(?Definitions $definitions) : void
    {
        $this->definitions = $definitions;
    }
    /**
     * @return Definitions|null
     */
    public function getDefinitions() : ?Definitions
    {
        return $this->definitions;
    }
    /**
     * @param Properties|null $properties
     */
    public function setProperties(?Properties $properties) : void
    {
        $this->properties = $properties;
    }
    /**
     * @return Properties|null
     */
    public function getProperties() : ?Properties
    {
        return $this->properties;
    }
    /**
     * @param array<string>|null $required
     */
    public function setRequired(?array $required) : void
    {
        $this->required = $required;
    }
    /**
     * @return array<string>|null
     */
    public function getRequired() : ?array
    {
        return $this->required;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('$import' => $this->import, 'title' => $this->title, 'description' => $this->description, 'type' => $this->type, 'definitions' => $this->definitions, 'properties' => $this->properties, 'required' => $this->required), static function ($value) : bool {
            return $value !== null;
        });
    }
}