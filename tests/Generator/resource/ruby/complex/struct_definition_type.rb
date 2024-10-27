
# A struct represents a class/structure with a fix set of defined properties.
class StructDefinitionType
  extend DefinitionType
  attr_accessor :parent, :base, :properties, :discriminator, :mapping

  def initialize(parent, base, properties, discriminator, mapping)
    @parent = parent
    @base = base
    @properties = properties
    @discriminator = discriminator
    @mapping = mapping
  end
end

