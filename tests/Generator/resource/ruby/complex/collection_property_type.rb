
# Base collection property type
class CollectionPropertyType
  extend PropertyType
  attr_accessor :schema

  def initialize(schema)
    @schema = schema
  end
end

