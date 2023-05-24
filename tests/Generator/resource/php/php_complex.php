use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;

#[Description('Represents a base type. Every type extends from this common type and shares the defined properties')]
class CommonType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('General description of this type, should not contain any new lines.')]
    protected ?string $description = null;
    #[Description('Type of the property')]
    #[Enum(array('object', 'array', 'boolean', 'integer', 'number', 'string', 'any'))]
    protected ?string $type = null;
    #[Description('Indicates whether it is possible to use a null value')]
    protected ?bool $nullable = null;
    #[Description('Indicates whether this type is deprecated')]
    protected ?bool $deprecated = null;
    #[Description('Indicates whether this type is readonly')]
    protected ?bool $readonly = null;
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('description', $this->description);
        $record->put('type', $this->type);
        $record->put('nullable', $this->nullable);
        $record->put('deprecated', $this->deprecated);
        $record->put('readonly', $this->readonly);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Required;

#[Description('Represents a struct type. A struct type contains a fix set of defined properties')]
#[Required(array('type', 'properties'))]
class StructType extends CommonType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Key('$final')]
    #[Description('Indicates that a struct is final, this means it is not possible to extend this struct')]
    protected ?bool $final = null;
    #[Key('$extends')]
    #[Description('Extends an existing type with the referenced type')]
    protected ?string $extends = null;
    #[Enum(array('object'))]
    protected ?string $type = null;
    protected ?Properties $properties = null;
    /**
     * @var array<string>|null
     */
    protected ?array $required = null;
    public function setFinal(?bool $final) : void
    {
        $this->final = $final;
    }
    public function getFinal() : ?bool
    {
        return $this->final;
    }
    public function setExtends(?string $extends) : void
    {
        $this->extends = $extends;
    }
    public function getExtends() : ?string
    {
        return $this->extends;
    }
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('$final', $this->final);
        $record->put('$extends', $this->extends);
        $record->put('type', $this->type);
        $record->put('properties', $this->properties);
        $record->put('required', $this->required);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<BooleanType|NumberType|StringType|ArrayType|UnionType|IntersectionType|ReferenceType|GenericType|AnyType>
 */
#[Description('Properties of a struct')]
class Properties extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Required;

#[Description('Represents a map type. A map type contains variable key value entries of a specific type')]
#[Required(array('type', 'additionalProperties'))]
class MapType extends CommonType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Enum(array('object'))]
    protected ?string $type = null;
    protected BooleanType|NumberType|StringType|ArrayType|UnionType|IntersectionType|ReferenceType|GenericType|AnyType|null $additionalProperties = null;
    #[Description('Positive integer value')]
    protected ?int $maxProperties = null;
    #[Description('Positive integer value')]
    protected ?int $minProperties = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setAdditionalProperties(BooleanType|NumberType|StringType|ArrayType|UnionType|IntersectionType|ReferenceType|GenericType|AnyType|null $additionalProperties) : void
    {
        $this->additionalProperties = $additionalProperties;
    }
    public function getAdditionalProperties() : BooleanType|NumberType|StringType|ArrayType|UnionType|IntersectionType|ReferenceType|GenericType|AnyType|null
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('additionalProperties', $this->additionalProperties);
        $record->put('maxProperties', $this->maxProperties);
        $record->put('minProperties', $this->minProperties);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Required;

#[Description('Represents an array type. An array type contains an ordered list of a specific type')]
#[Required(array('type', 'items'))]
class ArrayType extends CommonType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Enum(array('array'))]
    protected ?string $type = null;
    protected BooleanType|NumberType|StringType|ReferenceType|GenericType|AnyType|null $items = null;
    #[Description('Positive integer value')]
    protected ?int $maxItems = null;
    #[Description('Positive integer value')]
    protected ?int $minItems = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setItems(BooleanType|NumberType|StringType|ReferenceType|GenericType|AnyType|null $items) : void
    {
        $this->items = $items;
    }
    public function getItems() : BooleanType|NumberType|StringType|ReferenceType|GenericType|AnyType|null
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('items', $this->items);
        $record->put('maxItems', $this->maxItems);
        $record->put('minItems', $this->minItems);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('Represents a scalar type')]
class ScalarType extends CommonType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('Describes the specific format of this type i.e. date-time or int64')]
    protected ?string $format = null;
    /**
     * @var array<string|float>|null
     */
    protected ?array $enum = null;
    protected string|float|bool|null $default = null;
    public function setFormat(?string $format) : void
    {
        $this->format = $format;
    }
    public function getFormat() : ?string
    {
        return $this->format;
    }
    /**
     * @param array<string|float>|null $enum
     */
    public function setEnum(?array $enum) : void
    {
        $this->enum = $enum;
    }
    public function getEnum() : ?array
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('format', $this->format);
        $record->put('enum', $this->enum);
        $record->put('default', $this->default);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Required;

#[Description('Represents a boolean type')]
#[Required(array('type'))]
class BooleanType extends ScalarType implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('Represents a number type (contains also integer)')]
#[Required(array('type'))]
class NumberType extends ScalarType implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('multipleOf', $this->multipleOf);
        $record->put('maximum', $this->maximum);
        $record->put('exclusiveMaximum', $this->exclusiveMaximum);
        $record->put('minimum', $this->minimum);
        $record->put('exclusiveMinimum', $this->exclusiveMinimum);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('Represents a string type')]
#[Required(array('type'))]
class StringType extends ScalarType implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('maxLength', $this->maxLength);
        $record->put('minLength', $this->minLength);
        $record->put('pattern', $this->pattern);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Required;

#[Description('Represents an any type')]
#[Required(array('type'))]
class AnyType extends CommonType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Enum(array('any'))]
    protected ?string $type = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('Represents an intersection type')]
#[Required(array('allOf'))]
class IntersectionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $description = null;
    /**
     * @var array<ReferenceType>|null
     */
    #[Description('Contains an array of references. The reference must only point to a struct type')]
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
     * @param array<ReferenceType>|null $allOf
     */
    public function setAllOf(?array $allOf) : void
    {
        $this->allOf = $allOf;
    }
    public function getAllOf() : ?array
    {
        return $this->allOf;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('description', $this->description);
        $record->put('allOf', $this->allOf);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('Represents an union type. An union type can contain one of the provided types')]
#[Required(array('oneOf'))]
class UnionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $description = null;
    protected ?Discriminator $discriminator = null;
    /**
     * @var array<NumberType|StringType|BooleanType|ReferenceType>|null
     */
    #[Description('Contains an array of references. The reference must only point to a struct type')]
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
     * @param array<NumberType|StringType|BooleanType|ReferenceType>|null $oneOf
     */
    public function setOneOf(?array $oneOf) : void
    {
        $this->oneOf = $oneOf;
    }
    public function getOneOf() : ?array
    {
        return $this->oneOf;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('description', $this->description);
        $record->put('discriminator', $this->discriminator);
        $record->put('oneOf', $this->oneOf);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
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
class Discriminator implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('propertyName', $this->propertyName);
        $record->put('mapping', $this->mapping);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Required;

#[Description('Represents a reference type. A reference type points to a specific type at the definitions map')]
#[Required(array('$ref'))]
class ReferenceType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Key('$ref')]
    #[Description('Reference to a type under the definitions map')]
    protected ?string $ref = null;
    #[Key('$template')]
    #[Description('Optional concrete type definitions which replace generic template types')]
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('$ref', $this->ref);
        $record->put('$template', $this->template);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

/**
 * @extends \PSX\Record\Record<string>
 */
class TemplateProperties extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Required;

#[Description('Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword')]
#[Required(array('$generic'))]
class GenericType implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('$generic', $this->generic);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<StructType|MapType|ReferenceType>
 */
#[Description('The definitions map which contains all types')]
class Definitions extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
/**
 * @extends \PSX\Record\Record<string>
 */
#[Description('Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. \'my_namespace:my_type\'')]
class Import extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Required;

#[Description('The root TypeSchema')]
#[Required(array('definitions'))]
class TypeSchema implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Key('$import')]
    protected ?Import $import = null;
    protected ?Definitions $definitions = null;
    #[Key('$ref')]
    #[Description('Reference to a root schema under the definitions key')]
    protected ?string $ref = null;
    public function setImport(?Import $import) : void
    {
        $this->import = $import;
    }
    public function getImport() : ?Import
    {
        return $this->import;
    }
    public function setDefinitions(?Definitions $definitions) : void
    {
        $this->definitions = $definitions;
    }
    public function getDefinitions() : ?Definitions
    {
        return $this->definitions;
    }
    public function setRef(?string $ref) : void
    {
        $this->ref = $ref;
    }
    public function getRef() : ?string
    {
        return $this->ref;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('$import', $this->import);
        $record->put('definitions', $this->definitions);
        $record->put('$ref', $this->ref);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
