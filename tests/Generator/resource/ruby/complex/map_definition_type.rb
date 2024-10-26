
# Represents a map which contains a dynamic set of key value entries
class MapDefinitionType
  extend CollectionDefinitionType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

