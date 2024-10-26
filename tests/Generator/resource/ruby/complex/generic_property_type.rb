
# Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType
  extend PropertyType
  attr_accessor :type, :name

  def initialize(type, name)
    @type = type
    @name = name
  end
end

