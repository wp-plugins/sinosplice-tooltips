	
// * Javascript Pinyin Tone Tool (copied from http://toshuo.com)
// * Mark Wilbur
// * Copyright (c) 2005-2010
// * If you want to copy this and put it on your page fine, but give credit and link back to
// * http://toshuo.com
// The output is SHOULD BE correct. If you find any errors, email me at doubtingtoshuo@gmail.com
// - The first vowel in the syllable is the only one to become accented
// - For the u: (umlat) character, this converter follows the convention of using the letter v.

// Array of vowels used in the conversion
// Array of vowels used in the conversion

var vowels = new Array ("a","e","i","o","u","v","ü");
var capvowels = new Array ("A", "E", "I", "O", "U", "V", "Ü");
var umlatu = "ü";

// Array of vowels with tones


var tones = new Array ("ā","ē","ī","ō","ū","ǖ","á","é","í","ó","ú","ǘ","ǎ", "ě", "ǐ", "ǒ", "ǔ", "ǚ","à","è","ì","ò","ù","ǜ");
//var captones = new Array("Ā", "Ē", "Ī", "Ō", "Ū", "Ǖ", "Á", "É", "Í", "Ó", "Ú", "Ǘ", "Ǎ", "Ě", "Ǐ", "Ǒ", "Ǔ", "Ǚ", "À", "È", "Ì", "Ò", "Ù", "Ǜ", "A", "E", "I", "O", "U", "Ü");
function addtones (textin) {
textin.toLowerCase();

currentword = "";
currentchar = "";
i = 0;
numletters = textin.length;
textout = ""; // final output
tempword = "";
usevowel = 1; // which vowel will have the tone over it
foundvowel = 0;
capitalize = false;

for (i=0; i<=numletters; i++) {
currentchar = textin.charAt (i);
currentnumvalue = currentchar - 1;

// numbers 1-5 are tone marks, build the word until we hit one
if ( !(currentchar.match(/[1-5]/)) ) {
if ( currentchar.match(/[aeiouvü]/i)) foundvowel++;
// if the last character was a vowel and this isn't...
if ( ((foundvowel != 0))  && (currentchar.match(/[^aeiouvüngr]/i))  || (currentchar == "")) {
textout = textout + currentword;
currentword = currentchar;
}

else {
currentword = currentword + currentchar;
}
}// if !match 1-5
// the character must be a tone mark
else {

tempword=""; // the word being built in this loop
foundvowel = 0; // number of vowels found in the word
usevowel = 1; // which vowel (1st or 2nd) will get the tone mark

// step through each character in word
wordlen = currentword.length;

// If it doesn't have vowels, just output it
if ( !(currentword.match(/[aeiouvü]/i)) ) {
	textout = textout + currentword + currentchar; 
	currentword = "";
}

// the tone goes over the second vowel for these combinations
if ( currentword.match(/i[aeou]/i) ) usevowel = 2;
if ( currentword.match(/u[aeio]/i) ) usevowel = 2;
if ( currentword.match(/[vü]e/i) ) usevowel = 2;

// We'll check either the first or the first two vowels, depending on which should have the tone
for (j=0; (j<=wordlen) && (foundvowel<usevowel); j++) {

// Check to see if the character is a vowel
for (vowelnum=0; vowelnum<7; vowelnum++) {


if ((currentword.charAt (j) == vowels [ vowelnum ]) ||
	 (currentword.charAt (j) == capvowels [vowelnum])){
// It's a vowel - convert to corresponding numbered tone character from tones array
// If tone is 5th (Neutral tone) - Leave it as the normal vowel

(currentword.charAt (j) == capvowels [vowelnum]) ? capitalize = true : capitalize = false;
if (currentnumvalue<=3) {
if (vowelnum == 6) currentchar = tones [5 + (currentnumvalue *6)]; // Handle the damned ü for Europeans who can input it directly
else currentchar = tones [ vowelnum + (currentnumvalue * 6)];
}

else {
if (vowelnum == 5) currentchar = umlatu; //neutral tone umlat
else currentchar = vowels [ vowelnum ]; //all other neutral tones
}

if (capitalize) currentchar = currentchar.toUpperCase();
foundvowel++; // Increment the counter for vowels found in the word

if (foundvowel>=usevowel) {
// rebuild word with the tone if this vowel should have the tone

tempword="";
for (k=0; k<=wordlen; k++) {
if (k == j) {
tempword = tempword + currentchar;
}

else { //just copy from the input, but turn all remaining v's into umlated u's
								if (currentword.charAt(k) == vowels[5]) tempword = tempword + umlatu;
								else tempword = tempword + currentword.charAt(k);
							}
						} //for
						currentword="";
					}
				}
			}
		textout = textout + tempword;
		} // else -deal with numbers
	}
}
return textout;
}

function initBox() {
	try {
		var box = document.commandDispatcher.focusedElement;
		var startPos = box.selectionStart;
		var endPos = box.selectionEnd;
		var oPosition = box.scrollTop;
		var oHeight = box.scrollHeight;
		var text = box.value.substring(0,startPos);
		var nHeight = box.scrollHeight - oHeight;
		var endText = box.value.substring(endPos);
		if(endPos == endPos){
		  var selectText = box.value.substring(startPos, endPos);
		} else {
		  var selectText = '';
		}
	} catch(e) {
		var box = null;
		var startPos = null;
		var endPos = null;
		var oPosition = null;
		var oHeight = null;
		var text = null;
		var nHeight = null;
		var endText = null;
		var selectText = null;
	}

 var array = new Array(
	box,
	startPos,
	endPos,
	oPosition,
	oHeight,
	text,
	nHeight,
	endText,
	selectText,
	document.getElementById("format-bundle")
 );
 return array;
}

function textPaste(text){
 var a = initBox();
   if(a[0] != null && text != null){
	a[0].value = a[5] + text + a[7];
	a[0].selectionStart = a[1];
	a[0].selectionEnd = a[1] + text.length;
	a[0].scrollTop = a[3] + a[6];
   }
}

function convert() {
  var a = initBox();
   if(a[0] != null){
	  	  return addtones(a[8]);
    }
 return null;
}

