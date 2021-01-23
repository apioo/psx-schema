

// Common properties which can be used at any schema

// CommonProperties
type CommonProperties struct {
    Title string `json:"title"`
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
}



// ScalarProperties
type ScalarProperties struct {
    Format string `json:"format"`
    Enum interface{} `json:"enum"`
    Default interface{} `json:"default"`
}



// Properties specific for a container

// ContainerProperties
type ContainerProperties struct {
    Type string `json:"type"`
}



// Struct specific properties

// StructProperties
type StructProperties struct {
    Properties map[string]PropertyValue `json:"properties"`
    Required []string `json:"required"`
}



// Map specific properties

// MapProperties
type MapProperties struct {
    AdditionalProperties interface{} `json:"additionalProperties"`
    MaxProperties int `json:"maxProperties"`
    MinProperties int `json:"minProperties"`
}



// Array properties

// ArrayProperties
type ArrayProperties struct {
    Type string `json:"type"`
    Items interface{} `json:"items"`
    MaxItems int `json:"maxItems"`
    MinItems int `json:"minItems"`
    UniqueItems bool `json:"uniqueItems"`
}



// Boolean properties

// BooleanProperties
type BooleanProperties struct {
    Type string `json:"type"`
}



// Number properties

// NumberProperties
type NumberProperties struct {
    Type string `json:"type"`
    MultipleOf float64 `json:"multipleOf"`
    Maximum float64 `json:"maximum"`
    ExclusiveMaximum bool `json:"exclusiveMaximum"`
    Minimum float64 `json:"minimum"`
    ExclusiveMinimum bool `json:"exclusiveMinimum"`
}



// String properties

// StringProperties
type StringProperties struct {
    Type string `json:"type"`
    MaxLength int `json:"maxLength"`
    MinLength int `json:"minLength"`
    Pattern string `json:"pattern"`
}



// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description

// Discriminator
type Discriminator struct {
    PropertyName string `json:"propertyName"`
    Mapping map[string]string `json:"mapping"`
}



// An intersection type combines multiple schemas into one

// AllOfProperties
type AllOfProperties struct {
    Description string `json:"description"`
    AllOf []OfValue `json:"allOf"`
}



// An union type can contain one of the provided schemas

// OneOfProperties
type OneOfProperties struct {
    Description string `json:"description"`
    Discriminator Discriminator `json:"discriminator"`
    OneOf []OfValue `json:"oneOf"`
}



// Represents a reference to another schema

// ReferenceType
type ReferenceType struct {
    Ref string `json:"$ref"`
    Template map[string]ReferenceType `json:"$template"`
}



// Represents a generic type

// GenericType
type GenericType struct {
    Generic string `json:"$generic"`
}



// TypeSchema meta schema which describes a TypeSchema

// TypeSchema
type TypeSchema struct {
    Import map[string]string `json:"$import"`
    Title string `json:"title"`
    Description string `json:"description"`
    Type string `json:"type"`
    Definitions map[string]DefinitionValue `json:"definitions"`
    Properties map[string]PropertyValue `json:"properties"`
    Required []string `json:"required"`
}
