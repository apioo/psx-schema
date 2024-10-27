
# Base property type
class PropertyType
  attr_accessor :description, :type, :deprecated, :nullable

  def initialize(description, type, deprecated, nullable)
    @description = description
    @type = type
    @deprecated = deprecated
    @nullable = nullable
  end
end

