use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;

#[Description('Common properties which can be used at any schema')]
class CommonProperties implements \JsonSerializable
{
    #[Description('Distinct word which represents this schema')]
    protected ?string $title = null;
    #[Description('General description of this schema, should not contain any new lines.')]
    protected ?string $description = null;
    #[Description('JSON type of the property')]
    #[Enum(array('object', 'array', 'boolean', 'integer', 'number', 'string'))]
    protected ?string $type = null;
    #[Description('Indicates whether it is possible to use a null value')]
    protected ?bool $nullable = null;
    #[Description('Indicates whether this schema is deprecated')]
    protected ?bool $deprecated = null;
    #[Description('Indicates whether this schema is readonly')]
    protected ?bool $readonly = null;
    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }
    public function getTitle() : ?string
    {
        return $this->title;
    }
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setNullable(?bool $nullable) : void
    {
        $this->nullable = $nullable;
    }
    public function getNullable() : ?bool
    {
        return $this->nullable;
    }
    public function setDeprecated(?bool $deprecated) : void
    {
        $this->deprecated = $deprecated;
    }
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
    }
    public function setReadonly(?bool $readonly) : void
    {
        $this->readonly = $readonly;
    }
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

use PSX\Schema\Attribute\Description;

class ScalarProperties implements \JsonSerializable
{
    #[Description('Describes the specific format of this type i.e. date-time or int64')]
    protected ?string $format = null;
    #[Description('A list of possible enumeration values')]
    protected StringArray|NumberArray|null $enum = null;
    #[Description('Represents a scalar value')]
    protected string|float|bool|null $default = null;
    public function setFormat(?string $format) : void
    {
        $this->format = $format;
    }
    public function getFormat() : ?string
    {
        return $this->format;
    }
    public function setEnum(StringArray|NumberArray|null $enum) : void
    {
        $this->enum = $enum;
    }
    public function getEnum() : StringArray|NumberArray|null
    {
        return $this->enum;
    }
    public function setDefault(string|float|bool|null $default) : void
    {
        $this->default = $default;
    }
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

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<PropertyValue>
 */
#[Description('Properties of a schema')]
class Properties extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Required;

#[Description('Properties specific for a container')]
#[Required(array('type'))]
class ContainerProperties implements \JsonSerializable
{
    #[Enum(array('object'))]
    protected ?string $type = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\MinItems;
use PSX\Schema\Attribute\Required;

#[Description('Struct specific properties')]
#[Required(array('properties'))]
class StructProperties implements \JsonSerializable
{
    protected ?Properties $properties = null;
    /**
     * @var array<string>|null
     */
    #[Description('Array string values')]
    #[MinItems(1)]
    protected ?array $required = null;
    public function setProperties(?Properties $properties) : void
    {
        $this->properties = $properties;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('Map specific properties')]
#[Required(array('additionalProperties'))]
class MapProperties implements \JsonSerializable
{
    #[Description('Allowed values of an object property')]
    protected BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null $additionalProperties = null;
    #[Description('Positive integer value')]
    #[Minimum(0)]
    protected ?int $maxProperties = null;
    #[Description('Positive integer value')]
    #[Minimum(0)]
    protected ?int $minProperties = null;
    public function setAdditionalProperties(BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null $additionalProperties) : void
    {
        $this->additionalProperties = $additionalProperties;
    }
    public function getAdditionalProperties() : BooleanType|NumberType|StringType|ArrayType|CombinationType|ReferenceType|GenericType|null
    {
        return $this->additionalProperties;
    }
    public function setMaxProperties(?int $maxProperties) : void
    {
        $this->maxProperties = $maxProperties;
    }
    public function getMaxProperties() : ?int
    {
        return $this->maxProperties;
    }
    public function setMinProperties(?int $minProperties) : void
    {
        $this->minProperties = $minProperties;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('Array properties')]
#[Required(array('type', 'items'))]
class ArrayProperties implements \JsonSerializable
{
    #[Enum(array('array'))]
    protected ?string $type = null;
    #[Description('Allowed values of an array item')]
    protected BooleanType|NumberType|StringType|ReferenceType|GenericType|null $items = null;
    #[Description('Positive integer value')]
    #[Minimum(0)]
    protected ?int $maxItems = null;
    #[Description('Positive integer value')]
    #[Minimum(0)]
    protected ?int $minItems = null;
    protected ?bool $uniqueItems = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setItems(BooleanType|NumberType|StringType|ReferenceType|GenericType|null $items) : void
    {
        $this->items = $items;
    }
    public function getItems() : BooleanType|NumberType|StringType|ReferenceType|GenericType|null
    {
        return $this->items;
    }
    public function setMaxItems(?int $maxItems) : void
    {
        $this->maxItems = $maxItems;
    }
    public function getMaxItems() : ?int
    {
        return $this->maxItems;
    }
    public function setMinItems(?int $minItems) : void
    {
        $this->minItems = $minItems;
    }
    public function getMinItems() : ?int
    {
        return $this->minItems;
    }
    public function setUniqueItems(?bool $uniqueItems) : void
    {
        $this->uniqueItems = $uniqueItems;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Required;

#[Description('Boolean properties')]
#[Required(array('type'))]
class BooleanProperties implements \JsonSerializable
{
    #[Enum(array('boolean'))]
    protected ?string $type = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('Number properties')]
#[Required(array('type'))]
class NumberProperties implements \JsonSerializable
{
    #[Enum(array('number', 'integer'))]
    protected ?string $type = null;
    #[Minimum(0)]
    protected ?float $multipleOf = null;
    protected ?float $maximum = null;
    protected ?bool $exclusiveMaximum = null;
    protected ?float $minimum = null;
    protected ?bool $exclusiveMinimum = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setMultipleOf(?float $multipleOf) : void
    {
        $this->multipleOf = $multipleOf;
    }
    public function getMultipleOf() : ?float
    {
        return $this->multipleOf;
    }
    public function setMaximum(?float $maximum) : void
    {
        $this->maximum = $maximum;
    }
    public function getMaximum() : ?float
    {
        return $this->maximum;
    }
    public function setExclusiveMaximum(?bool $exclusiveMaximum) : void
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
    public function getExclusiveMaximum() : ?bool
    {
        return $this->exclusiveMaximum;
    }
    public function setMinimum(?float $minimum) : void
    {
        $this->minimum = $minimum;
    }
    public function getMinimum() : ?float
    {
        return $this->minimum;
    }
    public function setExclusiveMinimum(?bool $exclusiveMinimum) : void
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('String properties')]
#[Required(array('type'))]
class StringProperties implements \JsonSerializable
{
    #[Enum(array('string'))]
    protected ?string $type = null;
    #[Description('Positive integer value')]
    #[Minimum(0)]
    protected ?int $maxLength = null;
    #[Description('Positive integer value')]
    #[Minimum(0)]
    protected ?int $minLength = null;
    protected ?string $pattern = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setMaxLength(?int $maxLength) : void
    {
        $this->maxLength = $maxLength;
    }
    public function getMaxLength() : ?int
    {
        return $this->maxLength;
    }
    public function setMinLength(?int $minLength) : void
    {
        $this->minLength = $minLength;
    }
    public function getMinLength() : ?int
    {
        return $this->minLength;
    }
    public function setPattern(?string $pattern) : void
    {
        $this->pattern = $pattern;
    }
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

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<string>
 */
#[Description('An object to hold mappings between payload values and schema names or references')]
class DiscriminatorMapping extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description')]
#[Required(array('propertyName'))]
class Discriminator implements \JsonSerializable
{
    #[Description('The name of the property in the payload that will hold the discriminator value')]
    protected ?string $propertyName = null;
    protected ?DiscriminatorMapping $mapping = null;
    public function setPropertyName(?string $propertyName) : void
    {
        $this->propertyName = $propertyName;
    }
    public function getPropertyName() : ?string
    {
        return $this->propertyName;
    }
    public function setMapping(?DiscriminatorMapping $mapping) : void
    {
        $this->mapping = $mapping;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('An intersection type combines multiple schemas into one')]
#[Required(array('allOf'))]
class AllOfProperties implements \JsonSerializable
{
    protected ?string $description = null;
    /**
     * @var array<OfValue>|null
     */
    #[Description('Combination values')]
    protected ?array $allOf = null;
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('An union type can contain one of the provided schemas')]
#[Required(array('oneOf'))]
class OneOfProperties implements \JsonSerializable
{
    protected ?string $description = null;
    protected ?Discriminator $discriminator = null;
    /**
     * @var array<OfValue>|null
     */
    #[Description('Combination values')]
    protected ?array $oneOf = null;
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setDiscriminator(?Discriminator $discriminator) : void
    {
        $this->discriminator = $discriminator;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Required;

#[Description('Represents a reference to another schema')]
#[Required(array('$ref'))]
class ReferenceType implements \JsonSerializable
{
    #[Key('$ref')]
    #[Description('Reference to the schema under the definitions key')]
    protected ?string $ref = null;
    #[Key('$template')]
    #[Description('Optional concrete schema definitions which replace generic template types')]
    protected ?TemplateProperties $template = null;
    public function setRef(?string $ref) : void
    {
        $this->ref = $ref;
    }
    public function getRef() : ?string
    {
        return $this->ref;
    }
    public function setTemplate(?TemplateProperties $template) : void
    {
        $this->template = $template;
    }
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

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Required;

#[Description('Represents a generic type')]
#[Required(array('$generic'))]
class GenericType implements \JsonSerializable
{
    #[Key('$generic')]
    protected ?string $generic = null;
    public function setGeneric(?string $generic) : void
    {
        $this->generic = $generic;
    }
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

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<DefinitionValue>
 */
#[Description('Schema definitions which can be reused')]
class Definitions extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<string>
 */
#[Description('Contains external definitions which are imported. The imported schemas can be used via the namespace')]
class Import extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\MinItems;
use PSX\Schema\Attribute\Required;
use PSX\Schema\Attribute\Title;

#[Title('TypeSchema')]
#[Description('TypeSchema meta schema which describes a TypeSchema')]
#[Required(array('title', 'type', 'properties'))]
class TypeSchema implements \JsonSerializable
{
    #[Key('$import')]
    protected ?Import $import = null;
    protected ?string $title = null;
    protected ?string $description = null;
    #[Enum(array('object'))]
    protected ?string $type = null;
    protected ?Definitions $definitions = null;
    protected ?Properties $properties = null;
    /**
     * @var array<string>|null
     */
    #[Description('Array string values')]
    #[MinItems(1)]
    protected ?array $required = null;
    public function setImport(?Import $import) : void
    {
        $this->import = $import;
    }
    public function getImport() : ?Import
    {
        return $this->import;
    }
    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }
    public function getTitle() : ?string
    {
        return $this->title;
    }
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setDefinitions(?Definitions $definitions) : void
    {
        $this->definitions = $definitions;
    }
    public function getDefinitions() : ?Definitions
    {
        return $this->definitions;
    }
    public function setProperties(?Properties $properties) : void
    {
        $this->properties = $properties;
    }
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
