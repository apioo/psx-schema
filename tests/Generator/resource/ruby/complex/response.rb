class Response
  attr_accessor :code, :content_type, :schema

  def initialize(code, content_type, schema)
    @code = code
    @content_type = content_type
    @schema = schema
  end
end

