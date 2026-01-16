
# Represents a generic value which can be replaced with a concrete type
class GenericPropertyType
  extend PropertyType
  attr_accessor :name, :type

  def initialize(name, type)
    @name = name
    @type = type
  end
end

