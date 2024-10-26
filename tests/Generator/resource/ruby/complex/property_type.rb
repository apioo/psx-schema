
# Base property type
class PropertyType
  attr_accessor :description, :deprecated, :type, :nullable

  def initialize(description, deprecated, type, nullable)
    @description = description
    @deprecated = deprecated
    @type = type
    @nullable = nullable
  end
end

