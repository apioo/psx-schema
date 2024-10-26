
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

