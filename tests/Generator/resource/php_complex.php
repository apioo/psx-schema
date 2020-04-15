/**
 * Indicates whether this schema is readonly
 */
class CommonProperties
{
    protected $title;
    protected $description;
    protected $type;
    protected $nullable;
    protected $deprecated;
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
 * Represents a scalar value
 */
class ScalarProperties
{
    protected $format;
    protected $enum;
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
 * Array string values
 */
class StructProperties
{
    protected $properties;
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
 * Positive integer value
 */
class MapProperties
{
    protected $additionalProperties;
    protected $maxProperties;
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
 * Positive integer value
 */
class ArrayProperties
{
    protected $type;
    protected $items;
    protected $maxItems;
    protected $minItems;
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
    protected $type;
    protected $multipleOf;
    protected $maximum;
    protected $exclusiveMaximum;
    protected $minimum;
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
 * Positive integer value
 */
class StringProperties
{
    protected $type;
    protected $maxLength;
    protected $minLength;
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
 * An object to hold mappings between payload values and schema names or references
 */
class Discriminator
{
    protected $propertyName;
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
 * Combination values
 */
class AllOfProperties
{
    protected $description;
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
 * Combination values
 */
class OneOfProperties
{
    protected $description;
    protected $discriminator;
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
 * Reference to the schema under the definitions key
 */
class ReferenceType
{
    protected $ref;
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
 * Array string values
 */
class TypeSchema
{
    protected $import;
    protected $title;
    protected $description;
    protected $type;
    protected $definitions;
    protected $properties;
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