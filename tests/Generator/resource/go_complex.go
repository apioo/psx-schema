// Common properties which can be used at any schema
type CommonProperties struct {
    Title string `json:"title"`
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
}

type ScalarProperties struct {
    Format string `json:"format"`
    Enum interface{} `json:"enum"`
    Default interface{} `json:"default"`
}

// Properties of a schema
type Properties = map[string]PropertyValue

// Properties specific for a container
type ContainerProperties struct {
    Type string `json:"type"`
}

// Struct specific properties
type StructProperties struct {
    Properties Properties `json:"properties"`
    Required []string `json:"required"`
}

// Map specific properties
type MapProperties struct {
    AdditionalProperties interface{} `json:"additionalProperties"`
    MaxProperties int `json:"maxProperties"`
    MinProperties int `json:"minProperties"`
}

// Array properties
type ArrayProperties struct {
    Type string `json:"type"`
    Items interface{} `json:"items"`
    MaxItems int `json:"maxItems"`
    MinItems int `json:"minItems"`
    UniqueItems bool `json:"uniqueItems"`
}

// Boolean properties
type BooleanProperties struct {
    Type string `json:"type"`
}

// Number properties
type NumberProperties struct {
    Type string `json:"type"`
    MultipleOf float64 `json:"multipleOf"`
    Maximum float64 `json:"maximum"`
    ExclusiveMaximum bool `json:"exclusiveMaximum"`
    Minimum float64 `json:"minimum"`
    ExclusiveMinimum bool `json:"exclusiveMinimum"`
}

// String properties
type StringProperties struct {
    Type string `json:"type"`
    MaxLength int `json:"maxLength"`
    MinLength int `json:"minLength"`
    Pattern string `json:"pattern"`
}

// An object to hold mappings between payload values and schema names or references
type DiscriminatorMapping = map[string]string

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
type Discriminator struct {
    PropertyName string `json:"propertyName"`
    Mapping DiscriminatorMapping `json:"mapping"`
}

// An intersection type combines multiple schemas into one
type AllOfProperties struct {
    Description string `json:"description"`
    AllOf []OfValue `json:"allOf"`
}

// An union type can contain one of the provided schemas
type OneOfProperties struct {
    Description string `json:"description"`
    Discriminator Discriminator `json:"discriminator"`
    OneOf []OfValue `json:"oneOf"`
}

type TemplateProperties = map[string]ReferenceType

// Represents a reference to another schema
type ReferenceType struct {
    Ref string `json:"$ref"`
    Template TemplateProperties `json:"$template"`
}

// Represents a generic type
type GenericType struct {
    Generic string `json:"$generic"`
}

// Schema definitions which can be reused
type Definitions = map[string]DefinitionValue

// Contains external definitions which are imported. The imported schemas can be used via the namespace
type Import = map[string]string

// TypeSchema meta schema which describes a TypeSchema
type TypeSchema struct {
    Import Import `json:"$import"`
    Title string `json:"title"`
    Description string `json:"description"`
    Type string `json:"type"`
    Definitions Definitions `json:"definitions"`
    Properties Properties `json:"properties"`
    Required []string `json:"required"`
}
