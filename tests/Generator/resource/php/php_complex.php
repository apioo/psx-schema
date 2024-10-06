use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base definition type')]
#[Discriminator('type')]
#[DerivedType('StructDefinitionType', 'struct')]
#[DerivedType('MapDefinitionType', 'map')]
#[DerivedType('ArrayDefinitionType', 'array')]
abstract class DefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $description = null;
    #[Description('')]
    protected ?bool $deprecated = null;
    #[Description('')]
    protected ?string $type = null;
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setDeprecated(?bool $deprecated) : void
    {
        $this->deprecated = $deprecated;
    }
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
    }
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
        $record = new \PSX\Record\Record();
        $record->put('description', $this->description);
        $record->put('deprecated', $this->deprecated);
        $record->put('type', $this->type);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('Represents a struct which contains a fixed set of defined properties')]
class StructDefinitionType extends DefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('The parent type of this struct. The struct inherits all properties from the parent type')]
    protected ?string $parent = null;
    #[Description('Indicates that this struct is a base type, this means it is an abstract type which is used by different types as parent')]
    protected ?bool $base = null;
    /**
     * @var \PSX\Record\Record|null
     */
    #[Description('')]
    protected ?\PSX\Record\Record $properties = null;
    #[Description('In case this is a base type it is possible to specify a discriminator property')]
    protected ?string $discriminator = null;
    /**
     * @var \PSX\Record\Record|null
     */
    #[Description('In case a discriminator property was set it is possible to specify a mapping. The key is the type name and the value the concrete value which is mapped to the type')]
    protected ?\PSX\Record\Record $mapping = null;
    /**
     * @var \PSX\Record\Record|null
     */
    #[Description('In case the parent type contains generics it is possible to set a concrete type for each generic type')]
    protected ?\PSX\Record\Record $template = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setParent(?string $parent) : void
    {
        $this->parent = $parent;
    }
    public function getParent() : ?string
    {
        return $this->parent;
    }
    public function setBase(?bool $base) : void
    {
        $this->base = $base;
    }
    public function getBase() : ?bool
    {
        return $this->base;
    }
    public function setProperties(?\PSX\Record\Record $properties) : void
    {
        $this->properties = $properties;
    }
    public function getProperties() : ?\PSX\Record\Record
    {
        return $this->properties;
    }
    public function setDiscriminator(?string $discriminator) : void
    {
        $this->discriminator = $discriminator;
    }
    public function getDiscriminator() : ?string
    {
        return $this->discriminator;
    }
    public function setMapping(?\PSX\Record\Record $mapping) : void
    {
        $this->mapping = $mapping;
    }
    public function getMapping() : ?\PSX\Record\Record
    {
        return $this->mapping;
    }
    public function setTemplate(?\PSX\Record\Record $template) : void
    {
        $this->template = $template;
    }
    public function getTemplate() : ?\PSX\Record\Record
    {
        return $this->template;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('parent', $this->parent);
        $record->put('base', $this->base);
        $record->put('properties', $this->properties);
        $record->put('discriminator', $this->discriminator);
        $record->put('mapping', $this->mapping);
        $record->put('template', $this->template);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base type for the map and array collection type')]
#[Discriminator('type')]
#[DerivedType('MapDefinitionType', 'map')]
#[DerivedType('ArrayDefinitionType', 'array')]
abstract class CollectionDefinitionType extends DefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('')]
    protected ?PropertyType $schema = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setSchema(?PropertyType $schema) : void
    {
        $this->schema = $schema;
    }
    public function getSchema() : ?PropertyType
    {
        return $this->schema;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('schema', $this->schema);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('Represents a map which contains a dynamic set of key value entries')]
class MapDefinitionType extends CollectionDefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents an array which contains a dynamic list of values')]
class ArrayDefinitionType extends CollectionDefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base property type')]
#[Discriminator('type')]
#[DerivedType('IntegerPropertyType', 'integer')]
#[DerivedType('NumberPropertyType', 'number')]
#[DerivedType('StringPropertyType', 'string')]
#[DerivedType('BooleanPropertyType', 'boolean')]
#[DerivedType('MapPropertyType', 'map')]
#[DerivedType('ArrayPropertyType', 'array')]
#[DerivedType('AnyPropertyType', 'any')]
#[DerivedType('GenericPropertyType', 'generic')]
#[DerivedType('ReferencePropertyType', 'reference')]
abstract class PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $description = null;
    #[Description('')]
    protected ?bool $deprecated = null;
    #[Description('')]
    protected ?string $type = null;
    #[Description('')]
    protected ?bool $nullable = null;
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setDeprecated(?bool $deprecated) : void
    {
        $this->deprecated = $deprecated;
    }
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('description', $this->description);
        $record->put('deprecated', $this->deprecated);
        $record->put('type', $this->type);
        $record->put('nullable', $this->nullable);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base scalar property type')]
#[Discriminator('type')]
#[DerivedType('IntegerPropertyType', 'integer')]
#[DerivedType('NumberPropertyType', 'number')]
#[DerivedType('StringPropertyType', 'string')]
#[DerivedType('BooleanPropertyType', 'boolean')]
abstract class ScalarPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents an integer value')]
class IntegerPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents a float value')]
class NumberPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents a string value')]
class StringPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('')]
    protected ?string $format = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setFormat(?string $format) : void
    {
        $this->format = $format;
    }
    public function getFormat() : ?string
    {
        return $this->format;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('format', $this->format);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('Represents a boolean value')]
class BooleanPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base collection property type')]
#[Discriminator('type')]
#[DerivedType('MapPropertyType', 'map')]
#[DerivedType('ArrayPropertyType', 'array')]
abstract class CollectionPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('')]
    protected ?PropertyType $schema = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setSchema(?PropertyType $schema) : void
    {
        $this->schema = $schema;
    }
    public function getSchema() : ?PropertyType
    {
        return $this->schema;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('schema', $this->schema);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('Represents a map which contains a dynamic set of key value entries')]
class MapPropertyType extends CollectionPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents an array which contains a dynamic list of values')]
class ArrayPropertyType extends CollectionPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents an any value which allows any kind of value')]
class AnyPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
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

#[Description('Represents a generic value which can be replaced with a dynamic type')]
class GenericPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('The generic name, it is recommended to use typical generics names like T or TValue')]
    protected ?string $name = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('name', $this->name);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('Represents a reference to a definition type')]
class ReferencePropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('Name of the target reference, must a key from the definitions map')]
    protected ?string $target = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setTarget(?string $target) : void
    {
        $this->target = $target;
    }
    public function getTarget() : ?string
    {
        return $this->target;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('target', $this->target);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Description;

#[Description('')]
class Specification implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    /**
     * @var \PSX\Record\Record|null
     */
    #[Description('')]
    protected ?\PSX\Record\Record $import = null;
    /**
     * @var \PSX\Record\Record|null
     */
    #[Description('')]
    protected ?\PSX\Record\Record $definitions = null;
    #[Description('')]
    protected ?string $root = null;
    public function setImport(?\PSX\Record\Record $import) : void
    {
        $this->import = $import;
    }
    public function getImport() : ?\PSX\Record\Record
    {
        return $this->import;
    }
    public function setDefinitions(?\PSX\Record\Record $definitions) : void
    {
        $this->definitions = $definitions;
    }
    public function getDefinitions() : ?\PSX\Record\Record
    {
        return $this->definitions;
    }
    public function setRoot(?string $root) : void
    {
        $this->root = $root;
    }
    public function getRoot() : ?string
    {
        return $this->root;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('import', $this->import);
        $record->put('definitions', $this->definitions);
        $record->put('root', $this->root);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
