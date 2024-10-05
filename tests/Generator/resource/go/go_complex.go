// Base definition type
type DefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
}

// Represents a struct which contains a fixed set of defined properties
type StructDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Parent string `json:"parent"`
    Base bool `json:"base"`
    Properties map[string]PropertyType `json:"properties"`
    Discriminator string `json:"discriminator"`
    Mapping map[string]string `json:"mapping"`
    Template map[string]string `json:"template"`
}

// Base type for the map and array collection type
type CollectionDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

// Represents a map which contains a dynamic set of key value entries
type MapDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

// Represents an array which contains a dynamic list of values
type ArrayDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

// Base property type
type PropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
}

// Base scalar property type
type ScalarPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
}

// Represents an integer value
type IntegerPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
}

// Represents a float value
type NumberPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
}

// Represents a string value
type StringPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Format string `json:"format"`
}

// Represents a boolean value
type BooleanPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
}

// Base collection property type
type CollectionPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

// Represents a map which contains a dynamic set of key value entries
type MapPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

// Represents an array which contains a dynamic list of values
type ArrayPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

// Represents an any value which allows any kind of value
type AnyPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
}

// Represents a generic value which can be replaced with a dynamic type
type GenericPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Name string `json:"name"`
}

// Represents a reference to a definition type
type ReferencePropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Target string `json:"target"`
}

type Specification struct {
    Import map[string]string `json:"import"`
    Definitions map[string]DefinitionType `json:"definitions"`
    Root string `json:"root"`
}
