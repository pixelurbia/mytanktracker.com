///////////////////
//polyfill JS File
// by mozzilla 
///////////////////

//polyfill for IE support because it's shit and I hate it. 
	// if (!Object.entries)
 //  Object.entries = function( obj ){
 //    var ownProps = Object.keys( obj ),
 //        i = ownProps.length,
 //        resArray = new Array(i); // preallocate the Array
 //    while (i--)
 //      resArray[i] = [ownProps[i], obj[ownProps[i]]];

 //    return resArray;
 //  };


var assert = require('assert');
var entries = require('object.entries');

var obj = { a: 1, b: 2, c: 3 };
var expected = [['a', 1], ['b', 2], ['c', 3]];

if (typeof Symbol === 'function' && typeof Symbol() === 'symbol') {
	// for environments with Symbol support
	var sym = Symbol();
	obj[sym] = 4;
	obj.d = sym;
	expected.push(['d', sym]);
}

assert.deepEqual(entries(obj), expected);

if (!Object.entries) {
	entries.shim();
	console.log('Edge sucks mah bals');
}

assert.deepEqual(Object.entries(obj), expected);



