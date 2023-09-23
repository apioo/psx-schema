# Represents a base type. Every type extends from this common type and shares the defined properties
class CommonType
    attr_accessor :description, :type, :nullable, :deprecated, :readonly

    def initialize(description, type, nullable, deprecated, readonly)
        @description = description
        @type = type
        @nullable = nullable
        @deprecated = deprecated
        @readonly = readonly
    end
end

# Represents an any type
class AnyType
    extend CommonType
    attr_accessor :type

    def initialize(type)
        @type = type
    end
end

# Represents an array type. An array type contains an ordered list of a specific type
class ArrayType
    extend CommonType
    attr_accessor :type, :items, :max_items, :min_items

    def initialize(type, items, max_items, min_items)
        @type = type
        @items = items
        @max_items = max_items
        @min_items = min_items
    end
end

# Represents a scalar type
class ScalarType
    extend CommonType
    attr_accessor :format, :enum, :default

    def initialize(format, enum, default)
        @format = format
        @enum = enum
        @default = default
    end
end

# Represents a boolean type
class BooleanType
    extend ScalarType
    attr_accessor :type

    def initialize(type)
        @type = type
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

# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
class GenericType
    attr_accessor :_generic

    def initialize(_generic)
        @_generic = _generic
    end
end

# Represents an intersection type
class IntersectionType
    attr_accessor :description, :all_of

    def initialize(description, all_of)
        @description = description
        @all_of = all_of
    end
end

# Represents a map type. A map type contains variable key value entries of a specific type
class MapType
    extend CommonType
    attr_accessor :type, :additional_properties, :max_properties, :min_properties

    def initialize(type, additional_properties, max_properties, min_properties)
        @type = type
        @additional_properties = additional_properties
        @max_properties = max_properties
        @min_properties = min_properties
    end
end

# Represents a number type (contains also integer)
class NumberType
    extend ScalarType
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

# Represents a reference type. A reference type points to a specific type at the definitions map
class ReferenceType
    attr_accessor :_ref, :_template

    def initialize(_ref, _template)
        @_ref = _ref
        @_template = _template
    end
end

# Represents a string type
class StringType
    extend ScalarType
    attr_accessor :type, :max_length, :min_length, :pattern

    def initialize(type, max_length, min_length, pattern)
        @type = type
        @max_length = max_length
        @min_length = min_length
        @pattern = pattern
    end
end

# Represents a struct type. A struct type contains a fix set of defined properties
class StructType
    extend CommonType
    attr_accessor :_final, :_extends, :type, :properties, :required

    def initialize(_final, _extends, type, properties, required)
        @_final = _final
        @_extends = _extends
        @type = type
        @properties = properties
        @required = required
    end
end

# The root TypeSchema
class TypeSchema
    attr_accessor :_import, :definitions, :_ref

    def initialize(_import, definitions, _ref)
        @_import = _import
        @definitions = definitions
        @_ref = _ref
    end
end

# Represents an union type. An union type can contain one of the provided types
class UnionType
    attr_accessor :description, :discriminator, :one_of

    def initialize(description, discriminator, one_of)
        @description = description
        @discriminator = discriminator
        @one_of = one_of
    end
end
