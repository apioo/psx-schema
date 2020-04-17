// CommonProperties Common properties which can be used at any schema
type CommonProperties struct {
    title string `json:"title"`
    description string `json:"description"`
    type string `json:"type"`
    nullable bool `json:"nullable"`
    deprecated bool `json:"deprecated"`
    readonly bool `json:"readonly"`
}

// ScalarProperties
type ScalarProperties struct {
    format string `json:"format"`
    enum interface{} `json:"enum"`
    default interface{} `json:"default"`
}

// ContainerProperties Properties specific for a container
type ContainerProperties struct {
    type string `json:"type"`
}

// StructProperties Struct specific properties
type StructProperties struct {
    properties map[string]PropertyValue `json:"properties"`
    required []string `json:"required"`
}

// MapProperties Map specific properties
type MapProperties struct {
    additionalProperties interface{} `json:"additionalProperties"`
    maxProperties int `json:"maxProperties"`
    minProperties int `json:"minProperties"`
}

// ArrayProperties Array properties
type ArrayProperties struct {
    type string `json:"type"`
    items interface{} `json:"items"`
    maxItems int `json:"maxItems"`
    minItems int `json:"minItems"`
    uniqueItems bool `json:"uniqueItems"`
}

// BooleanProperties Boolean properties
type BooleanProperties struct {
    type string `json:"type"`
}

// NumberProperties Number properties
type NumberProperties struct {
    type string `json:"type"`
    multipleOf float64 `json:"multipleOf"`
    maximum float64 `json:"maximum"`
    exclusiveMaximum bool `json:"exclusiveMaximum"`
    minimum float64 `json:"minimum"`
    exclusiveMinimum bool `json:"exclusiveMinimum"`
}

// StringProperties String properties
type StringProperties struct {
    type string `json:"type"`
    maxLength int `json:"maxLength"`
    minLength int `json:"minLength"`
    pattern string `json:"pattern"`
}

// Discriminator Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
type Discriminator struct {
    propertyName string `json:"propertyName"`
    mapping map[string]string `json:"mapping"`
}

// AllOfProperties An intersection type combines multiple schemas into one
type AllOfProperties struct {
    description string `json:"description"`
    allOf []OfValue `json:"allOf"`
}

// OneOfProperties An union type can contain one of the provided schemas
type OneOfProperties struct {
    description string `json:"description"`
    discriminator Discriminator `json:"discriminator"`
    oneOf []OfValue `json:"oneOf"`
}

// ReferenceType Represents a reference to another schema
type ReferenceType struct {
    ref string `json:"$ref"`
    template map[string]ReferenceType `json:"$template"`
}

// GenericType Represents a generic type
type GenericType struct {
    generic string `json:"$generic"`
}

// TypeSchema TypeSchema meta schema which describes a TypeSchema
type TypeSchema struct {
    import map[string]string `json:"$import"`
    title string `json:"title"`
    description string `json:"description"`
    type string `json:"type"`
    definitions map[string]DefinitionValue `json:"definitions"`
    properties map[string]PropertyValue `json:"properties"`
    required []string `json:"required"`
}
