
# Base collection property type
class CollectionPropertyType
  extend PropertyType
  attr_accessor :schema, :type

  def initialize(schema, type)
    @schema = schema
    @type = type
  end
end

