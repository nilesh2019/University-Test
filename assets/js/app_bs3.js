var toolnames = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
    url: base_url+'assignment/get_tool_name',
    filter: function(list) {
      return $.map(list, function(cityname) {
        return { name: cityname }; });
    }
  }
});
toolnames.initialize();
var elt = $('.example_typeahead > > input');
elt.tagsinput({
  typeaheadjs: {
    name: 'toolnames',
    displayKey: 'name',
    valueKey: 'name',
    source: toolnames.ttAdapter()
  }
});


var featurenames = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
    url: base_url+'assignment/get_feature_name',
    filter: function(list) {
      return $.map(list, function(cityname) {
        return { name: cityname }; });
    }
  }
});
featurenames.initialize();
var elt = $('.example_typeahead1> > input');
elt.tagsinput({
  typeaheadjs: {
    name: 'featurenames',
    displayKey: 'name',
    valueKey: 'name',
    source: featurenames.ttAdapter()
  }
});



// HACK: overrule hardcoded display inline-block of typeahead.js
$(".twitter-typeahead").css('display', 'inline');
