/**
 * Common properties which can be used at any schema
 */
interface CommonProperties {
    title?: string
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

interface ScalarProperties {
    format?: string
    enum?: EnumValue
    default?: ScalarValue
}

type PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

type Properties = Record<string, PropertyValue>;

/**
 * Properties specific for a container
 */
interface ContainerProperties {
    type: string
}

/**
 * Struct specific properties
 */
interface StructProperties {
    properties: Properties
    required?: StringArray
}

type StructType = CommonProperties & ContainerProperties & StructProperties;

/**
 * Map specific properties
 */
interface MapProperties {
    additionalProperties: PropertyValue
    maxProperties?: number
    minProperties?: number
}

type MapType = CommonProperties & ContainerProperties & MapProperties;

type ObjectType = StructType | MapType;

type ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

/**
 * Array properties
 */
interface ArrayProperties {
    type: string
    items: ArrayValue
    maxItems?: number
    minItems?: number
    uniqueItems?: boolean
}

type ArrayType = CommonProperties & ArrayProperties;

/**
 * Boolean properties
 */
interface BooleanProperties {
    type: string
}

type BooleanType = CommonProperties & ScalarProperties & BooleanProperties;

/**
 * Number properties
 */
interface NumberProperties {
    type: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

type NumberType = CommonProperties & ScalarProperties & NumberProperties;

/**
 * String properties
 */
interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

type StringType = CommonProperties & ScalarProperties & StringProperties;

type OfValue = NumberType | StringType | BooleanType | ReferenceType;

type DiscriminatorMapping = Record<string, string>;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

/**
 * An intersection type combines multiple schemas into one
 */
interface AllOfProperties {
    description?: string
    allOf: Array<OfValue>
}

/**
 * An union type can contain one of the provided schemas
 */
interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<OfValue>
}

type CombinationType = AllOfProperties | OneOfProperties;

type TemplateProperties = Record<string, ReferenceType>;

/**
 * Represents a reference to another schema
 */
interface ReferenceType {
    ref: string
    template?: TemplateProperties
}

/**
 * Represents a generic type
 */
interface GenericType {
    generic: string
}

type DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;

type Definitions = Record<string, DefinitionValue>;

type Import = Record<string, string>;

type EnumValue = StringArray | NumberArray;

type ScalarValue = string | number | boolean;

type StringArray = Array<string>;

type NumberArray = Array<number>;

/**
 * TypeSchema meta schema which describes a TypeSchema
 */
interface TypeSchema {
    import?: Import
    title: string
    description?: string
    type: string
    definitions?: Definitions
    properties: Properties
    required?: StringArray
}
