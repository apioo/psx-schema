
# Represents a map which contains a dynamic set of key value entries of the same type
class MapPropertyType
  extend CollectionPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

