# Base definition type
class DefinitionType
  attr_accessor :description, :deprecated, :type

  def initialize(description, deprecated, type)
    @description = description
    @deprecated = deprecated
    @type = type
  end
end

# Represents a struct which contains a fixed set of defined properties
class StructDefinitionType
  extend DefinitionType
  attr_accessor :type, :parent, :base, :properties, :discriminator, :mapping, :template

  def initialize(type, parent, base, properties, discriminator, mapping, template)
    @type = type
    @parent = parent
    @base = base
    @properties = properties
    @discriminator = discriminator
    @mapping = mapping
    @template = template
  end
end

# Base type for the map and array collection type
class CollectionDefinitionType
  extend DefinitionType
  attr_accessor :type, :schema

  def initialize(type, schema)
    @type = type
    @schema = schema
  end
end

# Represents a map which contains a dynamic set of key value entries
class MapDefinitionType
  extend CollectionDefinitionType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents an array which contains a dynamic list of values
class ArrayDefinitionType
  extend CollectionDefinitionType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Base property type
class PropertyType
  attr_accessor :description, :deprecated, :type, :nullable

  def initialize(description, deprecated, type, nullable)
    @description = description
    @deprecated = deprecated
    @type = type
    @nullable = nullable
  end
end

# Base scalar property type
class ScalarPropertyType
  extend PropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents an integer value
class IntegerPropertyType
  extend ScalarPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents a float value
class NumberPropertyType
  extend ScalarPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents a string value
class StringPropertyType
  extend ScalarPropertyType
  attr_accessor :type, :format

  def initialize(type, format)
    @type = type
    @format = format
  end
end

# Represents a boolean value
class BooleanPropertyType
  extend ScalarPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Base collection property type
class CollectionPropertyType
  extend PropertyType
  attr_accessor :type, :schema

  def initialize(type, schema)
    @type = type
    @schema = schema
  end
end

# Represents a map which contains a dynamic set of key value entries
class MapPropertyType
  extend CollectionPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents an array which contains a dynamic list of values
class ArrayPropertyType
  extend CollectionPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents an any value which allows any kind of value
class AnyPropertyType
  extend PropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

# Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType
  extend PropertyType
  attr_accessor :type, :name

  def initialize(type, name)
    @type = type
    @name = name
  end
end

# Represents a reference to a definition type
class ReferencePropertyType
  extend PropertyType
  attr_accessor :type, :target

  def initialize(type, target)
    @type = type
    @target = target
  end
end

class Specification
  attr_accessor :import, :definitions, :root

  def initialize(import, definitions, root)
    @import = import
    @definitions = definitions
    @root = root
  end
end
