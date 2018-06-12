///////////////////
//polyfill JS File
// by mozzilla 
///////////////////

//polyfill for IE support because it's shit and I hate it. 
	if (!Object.entries)
  Object.entries = function( obj ){
    var ownProps = Object.keys( obj ),
        i = ownProps.length,
        resArray = new Array(i); // preallocate the Array
    while (i--)
      resArray[i] = [ownProps[i], obj[ownProps[i]]];

    return resArray;
  };






