// CommonProperties Common properties which can be used at any schema
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

// ContainerProperties Properties specific for a container
type ContainerProperties struct {
    Type string `json:"type"`
}

// StructProperties Struct specific properties
type StructProperties struct {
    Properties map[string]PropertyValue `json:"properties"`
    Required []string `json:"required"`
}

// MapProperties Map specific properties
type MapProperties struct {
    AdditionalProperties interface{} `json:"additionalProperties"`
    MaxProperties int `json:"maxProperties"`
    MinProperties int `json:"minProperties"`
}

// ArrayProperties Array properties
type ArrayProperties struct {
    Type string `json:"type"`
    Items interface{} `json:"items"`
    MaxItems int `json:"maxItems"`
    MinItems int `json:"minItems"`
    UniqueItems bool `json:"uniqueItems"`
}

// BooleanProperties Boolean properties
type BooleanProperties struct {
    Type string `json:"type"`
}

// NumberProperties Number properties
type NumberProperties struct {
    Type string `json:"type"`
    MultipleOf float64 `json:"multipleOf"`
    Maximum float64 `json:"maximum"`
    ExclusiveMaximum bool `json:"exclusiveMaximum"`
    Minimum float64 `json:"minimum"`
    ExclusiveMinimum bool `json:"exclusiveMinimum"`
}

// StringProperties String properties
type StringProperties struct {
    Type string `json:"type"`
    MaxLength int `json:"maxLength"`
    MinLength int `json:"minLength"`
    Pattern string `json:"pattern"`
}

// Discriminator Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
type Discriminator struct {
    PropertyName string `json:"propertyName"`
    Mapping map[string]string `json:"mapping"`
}

// AllOfProperties An intersection type combines multiple schemas into one
type AllOfProperties struct {
    Description string `json:"description"`
    AllOf []OfValue `json:"allOf"`
}

// OneOfProperties An union type can contain one of the provided schemas
type OneOfProperties struct {
    Description string `json:"description"`
    Discriminator Discriminator `json:"discriminator"`
    OneOf []OfValue `json:"oneOf"`
}

// ReferenceType Represents a reference to another schema
type ReferenceType struct {
    Ref string `json:"$ref"`
    Template map[string]ReferenceType `json:"$template"`
}

// GenericType Represents a generic type
type GenericType struct {
    Generic string `json:"$generic"`
}

// TypeSchema TypeSchema meta schema which describes a TypeSchema
type TypeSchema struct {
    Import map[string]string `json:"$import"`
    Title string `json:"title"`
    Description string `json:"description"`
    Type string `json:"type"`
    Definitions map[string]DefinitionValue `json:"definitions"`
    Properties map[string]PropertyValue `json:"properties"`
    Required []string `json:"required"`
}
