class SecurityOAuth
  extend Security
  attr_accessor :token_url, :authorization_url, :scopes

  def initialize(token_url, authorization_url, scopes)
    @token_url = token_url
    @authorization_url = authorization_url
    @scopes = scopes
  end
end

