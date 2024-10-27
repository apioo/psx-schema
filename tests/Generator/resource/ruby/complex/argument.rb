class Argument
  attr_accessor :in, :schema, :content_type, :name

  def initialize(in, schema, content_type, name)
    @in = in
    @schema = schema
    @content_type = content_type
    @name = name
  end
end

