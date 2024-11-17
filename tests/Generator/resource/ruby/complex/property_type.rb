
# Base property type
class PropertyType
  attr_accessor :deprecated, :description, :nullable, :type

  def initialize(deprecated, description, nullable, type)
    @deprecated = deprecated
    @description = description
    @nullable = nullable
    @type = type
  end
end

