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
    attr_accessor :additional_properties, :max_properties, :min_properties

    def initialize(additional_properties, max_properties, min_properties)
        @additional_properties = additional_properties
        @max_properties = max_properties
        @min_properties = min_properties
    end
end

# Array properties
class ArrayProperties
    attr_accessor :type, :items, :max_items, :min_items, :unique_items

    def initialize(type, items, max_items, min_items, unique_items)
        @type = type
        @items = items
        @max_items = max_items
        @min_items = min_items
        @unique_items = unique_items
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
    attr_accessor :type, :multiple_of, :maximum, :exclusive_maximum, :minimum, :exclusive_minimum

    def initialize(type, multiple_of, maximum, exclusive_maximum, minimum, exclusive_minimum)
        @type = type
        @multiple_of = multiple_of
        @maximum = maximum
        @exclusive_maximum = exclusive_maximum
        @minimum = minimum
        @exclusive_minimum = exclusive_minimum
    end
end

# String properties
class StringProperties
    attr_accessor :type, :max_length, :min_length, :pattern

    def initialize(type, max_length, min_length, pattern)
        @type = type
        @max_length = max_length
        @min_length = min_length
        @pattern = pattern
    end
end

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator
    attr_accessor :property_name, :mapping

    def initialize(property_name, mapping)
        @property_name = property_name
        @mapping = mapping
    end
end

# An intersection type combines multiple schemas into one
class AllOfProperties
    attr_accessor :description, :all_of

    def initialize(description, all_of)
        @description = description
        @all_of = all_of
    end
end

# An union type can contain one of the provided schemas
class OneOfProperties
    attr_accessor :description, :discriminator, :one_of

    def initialize(description, discriminator, one_of)
        @description = description
        @discriminator = discriminator
        @one_of = one_of
    end
end

# Represents a reference to another schema
class ReferenceType
    attr_accessor :_ref, :_template

    def initialize(_ref, _template)
        @_ref = _ref
        @_template = _template
    end
end

# Represents a generic type
class GenericType
    attr_accessor :_generic

    def initialize(_generic)
        @_generic = _generic
    end
end

# TypeSchema meta schema which describes a TypeSchema
class TypeSchema
    attr_accessor :_import, :title, :description, :type, :definitions, :properties, :required

    def initialize(_import, title, description, type, definitions, properties, required)
        @_import = _import
        @title = title
        @description = description
        @type = type
        @definitions = definitions
        @properties = properties
        @required = required
    end
end
