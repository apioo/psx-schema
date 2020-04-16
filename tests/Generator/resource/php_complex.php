/**
 * Common properties which can be used at any schema
 */
class CommonProperties
{
    /**
     * Distinct word which represents this schema
     * @var string
     */
    protected $title;
    /**
     * General description of this schema, should not contain any new lines.
     * @var string
     */
    protected $description;
    /**
     * JSON type of the property
     * @var string
     */
    protected $type;
    /**
     * Indicates whether it is possible to use a null value
     * @var bool
     */
    protected $nullable;
    /**
     * Indicates whether this schema is deprecated
     * @var bool
     */
    protected $deprecated;
    /**
     * Indicates whether this schema is readonly
     * @var bool
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
     * Describes the specific format of this type i.e. date-time or int64
     * @var string
     */
    protected $format;
    /**
     * A list of possible enumeration values
     * @var StringArray|NumberArray
     */
    protected $enum;
    /**
     * Represents a scalar value
     * @var string|float|bool
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
 * Properties specific for a container
 */
class ContainerProperties
{
    /**
     * @var string
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
 * Struct specific properties
 */
class StructProperties
{
    /**
     * Properties of a schema
     * @var array<string, PropertyValue>
     */
    protected $properties;
    /**
     * Array string values
     * @var array<string>
     */
    protected $required;
    /**
     * @param array<string, PropertyValue> $properties
     */
    public function setProperties(?array $properties)
    {
        $this->properties = $properties;
    }
    /**
     * @return array<string, PropertyValue>
     */
    public function getProperties() : ?array
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
 * Map specific properties
 */
class MapProperties
{
    /**
     * Allowed values of an object property
     * @var BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType
     */
    protected $additionalProperties;
    /**
     * Positive integer value
     * @var int
     */
    protected $maxProperties;
    /**
     * Positive integer value
     * @var int
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
 * Array properties
 */
class ArrayProperties
{
    /**
     * @var string
     */
    protected $type;
    /**
     * Allowed values of an array item
     * @var BooleanType|NumberType|StringType|ReferenceType|GenericType
     */
    protected $items;
    /**
     * Positive integer value
     * @var int
     */
    protected $maxItems;
    /**
     * Positive integer value
     * @var int
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
 * Boolean properties
 */
class BooleanProperties
{
    /**
     * @var string
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
 * Number properties
 */
class NumberProperties
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var float
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
 * String properties
 */
class StringProperties
{
    /**
     * @var string
     */
    protected $type;
    /**
     * Positive integer value
     * @var int
     */
    protected $maxLength;
    /**
     * Positive integer value
     * @var int
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
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
class Discriminator
{
    /**
     * The name of the property in the payload that will hold the discriminator value
     * @var string
     */
    protected $propertyName;
    /**
     * An object to hold mappings between payload values and schema names or references
     * @var array<string, string>
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
     * @param array<string, string> $mapping
     */
    public function setMapping(?array $mapping)
    {
        $this->mapping = $mapping;
    }
    /**
     * @return array<string, string>
     */
    public function getMapping() : ?array
    {
        return $this->mapping;
    }
}
/**
 * An intersection type combines multiple schemas into one
 */
class AllOfProperties
{
    /**
     * @var string
     */
    protected $description;
    /**
     * Combination values
     * @var array<OfValue>
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
 * An union type can contain one of the provided schemas
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
     * Combination values
     * @var array<OfValue>
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
 * Represents a reference to another schema
 */
class ReferenceType
{
    /**
     * Reference to the schema under the definitions key
     * @var string
     */
    protected $ref;
    /**
     * @var array<string, ReferenceType>
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
     * @param array<string, ReferenceType> $template
     */
    public function setTemplate(?array $template)
    {
        $this->template = $template;
    }
    /**
     * @return array<string, ReferenceType>
     */
    public function getTemplate() : ?array
    {
        return $this->template;
    }
}
/**
 * Represents a generic type
 */
class GenericType
{
    /**
     * @var string
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
 * TypeSchema meta schema which describes a TypeSchema
 */
class TypeSchema
{
    /**
     * Contains external definitions which are imported. The imported schemas can be used via the namespace
     * @var array<string, string>
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
     */
    protected $type;
    /**
     * Schema definitions which can be reused
     * @var array<string, DefinitionValue>
     */
    protected $definitions;
    /**
     * Properties of a schema
     * @var array<string, PropertyValue>
     */
    protected $properties;
    /**
     * Array string values
     * @var array<string>
     */
    protected $required;
    /**
     * @param array<string, string> $import
     */
    public function setImport(?array $import)
    {
        $this->import = $import;
    }
    /**
     * @return array<string, string>
     */
    public function getImport() : ?array
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
     * @param array<string, DefinitionValue> $definitions
     */
    public function setDefinitions(?array $definitions)
    {
        $this->definitions = $definitions;
    }
    /**
     * @return array<string, DefinitionValue>
     */
    public function getDefinitions() : ?array
    {
        return $this->definitions;
    }
    /**
     * @param array<string, PropertyValue> $properties
     */
    public function setProperties(?array $properties)
    {
        $this->properties = $properties;
    }
    /**
     * @return array<string, PropertyValue>
     */
    public function getProperties() : ?array
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