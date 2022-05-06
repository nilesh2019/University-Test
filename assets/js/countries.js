var country_arr = new Array("India");

// States
var s_a = new Array();
s_a[0]="";
s_a[1]="Maharashtra";

// City
var c_a = new Array();

c_a[0]="";
c_a[1]="Mumbai | Pune";
function populateCountries(countryElementId, stateElementId, cityElementId){
	// given the id of the <select> tag as function argument, it inserts <option> tags
	var countryElement = document.getElementById(countryElementId);
	countryElement.length=0;
	countryElement.options[0] = new Option('Select Country','-1');
	countryElement.selectedIndex = 0;
	for (var i=0; i<country_arr.length; i++) {
		countryElement.options[countryElement.length] = new Option(country_arr[i],country_arr[i]);
	}
	// Assigned all countries. Now assign event listener for the states.

	if( stateElementId ){
		countryElement.onchange = function(){
			populateStates( countryElementId, stateElementId, cityElementId );
		};
	}
}

function populateStates( countryElementId, stateElementId, cityElementId)
{	
	var selectedCountryIndex = document.getElementById( countryElementId ).selectedIndex;
	var stateElement = document.getElementById( stateElementId );	
	stateElement.length=0;
	stateElement.options[0] = new Option('Select State','');
	stateElement.selectedIndex = 0;	
	var state_arr = s_a[selectedCountryIndex].split("|");
	
	for (var i=0; i<state_arr.length; i++) {
		stateElement.options[stateElement.length] = new Option(state_arr[i],state_arr[i]);
	}
	
	if( cityElementId )
	{
		stateElement.onchange = function(){
			populateCities( countryElementId, stateElementId, cityElementId );
		};
	}
}

function populateCities( countryElementId, stateElementId, cityElementId)
{	
	var selectedStateIndex = document.getElementById( stateElementId ).selectedIndex;
	var cityElement = document.getElementById( cityElementId );	
	cityElement.length=0;
	cityElement.options[0] = new Option('Select City','');
	cityElement.selectedIndex = 0;	
	var city_arr = c_a[selectedStateIndex].split("|");
	
	for (var i=0; i<city_arr.length; i++) {
		cityElement.options[cityElement.length] = new Option(city_arr[i],city_arr[i]);
	}
}