class SecurityOAuth
  extend Security
  attr_accessor :authorization_url, :scopes, :token_url

  def initialize(authorization_url, scopes, token_url)
    @authorization_url = authorization_url
    @scopes = scopes
    @token_url = token_url
  end
end

