
# Base collection type
class CollectionDefinitionType
  extend DefinitionType
  attr_accessor :schema

  def initialize(schema)
    @schema = schema
  end
end

