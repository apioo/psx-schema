
# Represents a map which contains a dynamic set of key value entries of the same type
class MapDefinitionType
  extend CollectionDefinitionType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

