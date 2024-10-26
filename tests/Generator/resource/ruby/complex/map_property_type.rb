
# Represents a map which contains a dynamic set of key value entries
class MapPropertyType
  extend CollectionPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

