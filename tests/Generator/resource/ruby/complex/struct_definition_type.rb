
# A struct represents a class/structure with a fix set of defined properties.
class StructDefinitionType
  extend DefinitionType
  attr_accessor :base, :discriminator, :mapping, :parent, :properties

  def initialize(base, discriminator, mapping, parent, properties)
    @base = base
    @discriminator = discriminator
    @mapping = mapping
    @parent = parent
    @properties = properties
  end
end

