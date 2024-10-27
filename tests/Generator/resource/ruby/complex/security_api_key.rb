class SecurityApiKey
  extend Security
  attr_accessor :name, :in

  def initialize(name, in)
    @name = name
    @in = in
  end
end

