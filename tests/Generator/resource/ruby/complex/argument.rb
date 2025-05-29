
# Describes arguments of the operation
class Argument
  attr_accessor :content_type, :in, :name, :schema

  def initialize(content_type, in, name, schema)
    @content_type = content_type
    @in = in
    @name = name
    @schema = schema
  end
end

