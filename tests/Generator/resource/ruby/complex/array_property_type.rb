
# Represents an array which contains a dynamic list of values
class ArrayPropertyType
  extend CollectionPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

