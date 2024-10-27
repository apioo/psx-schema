
# Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType
  extend PropertyType
  attr_accessor :name

  def initialize(name)
    @name = name
  end
end

