class Operation
  attr_accessor :arguments, :authorization, :description, :method, :path, :_return, :security, :stability, :throws

  def initialize(arguments, authorization, description, method, path, _return, security, stability, throws)
    @arguments = arguments
    @authorization = authorization
    @description = description
    @method = method
    @path = path
    @_return = _return
    @security = security
    @stability = stability
    @throws = throws
  end
end

