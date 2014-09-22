$(document).ready(function() {
  Handlebars.registerHelper("debug", function(optionalValue) {
    console.log("Current Context");
    console.log("====================");
    console.log(this);

    if (optionalValue) {
      console.log("Value");
      console.log("====================");
      console.log(optionalValue);
    }
  });

  Handlebars.registerHelper('trimS', function(passedString, start, length ){
    var mlength = length,preS='',tailS='';
    if(start>0 && passedString.length>3){
      var preS= '...';
      mlength = length -3;
    };
    if(passedString.length>(start + length )){
      tailS = '...';
      mlength = mlength -3;
    };
    var theString = preS + passedString.substr(start, mlength) + tailS;
      return new Handlebars.SafeString(theString);
  });
});