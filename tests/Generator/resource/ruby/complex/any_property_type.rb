
# Represents an any value which allows any kind of value
class AnyPropertyType
  extend PropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

