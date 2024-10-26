
# Base collection property type
class CollectionPropertyType
  extend PropertyType
  attr_accessor :type, :schema

  def initialize(type, schema)
    @type = type
    @schema = schema
  end
end

