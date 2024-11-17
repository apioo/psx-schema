
# Base collection type
class CollectionDefinitionType
  extend DefinitionType
  attr_accessor :schema, :type

  def initialize(schema, type)
    @schema = schema
    @type = type
  end
end

