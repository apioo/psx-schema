# CommonType

Represents a base type. Every type extends from this common type and shares the defined properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String | General description of this type, should not contain any new lines. | 
type | String | Type of the property | 
nullable | Boolean | Indicates whether it is possible to use a null value | 
deprecated | Boolean | Indicates whether this type is deprecated | 
readonly | Boolean | Indicates whether this type is readonly |

# StructType

Represents a struct type. A struct type contains a fix set of defined properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
final | Boolean | Indicates that a struct is final, this means it is not possible to extend this struct | 
extends | String | Extends an existing type with the referenced type | 
type | String | **REQUIRED**.  | 
properties | Properties | **REQUIRED**.  | 
required | Array (String) |  |

# Properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (BooleanType &#124; NumberType &#124; StringType &#124; ArrayType &#124; UnionType &#124; IntersectionType &#124; ReferenceType &#124; GenericType &#124; AnyType) |  |

# MapType

Represents a map type. A map type contains variable key value entries of a specific type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
additionalProperties | BooleanType &#124; NumberType &#124; StringType &#124; ArrayType &#124; UnionType &#124; IntersectionType &#124; ReferenceType &#124; GenericType &#124; AnyType | **REQUIRED**.  | 
maxProperties | Integer | Positive integer value | 
minProperties | Integer | Positive integer value |

# ArrayType

Represents an array type. An array type contains an ordered list of a specific type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
items | BooleanType &#124; NumberType &#124; StringType &#124; ReferenceType &#124; GenericType &#124; AnyType | **REQUIRED**.  | 
maxItems | Integer | Positive integer value | 
minItems | Integer | Positive integer value |

# ScalarType

Represents a scalar type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
format | String | Describes the specific format of this type i.e. date-time or int64 | 
enum | Array (String &#124; Number) |  | 
default | String &#124; Number &#124; Boolean |  |

# BooleanType

Represents a boolean type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  |

# NumberType

Represents a number type (contains also integer)

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
multipleOf | Number |  | 
maximum | Number |  | 
exclusiveMaximum | Boolean |  | 
minimum | Number |  | 
exclusiveMinimum | Boolean |  |

# StringType

Represents a string type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
maxLength | Integer | Positive integer value | 
minLength | Integer | Positive integer value | 
pattern | String |  |

# AnyType

Represents an any type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  |

# IntersectionType

Represents an intersection type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
allOf | Array (ReferenceType) | **REQUIRED**. Contains an array of references. The reference must only point to a struct type |

# UnionType

Represents an union type. An union type can contain one of the provided types

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
discriminator | Discriminator |  | 
oneOf | Array (NumberType &#124; StringType &#124; BooleanType &#124; ReferenceType) | **REQUIRED**. Contains an array of references. The reference must only point to a struct type |

# DiscriminatorMapping

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (String) |  |

# Discriminator

Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
propertyName | String | **REQUIRED**. The name of the property in the payload that will hold the discriminator value | 
mapping | DiscriminatorMapping |  |

# ReferenceType

Represents a reference type. A reference type points to a specific type at the definitions map

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
ref | String | **REQUIRED**. Reference to a type under the definitions map | 
template | TemplateProperties | Optional concrete type definitions which replace generic template types |

# TemplateProperties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (String) |  |

# GenericType

Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
generic | String | **REQUIRED**.  |

# Definitions

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (StructType &#124; MapType &#124; ReferenceType) |  |

# Import

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (String) |  |

# TypeSchema

The root TypeSchema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
import | Import |  | 
definitions | Definitions | **REQUIRED**.  | 
ref | String | Reference to a root schema under the definitions key |
