
# A struct represents a class/structure with a fix set of defined properties
class StructDefinitionType
  extend DefinitionType
  attr_accessor :base, :discriminator, :mapping, :parent, :properties, :type

  def initialize(base, discriminator, mapping, parent, properties, type)
    @base = base
    @discriminator = discriminator
    @mapping = mapping
    @parent = parent
    @properties = properties
    @type = type
  end
end

