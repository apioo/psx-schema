class Operation
  attr_accessor :method, :path, :_return, :arguments, :throws, :description, :stability, :security, :authorization, :tags

  def initialize(method, path, _return, arguments, throws, description, stability, security, authorization, tags)
    @method = method
    @path = path
    @_return = _return
    @arguments = arguments
    @throws = throws
    @description = description
    @stability = stability
    @security = security
    @authorization = authorization
    @tags = tags
  end
end

