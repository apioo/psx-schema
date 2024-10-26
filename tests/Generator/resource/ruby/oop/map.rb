class Map
  attr_accessor :total_results, :parent, :entries

  def initialize(total_results, parent, entries)
    @total_results = total_results
    @parent = parent
    @entries = entries
  end
end

