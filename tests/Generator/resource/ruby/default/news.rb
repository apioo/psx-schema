
# An general news entry
class News
  attr_accessor :config, :inline_config, :map_tags, :map_receiver, :tags, :receiver, :read, :author, :meta, :send_date, :read_date, :price, :rating, :content, :question, :version, :coffee_time, :captcha, :media_fields, :payload

  def initialize(config, inline_config, map_tags, map_receiver, tags, receiver, read, author, meta, send_date, read_date, price, rating, content, question, version, coffee_time, captcha, media_fields, payload)
    @config = config
    @inline_config = inline_config
    @map_tags = map_tags
    @map_receiver = map_receiver
    @tags = tags
    @receiver = receiver
    @read = read
    @author = author
    @meta = meta
    @send_date = send_date
    @read_date = read_date
    @price = price
    @rating = rating
    @content = content
    @question = question
    @version = version
    @coffee_time = coffee_time
    @captcha = captcha
    @media_fields = media_fields
    @payload = payload
  end
end

