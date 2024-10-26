
# Base type for the map and array collection type
class CollectionDefinitionType
  extend DefinitionType
  attr_accessor :type, :schema

  def initialize(type, schema)
    @type = type
    @schema = schema
  end
end

