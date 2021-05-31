# Common properties which can be used at any schema
class CommonProperties
    attr_accessor :title, :description, :type, :nullable, :deprecated, :readonly

    def initialize(title, description, type, nullable, deprecated, readonly)
        @title = title
        @description = description
        @type = type
        @nullable = nullable
        @deprecated = deprecated
        @readonly = readonly
    end
end

class ScalarProperties
    attr_accessor :format, :enum, :default

    def initialize(format, enum, default)
        @format = format
        @enum = enum
        @default = default
    end
end

# Properties specific for a container
class ContainerProperties
    attr_accessor :type

    def initialize(type)
        @type = type
    end
end

# Struct specific properties
class StructProperties
    attr_accessor :properties, :required

    def initialize(properties, required)
        @properties = properties
        @required = required
    end
end

# Map specific properties
class MapProperties
    attr_accessor :additionalProperties, :maxProperties, :minProperties

    def initialize(additionalProperties, maxProperties, minProperties)
        @additionalProperties = additionalProperties
        @maxProperties = maxProperties
        @minProperties = minProperties
    end
end

# Array properties
class ArrayProperties
    attr_accessor :type, :items, :maxItems, :minItems, :uniqueItems

    def initialize(type, items, maxItems, minItems, uniqueItems)
        @type = type
        @items = items
        @maxItems = maxItems
        @minItems = minItems
        @uniqueItems = uniqueItems
    end
end

# Boolean properties
class BooleanProperties
    attr_accessor :type

    def initialize(type)
        @type = type
    end
end

# Number properties
class NumberProperties
    attr_accessor :type, :multipleOf, :maximum, :exclusiveMaximum, :minimum, :exclusiveMinimum

    def initialize(type, multipleOf, maximum, exclusiveMaximum, minimum, exclusiveMinimum)
        @type = type
        @multipleOf = multipleOf
        @maximum = maximum
        @exclusiveMaximum = exclusiveMaximum
        @minimum = minimum
        @exclusiveMinimum = exclusiveMinimum
    end
end

# String properties
class StringProperties
    attr_accessor :type, :maxLength, :minLength, :pattern

    def initialize(type, maxLength, minLength, pattern)
        @type = type
        @maxLength = maxLength
        @minLength = minLength
        @pattern = pattern
    end
end

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator
    attr_accessor :propertyName, :mapping

    def initialize(propertyName, mapping)
        @propertyName = propertyName
        @mapping = mapping
    end
end

# An intersection type combines multiple schemas into one
class AllOfProperties
    attr_accessor :description, :allOf

    def initialize(description, allOf)
        @description = description
        @allOf = allOf
    end
end

# An union type can contain one of the provided schemas
class OneOfProperties
    attr_accessor :description, :discriminator, :oneOf

    def initialize(description, discriminator, oneOf)
        @description = description
        @discriminator = discriminator
        @oneOf = oneOf
    end
end

# Represents a reference to another schema
class ReferenceType
    attr_accessor :ref, :template

    def initialize(ref, template)
        @ref = ref
        @template = template
    end
end

# Represents a generic type
class GenericType
    attr_accessor :generic

    def initialize(generic)
        @generic = generic
    end
end

# TypeSchema meta schema which describes a TypeSchema
class TypeSchema
    attr_accessor :import, :title, :description, :type, :definitions, :properties, :required

    def initialize(import, title, description, type, definitions, properties, required)
        @import = import
        @title = title
        @description = description
        @type = type
        @definitions = definitions
        @properties = properties
        @required = required
    end
end
